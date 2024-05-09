<?php
require_once('../php_classes/blog_class.php');
session_start();
$form = json_decode(file_get_contents('php://input'), true);
$account_id = $_SESSION['account_id'];
$blog = new BlogPost($form);
$result = $blog->loadBlog();
if($result && $account_id == $blog->account_id){
    $result = $blog->deleteBlog();
    if($result){
        echo json_encode([
            'request_outcome'=>true
        ]);
    }
    else{
        $blog->removeIV();
        $blog->removeID();
        echo json_encode(['request_outcome'=>false, 'class'=>$blog]);
    }
}
else{
    echo json_encode(['request_outcome'=>false]);
}

?>