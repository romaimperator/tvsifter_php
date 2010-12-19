<?php

class Episode extends AppModel {
    // Set up behaviors
    var $actsAs = array(
        'Containable',
        'Cacheable',
        'Linkable',
    );

    // Set up association with Show model
    var $belongsTo = array(
        'Show' => array(
            'counterCache' => TRUE,
        ),
    );
}
