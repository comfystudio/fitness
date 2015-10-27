<?php
	echo '<p>Results</p>';
	foreach($results as $result){
		echo '<a id = "food-select_'.$result['Food']['id'].'" class = "food-select-results">'
				.$result['Food']['name'].
			'</a>' ;	
	}
?>