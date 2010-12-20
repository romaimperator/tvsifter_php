<?php echo $html->css('navbar', null, array('inline' => FALSE)); ?>

<div class="navbar">
<?php
    $options = array(
        'admin' => FALSE,
        'controller' => 'users',
        'action' => 'login',
    );
    echo $html->link('Login', $options);
?>
</div>
