<?php
	if(empty($exercises) || !isset($exercises)){
		echo '<div id = "flashMessage" style="margin:0 auto; width:200px;">No activities match search</div>';	
	}
	echo '<div class = "error-message" id = "error-message-search"></div>';
	foreach($exercises as $exercise){
		echo '<a id = "exercise-select_'.$exercise['Exercise']['id'].'" class = "exercise-select-search">'
				.$exercise['Exercise']['name'].
			'</a>' ;	
	}
?>