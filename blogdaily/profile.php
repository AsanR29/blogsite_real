
<?php require_once('../loaders/header.php'); ?>
<body onload='pageObj = new CurrentPage([], "../loaders/load_blogposts.php"); updateCssSize();'>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>

<?php
    if(!isset($account_id) || !$account_id){
        header('location: ../blogdaily/search.php');
    }
?>
<article>
<div class="textcenter">
    <a class="titlesize notalink" href="../blogdaily/create.php">Create a Blog Post</a>
</div>
<?php require_once('../loaders/load_blogposts.php'); ?>
</article>

<?php require_once('../loaders/main_bottom.php'); ?>
<?php require_once('../loaders/nav_right.php'); ?>
</body>
</html>