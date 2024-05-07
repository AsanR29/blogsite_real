
<?php require_once('../loaders/header.php'); ?>
<body onload='pageObj = new CurrentPage([], "../loaders/load_blogposts.php"); updateCssSize();'>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>

<?php
    $account_id = 0;
?>
<article>
<?php require_once('../loaders/load_blogposts.php'); ?>
</article>

<?php require_once('../loaders/main_bottom.php'); ?>
<?php require_once('../loaders/nav_right.php'); ?>
</body>
</html>