<?php
    $html->css('shows/index', null, array('inline' => FALSE));
    $html->script('shows/index.js', FALSE);
?>

<cake:nocache>
<?php echo $elementcombiner->element('shows/index', array('cache' => array('key' => $user_id, 'time' => '+10 minutes'))); ?>
</cake:nocache>
