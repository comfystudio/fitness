<?php
class Like extends AppModel {
	var $name = 'Like';
	var $belongsTo = array(
		'User',
		'Post'
	);
}
?>