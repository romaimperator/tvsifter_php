<?php
    echo $html->css('users/change_settings', null, array('inline' => FALSE));
    echo $html->script('users/change_settings', array('inline' => FALSE));
?>

<div id="change_settings">
    <div class="header4">
        <h4>Change Account Settings:</h4>
    </div>
    
    <?php if (isset($success)): ?>
        <div id="success">
            <p><?php echo $success; ?></p>
        </div>
    <?php endif; ?>

    <div id="password_form">
        <?php
            echo $form->create('User', array('action' => 'change_settings'));
            echo $form->input('clear_password',
                array(
                    'type' => 'password',
                    'label' => 'New Password',
                    'default' => '',
                )
            );
            echo $form->input('password_confirm',
                array(
                    'type' => 'password',
                    'label' => 'Confirm Password',
                    'default' => '',
                )
            );
            echo $form->end('Change Password');
        ?>
    </div>

    <p>Current Email: <strong><?php echo $email; ?></strong>
        <a href="javascript:toggle_email()">Edit</a>
    </p>

    <div id="email_form">
        <?php
            echo $form->create('User', array('action' => 'change_settings'));
            echo $form->input('email',
                array(
                    'label' => 'Email',
                    'default' => '',
                )
            );
            echo $form->input('email_confirm',
                array(
                    'label' => 'Confirm Email',
                    'default' => '',
                )
            );
            echo $form->end('Change Email');
        ?>
    </div>
</div>
