<?php

App::import('Sanitize');

class AclsController extends AppController {
    var $uses = array();

    function addperm() {
        $this->data = Sanitize::clean($this->data);

        Controller::loadModel('Group');
        Controller::loadModel('Aco');

        if ($this->data) {
            $acl =& $this->Acl;
            $group =& $this->Group;
            $data = $this->data;

            $group->id = $data['Group']['id'];

            //$this->p($data); die();

            if ($data['Acl']['Perm'] == 1) {
                $acl->allow($group, $data['Aco']['id']);
            }
            else if ($data['Acl']['Perm'] == 0) {
                $acl->deny($group, $data['Aco']['id']);
            }
            $this->redirect(array('controller' => 'acls', 'action' => 'addperm'));

        } else {
            $params = array(
                'contain' => false,
            );
            
            $groups = Sanitize::clean($this->Group->find('list', $params));

            $params = array(
                'contain' => false,
                'joins' => array(
                    array(
                        'table' => 'acos',
                        'type' => 'inner',
                        'conditions' => array(
                            'Aco.id = acos.parent_id',
                        ),
                    ),
                ),
                'fields' => array(
                    'Aco.alias',
                    'acos.alias',
                    'acos.id',
                ),
            );
            $actions = Sanitize::clean($this->Aco->find('all', $params));

            $this->set('groups', $groups);
            $this->set('actions', $actions);
        }
    }

    function checkperms() {
        Controller::loadModel('User');

        $user = $this->User;

        $user->id = 9;//$this->Auth->user('id');

        echo "'",var_dump($this->Acl->check($user, 'Acl')), "'";
        echo var_dump($this->Acl->check($user, 'acl/addperm'));
    }
    
    function createaros() {
        $aro =& $this->Acl->Aro;

        $groups = array(
            0 => array(
                'alias' => 'admin',
            ),
            1 => array(
                'alias' => 'manager',
            ),
            2 => array(
                'alias' => 'user',
            ),
        );

        foreach ($groups as $data) {
            $aro->create();
            $aro->save($data);
        }
    }


    function assignperms() {
        Controller::loadModel('Group');

        $acl =& $this->Acl;
        $group =& $this->Group;

        $group->id = 1;
        $acl->allow($group, 'controllers');

        $group->id = 3;
        $acl->deny($group, 'controllers');

        $acl->allow($group, 'Users/login');
        $acl->allow($group, 'Users/logout');
        $acl->allow($group, 'Users/register');
        $acl->allow($group, 'Users/get_friends');
        $acl->allow($group, 'Users/get_friend_activity');
        $acl->allow($group, 'Users/get_shows');
        $acl->allow($group, 'Users/get_upcoming_episodes');
        $acl->allow($group, 'Users/home');

        $acl->allow($group, 'Shows/follow');
        $acl->allow($group, 'Shows/all');
        $acl->allow($group, 'Shows/all_untracked');
        $acl->allow($group, 'Shows/search');
        $acl->allow($group, 'Shows/index');
        $acl->allow($group, 'Shows/unfollow');
        $acl->allow($group, 'Shows/get_next_airing');
        $acl->allow($group, 'Shows/get_last_airing');
    }


    /**
    * Rebuild the Acl based on the current controllers in the application
    *
    * @return void
    */
    function buildAcl() {
        $log = array();
 
        $aco =& $this->Acl->Aco;
        $root = $aco->node('controllers');
        if (!$root) {
            $aco->create(array('parent_id' => null, 'model' => null, 'alias' => 'controllers'));
            $root = $aco->save();
            $root['Aco']['id'] = $aco->id; 
            $log[] = 'Created Aco node for controllers';
        } else {
            $root = $root[0];
        }   
 
        App::import('Core', 'File');
        $Controllers = Configure::listObjects('controller');
        $appIndex = array_search('App', $Controllers);
        if ($appIndex !== false ) {
            unset($Controllers[$appIndex]);
        }
        $baseMethods = get_class_methods('Controller');
        $baseMethods[] = 'buildAcl';
 
        // look at each controller in app/controllers
        foreach ($Controllers as $ctrlName) {
            App::import('Controller', $ctrlName);
            $ctrlclass = $ctrlName . 'Controller';
            $methods = get_class_methods($ctrlclass);
 
            // find / make controller node
            $controllerNode = $aco->node('controllers/'.$ctrlName);
            if (!$controllerNode) {
                $aco->create(array('parent_id' => $root['Aco']['id'], 'model' => null, 'alias' => $ctrlName));
                $controllerNode = $aco->save();
                $controllerNode['Aco']['id'] = $aco->id;
                $log[] = 'Created Aco node for '.$ctrlName;
            } else {
                $controllerNode = $controllerNode[0];
            }
 
            //clean the methods. to remove those in Controller and private actions.
            foreach ($methods as $k => $method) {
                if (strpos($method, '_', 0) === 0) {
                    unset($methods[$k]);
                    continue;
                }
                if (in_array($method, $baseMethods)) {
                    unset($methods[$k]);
                    continue;
                }
                $methodNode = $aco->node('controllers/'.$ctrlName.'/'.$method);
                if (!$methodNode) {
                    $aco->create(array('parent_id' => $controllerNode['Aco']['id'], 'model' => null, 'alias' => $method));
                    $methodNode = $aco->save();
                    $log[] = 'Created Aco node for '. $method;
                }
            }
        }
        debug($log);
    }
}
