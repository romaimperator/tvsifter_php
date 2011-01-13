<?php

class StatsController extends AppController {
    
    var $uses = array();

    /**
     * Retrieves the most up to date statistics about the site
     */
    function index() {
        App::import('Model', 'User');
        App::import('Model', 'Show');
        $this->User = new User();
        $this->Show = new Show();

        $stats = array();
        $stats['user_count'] = Sanitize::clean($this->User->get_count());
        $stats['show_count'] = Sanitize::clean($this->Show->get_count());
        $stats['avg_follow_count'] = Sanitize::clean($this->User->get_average_follow_count());

        return $stats;
    }
}
