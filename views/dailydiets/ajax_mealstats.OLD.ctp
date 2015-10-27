<div class = 'ajax_foodtype' id = 'foodtype_<?php echo $id?>'><?php echo $foodtype?></div>
<div class = 'ajax_metric' id = 'metricMass_<?php echo $id?>'><?php echo $metricMass?></div>
<div class = 'ajax_metric' id = 'metricVolume_<?php echo $id?>'><?php echo $metricVolume?></div>
<ul>
    <li class = 'singleList' id = 'protein<?php echo $id?>'>Protein: <?php echo $protein = round($quantity * $food['Food']['protein'],1 )?></li>
    <li class = 'singleList' id = 'carbs<?php echo $id?>'>Carbs: <?php echo $carbs = round($quantity * $food['Food']['carbs'],1 )?></li>
    <li class = 'singleList' id = 'fat<?php echo $id?>'>Fat: <?php echo $fat = round($quantity * $food['Food']['fat'],1 )?></li>
    <li class = 'singleList' id = 'fibre<?php echo $id?>'>Fibre: <?php echo $fibre =round($quantity * $food['Food']['fibre'],1 )?></li>
    <li class = 'singleList' id = 'calories<?php echo $id?>'>Calories: <?php echo $calories =round($quantity * $food['Food']['calories'],1 )?></li>
</ul>