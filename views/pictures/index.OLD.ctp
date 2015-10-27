<?php echo $this->Html->script('avatar', FALSE);?>
<h2>Your Pictures</h2>
<?php $urlString = '/img/uploads/users/'?>

<?php //pr($picture);die;?>
<div class  = 'picframe'>
	<?php foreach ($pictures as $picture): ?>
	<div class = 'first'>
    <?php echo $html->link('X', array('controller' => 'pictures', 'action' => 'delete', $picture['Picture']['id']), array('title' => 'delete image'), "are you sure?")?>
     <?php echo $html->link($html->image($urlString.$picture['Picture']['image']), array('controller' => 'pictures', 'action' => 'view',$picture['Picture']['id']), array('escape' => false));?>
     	<div class = 'date'>
         	Date added: <?php echo $picture['Picture']['created'];?>
         </div>
         
         <div class = 'about'>
         	About Picture: <?php echo $picture['Picture']['about'];?>
         </div>
         
         <div class = 'check'>
         	   <?php echo $form->input('avatar', array('type'=>'checkbox', 'label' => 'make image your avatar', 'id' =>$picture['Picture']['id']));?>
         </div>
    </div>
    <?php endforeach; ?> 	
</div>

<br/>

<h2>Add a new picture</h2>
<?php
		echo $this->Form->create('Picture', array('type' => 'file', 'action' => 'add'));
		echo $this->Form->input('image', array('type' => 'file'));
		echo $this->Form->input('about', array('type' => 'textarea'));
		echo $this->Form->end('Submit');
?>