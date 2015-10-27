<?php
class Follower extends AppModel {
	var $name = 'Follower';
	var $belongsTo = array(
		'User'
	);
}
?>