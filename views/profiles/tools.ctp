<?php echo $this->element('social-left'); ?>
<?php echo $this->Html->script('tools');?>

<div class = 'home-right-shadow'>
    <div class = 'right-nav-content'>
		<?php echo $this->Session->flash(); ?>
            <div class = 'tools-header'>
                <ul>
                    <li class = 'li-active' id = "tools-manageFood">Manage Food</li>
                    <li id = "tools-bmr">BMR</li>
                    <li id = "tools-bodyfat">Bodyfat</li>
                    <li id = "tools-bmi">BMI</li>
                </ul>
            </div>
            
            <div id="LoadingImage" style="display: none">
            	<img src="../../webroot/img/ajax-loader.gif" />
        	</div>
            
            <div class = 'tools-wrapper'>  
                <div class = 'tools-food'>
					<?php
						if(!isset($message)){
                       		echo $form->input('selectFood', array('type'=>'select', 'label' => 'Select Food' ,'options'=> $foodlist));
						}else{
							//echo '<div id = "flashMessage">'.$message.'</div>';
						}
                    ?>
                        <a id = 'add-food'><img src="../../webroot/img/add-food.png"></a>
                 </div>

             <div class = 'tools-content'>	
             </div>
         </div>
    </div>
</div>
<script> manageFood();</script>

    


 