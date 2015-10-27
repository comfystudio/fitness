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

    


 