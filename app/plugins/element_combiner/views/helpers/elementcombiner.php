<?php

class ElementCombinerHelper extends Helper {
    function __construct() {
        parent::__construct();

        $this->view =& ClassRegistry::getObject('view');
    }

    /**
     * When including an element, also includes css and javascript of similarly
     * named files
     */
    function element($name, $params = array(), $loadHelpers = false) {
        App::import('Helper', 'Html');
        $this->Html = new HtmlHelper();

        $this->Html->css($name, null, array('inline' => FALSE));
        $this->Html->script($name, array('inline' => FALSE));
        return $this->view->element($name, $params, $loadHelpers);
    }
}
