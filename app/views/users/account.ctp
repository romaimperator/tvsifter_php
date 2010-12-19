<?php echo $this->element('users/upcoming', array('cache' => array('key' => $user_id, 'time' => '+1 second'))); ?>

<?php echo $this->element('users/shows', array('cache' => array('key' => $user_id, 'time' => '+1 second'))); ?>
