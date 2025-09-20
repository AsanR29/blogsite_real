<?php
require_once('../php_classes/blog_class.php');
require_once('../php_classes/blog_tag_class.php');
require_once('../php_classes/account_class.php');
$form = json_decode(file_get_contents('php://input'), true);
$params = array();

if(isset($form['username']) && $form['username']){
    $account = new Account($form);
    $result = $account->loadAccount();
    if($result){
        $user_id = $account->account_id;
        $params['account_id'] = $user_id;
    }
}
if(isset($form['page'])){
    $params['page'] = $form['page'];
}
if(isset($form['title'])){
    $params['title'] = $form['title'];
}
//if(isset($form['blog_tag'])){
session_start();

$params['blog_tag'] = BlogTag::loadTags($_SESSION['blogtags']);//$form['blog_tag']);
//}

$blog_array = BlogPost::loadBlogs($params);

for($i = 0; $i < count($blog_array); $i++):
?>
<section class="blogpr blogpreview">
    <div><output class="titlesize"><?php echo $blog_array[$i]->title; ?></output></div>
    <div class="blogp">
        <div class="blogpL1 blogpr"></div>
        <div class="blogpM1">
            <div class="blogt"><p class="b_text"><?php echo substr($blog_array[$i]->contents, 0, 300) . '...'; ?></p></div>
            <div class="blogt"><a class="labelgen" href="../blogdaily/read.php?blog_url=<?php echo $blog_array[$i]->blog_url; ?>">Read more</a></div>
        </div>
        <div class="blogpR1 blogpr"></div>
    </div>
    <div class="blogfoot blogpr"></div>
</section>
<div id="mainbuffer"></div>
<?php endfor; ?>
<?php if(count($blog_array) == 0): ?>
<section>
    <div><output class="titlesize" style="color:grey">No results</h2></div>
</section>
<?php endif; ?>
