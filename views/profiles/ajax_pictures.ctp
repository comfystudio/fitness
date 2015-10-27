
<div class = 'home-pictures'>
	<div class = 'picture-upload'>
    	<?php
			if(($totalSize / 1000000) <= 1 || $this->Session->read('User.level') != 0){
				echo $this->Form->create('Picture', array('type' => 'file', 'action' => 'add'));
					echo $this->Form->input('image', array('label' => false, 'placeholder' => 'test', 'type' => 'file'));
					echo '<div id = "fake-upload"></div>';
					echo $this->Form->input('about', array('placeholder' => 'Add a note...', 'label' => false, 'class' => 'textarea', 'rows' => '1', 'type' => 'textarea'));
				echo $this->Form->end('upload.png');
			}else{
				echo '<p style = "color:red" class = "red">Upload Limit exceeded!</p>';	
			}
		?>
        <div class = 'picture-notes'>
            <p>Maintain 1 width to 1 height for best results..</p>
            <p class = 'right'><?php echo round($totalSize / 1000000, 3).'MB / 1 MB'?></p>
            <p>Total max of 1mb for all uploads...sorry.</p>
        </div>
    </div>
</div>
    
<div class = 'picture-gallery'>
    <?php
		$count = 0;
        foreach($pictures as $picture){
			$count++;
            $urlString = '/img/uploads/users/';
			$date = $this->requestAction('users/getTime/'.strtotime($picture['Picture']['created']));
            echo '<div class = "picture">';	
				if($picture['Picture']['avatar'] == 1){
                	//echo $html->link($html->image($urlString.$picture['Picture']['image'], array('id' => 'active-avatar', 'width' => '200px', 'height' => '200px')), array('controller' => 'pictures', 'action' => 'view',$picture['Picture']['id']), array('escape' => false));
					echo '<a id = "picture-click_'.$count.'" class = "picture-click">'.$html->image($urlString.$picture['Picture']['image'], array('id' => 'active-avatar', 'width' => '200px', 'height' => '200px')).'</a>';
				}else{
					//echo $html->link($html->image($urlString.$picture['Picture']['image'], array('width' => '200px', 'height' => '200px')), array('controller' => 'pictures', 'action' => 'view',$picture['Picture']['id']), array('escape' => false));
					echo '<a id = "picture-click_'.$count.'" class = "picture-click">'.$html->image($urlString.$picture['Picture']['image'], array('width' => '200px', 'height' => '200px')).'</a>';
				}
				echo '<div class = "picture-delete">';
					echo '<a href = "pictures/delete/'.$picture['Picture']['id'].'"><p id = "delete"><strong>Delete</strong></p></a>';
					if($picture['Picture']['avatar'] == 0){
						echo '<p id = "make-avatar_'.$picture['Picture']['id'].'" class = "make-avatar"><strong>Make Avatar</strong></p>';
					}else{
						echo '<p style="display:none" id = "make-avatar_'.$picture['Picture']['id'].'" class = "right"><strong>Make Avatar</strong></p>';
					}
				echo '</div>';
				
				echo '<div class = "picture-date">';
					echo '<strong>'.$date.'</strong>';
				echo '</div>';
				
				echo '<div class = "picture-about">';
					echo $picture['Picture']['about'];
				echo '</div>';
            
            echo '</div>';
        }
    ?>
    <div style = "display:none" class = 'picture-overlay'>
    	<a class = 'destroy-overlay'>Close Window</a>
        <a id = 'index-button-left'><img src="../../webroot/img/index-button-left.png"></a>
    	<div class = 'picture-overlay-overflow'>
        	<ul style = "width:<?php echo ($count * 600).'px'?>" id = 'mycarousel' class = 'tango_<?php echo $count?>'>
            	<?php 
					$count = 0;
					foreach($pictures as $picture){
						$count++;
						echo '<li id = "image_'.$count.'">'.$html->image($urlString.$picture['Picture']['image'], array('width' => '600px', 'height' => '600px')).'</li>';
						
					}
        		?>
        </div>
         <a id = 'index-button-right'><img src="../../webroot/img/index-button-right.png"></a>
    </div>

</div>



