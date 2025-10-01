<?php $pagetitle = "New trainer"; ?>
<?php require_once('../loaders/header.php'); ?>
<body onload='pageObj = new CurrentPage([], "../php_requests/create_trainer.php"); updateCssSize();'>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>

<form>
    <div class="inputrow">
        <label class="labelinput textright">Trainer name</label>
        <input name="trainer_name" type="text" class="createbloginput form_input" required></input>
        <label id="error_username" class="labelerror"></label>
    </div>
</form>
<div><button  class="gen_button floatright" onclick="sendForm()">Sign up</button></div>

<?php require_once('../loaders/main_bottom.php'); ?>
</body>
</html>