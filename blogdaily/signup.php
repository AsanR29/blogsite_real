<?php $pagetitle = "New account"; ?>
<?php require_once('../loaders/header.php'); ?>
<body onload='pageObj = new CurrentPage([], "../php_requests/create_account.php"); updateCssSize();'>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>

<form>
    <div class="inputrow">
        <label class="labelinput textright">Username</label>
        <input name="username" type="text" class="createbloginput form_input" required></input>
        <label id="error_username" class="labelerror"></label>
    </div>
    <div class="inputrow">
        <label class="labelinput textright">Password</label>
        <input name="password" type="password" class="createbloginput form_input" required></input>
        <label id="error_password" class="labelerror"></label>
    </div>
    <div class="inputrow">
        <label class="labelinput textright">Email Address</label>
        <input name="email" type="email" class="createbloginput form_input" required></input>
        <label id="error_email" class="labelerror"></label>
    </div>
    <?php if(isset($account_type) && $account_type == 3): ?>
    <div class="inputrow">
        <label class="labelinput textright">Account type</label>
        <select name="account_type" class="form_input" required>
            <option selected value="1">Unverified</option>
            <option value="2">Verified</option>
            <option value="3">Admin</option>
        </select>
        <label id="error_account_type" class="labelerror"></label>
    </div>
    <?php endif; ?>
</form>
<div><button  class="gen_button floatright" onclick="sendForm()">Sign up</button></div>

<?php require_once('../loaders/main_bottom.php'); ?>
</body>
</html>