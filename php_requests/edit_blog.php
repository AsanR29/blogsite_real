<?php
require_once('../php_classes/blog_class.php');
require_once('../php_classes/blog_tag_class.php');
require_once('../php_classes/file_class.php');
session_start();
$location = 'location: ../blogdaily/create.php';
print_r($_POST);
if(isset($_SESSION['account_id']) && isset($_POST['blog_id'])){
    $account_id = $_SESSION['account_id'];
    $blog_id = $_POST['blog_id'];

    $new_blog = new BlogPost(array('blog_id'=>$blog_id));
    $result = $new_blog->loadBlog();
    if($result && $new_blog->account_id == $_SESSION['account_id']){
        $result = $new_blog->updateBlog($_POST);
        if($result){
            $params = array(
                'blog_id'=>$blog_id
            );
            $result = BlogTag::deleteBlogTags($params);

            $params = array(
                'blog_id'=>$blog_id,
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
                'blog_id'=>$blog_id,
                'account_id'=>$account_id,
                'file_use'=>"blog_item"
            );
            $result_array = UserFile::createFiles($params, $_FILES["imageSubmission"]);
            
            $location = 'location: ../blogdaily/read.php?blog_url=' . $new_blog->blog_url;
        }
    }
}
header($location);

?>