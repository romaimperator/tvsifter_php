<?php

class EpisodeUser extends AppModel {
    var $actsAs = array(
        'Containable',
        'Cacheable',
    );

    var $belongsTo = array(
        'User',
        'Episode',
    );
}
