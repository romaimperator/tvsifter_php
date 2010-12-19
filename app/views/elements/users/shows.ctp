<?php $shows = $this->requestAction(array('controller' => 'users', 'action' => 'get_shows')); ?>

<?php
    $date_format = 'F j, Y';
?>

<h4>Your Shows:</h4>

<?php if (isset($shows) && ! empty($shows)): ?>

    <?php foreach($shows as $show): ?>

        <?php
            $last_airing = $this->requestAction(array('controller' => 'shows', 'action' => 'get_last_airing'), array('pass' => array($show['Show']['id'])));
            $next_airing = $this->requestAction(array('controller' => 'shows', 'action' => 'get_next_airing'), array('pass' => array($show['Show']['id'])));
        ?>

        <div class="show">
            <?php echo $html->link($show['Show']['display_name'], array('controller' => 'shows', 'action' => 'view', $show['Show']['name'])); ?>
            <p>Last Airing: <?php echo date($date_format, strtotime($last_airing)); ?></p>
            <p>Next Airing: <?php echo date($date_format, strtotime($next_airing)); ?></p>
        </div>

    <?php endforeach; ?>

<?php else: ?>

    <p>You are not currently tracking any shows. Add a show <?php echo $html->link('here', array('controller' => 'users', 'action' => 'add_show')); ?>. </p>

<?php endif; ?>
