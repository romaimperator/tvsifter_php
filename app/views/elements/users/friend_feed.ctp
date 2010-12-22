<?php
    // Retrieve the list of recent activity of friends
    $activity = $this->requestAction(array('controller' => 'users', 'action' => 'get_friend_activity'));

    $html->css('users/friend_feed', null, array('inline' => FALSE));
?>

<div id="friend_feed">
    <div class="header4">
        <h4>Recent Activity:</h4>
    </div>

    <?php if ( ! empty($activity)): ?>

        <?php foreach($activity as $index => $a): ?>

            <p><?php echo $a['Activity']['update']; ?></p>

            <?php if ($index < count($activity) - 1): ?>
                <hr>
            <?php endif; ?>

        <?php endforeach; ?>

    <?php else: ?>

        <p>There is no recent activity to display.</p>

    <?php endif; ?>
</div>
