<?php echo $this->Html->script('follow');?>
<div class ="userDetails">
	<h2><?php echo $users['User']['username'];?></h2>
    
    <?php 	/*This is required to pull the user date and work out the number of years between the date and todays current date*/
			$today = getdate(); $year = (60*60*24*364.25);
			$difference = ($today[0] - strtotime($users['User']['age'] ) );
			$age = $difference / $year ;
			$age = floor($age);
	?>
    <div class ='avatar'>
    </div>
    <div class ='userinfo'>
    	<p>Gender: <?php echo $users['User']['sex']?></p>
        <p>Age: <?php if($users['User']['age'] != null) {echo $age;}?></p>
        <p>Height: <?php if($this->Session->read('User.metricLength') == 1){
							echo $users['User']['height'];
						} else if ($this->Session->read('User.id')) {
							echo $users['User']['heightFoot'],"' ";
							echo $users['User']['heightInch'],"'' ";
						}?></p>
        <p>Location: <?php echo $users['User']['location'];?></p>
    </div>
    <div class = 'userAbout'>
    	<h2>About me</h2>
        <p><?php echo $users['User']['about']?></p>
    </div>
   <?php if($this->Session->read('User.id') != $users['User']['id']){?>
    <div class = 'follow' id =  '<?php echo $users['User']['id']?>'>
            <?php $count = 0;?>
            <?php foreach($currentFollowings as $following):?>
					<?php if($users['User']['id'] == $following['Follower']['following_id'] ){
                            $count = 1;
							break;
							
                    }?>
            <?php endforeach;?>
            <?php if($count != 1 ){?>
           		<p class = 'follow active <?php echo $users['User']['id']?>' id = '<?php echo $users['User']['id']?>'>Follow</p>
                <p class = 'unfollow inactive <?php echo $users['User']['id']?>' id = '<?php echo $users['User']['id']?>'>Unfollow</p>	
            <?php } else {?>
				<p class = 'follow inactive <?php echo $users['User']['id']?>' id = '<?php echo $users['User']['id']?>'>Follow</p>
                <p class = 'unfollow active <?php echo $users['User']['id']?>' id = '<?php echo $users['User']['id']?>'>Unfollow</p>	
			<?php }?>
         </div>
    <?php }?>
	<div class = 'viewGallery'>
    	<?php echo $html->link('View Gallery', array('controller' => 'pictures', 'action' => 'viewUser',$users['User']['id']))?>
    </div>
</div>

<?php $urlString = '/img/uploads/users/'?>
<div class = 'picframe'>
	<div class = 'firsted'>
       <?php if (isset($firstPicture['Picture']['image'])){?>
    		<?php echo $html->link($html->image($urlString.$firstPicture['Picture']['image']), array('controller' => 'pictures', 'action' => 'view',$firstPicture['Picture']['id']), array('escape' => false));?>
		<?php }?>
    	<div class = 'date'>
         	Date added: <?php echo $firstPicture['Picture']['created'];?>
         </div>
         
         <div class = 'about'>
         	About Picture: <?php echo $firstPicture['Picture']['about'];?>
         </div>
    </div>
         
    <div class = 'recent'>
     <?php if (isset($lastPicture['Picture']['image'])){?>
    		<?php echo $html->link($html->image($urlString.$lastPicture['Picture']['image']), array('controller' => 'pictures', 'action' => 'view',$lastPicture['Picture']['id']), array('escape' => false));?>
    <?php }?>
        <div class = 'date'>
         	Date added: <?php echo $lastPicture['Picture']['created'];?>
         </div>
         
         <div class = 'about'>
         	About Picture: <?php echo $lastPicture['Picture']['about'];?>
         </div>
    </div>
</div>
<?php echo $html->link('Total Summary', array('controller' => 'users', 'action' => 'table',$users['User']['id'] ));?>
<div class ='panel'>
	<h2>Weight Stats</h2>
        <p>Current Weight: <?php echo $current['Body']['weight'];?> <?php echo $current['Body']['units'];?></p>
        <p>Starting Weight: <?php echo $starting['Body']['weight'];?> <?php echo $current['Body']['units'];?></p>
        <p>Lightest Weight: <?php echo $lightestWeight['Body']['weight'];?> <?php echo $current['Body']['units'];?></p>
