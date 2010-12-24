<?php
    echo $this->Form->create('User', array('action' => 'login'));
    echo $this->Form->input('User.username');
    echo $this->Form->input('User.clear_password',
        array(
            'type' => 'password',
            'label' => 'Password',
        )
    );
    echo $this->Form->end('Login');
?>
