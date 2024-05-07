
<?php require_once('../loaders/header.php'); ?>
<body onload='pageObj = new CurrentPage([], "../php_requests/login_account.php"); updateCssSize();'>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>

<form>
<div class="inputrow">
    <label class="labelinput textright">Username</label>
    <input name="username" type="text" class="createbloginput form_input"></input>
    <label id="error_username" class="labelerror"></label>
</div>
<div class="inputrow">
    <label class="labelinput textright">Password</label>
    <input name="password" type="password" class="createbloginput form_input"></input>
    <label id="error_password" class="labelerror"></label>
</div>
</form>
<div><button class="svgbutton floatright" onclick="sendForm()">Log in</button></div>

<?php require_once('../loaders/main_bottom.php'); ?>
<?php require_once('../loaders/nav_right.php'); ?>
</body>
</html>