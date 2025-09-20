<?php $pagetitle = "Change about me"; ?>
<?php require_once('../loaders/header.php'); ?>
<body onload='pageObj = new CurrentPage([], "../php_requests/update_account.php"); updateCssSize();'>
<script type="text/javascript" src="../javascript_imports/textarea.js"></script>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>

<article>
    <p>Rewrite your About Me text:</p>
    <div id="shadowArea"></div>
    <textarea required oninput="measureTextarea()" class="editing form_input" id="testsubject" rows="1" name="bio"></textarea>
</article>
<div><button  class="gen_button floatright" onclick="sendForm()">Update</button></div>

<?php require_once('../loaders/main_bottom.php'); ?>
</body>
</html>