<?php
    $most_popular_limit = 15;
    $shows = $this->requestAction(array('controller' => 'shows', 'action' => 'popular'), array('pass' => array($most_popular_limit)));
?>

<ul id="show_list">
    <?php foreach($shows as $s): ?>
    
        <li><?php echo $s['Show']['display_name']; ?></li>

    <?php endforeach; ?>
</ul>
