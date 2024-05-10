<div id="mainbuffer"></div><div id="mainbuffer"></div>
<?php
require_once('../php_classes/comment_report_class.php');


$comment_array = CommentReport::loadCommentReports(array());
if(count($comment_array) == 1):
$comment = $comment_array[0];
?>
<div class="commentarea">
    <section class="commentpicarea">
        <a href="../blogdaily/user.php?username=<?php echo $comment->username; ?>"><img class="pfp" src="../css/defaultpfp.png"></a> 
    </section>
    <section class="commenttext">
        <div hidden class="linebreak">
            <input name="comment_id" hidden class="labelusername" value="<?php echo $comment->comment_id; ?>"></input>
            <input name="comment_report_id" hidden class="labelusername" value="<?php echo $comment->comment_report_id; ?>"></input>
        </div>
        <div class="linebreak"><label class="svgbutton">Report type:</label><label class="labelusername"><?php echo $comment->report_type; ?></label></div>
        <div class="commentpart"><label class="svgbutton">The Comment:</label><output class="editing"><?php echo $comment->contents; ?></output></div>
        <div class="commentpart"><label class="svgbutton">Explanation:</label><output class="editing"><?php echo $comment->explanation; ?></output></div>
        <div class="linebreak">
            <label class="svgbutton">Reported: <?php echo $comment->report_date; ?></label>
        </div>
    </section>
</div>
<div id="mainbuffer"></div>
<?php endif; ?>