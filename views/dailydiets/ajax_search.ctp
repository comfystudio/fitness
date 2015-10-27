<?php
	if(empty($foods) || !isset($foods)){
		echo '<div id = "flashMessage" style="margin:0 auto; width:200px;">No Foods match search</div>';	
	}
	echo '<div class = "error-message" id = "error-message-search"></div>';
	foreach($foods as $food){
		echo '<a id = "food-select_'.$food['Food']['id'].'" class = "food-select-search">'
				.$food['Food']['name'].
			'</a>' ;	
	}
?>