<?php $logged_in = $session->check('Auth.User.id'); ?>
<?php if (empty($selected)) { $selected = 'none'; } ?>

<div class="navbar">
<ul>
<?php //////////////////////////
      // BEGIN LOGGED IN MENU //
      ////////////////////////// ?>
    <?php if ($logged_in): ?>

        <li class="nav_item <?php echo $selected == 'home' ? 'nav_selected' : ''; ?>">
        <?php
            $url = array(
                'action' => 'home',
                'admin' => FALSE,
                'controller' => 'users',
            );
            echo $html->link('Home', $url);
        ?>
        </li>

    <?php endif; ?>

    <?php if ($logged_in): ?>

        <li class="nav_item <?php echo $selected == 'my shows' ? 'nav_selected' : ''; ?>">
        <?php
            $url = array(
                'action' => 'index',
                'admin' => FALSE,
                'controller' => 'shows',
            );
            echo $html->link('My Shows', $url);
        ?>
        </li>

    <?php endif; ?>

    <?php if ($logged_in): ?>

        <li class="nav_item <?php echo $selected == 'browse shows' ? 'nav_selected' : ''; ?>">
        <?php
            $url = array(
                'action' => 'search_page',
                'admin' => FALSE,
                'controller' => 'shows',
            );
            echo $html->link('Browse Shows', $url);
        ?>
        </li>

    <?php endif; ?>

    <?php if ($logged_in): ?>

        <li class="nav_item <?php echo $selected == 'settings' ? 'nav_selected' : ''; ?>">
        <?php
            $url = array(
                'action' => 'change_settings',
                'admin' => FALSE,
                'controller' => 'users',
            );
            echo $html->link('Settings', $url);
        ?>
        </li>

    <?php endif; ?>

    <?php if ($logged_in): ?>

        <li class="nav_item">
        <?php
            $url = array(
                'action' => 'logout',
                'admin' => FALSE,
                'controller' => 'users',
            );
            echo $html->link('Logout', $url);
        ?>
        </li>

    <?php endif; ?>

<?php ///////////////////////////
      // BEGIN LOGGED OUT MENU //
      /////////////////////////// ?>
    <?php if ( ! $logged_in): ?>

        <li class="nav_item <?php echo $selected == 'login' ? 'nav_selected' : ''; ?>">
        <?php
            $url = array(
                'action' => 'login',
                'admin' => FALSE,
                'controller' => 'users',
            );
            echo $html->link('Login', $url);
        ?>
        </li>

    <?php endif; ?>

    <?php if ( ! $logged_in): ?>

        <li class="nav_item <?php echo $selected == 'register' ? 'nav_selected' : ''; ?>">
        <?php
            $url = array(
                'action' => 'register',
                'admin' => FALSE,
                'controller' => 'users',
            );
            echo $html->link('Register', $url);
        ?>
        </li>

    <?php endif; ?>

</ul>
</div>
