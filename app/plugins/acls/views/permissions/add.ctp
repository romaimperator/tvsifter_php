<?php
/**
 * ACL Management Plugin
 *
 * @copyright     Copyright 2010, Joseph B Crawford II
 * @link          http://www.jbcrawford.net
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
echo '<h2>Add Permission to ' . implode('/', $path) . '</h2>';
echo $form->create('Permission');
echo $form->hidden('aco_id');
echo $form->input('aro_id', array('label' => 'Access Request Object', 'empty' => true));
echo $form->input('_create', array('options' => $perms));
echo $form->input('_read', array('options' => $perms));
echo $form->input('_update', array('options' => $perms));
echo $form->input('_delete', array('options' => $perms));
echo $form->submit('Submit', array('after' => ' or ' . $html->link('Cancel', array('action' => 'index', $this->data['Permission']['aco_id']))));
echo $form->end();
?>
