
<?php require_once('../loaders/header.php'); ?>
<?php
    if(isset($_SESSION['username']) && $_SESSION['username']){
        $username = $_SESSION['username'];
    }
    else{
        header('location: ../blogdaily/search.php');
    }
?>
<body onload='
    pageObj = new CurrentPage([], "../loaders/load_blogposts.php");
    createLoadable("../loaders/load_blogposts.php", "blog_section", "<?php echo $username; ?>", 0);
    updateCssSize();'>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>

<article>
    <div class="textcenter">
        <a class="titlesize notalink" href="../blogdaily/create.php">Create a Blog Post</a>
    </div>
    <div id="blog_section">
    </div>
    <div id="inputrow">
        <button class="svgbutton floatright" onclick="movePage(1);">Next page</button>
        <button class="svgbutton floatright" onclick="movePage(-1);">Previous page</button>
    </div>
</article>

<?php require_once('../loaders/main_bottom.php'); ?>
<?php require_once('../loaders/nav_right.php'); ?>
</body>
</html>