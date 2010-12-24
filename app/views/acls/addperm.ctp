<?php
    echo $form->create('Acl', array('action' => 'addperm'));

    echo $form->input('Perm', array(
        'label' => 'Permission:',
        'options' => array(1 => 'allow', 0 => 'deny'),
        'type' => 'select',
    ));

    echo $form->input('Group.id', array(
        'label' => 'Group:',
        'options' => $groups,
        'type' => 'select',
    ));
    
    foreach($actions as $a) {
        $options[$a['Aco']['alias'] . '/' . $a['acos']['alias']] = $a['Aco']['alias'] . '/' . $a['acos']['alias'];
    }
    $options['controllers'] = 'controllers';

    echo $form->input('Aco.id', array(
        'label' => 'Controller/Action:',
        'options' => $options,
        'type' => 'select',
    ));

    echo $form->end('Add permission');
?>
