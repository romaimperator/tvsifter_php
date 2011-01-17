<?php
    $show = $this->requestAction(array('controller' => 'shows', 'action' => 'view_info'), array('pass' => array($show_id, $season)));

    $current_season = $show['Show']['season_count'];
    $unaired = TRUE; // used to set where the horizontal rule goes

    $date_format = 'M j, Y';
?>

<div id="show">
    <input id="show_id" type="hidden" value="<?php echo $show['Show']['id']; ?>" />
    <div id="season_links">
        <p>view seasons</p>
        <ul>
            <!--<li><a href="javascript:show_all()">all</a></li>-->
            <?php echo $html->link('all', array('controller' => 'shows', 'action' => 'view', $show['Show']['name'], 0)); ?>
            <?php for($i = 1; $i <= $current_season; $i++): ?>
                
                <!--<li><a href="javascript:show(<?php //echo $i; ?>)"><?php //echo $i; ?></a></li>-->
                <?php echo $html->link($i, array('controller' => 'shows', 'action' => 'view', $show['Show']['name'], $i)); ?>

            <?php endfor; ?>
        </ul>
    </div>
    <div class="header4">
        <h4><?php echo $show['Show']['display_name']; ?></h4>
    </div>

    <?php if ( ! empty($show['Episode'])): ?>

        <table>
            <tbody id="episodes_table">
                <tr>
                    <th></th>
                    <th></th>
                    <th>Name</th>
                    <th>Season</th>
                    <th>Episode</th>
                    <th>Air Date</th>
                </tr>

            <?php foreach($show['Episode'] as $e): ?>

                <?php $watched = isset($e['episode_users']['watched']) && $e['episode_users']['watched'] == 1; ?>
                <?php $owned = isset($e['episode_users']['downloaded']) && $e['episode_users']['downloaded'] == 1; ?>

                <?php if ($unaired && (strtotime($e['Episode']['air_date']) <= time() - 60*60*24 && $e['Episode']['air_date'] != "Unknown")): ?>
                    <tr class="separator">
                        <td colspan="6">
                            <span class="left">Previously Aired</span>
                            <hr>
                        </td>
                    </tr>
                    <?php $unaired = FALSE; ?>
                <?php endif; ?>

                <tr>
                    <?php if ($watched): ?>
                        <td class="unmark"><?php echo $html->link('Unwatch', array('controller' => 'EpisodeUsers', 'action' => 'unmark_as_watched', $e['Episode']['id'])); ?></td>
                    <?php else: ?>
                        <td class="mark"><?php echo $html->link('Watched', array('controller' => 'EpisodeUsers', 'action' => 'mark_as_watched', $e['Episode']['id'])); ?></td>
                    <?php endif; ?>
                    <?php if ($owned): ?>
                        <td class="unmark"><?php echo $html->link('Unown', array('controller' => 'EpisodeUsers', 'action' => 'unmark_as_owned', $e['Episode']['id'])); ?></td>
                    <?php else: ?>
                        <td class="mark"><?php echo $html->link('Owned', array('controller' => 'EpisodeUsers', 'action' => 'mark_as_owned', $e['Episode']['id'])); ?></td>
                    <?php endif; ?>
                    <td><?php echo $e['Episode']['name']; ?></td>
                    <td class="center"><?php echo $e['Episode']['season']; ?></td>
                    <td class="center"><?php echo $e['Episode']['episode']; ?></td>
                    <td class="center"><?php
                        if ($e['Episode']['air_date'] == "Unknown") {
                            echo $e['Episode']['air_date'];
                        } else {
                            echo date($date_format, strtotime($e['Episode']['air_date']));
                        }
                    ?></td>
                </tr>

            <?php endforeach; ?>

            </tbody>
        </table>

    <?php else: ?>
        
        <p>This show has no episodes.</p>

    <?php endif; ?>

</div>
