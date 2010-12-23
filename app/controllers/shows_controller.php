<?php

class ShowsController extends AppController {
    var $components = array(
        'RequestHandler',
    );

    var $helpers = array(
        'Ajax',
        'Js',
    );

    /**
     * Marks the show as followed by the currently logged in user
     */
    function follow($show_id) {
        // Sanitize to be safe
        $show_id = Sanitize::clean($show_id);

        //$user_id = $this->Auth->user('id');
        $user_id = 1;

        if ($user_id) {
            // Mark the show as followed
            $this->Show->follow($show_id, $user_id);
        } else {
            $this->cakeError('error404');
        }
   }
            
    
    /**
     * Returns all of the shows available
     */
    function all() {
        if ($this->params['isAjax']) {
            // This is sent via ajax so setup JSON output
            $this->layout = 'ajax';
            
            // Grab the data
            $show_names = $this->Show->get_all_show_names();

            // Set the return value
            $this->set('show_names', $show_names);
        }
    }


    /**
     * Returns all untracked shows by the logged in user
     */
    function all_untracked() {
        //if ($this->params['isAjax']) {
            // Returning JSON output
            $this->layout = 'ajax';

            // Get the user id
            //$user_id = $this->Auth->user('id');
            $user_id = 1;

            if ($user_id) {
                // Grab the data
                $show_names = $this->Show->get_all_show_names($user_id);

                // Set the return
                $this->set('show_names', $show_names);
            }
        //}
    }


    /**
     * Search by show name
     */
    function search() {
        // Sanitize to be safe
        $this->data = Sanitize::clean($this->data);

        if ($this->params['isAjax']) {
            // Set ajax output
            $this->layout = 'ajax';

            // Grab the similar matches
            $show_names = $this->Show->get_similar_show_names($this->data['Show']['display_name']);

            // Return values
            $this->set('show_names', $show_names);
        }
    }


    /**
     * Shows the list of shows tracked by the currently logged in user
     */
    function index() {
        //$user_id = $this->Auth->user('id');
        $user_id = 1;

        if ($user_id) {
            $shows = $this->Show->get_tracked_shows($user_id);

            $this->set('selected', 2); // 2 being the number assigned to the Your Shows link in navbar.ctp
            $this->set('user_id', $user_id);
            $this->set('shows', $shows);
        } else {
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
    }


    /**
     * Unfollows the logged in user from the show specified by the id
     */
    function unfollow($show_id) {
        // Sanitize to be safe
        $show_id = Sanitize::clean($show_id);

        // Get the logged in user id
        //$user_id = $this->Auth->user('id');
        $user_id = 1;

        // Check if user is logged in
        if ($user_id) {
            // Unfollow
            $this->Show->unfollow($show_id, $user_id);
        } else {
            $this->cakeError('error404');
        }
    }
    
    /**
     * Returns the date of the next episode of a show
     */
    function get_next_airing($show_id) {
        if (isset($this->params['requested'])) {
            // Sanitize just to be safe
            $show_id = Sanitize::clean($show_id);

            // Query for the date
            return $this->Show->get_next_airing($show_id);
        }
    }


    /**
     * Returns the date of the last episode of a show
     */
    function get_last_airing($show_id) {
        if (isset($this->params['requested'])) {
            // Sanitize just to be safe
            $show_id = Sanitize::clean($show_id);

            // Query for the date
            return $this->Show->get_last_airing($show_id);
        }
    }


    // This function should be removed before going live.
    // It grabs the tvrage.com episode list page for the $show_name and the
    // uses the show model's parser to store the show data.
    function refresh($show_name, $refresh=false) {
        $show_name = Sanitize::clean($show_name);
        // Find the first show that matches the name given
        $params = array(
            'conditions' => array(
                'Show.name' => $show_name,
            ),
            'contain' => false,
        );

        // check if this show has already been acquired
        $show = $this->Show->find('first', $params);
        $this->Show->id = $show['Show']['id'];

        // If the show doesn't yet exist, create it
        if ( ! $show) {
            $this->Show->create();
            $this->Show->set('name', $show_name);

            // set the display name as the first letter capitalized,
            // underscores removed name
            $display_name = ucwords(str_replace("_", " ", $show_name));
            $this->Show->set('display_name', $display_name);
            $this->Show->save();
            $show = $this->Show->find('first', $params);
            $this->Show->read(null, $show['Show']['id']);
        }

        // If the refresh option is there or the html has not been cached yet,
        // retrieve the page from TVRage.
        $show_addr = 'http://www.tvrage.com/'.$show_name.'/episode_list/all';

        // the utf8 decode is necessary because otherwise the show names
        // must be decoded twice before rendered to view
        $episode_list_html = utf8_decode(file_get_contents($show_addr));
        $this->Show->save($show);

        // parse the received html and store the episode list
        $this->set('response', $this->Show->parse_html($episode_list_html));
    }
}
