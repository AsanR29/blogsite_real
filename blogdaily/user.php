
<?php require_once('../loaders/header.php'); ?>
<body onload='pageObj = new CurrentPage([], "../loaders/load_blogposts.php"); updateCssSize();'>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>

<?php
    if(isset($_GET['account_id'])){
        $account_id = $_GET['account_id'];
    }
    else if(isset($_GET['username'])){
        $username = $_GET['username'];
    }
    else{
        header('location: ../blogdaily/search.php');
    }
?>
<article>
<?php require_once('../loaders/load_blogposts.php'); ?>
</article>

<?php require_once('../loaders/main_bottom.php'); ?>
<?php require_once('../loaders/nav_right.php'); ?>
</body>
</html>