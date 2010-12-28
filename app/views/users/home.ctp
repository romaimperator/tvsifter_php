<?php
    $html->css('users/account', null, array('inline' => FALSE));
?>

<h1 class="page_title">Welcome back <?php echo $username; ?>!</h1>

<?php echo $elementcombiner->element('users/upcoming', array('cache' => FALSE));//array('key' => $user_id, 'time' => '+1 second'))); ?>

<?php //echo $this->element('users/shows', array('cache' => FALSE));//array('key' => $user_id, 'time' => '+1 second'))); ?>

<?php echo $elementcombiner->element('users/friend_feed', array('cache' => FALSE));//array('key' => $user_id, 'time' => '+1 second'))); ?>
