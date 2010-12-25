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


    // Setup validation rules
    var $validate = array(
        'username' => array(
            'empty' => array(
                'rule' => 'notEmpty',
                'last' => TRUE,
                'message' => 'You did not enter a username.',
            ),
            'valid' => array(
                'rule' => '_alphaNumericDashUnderscore',
                'last' => TRUE,
                'message' => 'The username can only be numbers, letters, dashes, and underscores',
            ),
            'minlength' => array(
                'rule' => array('minLength', 4),
                'last' => TRUE,
                'message' => 'Your username must be at least 4 characters.',
            ),
            'maxlength' => array(
                'rule' => array('maxLength', 64),
                'last' => TRUE,
                'message' => 'Your username cannot be longer than 64 characters.',
            ),
            'exists' => array(
                'rule' => 'isUnique',
                'last' => TRUE,
                'message' => 'This username has already been selected.',
            ),
        ),
        'clear_password' => array(
            'empty' => array(
                'rule' => 'notEmpty',
                'last' => TRUE,
                'message' => 'Your password cannot be blank.',
            ),
            'notsimple' => array(
                'rule' => '_not_simple',
                'last' => TRUE,
                'message' => 'Your password is a common password. Please choose another.'
            ),
            'minlength' => array(
                'rule' => array('minLength', 8),
                'last' => TRUE,
                'message' => 'Your password must be a minimum of 8 characters.',
            ),
        ),
        'password_confirm' => array(
            'empty' => array(
                'rule' => 'notEmpty',
                'last' => TRUE,
                'message' => 'You must confirm your password.'
            ),
            'matches' => array(
                'rule' => array('_field_match', 'clear_password'),
                'last' => TRUE,
                'message' => 'Your passwords do not match.'
            ),
        ),
        'email' => array(
            'empty' => array(
                'rule' => 'notEmpty',
                'last' => TRUE,
                'message' => 'You must supply an email address.',
            ),
            'valid' => array(
                'rule' => 'email',
                'last' => TRUE,
                'message' => 'The email entered is not a valid email address.',
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 64),
                'last' => TRUE,
                'message' => 'Sorry but your email address cannot be longer than 64 characters.',
            ),
        ),
        'email_confirm' => array(
            'empty' => array(
                'rule' => 'notEmpty',
                'last' => TRUE,
                'message' => 'You must confirm your email address.',
            ),
            'matches' => array(
                'rule' => array('_field_match', 'email'),
                'last' => TRUE,
                'message' => 'Your email does not match.',
            ),
        ),
    );


    /**
     * Validates that the password is not simple and obvious
     */
    function _not_simple($fields) {
        // Extract the value because $fields is a hash
        $field = array_values($fields);
        $field = $field[0];

        // Setup array of simple passwords
        $simple_pass = array('123456', 'password', '12345678', 'qwerty',
            'abc123', '12345', 'monkey', '111111', 'consumer', 'letmein',
            '1234', 'dragon', 'trustno1', 'baseball', 'gizmodo', 'whatever',
            'superman', '1234567', 'sunshine', 'iloveyou', 'fuckyou',
            'starwars', 'shadow', 'princess', 'cheese', '123123', 'computer',
            'gawker', 'football', 'blahblah', 'nintendo', '000000', 'soccer',
            '654321', 'asdfasdf', 'master', 'michael', 'passw0rd', 'hello',
            'kotaku', 'pepper', 'jennifer', '666666', 'welcome', 'buster',
            'Password', 'batman', '1q2w3e4r', 'maggie', 'michelle', 'pokemon',
            'killer', 'andrew', 'internet', 'biteme', 'orange', 'jordan',
            'ginger', '123', 'aaaaaa', 'tigger', 'charlie', 'chicken',
            'nothing', 'fuckoff', 'deadspin', 'valleywa', 'qwerty12', 'george',
            'swordfis', 'summer', 'asdf', 'matthew', 'asdfgh', 'mustang',
            'yankees', 'hannah', 'asdfghjk', '1qaz2wsx', 'cookie', 'midnight',
            '123qwe', 'scooter', 'purple', 'banana', 'matrix', 'jezebel',
            'daniel', 'hunter', 'freedom', 'secret', 'redsox', 'spiderma',
            'phoenix', 'joshua', 'jessica', 'asshole', 'asdf1234', 'william',
            'qwertyui', 'jackson', 'foobar', 'nicole', '123321', 'peanut',
            'samantha', 'mickey', 'booger', 'poop', 'hockey', 'thx1138',
            '121212', 'ashley', 'silver', 'gizmodo1', 'chocolat', 'booboo',
            'metallic', '1q2w3e', 'bailey', 'google', 'babygirl', 'thomas',
            'simpsons', 'remember', 'gateway', 'oliver', 'monster', 'guitar',
            'qazwsx', 'taylor', 'madison', 'anthony', 'justin', 'elizabet',
            '1111', 'november', 'drowssap', 'bubbles', 'startrek', 'monkey12',
            'diamond', 'coffee', 'butterfl', 'brooklyn', 'amanda', 'adidas',
            'test', 'love', 'wordpass', 'sparky', 'morgan', 'merlin',
            'maverick', 'elephant', 'Highlife', 'poopoo', 'nirvana', 'liverpoo',
            'lauren', 'stupid', 'chelsea', 'compaq', 'boomer', 'yellow',
            'sophie', 'q1w2e3r4', 'fucker', 'coolness', 'cocacola', 'blink182',
            'zxcvbnm', 'snowball', 'snoopy', 'gundam', 'alexande', 'rachel',
            'jasmine', 'danielle', 'basketba', '7777777', 'thunder', 'snickers',
            'patrick', 'darkness', 'boston', 'abcd1234', 'pumpkin', 'creative',
            '88888888', 'smokey', 'sample12', 'godzilla', 'december', 'corvette',
            'brandon', 'bandit', '123abc', 'voodoo', 'turtle', 'spider',
            'london', 'jonathan', 'hello123', 'hahaha', 'chicago', 'austin',
            'tennis', 'scooby', 'naruto', 'mercedes', 'maxwell', 'fluffy',
            'eagles', '11111111', 'penguin', 'muffin', 'bullshit', 'steelers',
            'jasper', 'flower', 'ferrari', 'slipknot', 'pookie', 'murphy',
            'joseph', 'calvin', 'apples', '159753', 'tucker', 'martin',
            '11235813', 'whocares', 'pineappl', 'nicholas', 'jackass', 'goober',
            'chester', '8675309', '222222', 'winston', 'somethin', 'please',
            'dakota', '112233', 'rosebud', 'dallas', '696969', 'shithead',
            'popcorn');

        // Check if they match
        return ( ! in_array($field, $simple_pass));
    }


    /**
     * Validate that the two fields match
     */
    function _field_match($fields, $other) {
        // Extract the value because $fields is a hash
        $field = array_values($fields);
        $field = $field[0];

        $other = $this->data['User'][$other];

        // Check if they match
        return ($field === $other);
    }


    /**
     * Validates that the value contains only letters, numbers, dashes, and underscores
     */
    function _alphaNumericDashUnderscore($fields) {
        // Extract the value because $fields is a hash
        $field = array_values($fields);
        $field = $field[0];

        // Check if it is valid
        return preg_match('|^[0-9a-zA-Z_-]+$|', $field);
    }


    /**
     * Returns the average number of follows per user
     */
    function get_average_follow_count() {
        // Setup parameters
        $params = array(
            'contain' => FALSE,
            'fields' => array(
                'User.show_count',
            ),
        );

        // Perform query
        $counts = $this->find('list', $params);

        // Count the average
        $average_count = array_sum($counts) / count($counts);

        // Return the average
        return Sanitize::clean($average_count);
    }


    /**
     * Returns the number of users
     */
    function get_count() {
        // Perform count
        $user_count = $this->cache('count');
        
        // Return cleaned count
        return Sanitize::clean($user_count);
    }


    /**
     * Returns the user info
     */
    function get_user_info($user_id) {
        // Sanitize to be safe
        $user_id = Sanitize::clean($user_id);

        // Setup parameters
        $params = array(
            'contain' => FALSE, // save nothing else
            'conditions' => array(
                'User.id =' => $user_id, // match only this user
            ),
        );

        // Perform query
        $user = $this->cache('first', $params);

        // Return cleaned data
        return Sanitize::clean($user);
    }


    /**
     * Returns a list of the recent activity from the user's friends
     */
    function get_friend_activity($user_id) {
        // Sanitize to be safe
        $user_id = Sanitize::clean($user_id);

        // Get the friend ids in an array
        $friend_ids = $this->get_friend_ids($user_id);

        // Get the activity for these friends...say the last 10 items
        $activities = $this->Activity->get_recent_activity($friend_ids, 10);

        // Return the sanitized data
        return Sanitize::clean($activities);
    }


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

        // Flatten into an array of ids
        $ids = array();
        foreach ($friends as $id) {
            $ids[] = $id['Friend']['friend_id'];
        }

        // Return the cleaned data
        return Sanitize::clean($ids);
    }


    /**
     * Get the info of this user's friends
     */
    function get_friend_info($user_id) {
        // Sanitize just to be safe
        $user_id = Sanitize::clean($user_id);

        // Get the list of friend ids
        $friend_ids = $this->get_friend_ids($user_id);

        // Setup parameters
        $params = array(
            'contain' => FALSE,
            'conditions' => array(
                'User.id' => $friend_ids,
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
        /*App::import('Model', 'Show');
        $this->Show = new Show();*/

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
        $shows = $this->Show->find('all', $params);

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
                'Episode.air_date <' => date('Y-m-d', strtotime($date)),
                'Episode.air_date >=' => date('Y-m-d', time()),
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
        $episodes = $this->Episode->find('all', $params);

        // Return the cleaned data
        return Sanitize::clean($episodes);
    }
}
