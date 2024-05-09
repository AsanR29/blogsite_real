<?php
require_once('../php_classes/blog_class.php');
require_once('../php_classes/blog_tag_class.php');
require_once('../php_classes/file_class.php');
session_start();
$location = 'location: ../blogdaily/create.php';
if(isset($_SESSION['account_id'])){
    $account_id = $_SESSION['account_id'];

    $new_blog = new BlogPost($_POST);
    $new_blog->account_id = $account_id;
    $result = $new_blog->createBlog();
    if($result){
        $params = array(
            'blog_id'=>$new_blog->blog_id,
            'tag_type'=>"content",
            'tag_name'=>""
        );
        if(isset($_POST['blog_tag'])){
            for($i = 0; $i < count($_POST['blog_tag']); $i+=1){
                $params['tag_name'] = $_POST['blog_tag'][$i];
                $new_blog_tag = new BlogTag($params);
                $result = $new_blog_tag->createBlogTag();
            }
        }
        $params = array(
            'blog_id'=>$new_blog->blog_id,
            'account_id'=>$account_id,
            'file_use'=>"blog_item"
        );
        $result_array = UserFile::createFiles($params, $_FILES["imageSubmission"]);
        
        $location = 'location: ../blogdaily/read.php?blog_url=' . $new_blog->blog_url;
    }
}
//header($location);

?>