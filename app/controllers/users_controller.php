<?php

class UsersController extends AppController {
    /**
     * Logs the user in after validating password
     */
    function login() {
        if ($this->data) {
            // Sanitize the data
            $data = Sanitize::clean($this->data);

            // Validate the login
            $data['User']['password'] = $this->Auth->password($data['User']['clear_password']);
            if ($this->Auth->login($data)) {
                // On success redirect to the proper page
                $this->redirect($this->Auth->loginRedirect);
            } else {
                // On error show error message
                $this->Session->setFlash('Login failed. Check that both the username and password are correct.');
            }
        }
    }


    /**
     * Registers the new user
     */
    function register() {
        // First ensure that there is data otherwise skips straight to the page
        // rendering.
        if ($this->data) {
            // Clean out the loaded model User data just in case
            $this->User->create();

            // Sanitize the data the user submitted
            $data = Sanitize::clean($this->data);

            // Assign the hashed password from the form input field to the
            // model's password field
            $data['User']['password'] = $this->Auth->password($data['User']['clear_password']);

            // Set the user's group
            $data['User']['group_id'] = '3';
            
            // Attempt to save the data. If validation passes the login the new
            // user and redirect them. Otherwise skip straight back to the
            // validation page.
            if ($this->User->saveAll($data)) {
                $this->Auth->login($data);
                $this->redirect($this->Auth->loginRedirect);
            }
        }
        $this->set('selected', 3);
    } 


    /**
     * Logout the user
     */
    function logout() {
        $this->redirect($this->Auth->logout());
    }


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
