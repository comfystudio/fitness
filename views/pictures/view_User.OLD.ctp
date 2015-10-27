<?php if (!empty($pictures)){?>
<h2><?php echo $html->link($pictures[0]['User']['username'], array('controller' => 'users', 'action' => 'view',$pictures[0]['User']['id']));?>'s Pictures</h2>
<?php }?>
<?php $urlString = '/img/uploads/users/'?>

<div class  = 'picframe'>
	<?php foreach ($pictures as $picture): ?>
	<div class = 'first'>
    <?php //echo $html->link('X', array('controller' => 'pictures', 'action' => 'delete', $picture['Picture']['id']), array('title' => 'delete image') )?>
     <?php echo $html->link($html->image($urlString.$picture['Picture']['image']), array('controller' => 'pictures', 'action' => 'view',$picture['Picture']['id']), array('escape' => false));?>
     	<div class = 'date'>
         	Date added: <?php echo $picture['Picture']['created'];?>
         </div>
         
         <div class = 'about'>
         	About Picture: <?php echo $picture['Picture']['about'];?>
         </div>
    </div>
    <?php endforeach; ?> 	
</div>