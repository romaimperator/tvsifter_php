<?php echo $html->css('users/register', null, array('inline' => FALSE)); ?>

<div id="register_form">
    <div class="header4">
        <h4>Become a member:</h4>
    </div>

    <?php
        echo $form->create('User', array('action' => 'register'));

        echo $form->input('User.username');
    ?>

    <div id="email_fields">
    <?php
        echo $form->input('User.email');
        echo $form->input('User.email_confirm', array(
            'label' => 'Confirm Email'
        ));
    ?>
    </div>

    <div id="password_fields">
    <?php
        echo $form->input('User.clear_password', array(
            'type' => 'password',
            'label' => 'Password',
        ));

        echo $form->input('password_confirm', array(
            'type' => 'password',
            'label' => 'Confirm Password'
        ));
    ?>
    </div>

    <?php
        echo $form->end('Register');
    ?>
</div>
