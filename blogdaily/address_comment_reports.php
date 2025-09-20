<?php $pagetitle = "Address reports"; ?>
<?php require_once('../loaders/header.php'); ?>
<?php 
require_once('../php_classes/account_class.php');
require_once('../php_classes/comment_class.php');
require_once('../php_classes/comment_report_class.php'); ?>
<body onload='pageObj = new CurrentPage([], ""); updateCssSize();'>
<?php
if($_SESSION['account_type'] != 3){
    header('../blogdaily/search.php');
}
if(isset($_POST['comment_report_id']) && isset($_POST['comment_id'])){
    if(isset($_POST['approve'])){
        $params = array('comment_id'=>$_POST['comment_id']);
        $comment = new Comment($params);
        $result = $comment->loadComment();
        if($result){
            $params = array('account_id'=>$comment->account_id);
            $account = new Account($params);
            $result = $account->loadAccount();
            if($result){
                $params = array('account_type'=>0);
                $result = $account->updateAccount($params);
                if($result){
                    //echo "Successfully banned.";
                }
                else{
                    //echo "Ban failed.";
                }
            }
        }
        $comment->deleteComment();
        $params = array('comment_report_id'=>intval($_POST['comment_report_id']));
        $comment_report = new CommentReport($params);
        $result = $comment_report->loadCommentReport();
        if($result){
            $date = date('Y-m-d');
            $result = $comment_report->updateCommentReport(array('resolved_date'=>$date));
        }
    }
    else if(isset($_POST['dismiss'])){
        $params = array('comment_report_id'=>intval($_POST['comment_report_id']));
        $comment_report = new CommentReport($params);
        $result = $comment_report->loadCommentReport();
        if($result){
            $date = date('Y-m-d');
            $result = $comment_report->updateCommentReport(array('resolved_date'=>$date));
        }
        if($result){
            //echo "Successfully dismissed.";
        }
        else{
            //echo "Dismiss failed.";
        }
    }
}

?>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>

<form method="post">
<?php require_once('../loaders/comment_report.php');
if(count($comment_array) == 1): ?>
<div class="inputarea">
    <input type="submit" class="yesdelete deleteoption" name="approve" value="BAN ACCOUNT"></input>
    <input type="submit" class="nodelete deleteoption" name="dismiss" value="DISMISS REPORT"></input>
</div>
<?php endif; ?>
</form>

<?php require_once('../loaders/main_bottom.php'); ?>
</body>
</html>