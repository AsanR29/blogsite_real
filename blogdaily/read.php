
<?php require_once('../loaders/header.php'); ?>
<?php
$blog_url = "";
if(isset($_GET['blog_url'])){
    $blog_url = $_GET['blog_url'];
}
?>
<body onload='
    pageObj = new CurrentPage(["<?php echo $blog_url; ?>"], "../php_requests/create_comment.php");
    createLoadable("../loaders/load_comments.php", "comment_section", "<?php echo $blog_url; ?>", 0);
    updateCssSize();'>
<script type="text/javascript" src="../javascript_imports/textarea.js"></script>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>

<?php require_once('../popups/login.php'); ?>
<?php require_once('../popups/reportblog.php'); ?>
<?php require_once('../popups/reportcomment.php'); ?>
<?php require_once('../popups/deleteblog.php'); ?>
<?php require_once('../popups/deletecomment.php'); ?>
<?php require_once('../popups/showimage.php'); ?>

<?php require_once('../php_classes/file_class.php'); ?>

<?php require_once('../php_requests/load_blog.php'); ?>
<article>
    <output class="titlesize"><?php echo $blog->title; ?></output>
    <div id="mainbuffer"></div>
    <output class="editing"><?php echo $blog->contents; ?></output>
    <div id="blog_pictures">
        <?php require_once('../loaders/load_pics.php'); ?>
    </div>
    <div class="linebreak">
        <label class="svgbutton">Posted: <?php echo $blog->blog_datetime; ?></label>
    <?php if($account_id){
        if($account_id == $blog->account_id): ?>
            <button onclick="loadPopup('deleteblog')" class="svgbutton floatright">Delete</button>
        <?php else: ?>
            <button onclick="loadPopup('popupreportblog')" class="svgbutton floatright">Report</button>
        <?php endif; } ?>
    </div>
    
    <div id="leave_comment">
        <?php require_once('../loaders/comment_box.php'); ?>
    </div>
    <div id="comment_section">
    </div>
    <div id="inputrow">
        <button class="svgbutton floatright" onclick="movePage(1);">Next page</button>
        <button class="svgbutton floatright" onclick="movePage(-1);">Previous page</button>
    </div>
</article>
<?php
    if(!isset($_SESSION['history'])){
        $_SESSION['history'] = array(
            'url'=>array(),
            'title'=>array()
        );
    }
    if($blog->blog_url && $blog->title){
        if( !in_array($blog->blog_url, $_SESSION['history']['url']) ){
            $_SESSION['history']['url'][] = $blog->blog_url;
            $_SESSION['history']['title'][] = $blog->title;
        }
    }
?>
<?php require_once('../loaders/main_bottom.php'); ?>
<?php require_once('../loaders/nav_right.php'); ?>
</body>
</html>