<?php

class UsersController extends AppController {
    
    /**
     * Returns the list of shows of the currently logged in user
     */
    function get_shows() {
        //$id = $this->Auth->user('id');
        $id = 1;

        if ($id) {
            return $this->User->get_shows($id);
        } else {
            $this->redirect(array('admin' => FALSE, 'controller' => 'users', 'action' => 'login'));
        }
    }

    
    /**
     * Returns the list of upcoming episodes from now to the $date in the
     * future
     */
    function get_upcoming_episodes($date) {
        // Sanitize just to be safe
        $date = Sanitize::clean($date);

        // $id = $this->Auth->user('id');
        $id = 1;

        if ($id) {
            // Run query
            return $this->User->get_upcoming_episodes($id, $date);
        } else {
            $this->redirect(array('admin' => FALSE, 'controller' => 'users', 'action' => 'login'));
        }
    }


    /**
     * Generates the user's account page
     */
    function account() {
        //$id = $this->Auth->user('id');
        $id = 1;

        if ($id) {
            $this->set('user_id', $id);
        } else {
            $this->redirect(array('admin' => FALSE, 'controller' => 'users', 'action' => 'login'));
        }
    }
}
