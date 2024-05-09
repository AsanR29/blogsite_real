<?php
require_once('../php_classes/comment_class.php');
session_start();
$form = json_decode(file_get_contents('php://input'), true);
$account_id = $_SESSION['account_id'];
$comment = new Comment($form);
$result = $comment->loadComment();
if($result && $account_id == $comment->account_id){
    $result = $comment->deleteComment();
    if($result){
        echo json_encode([
            'request_outcome'=>true
        ]);
    }
    else{
        $comment->removeIV();
        $comment->removeID();
        echo json_encode(['request_outcome'=>false, 'class'=>$blog]);
    }
}
else{
    echo json_encode(['request_outcome'=>false]);
}

?>