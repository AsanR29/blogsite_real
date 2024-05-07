
<?php require_once('../loaders/header.php'); ?>
<body onload='pageObj = new CurrentPage([], ""); updateCssSize();'>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>

<?php require_once('../php_requests/load_blog.php'); ?>
<article>
    <output class="titlesize"><?php echo $blog->title; ?></output>
    <div id="mainbuffer"></div>
    <output class="editing"><?php echo $blog->contents; ?></output>
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