<?php $pagetitle = "Account deletion failed."; ?>
<?php require_once('../loaders/header.php'); ?>
<body onload='pageObj = new CurrentPage([], "../php_requests/update_account.php"); updateCssSize();'>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>

<?php 
require_once('../php_classes/account_class.php');
$account = new Account(array('account_id'=>$account_id));
$account->loadAccount();
$result = $account->deleteAccount();
if($result){
    session_unset();
    header('location: ../blogdaily/search.php');
}
?>

<?php require_once('../loaders/main_bottom.php'); ?>
</body>
</html>