<?php
    $html->css('users/account', null, array('inline' => FALSE));
?>

<h1 class="page_title">Welcome back <cake:nocache><?php echo $username; ?></cake:nocache>!</h1>

<?php echo $elementcombiner->element('users/upcoming', array('cache' => array('key' => $user_id, 'time' => '+10 minutes'))); ?>

<?php //echo $this->element('users/shows', array('cache' => FALSE));//array('key' => $user_id, 'time' => '+1 second'))); ?>

<?php echo $elementcombiner->element('users/friend_feed', array('cache' => array('key' => $user_id, 'time' => '+10 minutes'))); ?>
