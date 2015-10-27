<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="google-site-verification" content="PwcwCkqJdnR4cIa9GRfsjzI0xR1SehUYN66leZypZaE" />
	<?php 
		
		echo $this->Html->charset(); 
	?>
	<title>
		<?php __('Witness The Fitness'); ?>
		<?php echo $title_for_layout; ?>
        <?php //echo 'offers free journal tracking + much more to increase your fitness'?>
        <?php echo 'workout bodyfat bmi bmr journal social log diet';?>
	</title>
    
    <!-- FACEBOOK META DATA-->
     <meta property="og:title" content="Witness The Fitness offers free journal tracking + much more to increase your fitness"/>
     <meta property="og:image" content="http://wtfitness.net/img/WTF%20-%20logo-dark.png"/>
     <meta property="og:type" content="activity"/>
     <meta property="og:url" content="http://www.wtfitness.net"/>
     <meta property="og:description"
        	content="wtfitness.net allows users to track their workouts, calories and measurements aswell as socialise with other members"/>
	<?php
		echo $this->Html->meta('favicon.ico', '/webroot/favicon.ico', array('type' => 'icon'));
		echo $this->Html->meta('keywords', 'witness, fitness, workout, weights, weightlifting, weight, bodyfat, bmi, bmr, journal, social, log, diet, calories, measurements');
		echo $this->Html->meta('description', 'wtfitness.net allows users to track their workouts, calories and measurements aswell as socialise with other members');
		//echo $this->Html->meta('icon');
		
		echo $this->Html->css('style2');
		echo $this->Html->script('jquery-1.7');
		echo $this->Html->script('navigation');
		echo $this->Html->script('css3-mediaqueries');
		
		echo $scripts_for_layout;
		
		
	?>
    <!--[if lte IE 9]>
    	<style>
        	* {font-family:"Arial", Gadget, sans-serif;}
            img {border:none;}
        </style>
    <![endif]-->
    
     <!--[if lte IE 8]>
    	<style>
        	.topheader_bg {border-bottom: 2px solid black;}
			.home-left-shadow { border:2px solid black; width:396px;}
            .home-right-shadow { border:2px solid black; width:746px;}
            .right-shadow { border:2px solid black; width:746px;}
            .left-shadow { border:2px solid black; width:396px;}
        </style>
    <![endif]-->
    
    
    <!--<link rel='stylesheet' media='screen and (min-width: 100px) and (max-width: 800px)' href='css/small.css' />
    <link rel='stylesheet' media='screen and (min-width: 801px) and (max-width: 1100px)' href='css/medium.css' />-->
   
    
	<base href="http://<?php echo $_SERVER['HTTP_HOST'];?>" />
    
    <!--GOOLGE ANALYTICS-->
    <script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-34440179-1']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	</script>
