<?php echo $html->css('navbar', null, array('inline' => FALSE)); ?>

<?php $selected = 1;?>
<?php $logged_in = TRUE; ?>

<div class="navbar">
<ul>
    <?php if ($logged_in): ?>

        <li class="nav_item <?php echo $selected == 1 ? 'nav_selected' : ''; ?>">
        <?php
            $url = array(
                'admin' => FALSE,
                'controller' => 'users',
                'action' => 'account',
            );
            $options = array(   
                'escape' => FALSE,
            );
            echo $html->link('Account', $url, $options);
        ?>
        </li>

    <?php endif; ?>

    <?php if ( ! $logged_in): ?>

        <li class="nav_item">
        <?php
            $url = array(
                'admin' => FALSE,
                'controller' => 'users',
                'action' => 'login',
            );
            $options = array(   
                'escape' => FALSE,
            );
            echo $html->link('Login', $url, $options);
        ?>
        </li>

    <?php endif; ?>

    <?php if ($logged_in): ?>

        <li class="nav_item">
        <?php
            $url = array(
                'admin' => FALSE,
                'controller' => 'users',
                'action' => 'logout',
            );
            $options = array(   
                'escape' => FALSE,
            );
            echo $html->link('Logout', $url, $options);
        ?>
        </li>

    <?php endif; ?>
</ul>
</div>
