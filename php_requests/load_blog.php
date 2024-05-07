<?php
require_once('../php_classes/blog_class.php');
if(isset($_GET['blog_id'])){
    $blog_id = $_GET['blog_id'];

    $blog = new BlogPost($_POST);
    $blog->blog_id = $blog_id;
    $blog->loadBlog();
}
else if(isset($_GET['blog_url'])){
    $blog_url = $_GET['blog_url'];

    $blog = new BlogPost($_POST);
    $blog->blog_url = $blog_url;
    $blog->loadBlog();
}
else{
    header('location: ../blogdaily/search.php');
}

?>