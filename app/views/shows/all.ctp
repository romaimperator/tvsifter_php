<?php
    Configure::write('debug', 0);

    if ( ! empty($show_names)) {

        echo $js->object($show_names);

    }
?>
