<?php
    $episodes = $this->requestAction(array('controller' => 'users', 'action' => 'get_upcoming_episodes'), array('pass' => array('+6 week')));

    $date_format = 'F j, Y'; // example: January 20, 2010

    //$html->css('users/upcoming', null, array('inline' => FALSE));
    //$html->script('users/upcoming.js', array('inline' => FALSE));
?>

<div id="episodes">
    <div class="header4">
        <h4>Upcoming Episodes:</h4>
    </div>

    <?php if ( ! empty($episodes)): ?>

        <?php $cur_time = 0; ?>

        <table id="upcoming_table">

        <?php foreach($episodes as $e): ?>

            <tr>
                <td class="upcoming_date">

                <?php if ($e['Episode']['air_date'] != $cur_time): ?>

                    <?php $cur_time = $e['Episode']['air_date']; ?>

                    <?php echo date($date_format, strtotime($cur_time)); ?>
                    
                <?php endif; ?>

                </td>
                <td class="upcoming_show"> <?php echo $html->link($e['Show']['display_name'], array('controller' => 'shows', 'action' => 'view', $e['Show']['name'])); ?> </td>
                <td class="upcoming_episode"> <?php echo $e['Episode']['name']; ?> </td>
                <td class="upcoming_details"> <a href="javascript:show_details(<?php echo $e['Episode']['id']; ?>)">Details</a> </td>
            </tr>
            <tr>
                <td></td>
                <td class="center"><div class="hidden <?php echo $e['Episode']['id'];?>">Season: <?php echo $e['Episode']['season']; ?></div></td>
                <td class="center"><div class="hidden <?php echo $e['Episode']['id'];?>">Episode: <?php echo $e['Episode']['episode']; ?></div></td>
            </tr>

        <?php endforeach; ?>

        </table>

    <?php else: ?>

        <p>There are no upcoming episodes.</p>

    <?php endif; ?>
</div>
