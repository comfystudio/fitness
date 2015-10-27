<?php
/** 
 * Attachment Behavior
 *
 *	The behavior takes an array of files to be attached to the model
 *	Each key in the array should be the name of the file field input
 *	So for example if we have a form input called image, we should 
 *	have an array key called image
 *
 *	Each field then accepts multiple versions (or styles)
 *	There should always be a default version, see example below
 *
 *	public $actsAs = array(
 *		'Attachment' => array(
 *			'image' => array(
 *				'default' => array(
 *					'path' => ':webroot/img/uploads',
 *					'settings' => array(
 *						'image_resize' => true,
 *						'image_x' => 100,
 *						'image_ratio_y' => true
 *					),
 * 				)
 *			)
 *		),
 *		// ... other behaviors go here....
 *	);
 *	
 *	Advanced usage:
 *	To use multiple styles you should have a field in the database for each style
 *	It should be in the format of {field}_{style}
 *	In the example below we would have fields called
 *	- image
 *	- image_thumb
 *	- image_large
 *
 *	public $actsAs = array(
 *		'Attachment' => array(
 *			'image' => array(
 *				'default' => array(
 *					'path' => ':webroot/img/uploads',
 *					'settings' => array(
 *						'image_resize' => true,
 *						'image_x' => 150,
 *						'image_y' => 150,
 *						'image_ratio_crop' => true
 *					),
 *				),
 *				'thumb' => array(
 *					'path' => ':webroot/img/uploads/:version',
 *					'settings' => array(
 *						'image_resize' => true,
 *						'image_x' => 128,
 *						'image_y' => 72,
 *						'image_ratio_crop' => true
 *					),
 *				),
 *				'large' => array(
 *					'path' => ':webroot/img/uploads/:version',
 *					'settings' => array(
 *						'image_resize' => true,
 *						'image_x' => 600,
 *						'image_y' => 400,
 *						'image_ratio_crop' => true
 *					)
 *				)
 *			)
 *		)
 *	);
 */


