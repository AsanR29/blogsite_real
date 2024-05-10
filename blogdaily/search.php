
<?php require_once('../loaders/header.php'); ?>
<body onload='
    pageObj = new CurrentPage([], "../loaders/load_blogposts.php");
    <?php $blog_tag_str = ""; if(isset($_POST["blog_tag"])){ for($i = 0; $i < count($_POST["blog_tag"]); $i++){ $blog_tag_str .= "\"" . $_POST["blog_tag"][$i] . "\"";} } ?>
    var params = {"hey":"0"<?php if(isset($_POST["title"])){ echo ",\"title\":\"" . $_POST["title"] . "\""; } if(isset($_POST["blog_tag"])){ echo ",\"blog_tag\":[" . $blog_tag_str . "]"; } ?>};
    createLoadable("../loaders/load_blogposts.php", "blog_section", "", 0, params);
    updateCssSize();'>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>

<article>
    <?php require_once('../loaders/search_box.php'); ?>
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
</div>
</html>