<?php

class ShowsUsers extends AppModel {
    /**
     * Returns a list of show_ids that the user_id matches as following.
     *
     * @param user_id the user id to find the data for
     */
    function get_show_ids($user_id) {
        // Setup query
        $params = array(
            'contain' => FALSE,
            'conditions' => array(
                'ShowsUsers.user_id =' => $user_id,
            ),
            'fields' => array(
                'ShowsUsers.show_id',
                'ShowsUsers.user_id',
            ),
        );

        // Perform query
        $show_ids = $this->find('list', $params);

        //debug($show_ids);

        return $show_ids;
    }
}
