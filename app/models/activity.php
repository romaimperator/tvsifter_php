<?php

class Activity extends AppModel {
    // Set the association to the user
    var $belongsTo = array(
        'User',
    );


    /**
     * Returns the activity from the last 7 days, limited if provided
     */
    function get_recent_activity($user_id, $limit=FALSE) {
        // Sanitize the user id
        $user_id = Sanitize::clean($user_id);

        // Setup the query parameters
        $params = array(
            'contain' => FALSE, // don't save anything else
            'conditions' => array(
                'Activity.user_id =' => $user_id, // only grab this friend's
                'Activity.created >=' => date('Y-m-d H:i:s', time('-7 days')), // only grab activity within 7 days
            ),
            'order' => array(
                'Activity.created DESC', // order so the most recent is first
            ),
        );

        // Add the limit if provided
        if ($limit && is_numeric($limit)) {
            $params['limit'] = $limit;
        }

        // Perform query
        $activity = $this->cache('all', $params);

        // Return the cleaned array
        return Sanitize::clean($activity);
    }
}
