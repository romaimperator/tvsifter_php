<?php
    //$shows = $this->requestAction(array('controller' => 'shows', 'action' => 'index'));

    $date_format = 'F j, Y';
?>

<div id="shows">
    <div class="header4">
        <h4>My Shows:</h4>
    </div>

    <?php if (isset($shows) && ! empty($shows)): ?>

        <table>
        <tbody>
            <tr>
                <th id="first_col" class="unfollow"></th>
                <th id="second_col"></th>
                <th id="third_col">Last Airing:</th>
                <th id="fourth_col">Next Airing:</th>
            </tr>

        <?php foreach($shows as $show): ?>

            <?php
                $last_airing = $this->requestAction(array('controller' => 'shows', 'action' => 'get_last_airing'), array('pass' => array($show['Show']['id'])));
                $next_airing = $this->requestAction(array('controller' => 'shows', 'action' => 'get_next_airing'), array('pass' => array($show['Show']['id'])));
            ?>

            <tr class="show" id="<?php echo $show['Show']['id']; ?>">
                <td class="unfollow"><?php echo $html->image('red_x.png'); ?></td>
                <td class="normal_td"><?php echo $html->link($show['Show']['display_name'], array('controller' => 'shows', 'action' => 'view', $show['Show']['name'])); ?></td>
                <td class="normal_td center"><?php echo $last_airing; ?></td>
                <td class="normal_td center"><?php echo $next_airing; ?></td>
            </tr>

        <?php endforeach; ?>

         <?php //echo $ajax->autoComplete('Show.display_name', array('controller' => 'shows', 'action' => 'search')) ?>
        </tbody>
        </table>

        <div id="search_div"><input class="follow" type="text" value="Enter search here..." id="follow_search" /></div>

        <p id="add_show_link">
            <?php echo $html->link('Follow a new show', 'javascript:toggle_follow_show()'); //array('admin' => FALSE, 'controller' => 'shows', 'action' => 'follow_show')); ?>
            or
            <?php echo $html->link('Unfollow a show', 'javascript:unfollow_show()'); ?>
        </p>

    <?php else: ?>

        <p>You are not currently tracking any shows. Add a show <?php echo $html->link('here', array('controller' => 'users', 'action' => 'add_show')); ?>. </p>

    <?php endif; ?>
</div>
