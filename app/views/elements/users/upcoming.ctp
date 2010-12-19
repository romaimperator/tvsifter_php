<?php
    $episodes = $this->requestAction(array('controller' => 'users', 'action' => 'get_upcoming_episodes'), array('pass' => array('+1 week')));
    
    $date_format = 'F j, Y';

    $html->css('users/upcoming', null, array('inline' => FALSE));
?>

<div id="episodes">
    <h4>Upcoming Episodes:</h4>

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
                <td class="upcoming_details"> <a href="/#">Details</a> </td>
            </tr>

        <?php endforeach; ?>

        </table>

    <?php else: ?>

    <?php endif; ?>
</div>
