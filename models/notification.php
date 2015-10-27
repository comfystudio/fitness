<?php
class Notification extends AppModel {
	var $name = 'Notification';
	var $order = 'Notification.created DESC';
	var $belongsTo = array(
		'User'
	);
}
?>