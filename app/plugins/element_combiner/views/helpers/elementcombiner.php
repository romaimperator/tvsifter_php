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

        $css_file_path = ROOT.DS.APP_DIR.DS.'webroot'.DS.'css/'.$name.'.css';
        $js_file_path = ROOT.DS.APP_DIR.DS.'webroot'.DS.'js/'.$name.'.js';

        //debug($name);
        //debug($css_file_path);

        if (file_exists($css_file_path)) {
            $this->Html->css('/css/'.$name, null, array('inline' => FALSE));
        }
        if (file_exists($js_file_path)) {
            $this->Html->script('/js/'.$name, array('inline' => FALSE));
        }
        return $this->view->element($name, $params, $loadHelpers);
    }
}
