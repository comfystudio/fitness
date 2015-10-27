<h2>Users Matching search</h2>
<?php echo $this->Html->script('follow');?>
<?php $urlString = '/img/uploads/users/'?>
<?php foreach($results as $item):?>
<?php if($item['User']['id'] != $this->Session->read('User.id')) {?>
	<div class = 'panel'>
    	<div class = 'searchContainer'>
    		<div class = 'pic'>
    <?php foreach($item['Picture'] as $picture):?>
   		<?php if($picture['avatar'] == 1){?>
        <?php
			 echo $html->link($html->image($urlString.$picture['image'], array('width' => '64', 'height' => '64')), array('controller' => 'users', 'action' => 'view',$picture['user_id']), array('escape' => false));	
		}?>
    	
    <?php endforeach;?>
     <?php 	/*This is required to pull the user date and work out the number of years between the date and todays current date*/
			$today = getdate(); $year = (60*60*24*364.25);
			$difference = ($today[0] - strtotime($item['User']['age'] ) );
			$age = $difference / $year ;
			$age = floor($age);
	?>
   		</div>
        	<div class ='userinfo'>
            <p>Username: <?php echo $html->link($item['User']['username'], array('controller' => 'users', 'action' => 'view', $item['User']['id']))?></p>
            <p>Gender: <?php echo $item['User']['sex']?></p>
            <p>Age: <?php if($item['User']['age'] != null) {echo $age;}?></p>
            <p>Height: <?php if($this->Session->read('User.metricLength') == 1){
                                echo $item['User']['height'], ' cm';
                            } else if ($this->Session->read('User.id')) {
                                echo $item['User']['heightFoot'],"' ";
                                echo $item['User']['heightInch'],"'' ";
                            }?></p>
            <p>Location: <?php echo $item['User']['location'];?></p>
         	</div>                   
   		 </div>
         <div class = 'follow' id =  '<?php echo $item['User']['id']?>'>
            <?php $count = 0;
            foreach($currentFollowings as $following):
					if($item['User']['id'] == $following['Follower']['following_id'] ){
                            $count = 1;
							break;
							
                    }
            endforeach;
			
            if(!$this->Session->read('User.id')){
			}else{
				if($count != 1 ){?>
                    <p class = 'follow active <?php echo $item['User']['id']?>' id = '<?php echo $item['User']['id']?>'>Follow</p>
                    <p class = 'unfollow inactive <?php echo $item['User']['id']?>' id = '<?php echo $item['User']['id']?>'>Unfollow</p>	
                <?php } else {?>
                    <p class = 'follow inactive <?php echo $item['User']['id']?>' id = '<?php echo $item['User']['id']?>'>Follow</p>
                    <p class = 'unfollow active <?php echo $item['User']['id']?>' id = '<?php echo $item['User']['id']?>'>Unfollow</p>	
               <?php }
              }?>
         </div>
    </div>
<?php }?>
<?php endforeach;?>