App::import('Lib', 'upload');
class AttachmentBehavior extends ModelBehavior { 

/**
 * Files already processed and set in the models data array.
 *
 * @access protected
 * @var array
 */
	protected $_queued;

/**
 * Attachments to be processed, keyed by model alias
 *
 * @access protected
 * @var array
 */
	protected static $_attachments;

/**
 * Initialize uploader
 *
 * @access public
 * @param array $config
 */
	public function setup(&$model, $attachments = array()) {
		if (!empty($attachments) && is_array($attachments)) {
			self::$_attachments[$model->alias] = $attachments;
		}
	}
	

/**
 * Before saving the data, try uploading the image, if successful save to database.
 *
 * @access public
 * @param object $model
 * @return boolean
 */
	public function beforeSave(&$model) {
		foreach(self::$_attachments[$model->alias] as $field => $versions){
			if(!in_array('default', array_keys($versions))){
				trigger_error("Attachment Behavior: You must set a version to be default", E_USER_ERROR);
			}

			// Check that file exists in the data array and has been uploaded to the filesystem
			if (isset($model->data[$model->alias][$field])
			&& !empty($model->data[$model->alias][$field]['tmp_name'])
			&& $model->data[$model->alias][$field]['error'] === UPLOAD_ERR_OK) {
				
				// Create new upload object
				$uploader = new upload($model->data[$model->alias][$field]);
				if ($uploader->uploaded) {
					
					// Process the versions of the attachment
					foreach($versions as $version => $settings){
						
						// Set object properties for each remaining settings
						if(array_key_exists('settings', $settings)){
							foreach($settings['settings'] as $key => $value){
								$uploader->{$key} = $value;
							}
						}
						
						// Substitute any special tokens in the path setting
						$path = self::getPath($model->alias, $field, $version);

						// Upload the file
						$uploader->process($path);
						if ($uploader->processed) {
														
							// If not default, append the version onto the end of the field
							if($version == 'default'){
								$field_name = $field;
							} else {
								$field_name = $field . '_' . $version;								
							}
														
							// Populate model data with saved filename
							$model->data[$model->alias][$field_name] = $uploader->file_dst_name;
							
							// Place uploaded file path into queued var so we can delete if something goes wrong
							$this->_queued[] = $path. DS . $uploader->file_dst_name;
							
							// If editing an existing record, remove the current file to free up file system space
							if($model->id){
								$existing_filename = $model->field($field_name);
								if($existing_filename != $uploader->file_dst_name){
									$this->_unlinkFile($path . DS . $existing_filename);
								}
							}
						} else {
							// If something goes wrong delete any files uploaded in this process, return false to abort save
							$this->log($uploader->error);
							$this->_deleteQueued();
							$model->invalidate($field, $uploader->error);
							return false;
						}
						
						
					} // End processing of each version
					$uploader->clean();
				}
			} else {
				// If no file is uploaded unset the field to prevent it being saved to the database
				unset($model->data[$model->alias][$field]);
			}		
		}
		return true;
	}

/**
 * getPath
 * returns a path to an attachment with values interpolated
 *
 * @param string $field The field name
 * @param string $version The version of the attachment we want returned
 * @param string $type Whether to return a path or url (url will be relative to the document root)
 * @return string $path Path to attachment
 */
public static function getPath($model, $field, $version, $type = 'path'){
	$path = self::$_attachments[$model][$field][$version]['path'];
	if($type == 'url'){
		$substitutions = array(
			'webroot' => '',
			'app' => '',
			'version' => $version,
			//'user_id' => ''
		);
	} else {
		$substitutions = array(
			'webroot' => rtrim(WWW_ROOT, '/\\'),
			'app' => rtrim(APP, '/\\'),
			'version' => $version,
			//'user_id' => $this->Session->read('User.id'),
		);
	}
	
	foreach ($substitutions as $key => $value) {
    	$path = str_replace(':'.$key, $value, $path);
	}

	return $path;
}

/**
 * Deletes any files that have been attached to the current active record.
 *
 * Uses the attachment settings to find the paths of any files attached
 * Queries the model for the record about to be deleted and removes the file
 *
 * @access public
 * @param object $Model
 * @return boolean
 */
	public function beforeDelete(&$model) {
		// Grab the record
		$data = $model->find('first', array(
			'conditions' => array($model->alias.'.id' => $model->id),
			'recursive' => -1
		));
		
		foreach(self::$_attachments[$model->alias] as $field => $versions){
			foreach($versions as $version => $settings){
				$path = self::getPath($model->alias, $field, $version);					
				if($version == 'default'){
					$this->_unlinkFile($path . DS . $data[$model->alias][$field]);	
				} else {
					$this->_unlinkFile($path . DS . $data[$model->alias][$field . '_' . $version]);
				}
			}
		}
	}
	
/**
 * Applies dynamic settings to an attachment.
 *
 * @access public
 * @param string $model
 * @param string $file
 * @param array $settings
 * @return void
 */
	public function updateSettings($model, $field, $settings) {
		if (isset(self::$_attachments[$model][$field])) {
			self::$_attachments[$model][$field] = $settings + self::$_attachments[$model][$field];
		}
	}
	
/**
 *	Deletes a file from the system
 *
 * @param string $file
 * @return boolean true/false
 */
	private function _unlinkFile($file){
		if (!is_file($file)) {
			return false;
		}
		return unlink($file);
	}

/**
 * Delete all attached images if something goes wrong.
 * 
 * @access private
 */
	private function _deleteQueued() {
		if (isset($this->_queued)) {
			foreach($this->_queued as $key => $path) {
				$this->_unlinkFile($path);
			}
		}
		return true;
	}
	
	
/**
 * Validates that field has a value
 *
 * @return boolean
 **/
	public function attachmentNotEmpty(&$model, $check){
		$field = array_keys($check);
		$field = $field[0];
	    $value = $check[$field];

	    if ($value['error'] === UPLOAD_ERR_OK) {
	      return true;
	    }

	    if (!empty($model->id)) {
			if (isset($model->data[$model->alias][$field]) && !empty($model->data[$model->alias][$field])) {
				return true;
			} else {
				$current = $model->field($field, array($model->primaryKey => $model->id));
		        if (!empty($current)) {
		          return true;
		        }
				return true;
			}
	    }
		return false;
	}

/**
* Takes a file field and checks for an appropriate extension, as defined in $validate.
* If the 'allowEmpty' has been set to true, the function will exit and return true.
*
* @param object $model The model calling the behaviour / action.
* @param array $check Field passed by cake.
* @param array $extensions The list of allowed file extensions.
* @return boolean
*/
	public function attachmentFileExtension(&$model, $check, $extensions, $params) {
		$field = array_keys($check);
		$field = $field[0];
		$value = array_values($check);
		$value = $value[0];

		if (is_array($value)) {
			if ($value['error'] == 4 && $params['allowEmpty'] == true) {
				unset($model->data[$model->alias][$field]);
				return true;
			}
		}
		return Validation::extension($value, $extensions);
	}

}