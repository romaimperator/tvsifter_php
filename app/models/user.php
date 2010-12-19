<?php

// Import the sanitizing component
App::import('Sanitize');

class User extends AppModel {
    // Set the behaviors
    var $actsAs = array(
        'Containable',
        'Cacheable',
        'Linkable',
    );

    // Set the association to the Show model
    var $hasAndBelongsToMany = array(
        'Show',
    );


    /**
     * Get the group id of this user. Needed for ACL.
     */
    function parentNode() {
        if (!$this->id && empty($this->data)) {
            echo 'returning null';
            return null;
        }
        $data = $this->data;
        if (empty($this->data)) {
            $data = $this->read();
        }
        if (!$data['User']['group_id']) {
            echo 'returning null';
            return null;
        } else {
            return array('Group' => array('id' => $data['User']['group_id']));
        }
    }


    /**
     * Returns all of the shows tracked by the user.
     */
    function get_shows($user_id) {
        // Ensure that the id is clean
        $user_id = Sanitize::clean($user_id);

        // Import the show model so we can use linkable and go many-to-one
        App::import('Model', 'Show');
        $this->Show = new Show();

        // Set the query parameters
        $params = array(
            'conditions' => array(
                'User.id =' => $user_id, // only the matching user's shows
            ),
            'contain' => false, // don't save any data except for the show info
            'link' => array(
                'User', // link the shows to the user
            ),
        );

        // Perform the query to get the shows
        $shows = $this->Show->cache('all', $params, array('duration' => '+1 second', 'update' => TRUE));

        // Return the cleaned data
        return Sanitize::clean($shows);
    }
}
