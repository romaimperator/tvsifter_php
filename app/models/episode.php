<?php

class Episode extends AppModel {
    // Set up association with Show model
    var $belongsTo = array(
        'Show' => array(
            'counterCache' => TRUE,
        ),
    );
}
