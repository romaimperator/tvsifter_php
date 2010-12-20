<?php

// Import the sanitizing component
App::import('Sanitize');

class User extends AppModel {
    // Set the association to the Show model
    var $hasAndBelongsToMany = array(
        'Show',
        'Friend' => array(
            'foreignKey' => 'user_id', 
            'associationForeignKey' => 'friend_id',
            'joinTable' => 'friends',
        ),
    );

    // Set the association to the activity model
    var $hasMany = array(
        'Activity',
    );


    /**
     * Returns a list of friend ids
     */
    function get_friend_ids($user_id) {
        // Sanitize just to be safe
        $user_id = Sanitize::clean($user_id);
        
        // Setup parameters
        $params = array(
            'contain' => FALSE,
            'conditions' => array(
                'User.id =' => $user_id,
            ),
            'fields' => array(
                'Friend.friend_id',
            ),
            'link' => array(
                'Friend' => array(
                    'fields' => array(
                        'Friend.friend_id',
                    ),
                    'conditions' => array(
                        'Friend.user_id = User.id',
                    ),
                ),
            ),
        );

        // Perform query
        $friends = $this->cache('all', $params);

        // Return the cleaned data
        return Sanitize::clean($friends);
    }


    /**
     * Get the info of this user's friends
     */
    function get_friend_info($user_id) {
        // Sanitize just to be safe
        $user_id = Sanitize::clean($user_id);

        // Get the list of friend ids
        $friend_ids = $this->get_friend_ids($user_id);

        // Flatten into an array of ids
        $ids = array();
        foreach ($friend_ids as $id) {
            $ids[] = $id['Friend']['friend_id'];
        }

        // Setup parameters
        $params = array(
            'contain' => FALSE,
            'conditions' => array(
                'User.id' => $ids,
            ),
            'fields' => array(
                'User.id',
                'User.username',
            ),
        );

        // Perform query
        $friends = $this->cache('all', $params);

        // Return cleaned data
        return Sanitize::clean($friends);
    }


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
            'order' => array(
                'Show.display_name ASC', // sort by the name
            ),
        );

        // Perform the query to get the shows
        $shows = $this->Show->cache('all', $params, array('duration' => '+1 second', 'update' => TRUE));

        // Return the cleaned data
        return Sanitize::clean($shows);
    }


    /**
     * Returns the episodes that air between today and $date in the future
     */
    function get_upcoming_episodes($user_id, $date) {
        // Ensure that the date is clean
        $date = Sanitize::clean($date);

        // Import the Episode model
        App::import('Model', 'Episode');
        $this->Episode = new Episode();

        // Set the query parameters
        $params = array(
            'conditions' => array(
                'shows_users.user_id =' => $user_id,
                'Episode.air_date >=' => date('Y-m-d', time($date)),
            ),
            'contain' => FALSE,
            'link' => array(
                'shows_users' => array(
                    'conditions' => 'shows_users.show_id = Episode.show_id',
                ),
                'Show' => array(
                    'conditions' => 'Episode.show_id = Show.id',
                ),
            ),
            'order' => array(
                'Episode.air_date ASC',
            ),
        );

        // Perform the query to get the episodes
        $episodes = $this->Episode->cache('all', $params);

        // Return the cleaned data
        return Sanitize::clean($episodes);
    }
}
