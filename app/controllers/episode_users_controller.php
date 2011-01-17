<?php

/**
 * This controller handles the many-to-many relationship between episodes and
 * users.
 * 
 * @author Daniel Fox
 */
App::import('Sanitize');

class EpisodeUsersController extends AppController {
    var $components = array(
        'RequestHandler',
    );

    /**
     * Creates the relationship between the episode and the user
     */
    /*function add() {
        if ( ! empty($this->data)) {
            $this->data = Sanitize::clean($this->data);

            $this->EpisodeUser->create();
            $this->EpisodeUser->saveAll($this->data);
        }
    }*/


    /**
     * Marks the episode as watched for the logged in user
     */
    function mark_as_watched($id) {
        $user_id = $this->Auth->user('id');

        if ($user_id) {
            if ($this->params['isAjax']) {
                // Ajax submition only code
            } else {
                $existing = $this->_get_episode_user($user_id, $id);

                if ($existing) {
                    $this->EpisodeUser->id = $existing['EpisodeUser']['id'];
                    $this->EpisodeUser->saveField('watched', TRUE);
                } else {
                    $this->data['EpisodeUser']['episode_id'] = $id;
                    $this->data['EpisodeUser']['user_id'] = $user_id;
                    $this->data['EpisodeUser']['watched'] = TRUE;
                    $this->data['EpisodeUser']['downloaded'] = FALSE;
                    $this->EpisodeUser->save($this->data);
                }

                // Redirect to the page we came from
                $this->redirect($this->referer());
            }
        } else {
            $this->redirect($this->Auth->loginAction);
        }
    }


    /**
     * Unmarks the episode as watched for the logged in user
     */
    function unmark_as_watched($id) {
        $user_id = $this->Auth->user('id');

        if ($user_id) {
            if ($this->params['isAjax']) {
            } else {
                $existing = $this->_get_episode_user($user_id, $id);

                if ($existing) {
                    if ($existing['EpisodeUser']['downloaded'] == FALSE) {
                        $this->EpisodeUser->delete($existing['EpisodeUser']['id']);
                    } else {
                        $this->EpisodeUser->id = $existing['EpisodeUser']['id'];
                        $this->EpisodeUser->saveField('watched', FALSE);
                    }
                } 

                // Redirect to the page we came from
                $this->redirect($this->referer());
            }
        } else {
            $this->redirect($this->Auth->loginAction);
        }
    }


    /**
     * Marks the episode as watched for the logged in user
     */
    function mark_as_owned($id) {
        $user_id = $this->Auth->user('id');

        if ($user_id) {
            if ($this->params['isAjax']) {
            } else {
                $existing = $this->_get_episode_user($this->Auth->user('id'), $id);

                if ($existing) {
                    $this->EpisodeUser->id = $existing['EpisodeUser']['id'];
                    $this->EpisodeUser->saveField('downloaded', TRUE);
                } else {
                    $this->data['EpisodeUser']['episode_id'] = $id;
                    $this->data['EpisodeUser']['user_id'] = $this->Auth->user('id');
                    $this->data['EpisodeUser']['watched'] = FALSE;
                    $this->data['EpisodeUser']['downloaded'] = TRUE;
                    $this->EpisodeUser->save($this->data);
                }

                // Redirect to the page we came from
                $this->redirect($this->referer());
            }
        } else {
            $this->redirect($this->Auth->loginAction);
        }
    }


    /**
     * Unmarks the episode as watched for the logged in user
     */
    function unmark_as_owned($id) {
        $user_id = $this->Auth->user('id');

        if ($user_id) {
            if ($this->params['isAjax']) {
            } else {
                $existing = $this->_get_episode_user($this->Auth->user('id'), $id);

                if ($existing) {
                    if ($existing['EpisodeUser']['watched'] == FALSE) {
                        $this->EpisodeUser->delete($existing['EpisodeUser']['id']);
                    } else {
                        $this->EpisodeUser->id = $existing['EpisodeUser']['id'];
                        $this->EpisodeUser->saveField('downloaded', FALSE);
                    }
                } 

                // Redirect to the page we came from
                $this->redirect($this->referer());
            }
        } else {
            $this->redirect($this->Auth->loginAction);
        }
    }


    /**
     * Returns the episodeuser with the given user_id and episode_id
     */
    function _get_episode_user($user_id, $episode_id) {
        $params = array(
            'contain' => false,
            'conditions' => array(
                'EpisodeUser.user_id =' => $user_id,
                'EpisodeUser.episode_id =' => $episode_id,
            ),
            'fields' => array(
                'EpisodeUser.id',
                'EpisodeUser.user_id',
                'EpisodeUser.episode_id',
                'EpisodeUser.watched',
                'EpisodeUser.downloaded',
            ),
        );

        return $this->EpisodeUser->find('first', $params);
    }
}
