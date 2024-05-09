
<?php require_once('../loaders/header.php'); ?>
<body onload='pageObj = new CurrentPage([], ""); updateCssSize();'>
<script type="text/javascript" src="../javascript_imports/textarea.js"></script>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>

<article>
<form method="post" action="../php_requests/create_blog.php" enctype="multipart/form-data">
    <input required type="text" class="titlesize createbloginput form_input" name="title"></input>
    <div id="mainbuffer"></div>
    <div id="shadowArea"></div>
    <textarea required oninput="measureTextarea()" class="editing form_input" id="testsubject" rows="1" name="contents"></textarea>
    <div id="bloglinks"></div>
    <input hidden type="file" id="imageSubmission" name="imageSubmission[]" accept="image/jpeg, application/pdf" multiple class="form_input"><br>           
    <label class="svgbutton" for="imageSubmission">Add images</label>
    <label id="blogtag_create" class="svgbutton" for="addBlogtag">Add Tag</label>
    <select name="visibility" class="form_input" required>
        <option value="0">Private</option>
        <option value="1">Unlisted</option>
        <option selected value="2">Public</option>
    </select>
    <button class="svgbutton floatright">Create blog post</button>
</form>
<div id="imagepreviews"></div>
<button id="addBlogtag" hidden onclick="addBlogTag('blogtag_create')"></button>
</article>

<?php require_once('../loaders/main_bottom.php'); ?>
<?php require_once('../loaders/nav_right.php'); ?>
</body>
</html>