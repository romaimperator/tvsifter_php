<?php
    echo $elementcombiner->element('shows/view',
        array(
            'cache' => array('time' => '+1 second', 'key' => $show_id),
            'show_id' => $show_id
        )
    );
?>
