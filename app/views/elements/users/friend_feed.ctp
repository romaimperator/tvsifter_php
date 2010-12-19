<?php
    // TODO: add pulling of activity
    //$activity = 

    $html->css('users/friend_feed', null, array('inline' => FALSE));
?>

<div id="friend_feed">
    <h4>Recent Activity:</h4>

    <?php if ( ! empty($activity)): ?>

        <?php foreach($activity as $index => $a): ?>

            <?php if ($index < count($activity) - 1): ?>
                <hr>
            <?php endif; ?>

        <?php endforeach; ?>

    <?php else: ?>

        <p>There is no recent activity to display.</p>

    <?php endif; ?>
</div>
