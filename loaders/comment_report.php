
<?php
require_once('../php_classes/comment_report_class.php');
require_once('../php_classes/comment_class.php');
require_once('../php_classes/file_class.php');

$comment_array = CommentReport::loadCommentReports(array());
if(count($comment_array) == 1):
$comment = $comment_array[0];

$params = array('comment_id'=>$comment->comment_id);
$comment_array = Comment::loadComments($params);
?>
<div class="commentarea">
    <section class="commentpicarea">
        <a href="../blogdaily/user.php?username=<?php echo $comment_array[0]->username; ?>"><img class="pfp" src="
        <?php
            $account_id = $comment_array[0]->account_id;
            $params = array(
                'account_id'=>$account_id,
                'file_use'=>"pfp"
            );
            $pfp_file = new UserFile($params);
            $result = $pfp_file->loadFile();
            if($result){
                echo $pfp_file->getUrl();
            }
        ?>
        "></a> 
    </section>
    <section class="commenttext">
        <div class="linebreak"><label class="labelusername"><?php echo $comment_array[0]->username; ?></label></div>
        <div class="commentpart"><output class="b_text"><?php echo $comment->contents; ?></output></div>
        <div class="linebreak">
            <label class="info_span">Posted: <?php echo $comment_array[0]->comment_datetime; ?></label>
        </div>
    </section>
</div>

<div class="commentarea">
    <section class="commentpicarea">
         
    </section>
    <section class="commenttext">
        <div hidden class="linebreak">
            <input name="comment_id" hidden class="labelusername" value="<?php echo $comment->comment_id; ?>"></input>
            <input name="comment_report_id" hidden class="labelusername" value="<?php echo $comment->comment_report_id; ?>"></input>
        </div>
        <div class="linebreak"><label class="editing">Report type:</label><label class="labelusername"><?php echo $comment->report_type; ?></label></div>
        <div class="commentpart"><label class="editing">Explanation:</label><output class="b_text"><?php echo $comment->explanation; ?></output></div>
        <div class="linebreak">
        <label class="info_span">Reported: <?php echo $comment->report_date; ?></label>
        </div>
    </section>
</div>
<div id="mainbuffer"></div>
<?php else: ?>
<section>
    <div><output class="titlesize" style="color:grey">No results</h2></div>
</section>
<?php endif; ?>