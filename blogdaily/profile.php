<?php $pagetitle = '
    <div id="createprompt" class="textcenter">
        <a class="titlesize notalink" href="../blogdaily/create.php">Create a Blog Post</a>
    </div>'; ?>
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
    <?php require_once('../loaders/nav_middle.php'); ?>
    <div id="blog_section">
    </div>
    <div id="inputrow">
        <button class="gen_button floatright" onclick="movePage(1);">Next page</button>
        <button class="gen_button floatright" onclick="movePage(-1);">Previous page</button>
    </div>
</article>

<?php require_once('../loaders/main_bottom.php'); ?>
</body>
</html>