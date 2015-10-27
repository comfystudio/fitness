<?php
    class Picture extends AppModel {
        var $name = 'Picture';
		var $order = 'Picture.created ASC';
		var $belongsTo = array (
			'User'
		);
		
		var $validate = array(
			'image' => array(
				'extension' => array(
					'rule' => array('attachmentNotEmpty'),
					'message' => 'Please supply a valid image'
				)
			),
			'about' => array(
				'alphaNumeric' => array(
					'rule' => '/^[a-z0-9\s]*(\.\.\.)?$/i',
					'message' => 'About must contain only alphaNumeric characters'
				),
				'max' => array(
					'rule' => array('maxLength', 50),
					'message' => 'About must be no longer than 50 characters'
				)
			),
		);
		
		
		public $actsAs = array(
			'Attachment' => array(
				'image' => array(
					'default' => array(
						'path' => ':webroot/img/uploads/users/',
						'settings' => array(
							'image_resize' => true,
							'image_x' => 600,
							'image_y' => 600,
							'image_ratio_crop' => true,
							'allowed' => array('image/gif', 'iamge/bmp', 'image/jpeg', 'image/png', 'image/pjpeg')
	
						)
					)
				)
			)
		);
		
    }
?>