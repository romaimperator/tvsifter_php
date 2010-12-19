<?php $episodes = $this->requestAction(array('controller' => 'users', 'action' => 'get_upcoming_episodes'), array('pass' => array('+1 week'))); ?>

<?php
    $date_format = 'F j, Y';
?>

<div class="episodes">
    <h4>Upcoming Episodes:</h4>

    <?php if ( ! empty($episodes)): ?>

        <?php $cur_time = 0; ?>

        <table>

        <?php foreach($episodes as $e): ?>

            <tr>
                <td>

                <?php if ($e['Episode']['air_date'] != $cur_time): ?>

                    <?php $cur_time = $e['Episode']['air_date']; ?>

                    <?php echo date($date_format, strtotime($cur_time)); ?>
                    
                <?php endif; ?>

                </td>
                <td> <?php echo $html->link($e['Show']['display_name'], array('controller' => 'shows', 'action' => 'view', $e['Show']['name'])); ?> </td>
                <td> <?php echo $e['Episode']['name']; ?> </td>
                <td> <a href="/#">Details</a> </td>
            </tr>

        <?php endforeach; ?>

        </table>

    <?php else: ?>

    <?php endif; ?>
</div>
