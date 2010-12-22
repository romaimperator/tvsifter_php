<?php echo $html->css('navbar', null, array('inline' => FALSE)); ?>

<?php $logged_in = TRUE; ?>

<div class="navbar">
<ul>
    <?php if ($logged_in): ?>

        <li class="nav_item <?php echo $selected == 1 ? 'nav_selected' : ''; ?>">
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

    <?php endif; ?>

    <?php if ($logged_in): ?>

        <li class="nav_item <?php echo $selected == 2 ? 'nav_selected' : ''; ?>">
        <?php
            $url = array(
                'action' => 'index',
                'admin' => FALSE,
                'controller' => 'shows',
            );
            echo $html->link('Your Shows', $url);
        ?>
        </li>

    <?php endif; ?>

    <?php if ( ! $logged_in): ?>

        <li class="nav_item">
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
</ul>
</div>
