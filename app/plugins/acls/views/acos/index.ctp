<?php
/**
 * ACL Management Plugin
 *
 * @copyright     Copyright 2010, Joseph B Crawford II
 * @link          http://www.jbcrawford.net
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
echo $this->Html->css('/acls/css/tables');
echo $this->Html->script(array('/acls/js/jquery-1.4.2.min', '/acls/js/jquery-acl'));
echo '<h2>ACOs</h2>';
echo '<div id="breadcrumbs">';
if (!empty($path)) {
    foreach($path as $id => $alias) {
        $this->Html->addCrumb($alias, array('action' => 'index', $id));
    }
}
echo $this->Html->getCrumbs(' &#8250; ');
echo '</div>';
echo $form->create('Aco', array('action' => 'delete', 'id' => 'aco-form'));
echo '<table width="100%">';
echo '  <thead>';
echo '      <tr>';
echo '          <th width="25">' . $form->checkbox(null, array('id' => 'select-all')) . '</th>';
echo '          <th width="25">' . $html->link($this->Html->image('/acls/img/add.png', array('alt' => 'Add ACO')), array('action' => 'add', $parent_id), array('escape' => false, 'title' => 'Add ACO')) . '</th>';
echo '          <th width="75"></th>';
echo '          <th></th>';
echo '          <th>Alias</th>';
echo '          <th>Model</th>';
echo '          <th>ForeignKey</th>';
echo '      </tr>';
echo '  </thead>';
if (!empty($acos)) {
	echo '<tbody>';
    foreach($acos as $i) {
        if (empty($count)) $count = 1; else $count++;
        echo '<tr class="' . (($count % 2 == 0) ? 'even' : 'odd') . '">';
        echo '  <td>' . $form->checkbox('Aco.delete.' . $i['Aco']['id']) . '</td>';
        echo '  <td>' . $html->link($this->Html->image('/acls/img/edit.png', array('alt' => 'Edit ACO')), array('action' => 'edit', $i['Aco']['id']), array('escape' => false, 'title' => 'Edit ACO')) . '</td>';
        echo '  <td>' . $html->link($this->Html->image('/acls/img/permissions.png', array('alt' => 'View Permissions')), array('controller' => 'permissions', 'action' => 'index', $i['Aco']['id']), array('escape' => false, 'title' => 'View Permissions')) . ' <small>(' . $i['Aco']['num_permissions'] . ')</small></td>';
        echo '  <td>' . (($i['Aco']['num_children'] > 0) ? $html->link('Children', array('action' => 'index', $i['Aco']['id'])) : 'Children') . ' <small>(' . $i['Aco']['num_children'] . ')</small></td>';
        echo '  <td>' . $i['Aco']['alias'] . '</td>';
        echo '  <td>' . $i['Aco']['model'] . '</td>';
        echo '  <td>' . $i['Aco']['foreign_key'] . '</td>';
        echo '</tr>';
    }
	echo '</tbody>';
}
echo '</table>';
echo $form->hidden('parent_id', array('value' => $parent_id));
echo $form->submit('Delete Selected', array('after' => ' <input type="submit" value="Rebuild ACOs" id="rebuildButton" />'));
echo $form->end();
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#rebuildButton').click(function() {
            $('#aco-form').attr('action', '/acls/acos/rebuild').submit();
        });
    });
</script>
