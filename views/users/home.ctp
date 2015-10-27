<?php $urlString = '/img/uploads/users/';?>

<div class = "help">
	<div class = 'base-header'>
    	<a href = '/'><img src='../../webroot/img/WTF - logo.png' title="Witness the Fitness" alt="Witness the fitness logo"></img></a>
        <h1>Free Workout, Diet and Tracking Journal</h1>
        <p><strong>wtfitness.net</strong> lets you connect with other members as you track your progess towards your goals</p>
        <div class = 'base-header-botton'><a title="Register" href = '/users/register'>Register Now (it's free)</a></div>
        <p>Already a Member?</p>
        <div class = 'base-header-botton'><a title="Login" href = '/users/login'>Login</a></div>
    </div>
    
    <div class = 'base-showcase'>
    <img id = 'img-social'src='../../webroot/img/front/social.png'></img>
    <img style='display:none' id = 'img-journal' src='../../webroot/img/front/journal.png'></img>
    <img style='display:none' id = 'img-tracking' src='../../webroot/img/front/tracking.png'></img>
    <img style='display:none' id = 'img-pictures'src='../../webroot/img/front/pictures.png'></img>
    <img style='display:none' id = 'img-tools'src='../../webroot/img/front/tools.png'></img>
    <img style='display:none' id = 'img-settings'src='../../webroot/img/front/settings.png'></img>
    	<ul id = 'base-showcase-text'>
        	<li>Post, comment and send messages.</li>
            <li>Upkeep a journal of your workouts, meals and measurements.</li>
            <li>Keep track of your past entries</li>
            <li>Upload pictures of your progress</li>
            <li>Check your bodyfat, BMI, BMR and even add a custom food</li>
            <li>Complete control over your information and how it's displayed</li>
        </ul>
        
        <ul id = 'base-showcase-botton'>
        	<li class = 'active' id = 'base_social'>Social</li>
            <li id = 'base_journal'>Journal</li>
            <li id = 'base_tracking'>Tracking</li>
            <li id = 'base_pictures'>Pictures</li>
            <li id = 'base_tools'>Tools</li>
            <li id = 'base_settings'>Settings</li>
        </ul>
    </div>
    
    <div class = 'base-info'>
    	<div class = 'info'>
        	<h2>Social</h2>
            <p>
            	Witness the Fitness allows you to post,
                comment, like and send messages to
                fellow users. If you want to get your
                stalker on you can view other users
                progress and see any pictures they've
                uploaded.
            </p>
        </div>
        
        <div class = 'info'>
        	<h2>Journal</h2>
            <p>
            	Most people who workout will keep some kind
                of journal. Rather than carrying
                a notepad with you why not just keep it
                here. You can select a date, add a
                workout, meal or measurement, wtfitness.net
                makes it easy.
            </p>
        </div>
        
        <div class = 'info'>
        	<h2>Help</h2>
            <p>
            	Whether your a battle worn veteran or 
                just starting out, having other members
                comment and offer advice can give you
                new prespective and help motivate your progress
                to a whole new level.
            </p>
        </div>
        
        <div class = 'info'>
        	<h2>Together</h2>
            <p>
            	Many websites offer workout tracking,
                and others offer diet tracking. But
                none offer the comprehensive array of features
                that a fit and healthy lifestyle requires
                all in one place until now.
            </p>
        </div>
    </div>
    
    <div class = 'latest-article'>
    	<?php
			$user = $this->requestAction('users/getSelectedUser/'.$article['Post']['user_id']);
			$date = $this->requestAction('users/getTime/'.strtotime($article['Post']['created']));
		?>
        
        <h1><?php echo $article['Post']['title'];?></h1>
        <a href = 'users/view/<?php echo $article['Post']['user_id']?>'><h2>by <?php echo $user['User']['username'].' - '.$date;?></h2></a>
        <p><?php echo  $article['Post']['body']?></p>
        <a id = 'back-article' href = '/article'><p>Go to articles</p></a>
        <!--<h2>Test</h2>
        
        <p>
        	Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test 
            Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test 
            Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test 
            Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test 
            Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test 
        </p>
        
        <img alt = 'test' src="../../webroot/img/front/workout.png" width="20px" height="20px"><img>
        
        <p>
        	Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test 
            Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test 
            Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test 
            Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test 
        
        </p>
        
        <p>
        	View more articles <a href='/article'>here</a>
        </p>-->
        
    </div>
	
	<div class = 'help-others'>
    <h1>Meet Our Members</h1>
    <?php $meets = $this->requestAction('users/getOthersHelp/');?>
    <div class = 'base-others'>
    	<?php $count2 = 0;?>
		<?php foreach ($meets as $meet):
                    $count = 0;
                    foreach($meet['Picture'] as $picture):
                        if($picture['avatar'] == 1){
                            $count = $picture['image'];
                            break;
                        }else {
                            $count = 0;
                        }
                        endforeach;
                        if($count == '0'){
                            echo $html->link($html->image('/img/avatar.png',array('alt' => 'avatar_'.$meet['User']['username'].'')), array('controller' => 'users', 'action' => 'view',$meet['User']['id']), array('escape' => false, 'title' => $meet['User']['username']));
    
                        }else {
                            echo $html->link($html->image($urlString.$count, array('alt' => 'avatar_'.$meet['User']['username'].'')), array('controller' => 'users', 'action' => 'view',$meet['User']['id']), array('escape' => false, 'title' => $meet['User']['username']));
    
                        }
				$count2++;
				if($count2 >= 6){
					break(1);	
				}
            endforeach;?>
    	</div>
    </div>
</div>