
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
<table>
    <tr>
        <div class="textcenter">
            <a class="titlesize notalink" href="../blogdaily/edit_account.php">Account details</a>
        </div>
    </tr>
    <tr>
        <div class="textcenter">
            <a class="titlesize notalink" href="../blogdaily/logout.php">Log out</a>
        </div>
    </tr>
    <tr>
        <div class="textcenter">
            <a class="titlesize notalink" href="../blogdaily/delete_account.php">Delete account</a>
        </div>
    </tr>
</table>
</article>

<?php require_once('../loaders/main_bottom.php'); ?>
<?php require_once('../loaders/nav_right.php'); ?>
</body>
</html>