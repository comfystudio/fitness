<?php
	echo '<p>Results</p>';
	foreach($results as $result){
		echo '<a id = "exercise-select_'.$result['Exercise']['id'].'" class = "exercise-select-results">'
				.$result['Exercise']['name'].
			'</a>' ;	
	}
?>