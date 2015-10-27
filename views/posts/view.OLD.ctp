<!-- File: /app/views/posts/view.ctp -->
<?php echo $this->Html->script('index', FALSE);?>
 <div class="panel">
    <h2>
          <?php echo $html->link($post['User']['username'], array('controller' => 'users', 'action' => 'view',$post['User']['id']));?>
        
    </h2>
    <p>
        <?php echo $post['Post']['body']; ?>
    </p>
    <div class="comment">
        <?php   
            $today = getdate();
            $day = (60*60*24);
            if ($today[0] - strtotime($post['Post']['created']) < $day) {
                echo  'Today';
            }else{
                 echo date("d, M, Y", strtotime($post['Post']['created']));
            }
        ?>
        <br/>
    </div>
</div>

<?php if(!empty($comments)){?>
	<a id = "paragraphAnchor"> Click to view comments</a> <a id="paragraphAnchor2"> Click to hide comments</a>
<?php }?>
<?php //pr($post);  pr($comments);die;?>
 <?php foreach($comments as $item): ?>
 <?php //pr($comments);die;?> 
 	<div class="panelComments">
		<p><?php echo $item['Comment']['date'];?></p>
		<p><b>Username</b>: <?php echo $html->link($users[$item['Comment']['user_id']], array('controller' => 'users', 'action' => 'view',$item['Comment']['user_id']));?></p>
		<p><?php echo $item['Comment']['text'];?></p>
        <?php if($this->Session->read('User')){?>
        <!--<div class="rating">
            <ul id = 'rating'>
                <li><a href='<?php //echo $item['id'];?>' class='negative'> - </a></li>
                <li><a href='<?php // echo $item['id'];?>' class='positive'> + </a></li>
            </ul>
        </div>-->
        <?php }?>
        <?php /*if($item['rating'] >=1){?>
        <div class ='score'>
        	<a id='score_<?php echo $item['id'];?>' class = 'ratingPositive'><?php echo $item['rating'];?></a>
        </div>
        <?php } elseif($item['rating'] < 0) { ?>
		<div class ='score'>
			<a id='score_<?php echo $item['id'];?>' class = 'ratingNegative'><?php echo $item['rating'];?></a>
        </div>
		<?php } else { ?>
        <div class ='score'>
			<a id='score_<?php echo $item['id'];?>' class = 'rating'><?php echo $item['rating'];?></a>
        </div>
		<?php }?>
        <?php if($item['rating'] >=1){
			
		}else{
			
		}*/?>
         
       
        <?php if($this->Session->read('User.level') == 1) {
        		 echo $html->link('Delete', array('controller'=> 'comments', 'action'=>'delete', $item['Comment']['id']), array('class' => 'comment_options'), "are you sure?");
       		 }
         if($this->Session->read('User.level') == 1 || $this->Session->read('User.id') ==  $users[$item['Comment']['user_id']] ) {
        		echo $html->link('Edit', array('controller'=> 'comments', 'action'=>'edit', $item['Comment']['id']), array('class' => 'comment_options'));
        	}?>
	</div>
<?php endforeach; ?>
<br/>
<br/>

<?php if($this->Session->read('User')){	
	echo  '<p>Add Comment</p>';
	echo $this->Form->create('Comment', array('action'=>'add'));
	echo $this->Form->hidden('post_id', array('value' => $post['Post']['id']));
	echo $this->Form->input('text', array('rows' => '3', 'label' => false));
	echo $this->Form->end('Save comment');
}?>