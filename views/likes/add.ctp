	
    <?php
	$count3 = 0; $test = array();  $urlString = '/img/uploads/users/'; 
	foreach($likes as $like){
		if($post['Post']['id'] == $like['Like']['post_id']){
			$test[$count3]['username'] = $like['User']['username'];
			$test[$count3]['user_id'] = $like['Like']['user_id'];
			$test[$count3]['break'] = ', ';
			$count3++;
		}
	}
    foreach ($test as $item){
            $avatar = $this->requestAction('pictures/getAvatar/'.$item['user_id']);
            if(!empty($avatar)){
                echo $html->link($html->image($urlString.$avatar['Picture']['image'], array('width' => '32', 'height' => '32')), array('controller' => 'users', 'action' => 'view',$item['user_id']), array('escape' => false, 'title' => $item['username']));
            }else{
                echo $html->link($html->image('/img/avatar.png',array('width' => '32', 'height' => '32')), array('controller' => 'users', 'action' => 'view',$item['user_id']), array('escape' => false, 'title' => $item['username']));
            
            }
        }
    if(!empty($test)){
        echo 'Likes this!';
    }
	?>