</head>
<body>
	<!--FACEBOOK LIKE -->
	<div id="fb-root"></div>
		<script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
    <div class = 'modal'></div>    
	<div class = 'wrapper'>
        <div class = 'topheader_bg'>
            <div class = 'topheader'>
                <a href = '/'><h1 id = 'logo-name'>Witness the Fitness</h1></a>
                <a href = '/'><div id = 'logo'></div></a>
                <ul id = 'menu'>
                <?php $urlString = '/img/uploads/users/';?>
                <?php if ($this->Session->read('User')) { ?>
                
                    <li class = '<?php  echo $this->Menu->highlight('/^\/profiles\/index\/?|\/profiles\/?$/')?>'>
                    	<a class = '<?php echo $this->Menu->highlight('/^\/profiles\/index\/?|\/profiles\/?$/');?>-atag' id = 'home-menu' href = 'profiles/index'>Home
                        </a>
                    </li>
                    
                    <li class = '<?php echo $this->Menu->highlight('/^\/post/');?>'>
                    	<a class = '<?php echo $this->Menu->highlight('/^\/post/');?>-atag' id = 'social' href = "posts/index">Social
                        </a>
                    </li>
                    
                    <li class = '<?php echo $this->Menu->highlight('/^\/workouts/');?>'>
                    	<a class = '<?php echo $this->Menu->highlight('/^\/workouts/');?>-atag' id = 'journal' href = "workouts/index">Journal
                        </a>
                    </li>
                    
                    <li class = '<?php echo $this->Menu->highlight('/^\/profiles\/tools\/?$/');?>'>
                    	<a class = '<?php echo $this->Menu->highlight('/^\/profiles\/tools\/?$/');?>-atag' id = 'tools' href = "profiles/tools">Tools
                        </a>
                    </li>
                   
                <?php $avatar = $this->requestAction('pictures/getAvatar/'.$this->Session->read('User.id'));?> 
                <?php if(!empty($avatar)){
						echo '<li id = "header-picture" class = "'.$this->Menu->highlight('/^\/users\/setting\/.?$/').'">';
						//echo '<li class = "header-picture '.$this->Menu->highlight('/^\/users\/setting\/.?$/').'">';
							echo $html->image($urlString.$avatar['Picture']['image'], array ('height' => '40', 'width' => '40', 'alt' => 'avatar', 'title' => 'Looking Fine!'));
						echo '</li>';
						
					}else{
						echo '<li id = "header-picture" class = "'.$this->Menu->highlight('/^\/users\/setting\/.?$/').'">';
						//echo '<li class = "header-picture '.$this->Menu->highlight('/^\/users\/setting\/.?$/').'">';
							echo $html->image('/img/avatar.png', array ('height' => '40', 'width' => '40', 'alt' => 'avatar', 'title' => 'Looking Fine!'));
						echo '</li>';
						
					}?>
                    
                    <div id = '<?php echo $this->Menu->highlightOther('/^\/users\/setting\/.?$/')?>' class = 'header-options'>
                    	<a href = 'users/logout' class = 'left'>Logout</a>
                        <a class = '<?php echo $this->Menu->highlightOther('/^\/users\/setting\/.?$/')?>' href = 'users/setting/<?php echo $this->Session->read('User.id');?>'>Settings</a>
                    </div>
                    
                    <?php $notifications = $this->requestAction('notifications/index/'.$this->Session->read('User.id'));
						  $countNotification = count($notifications);
					?>
                    <li id = 'mail'><a><img id="mail-image" alt = 'mail' src="../../webroot/img/mail.png">
                    	<?php if($countNotification > 0){?>
                    		<div id = 'notifications-alert'><p><?php echo $countNotification; ?></p></div>
                        <?php }?>
                   </a></li>
                   
                   <div id = 'header-notifications'>
                   <table class = 'table'>
                   		<?php foreach($notifications as $notification){?>
                        	<?php $userAvatar = $this->requestAction('pictures/getAvatar/'.$notification['User']['id'])?>
                            <tr>
                                <td class = 'notifications-pictures'>
                                    <?php if(!empty($userAvatar)){
                                            echo '<a href = "users/view/'.$notification['Notification']['user_id'].'">'.$html->image($urlString.$userAvatar['Picture']['image'], array ('height' => '64', 'width' => '64', 'alt' => 'avatar', 'title' => 'This guy!')).'</a>';
                                         }else {
                                            echo '<a href = "users/view/'.$notification['Notification']['user_id'].'">'.$html->image('/img/avatar.png', array ('height' => '64', 'width' => '64', 'alt' => 'avatar', 'title' => 'This guy!')).'</a>';
                                    }?>
                                </td>
                                <td class = 'notifications-info'>
                                    <a href = '<?php echo $notification['Notification']['source_controller']."/".$notification['Notification']['source_action']."/".$notification['Notification']['source_id']?>'>
                                        <p class = 'info-username'><?php echo $notification['User']['username'];?></p>
                                        <p class = 'info-notification'><?php echo $notification['Notification']['content'];?></p>
                                    </a>
                                </td>
                                
                                <td class = 'notifications-other'>
                                	<?php $time = $this->requestAction('users/getTime/'.strtotime($notification['Notification']['created']));?>
                                    <p class = 'notifications-date'><?php echo $time;?></p>
                                	<!--<p id = 'notifications-delete_<?php //echo $notification['Notification']['id']?>' class = 'notifications-delete'><?php //echo 'Delete X'//echo $html->link('Delete X', array('controller' => 'notifications', 'action' => 'delete',$notification['Notification']['id']))?></p>-->
                            </tr>
                            
                            
                        <?php }?>
                   </table>
                   </div>
                   
                <?php } else {?>
                    <li class = '<?php echo $this->Menu->highlight('/^\/users\/login\/?$/');?>'>
                    	<a class = '<?php echo $this->Menu->highlight('/^\/users\/login\/?$/');?> header-other' href="/users/login">Login
                    	</a>
                    </li>
                    <li class = '<?php echo $this->Menu->highlight('/^\/users\/register\/?$/');?>'>
                    	<a class = '<?php echo $this->Menu->highlight('/^\/users\/register\/?$/');?> header-other' href="/users/register">Register
                        </a>
                    </li>
                <?php }?>
                </ul>
            </div>
        </div>
        
       <!-- <div class = 'ad-banner'>
			<script type="text/javascript"><!--
                google_ad_client = "ca-pub-7534023795746626";
                /* Test */
                google_ad_slot = "7561418857";
                google_ad_width = 728;
                google_ad_height = 90;
           		
                </script>
                <script type="text/javascript"
                src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
            </script>
        </div>-->
        <div id="container">
            <div id="main">
                <?php //echo $this->Session->flash(); ?>
                <div id="content">
                        <div class="body">     
                            <?php echo $content_for_layout; ?>
                        </div>
                </div>
                
               <!-- <div class = 'ad-banner'>
					<script type="text/javascript"><!--
						google_ad_client = "ca-pub-7534023795746626";
						/* footer */
						google_ad_slot = "6365489680";
						google_ad_width = 728;
						google_ad_height = 90;
					
						</script>
						<script type="text/javascript"
						src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					</script>
                </div>-->
                <div id='<?php echo $this->Menu->highlightOther('/^\/users\/login\/?|\/users\/register\/?$/')?>-footer-wrapper'>
                 <div id="footer">
                    <ul class = 'left'>
                       <li><a href = '/help'>Help</a></li>
                        <!--<li><a href = 'mailto:admin@wtfitness.com'>Contact</a></li>-->
                        <li><a href = '/contact'>Contact</a></li>
                        <li><a href = '/terms'>Terms</a></li>
                        <li><a href = '/privacy'>Privacy Policy</a></li>
						<!--<a href="https://www.iubenda.com/privacy-policy/115254" class="iubenda-white iubenda-embed" title="Privacy Policy">Privacy Policy</a><script type="text/javascript">(function (w,d) {var loader = function () {var s = d.createElement("script"), tag = d.getElementsByTagName("script")[0]; s.src = "https://cdn.iubenda.com/iubenda.js"; tag.parentNode.insertBefore(s,tag);}; w.addEventListener ? w.addEventListener("load", loader, false) : w.attachEvent("onload", loader);})(window, document);</script>-->
                    	<li><a href = '/about'>About</a></li>
                        <li id = 'facebook-like'><div class="fb-like" data-href="http://www.wtfitness.net" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div></li>
                    </ul>
                    <p class = 'right'>Copyright © <?php echo date("Y"); ?> Witness The Fitness. All Rights Reserved. </p>
                </div>
               </div> 
            </div>
        </div>
	</div>
</body>
</html>