</div>
<div class ='panel'>
	<h2>Body Fat</h2>
    	<p>Current Bodyfat: <?php echo $current['Body']['bodyfat'];?> %</p>
        <p>Starting Bodyfat: <?php echo $starting['Body']['bodyfat'];?> %</p>
        <p>Lowest Bodyfat: <?php echo $lowestBf['Body']['bodyfat'];?> %</p>
        <br/>
        
    <h2>Chest</h2>
        <p>Current Chest: <?php echo $current['Body']['chest'];?> <?php echo $current['Body']['units2'];?></p>
        <p>Starting Chest: <?php echo $starting['Body']['chest'];?> <?php echo $current['Body']['units2'];?></p>
        <p>Smallest Chest: <?php echo $lowestChest['Body']['chest'];?> <?php echo $current['Body']['units2'];?></p>
        <p>Biggest Chest: <?php echo $biggestChest['Body']['chest'];?> <?php echo $current['Body']['units2'];?></p>
    <br/>
    
    <h2>Arms</h2>
        <p>Current Arms: <?php echo $current['Body']['arms'];?> <?php echo $current['Body']['units2'];?></p>
        <p>Starting Arms: <?php echo $starting['Body']['arms'];?> <?php echo $current['Body']['units2'];?></p>
        <p>Smallest Arms: <?php echo $lowestArms['Body']['arms'];?> <?php echo $current['Body']['units2'];?></p>
    <br/>
    
    <h2>Thighs</h2>
        <p>Current Thighs: <?php echo $current['Body']['thighs'];?> <?php echo $current['Body']['units2'];?></p>
        <p>Starting Thighs: <?php echo $starting['Body']['thighs'];?> <?php echo $current['Body']['units2'];?></p>
        <p>Smallest Thighs: <?php echo $lowestThighs['Body']['thighs'];?> <?php echo $current['Body']['units2'];?></p>
        <p>Biggest Thighs: <?php echo $biggestThighs['Body']['thighs'];?> <?php echo $current['Body']['units2'];?></p>
    <br/>
</div>

<div class ='panel'>
	<h2>Bench Press</h2>
        <p>Current Bench: <?php echo $currentBench;?> <?php echo $current['Body']['units'];?></p>
        <p>Starting Bench: <?php echo $startingBench;?> <?php echo $current['Body']['units'];?></p>
        <p>Strongest Bench: <?php echo $strongestBench;?> <?php echo $current['Body']['units'];?></p>
    <br/>
    
    <h2>Squat</h2>
        <p>Current Squat: <?php echo $currentSquat;?> <?php echo $current['Body']['units'];?></p>
        <p>Starting Squat: <?php echo $startingSquat;?> <?php echo $current['Body']['units'];?></p>
        <p>Strongest Squat: <?php echo $strongestSquat;?> <?php echo $current['Body']['units'];?></p>
    <br/>
    
    <h2>Deadlift</h2>
        <p>Current Deadlift: <?php echo $currentDeadlift;?> <?php echo $current['Body']['units'];?></p>
        <p>Starting Deadlift: <?php echo $startingDeadlift;?> <?php echo $current['Body']['units'];?></p>
        <p>Strongest Deadlift: <?php echo $strongestDeadlift;?> <?php echo $current['Body']['units'];?></p>
    <br/>
    
    <h2>Row</h2>
        <p>Current Row: <?php echo $currentRow;?> <?php echo $current['Body']['units'];?></p>
        <p>Starting Row: <?php echo $startingRow;?> <?php echo $current['Body']['units'];?></p>
        <p>Strongest Row: <?php echo $strongestRow;?> <?php echo $current['Body']['units'];?></p>
    <br/>
    
    <h2>Curl</h2>
        <p>Current Curl: <?php echo $currentCurl;?> <?php echo $current['Body']['units'];?></p>
        <p>Starting Curl: <?php echo $startingCurl;?> <?php echo $current['Body']['units'];?></p>
        <p>Strongest Curl: <?php echo $strongestCurl;?> <?php echo $current['Body']['units'];?></p>
    <br/>
    
    <h2>Press</h2>
        <p>Current Press: <?php echo $currentPress;?> <?php echo $current['Body']['units'];?></p>
        <p>Starting Press: <?php echo $startingPress;?> <?php echo $current['Body']['units'];?></p>
        <p>Strongest Press: <?php echo $strongestPress;?> <?php echo $current['Body']['units'];?></p>
    <br/>
    
</div>

	<?php  if(isset($totalProtein0)){?>
<div class ='panel'>
        <h2>Most Recent Diet entry</h2>
        <p>Protein: <?php echo round($totalProtein0,2);?> grams(g)</p>
        <p>Carbs: <?php echo round($totalCarbs0,2);?> grams(g)</p>
        <p>Fat: <?php echo round($totalFat0,2);?> grams(g)</p>
        <p>Fibre: <?php echo round($totalFibre0,2);?> grams(g)</p>
        <p>Calories: <?php echo round($totalCalories0,2);?> grams(g)</p>
        <br/>
     <?php }?>
       
    
    <?php  if(isset($totalProtein1)){?>
        <h2>2nd Most Recent Diet entry</h2>
        <p>Protein: <?php echo round($totalProtein1,2);?> grams(g)</p>
        <p>Carbs: <?php echo round($totalCarbs1,2);?> grams(g)</p>
        <p>Fat: <?php echo round($totalFat1,2);?> grams(g)</p>
        <p>Fibre: <?php echo round($totalFibre1,2);?> grams(g)</p>
        <p>Calories: <?php echo round($totalCalories1,2);?> grams(g)</p>
        <br/>
    <?php }?>
    
    <?php if(isset($totalProtein2)){?>
        <h2>3nd Most Recent Diet entry</h2>
        <p>Protein: <?php echo round($totalProtein2,2);?> grams(g)</p>
        <p>Carbs: <?php echo round($totalCarbs2,2);?> grams(g)</p>
        <p>Fat: <?php echo round($totalFat2,2);?> grams(g)</p>
        <p>Fibre: <?php echo round($totalFibre2,2);?> grams(g)</p>
        <p>Calories: <?php echo round($totalCalories2,2);?> grams(g)</p>
        <br/>
    <?php }?>
</div>

