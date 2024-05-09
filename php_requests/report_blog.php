<?php
require_once('../php_classes/blog_class.php');
require_once('../php_classes/blog_report_class.php');
session_start();
$form = json_decode(file_get_contents('php://input'), true);

$blog = new BlogPost($form);
$result = $blog->loadBlog();
if($result){
    $new_blog_report = new BlogReport($form);
    $new_blog_report->blog_id = $blog->blog_id;
    $new_blog_report->contents = $blog->contents;
    $result = $new_blog_report->createBlogReport();
    if($result){
        echo json_encode([
            'request_outcome'=>true
        ]);
    }
    else{
        $new_blog_report->removeIV();
        $new_blog_report->removeID();
        echo json_encode(['request_outcome'=>false, 'class'=>$new_blog_report]);
    }
}
else{
    echo json_encode(['request_outcome'=>false]);
}

?>