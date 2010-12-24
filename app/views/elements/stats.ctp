<?php
    $stats = $this->requestAction(array('controller' => 'stats', 'action' => 'index'));

    echo $html->css('stats', FALSE);
?>

<div id="stats">
    <h5>Site Statistics</h5>
    <table>
        <tbody>
            <tr>
                <th>Number of Users:</th>
                <td><?php echo $stats['user_count']; ?></td>
            </tr>
            <tr>
                <th>Number of Supported Shows:</th>
                <td><?php echo $stats['show_count']; ?></td>
            </tr>
            <tr>
                <th>Average Number of Followed Shows:</th>
                <td><?php echo $stats['avg_follow_count']; ?></td>
            </tr>
        </tbody>
    </table>
</div>
