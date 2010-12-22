<?php
    //$shows = $this->requestAction(array('controller' => 'shows', 'action' => 'index'));

    $date_format = 'F j, Y';

    $html->css('shows/index', null, array('inline' => FALSE));
?>

<div id="shows">
    <div class="header4">
        <h4>Your Shows:</h4>
    </div>

    <?php if (isset($shows) && ! empty($shows)): ?>

        <table>
        <tbody>
            <tr>
                <th></th>
                <th>Last Airing:</th>
                <th>Next Airing:</th>
            </tr>

        <?php foreach($shows as $show): ?>

            <?php
                $last_airing = $this->requestAction(array('controller' => 'shows', 'action' => 'get_last_airing'), array('pass' => array($show['Show']['id'])));
                $next_airing = $this->requestAction(array('controller' => 'shows', 'action' => 'get_next_airing'), array('pass' => array($show['Show']['id'])));
            ?>

            <tr class="show">
                <td><?php echo $html->link($show['Show']['display_name'], array('controller' => 'shows', 'action' => 'view', $show['Show']['name'])); ?></td>
                <td class="center"><?php echo $last_airing; ?></td>
                <td class="center"><?php echo $next_airing; ?></td>
            </tr>

        <?php endforeach; ?>

        </tbody>
        </table>

        <p id="add_show_link">
            <?php echo $html->link('Follow a new show', array('admin' => FALSE, 'controller' => 'shows', 'action' => 'follow_show')); ?>
            or
            <?php echo $html->link('Unfollow a show', array('admin' => FALSE, 'controller' => 'shows', 'action' => 'unfollow_show')); ?>
        </p>

    <?php else: ?>

        <p>You are not currently tracking any shows. Add a show <?php echo $html->link('here', array('controller' => 'users', 'action' => 'add_show')); ?>. </p>

    <?php endif; ?>
</div>
