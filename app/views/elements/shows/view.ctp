<?php
    $show = $this->requestAction(array('controller' => 'shows', 'action' => 'view_info'), array('pass' => array($show_id)));

    $current_season = $show['Show']['season_count'];
?>

<div id="show">
    <div class="header4">
        <h4><?php echo $show['Show']['display_name']; ?></h4>
    </div>

    <?php if ( ! empty($show['Episode'])): ?>

        <table>
            <tr>
                <th>Name</th>
                <th>Season</th>
                <th>Episode</th>
                <th>Air Date</th>
            </tr>

        <?php foreach($show['Episode'] as $e): ?>

            <tr>
                <td><?php echo $e['Episode']['name']; ?></td>
                <td><?php echo $e['Episode']['season']; ?></td>
                <td><?php echo $e['Episode']['episode']; ?></td>
                <td><?php echo $e['Episode']['air_date']; ?></td>
            </tr>

        <?php endforeach; ?>

        </table>

    <?php else: ?>
        
        <p>This show has no episodes.</p>

    <?php endif; ?>

</div>
