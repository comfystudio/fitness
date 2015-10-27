<?php echo $html->link('inbox', array('controller' => 'messages', 'action' => 'inbox', $this->Session->read('User.id')));?>
<br/>
<?php echo $html->link('sent', array('controller' => 'messages', 'action' => 'sent', $this->Session->read('User.id')));?>
<br/>
<?php echo $html->link('compose', array('controller' => 'messages', 'action' => 'compose', $this->Session->read('User.id')));?>