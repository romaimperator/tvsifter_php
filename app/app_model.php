<?php

// Import the lazy model plugin
App::import('Lib', 'LazyModel');

class AppModel extends LazyModel {
    // Set the behaviors
    var $actsAs = array(
        'Containable',
        'Cacheable',
        'Linkable',
    );
}
