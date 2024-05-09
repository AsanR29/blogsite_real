<div id="mainbuffer"></div><div id="mainbuffer"></div>
<?php
session_start();
$username = false;
if(isset($_SESSION['username']) && $_SESSION['username']){
    $username = $_SESSION['username'];
}
require_once('../php_classes/blog_class.php');
require_once('../php_classes/comment_class.php');
$form = json_decode(file_get_contents('php://input'), true);
$params = array();

if(isset($form['blog_url']) && $form['blog_url']){
    $blog = new BlogPost($form);
    $result = $blog->loadBlog();
    if($result){
        $blog_id = $blog->blog_id;
        $params['blog_id'] = $blog_id;
    }
}
if(isset($form['page'])){
    $params['page'] = $form['page'];
}

$comment_array = Comment::loadComments($params);
for($i = 0; $i < count($comment_array); $i++): ?>
    <div class="commentarea">
        <section class="commentpicarea">
            <a href="../blogdaily/user.php?username=<?php echo $comment_array[$i]->username; ?>"><img class="pfp" src="../css/defaultpfp.png"></a> 
        </section>
        <section class="commenttext">
            <div class="linebreak"><label class="labelusername"><?php echo $comment_array[$i]->username; ?></label></div>
            <div class="commentpart"><output class="editing"><?php echo $comment_array[$i]->contents; ?></output></div>
            <div class="linebreak">
                <label class="svgbutton">Posted: <?php echo $comment_array[$i]->comment_datetime; ?></label>
            <?php if($username){
                if($username == $comment_array[$i]->username): ?>
                    <button name="<?php echo $comment_array[$i]->comment_id; ?>" onclick="loadPopup('deletecomment'); updateSelectedComment(this)" class="svgbutton floatright">Delete</button>
                <?php else: ?>
                    <button name="<?php echo $comment_array[$i]->comment_id; ?>" onclick="loadPopup('popupreportcomment'); updateSelectedComment(this)" class="svgbutton floatright">Report</button>
                <?php endif; } ?>
            </div>
        </section>
    </div>
    <div id="mainbuffer"></div>
<?php endfor; ?>