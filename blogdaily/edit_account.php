<?php $pagetitle = "Edit Account details"; ?>
<?php require_once('../loaders/header.php'); ?>
<body onload='pageObj = new CurrentPage([], "../php_requests/update_account.php"); updateCssSize();'>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>

<?php 
require_once('../php_classes/account_class.php');
$account = new Account(array('account_id'=>$account_id));
$account->loadAccount();
?>
<form>
    <div class="inputrow">
        <label class="labelinput textright">Username</label>
        <input name="username" type="text" class="createbloginput form_input" required value="<?php echo $account->username; ?>"></input>
        <label id="error_username" class="labelerror"></label>
    </div>
    <div class="inputrow">
        <label class="labelinput textright">Email Address</label>
        <input name="email" type="email" class="createbloginput form_input" required value="<?php echo $account->email; ?>"></input>
        <label id="error_email" class="labelerror"></label>
    </div>
</form>
<div><button  class="gen_button floatright" onclick="sendForm()">Update</button></div>

<?php require_once('../loaders/main_bottom.php'); ?>
</body>
</html>