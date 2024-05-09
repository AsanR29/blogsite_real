<?php
require_once('../php_classes/blog_class.php');
require_once('../php_classes/comment_class.php');
session_start();
$form = json_decode(file_get_contents('php://input'), true);

$account_id = 0;
if(isset($_SESSION['account_id']) && $_SESSION['account_id']){
    $account_id = $_SESSION['account_id'];
}
$blog = new BlogPost($form);
$result = $blog->loadBlog();
if($result){
    $new_comment = new Comment($form);
    $new_comment->blog_id = $blog->blog_id;
    $new_comment->account_id = $account_id;
    $result = $new_comment->createComment();
    if($result){
        echo json_encode([
            'request_outcome'=>true
        ]);
    }
    else{
        $new_comment->removeIV();
        $new_comment->removeID();
        echo json_encode(['request_outcome'=>false, 'class'=>$new_comment]);
    }
}

?>