<?php
require_once('../php_classes/blog_class.php');
session_start();
$location = 'location: ../blogdaily/create.php';
if(isset($_SESSION['account_id'])){
    $account_id = $_SESSION['account_id'];

    $new_blog = new BlogPost($_POST);
    $new_blog->account_id = $account_id;
    $result = $new_blog->createBlog();
    if($result){
        $location = 'location: ../blogdaily/read.php?blog_url=' . $new_blog->blog_url;
    }
}
header($location);

?>