<?php echo $html->css('users/login', null, array('inline' => FALSE)); ?>

<div id="login_form">
    <div class="header4">
        <h4>Login:</h4>
    </div>

    <?php
        echo $this->Form->create('User', array('action' => 'login'));
        echo $this->Form->input('User.username');
    ?>
    <div id="password_fields">
    <?php
        echo $this->Form->input('User.clear_password',
            array(
                'type' => 'password',
                'label' => 'Password',
            )
        );
    ?>
    </div>
    <?php
        echo $this->Form->end('Login');
    ?>
</div>
