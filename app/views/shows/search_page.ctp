<?php
    echo $html->css('shows/search_page', null, array('inline' => TRUE));
    echo $html->script('shows/search_page', array('inline' => TRUE));
?>


<div id="search">
    <div class="header4">
        <h4>All Shows</h4>
    </div>
    <div id="results">
        
        <?php if (isset($shows) && count($shows) > 0): ?>

            <table>
            <tbody>
                <tr>
                    <th id="first_col"></th>
                    <th id="second_col">Name:</th>
                    <th id="third_col">Last Airing:</th>
                    <th id="fourth_col">Next Airing:</th>
                </tr>

            <?php foreach($shows as $s): ?>

                <?php $followed = $s['Show']['followed']; ?>

                <tr class="show" id="<?php echo $s['Show']['id']; ?>">

                    <?php if ($followed): ?>
                        <td class="unfollow"><?php echo $html->link('Unfollow', array('controller' => 'shows', 'action' => 'unfollow', $s['Show']['id'])); ?></td>
                    <?php else: ?>
                        <td class="follow"><?php echo $html->link('Follow', array('controller' => 'shows', 'action' => 'follow', $s['Show']['id'])); ?></td>
                    <?php endif; ?>

                    <td class="normal_td center"><?php echo $html->link($s['Show']['display_name'], array('controller' => 'shows', 'action' => 'view', $s['Show']['name'])); ?></td>
                    <td class="normal_td"><?php echo $s['Show']['last_air_date']; ?></td>
                    <td class="normal_td"><?php echo $s['Show']['next_air_date']; ?></td>
                </tr>

            <?php endforeach; ?>

            </tbody>
            </table>
        <?php elseif (isset($no_shows_message)): ?>

            <?php echo $no_shows_message; ?>
        
        <?php endif; ?>

    </div>
</div>
