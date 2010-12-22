<?php

class UsersController extends AppController {
    /**
     * Returns the list of friend ids of the currently logged in user
     */
    function get_friends() {
        if (isset($this->params['requested'])) {
            //$this->layout = 'ajax';
            $id = 1;

            if ($id) {
                return $this->User->get_friend_info($id);
            } else {
                $this->redirect(array('admin' => FALSE, 'controller' => 'users', 'action' => 'login'));
            }
        }
    }

    
    /**
     * Returns the list of activity updates from friends of the currently
     * logged in user
     */
    function get_friend_activity() {
        if (isset($this->params['requested'])) {
            $id = 1;
            
            if ($id) {
                return $this->User->get_friend_activity($id);
            } else {
                $this->redirect(array('admin' => FALSE, 'controller' => 'users', 'action' => 'login'));
            }
        }
    }

    
    /**
     * Returns the list of shows of the currently logged in user
     */
    function get_shows() {
        if (isset($this->params['requested'])) {
            //$id = $this->Auth->user('id');
            $id = 1;

            if ($id) {
                return $this->User->get_shows($id);
            } else {
                $this->redirect(array('admin' => FALSE, 'controller' => 'users', 'action' => 'login'));
            }
        }
    }

    
    /**
     * Returns the list of upcoming episodes from now to the $date in the
     * future
     */
    function get_upcoming_episodes($date='+1 week') {
        if (isset($this->params['requested'])) {
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
    }


    /**
     * Generates the user's account page
     */
    function home() {
        //$id = $this->Auth->user('id');
        $id = 1;

        if ($id) {
            $user = $this->User->get_user_info($id);

            $this->set('selected', 1); // 1 being assigned to the Home link in navbar.ctp
            $this->set('username', $user['User']['username']);
            $this->set('user_id', $id);
        } else {
            $this->redirect(array('admin' => FALSE, 'controller' => 'users', 'action' => 'login'));
        }
    }
}
