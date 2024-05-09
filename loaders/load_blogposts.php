<?php
require_once('../php_classes/blog_class.php');
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
$blog_array = BlogPost::loadBlogs($params);

for($i = 0; $i < count($blog_array); $i++):
?>
<section>
    <div><output class="titlesize"><?php echo $blog_array[$i]->title; ?></output></div>
    <div><output class="editing"><?php echo substr($blog_array[$i]->contents, 0, 300) . '...'; ?></output></div>
    <div><a class="labelgen" href="../blogdaily/read.php?blog_url=<?php echo $blog_array[$i]->blog_url; ?>">Read more</a></div>
</section>
<div id="mainbuffer"></div>
<?php endfor; ?>