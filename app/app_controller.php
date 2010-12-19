<?php

class AppController extends Controller {
    var $helpers = array(
        'Asset.asset' => array('debug' => TRUE),
        'Session',
        'Html',
        'Form',
        'Javascript',
    );

    var $components = array(
        'DebugKit.Toolbar',
    );

    function __construct() {
        parent::__construct();
    }
}
