<?php

class AppController extends Controller {
    var $helpers = array(
        'Asset.asset',// => array('debug' => TRUE),
        'Session',
        'Html',
        'Form',
        'Javascript',
    );

    var $components = array(
        'DebugKit.Toolbar' => array('panels' => array('Interactive.interactive')),
        'Acl',
        'Auth',
        'Session',
    );

    function beforeFilter() {
        parent::beforeFilter();

        $a =& $this->Auth;

        $a->allow('*');
        $a->allow('stats', 'display', 'register', 'login');

        $a->authorize = 'actions';
        $this->Auth->actionPath = 'controllers/';
        $a->autoRedirect = FALSE;
        $a->loginAction = array('controller' => 'users', 'action' => 'login');
        $a->loginRedirect = array('controller' => 'users', 'action' => 'home');
        $a->logoutRedirect = array('controller' => 'users', 'action' => 'login');

    }

    function __construct() {
        parent::__construct();
    }
}
