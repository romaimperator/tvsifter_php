<?php

class Activity extends AppModel {
    // Set the association to the user
    var $belongsTo = array(
        'User',
    );


    /**
     * Returns the activity from the last 7 days, limited if provided, of the
     * user_ids specified
     */
    function get_recent_activity($user_ids, $limit=FALSE) {
        // Sanitize the user id
        $user_ids = Sanitize::clean($user_ids);

        // Setup the query parameters
        $params = array(
            'contain' => FALSE, // don't save anything else
            'conditions' => array(
                'Activity.user_id' => $user_ids, // only grab these friend's
                'Activity.created >=' => date('Y-m-d', strtotime('-7 days')), // only grab activity within 7 days
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
