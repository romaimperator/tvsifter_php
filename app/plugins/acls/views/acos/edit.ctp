<?php
/**
 * ACL Management Plugin
 *
 * @copyright     Copyright 2010, Joseph B Crawford II
 * @link          http://www.jbcrawford.net
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
echo '<h2>Edit ACO</h2>';
echo $form->create('Aco');
echo $form->hidden('id');
echo $form->input('parent_id', array('empty' => 'None'));
echo $form->input('alias');
echo $form->input('model');
echo $form->input('foreign_key');
echo $form->submit('Submit', array('after' => ' or ' . $html->link('Cancel', array('action' => 'index', $this->data['Aco']['parent_id']))));
echo $form->end();
?>
