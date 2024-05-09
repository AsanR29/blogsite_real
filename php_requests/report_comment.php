<?php
require_once('../php_classes/comment_class.php');
require_once('../php_classes/comment_report_class.php');
session_start();
$form = json_decode(file_get_contents('php://input'), true);

$comment = new Comment($form);
$result = $comment->loadComment();
if($result){
    $new_comment_report = new CommentReport($form);
    $new_comment_report->contents = $comment->contents;
    $result = $new_comment_report->createCommentReport();
    if($result){
        echo json_encode([
            'request_outcome'=>true
        ]);
    }
    else{
        $new_comment_report->removeIV();
        $new_comment_report->removeID();
        echo json_encode(['request_outcome'=>false, 'class'=>$new_comment_report]);
    }
}
else{
    echo json_encode(['request_outcome'=>false]);
}

?>