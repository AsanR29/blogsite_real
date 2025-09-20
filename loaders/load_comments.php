<div id="mainbuffer"></div>
<?php
session_start();
$username = false;
if(isset($_SESSION['username']) && $_SESSION['username']){
    $username = $_SESSION['username'];
}
require_once('../php_classes/blog_class.php');
require_once('../php_classes/comment_class.php');
require_once('../php_classes/file_class.php');
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
            <a href="../blogdaily/user.php?username=<?php echo $comment_array[$i]->username; ?>"><img class="pfp" src="
            <?php
                $account_id = $comment_array[$i]->account_id;
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
            <div class="linebreak"><label class="labelusername"><?php echo $comment_array[$i]->username; ?></label></div>
            <div class="commentpart"><output class="b_text"><?php echo $comment_array[$i]->contents; ?></output></div>
            <div class="linebreak">
                <label class="info_span">Posted: <?php echo $comment_array[$i]->comment_datetime; ?></label>
            <?php if($username){
                if($username == $comment_array[$i]->username): ?>
                    <button name="<?php echo $comment_array[$i]->comment_id; ?>" onclick="loadPopup('deletecomment'); updateSelectedComment(this)" class="gen_button floatright">Delete</button>
                <?php else: ?>
                    <button name="<?php echo $comment_array[$i]->comment_id; ?>" onclick="loadPopup('popupreportcomment'); updateSelectedComment(this)" class="gen_button floatright">Report</button>
                <?php endif; } ?>
            </div>
        </section>
    </div>
    
<?php endfor; ?>