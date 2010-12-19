<?php
    $html->css('users/account', null, array('inline' => FALSE));
?>

<?php echo $this->element('users/upcoming', array('cache' => array('key' => $user_id, 'time' => '+1 second'))); ?>

<div id="middle">
    <?php echo $this->element('users/shows', array('cache' => array('key' => $user_id, 'time' => '+1 second'))); ?>

    <?php echo $this->element('users/friend_feed', array('cache' => array('key' => $user_id, 'time' => '+1 second'))); ?>
</div>
