<?php $pagetitle = "Edit Blog Post"; ?>
<?php require_once('../loaders/header.php'); ?>
<?php 
require_once('../php_classes/blog_tag_class.php');
require_once('../php_requests/load_blog.php');
require_once('../php_classes/file_class.php');
$blog_url = "";
if(isset($_GET['blog_url'])){
    $blog_url = $_GET['blog_url'];
}
$params = array('blog_id' => $blog->blog_id);
$blog_tag_array = BlogTag::loadBlogTags($params);
?>
<body onload='pageObj = new CurrentPage(["<?php echo count($blog_tag_array); ?>"], ""); updateCssSize();'>
<script type="text/javascript" src="../javascript_imports/textarea.js"></script>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>



<article>
<form method="post" action="../php_requests/edit_blog.php" enctype="multipart/form-data">
    <input required type="text" class="titlesize createbloginput form_input" name="title" value="<?php echo $blog->title; ?>"></input>
    <div id="mainbuffer"></div>
    <div id="shadowArea"></div>
    <textarea required oninput="measureTextarea()" class="editing form_input" id="testsubject" rows="1" name="contents"><?php echo $blog->contents; ?></textarea>
    <script> measureTextarea(); </script>
    <div id="bloglinks"></div>
    <?php require_once('../loaders/load_pics.php'); ?>
    <input hidden type="file" id="imageSubmission" name="imageSubmission[]" accept="image/jpeg, application/pdf" multiple class="form_input"><br>           
    <label class="gen_button" for="imageSubmission">Add images</label>
    <label>Blog tags: </label>
    <div id="createtags" class="inputrow">
        <span id="tag_source_new" class="editing" contenteditable="true"></span>
        <label id="blogtag_create" class="gen_button" for="addBlogtagnew">Add Tag</label>
    </div>
    <div id="invisible_blogtags">
    <?php
        for($i = 0; $i < count($blog_tag_array); $i++): ?>
        <div id="blogtagvis_<?php echo $i; ?>" class="blogtagdiv"><span name="blogtag_<?php echo $i; ?>" class="blog_tag"><?php echo $blog_tag_array[$i]->tag_name; ?></span><button onclick="removeNewBlogtag(<?php echo $i; ?>)" class="gen_button blogtagbutton unround">X</button></div>
        <div hidden id="blogtagnew_<?php echo $i; ?>"><input name="blog_tag[]" hidden value="<?php echo $blog_tag_array[$i]->tag_name; ?>"></input></div>
    <?php endfor; ?>
    </div>
    <select name="visibility" class="form_input" required>
        <option value="0">Private</option>
        <option value="1">Unlisted</option>
        <option selected value="2">Public</option>
    </select>
    <input hidden name="blog_id" value="<?php echo $blog->blog_id; ?>"></input>
    <button class="gen_button floatright">Update blog post</button>
</form>
<div id="imagepreviews"></div>
<button id="addBlogtagnew" hidden onclick="addNewBlogTag('invisible_blogtags')"></button>
</article>

<?php require_once('../loaders/main_bottom.php'); ?>
</body>
</html>