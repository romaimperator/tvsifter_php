<?php echo $html->css('pages/home.css', FALSE); ?>

<div id="home_body">
    <h1>Welcome to tvsifter.com</h1>
    <div class="header4">
        <h4>What is tvsifter?</h4>
    </div>
    <p>tvsifter is a site that let's you follow only the shows you watch.
    No longer do you have to search for each and every show to find out when
    the next episode airs.</p>
    <div class="header4">
        <h4>Features:</h4>
    </div>
    <ul>
        <li>Follow only the shows you want</li>
        <li>Keep track of the episodes you have seen and own</li>
        <li>Find out when new episodes are going to air</li>
        <li>Receive an email update of which episodes are airing each week (opt-in)</li>
    </ul>

    <?php echo $elementcombiner->element('stats', array('cache' => '+1 hour')); ?>
</div>
