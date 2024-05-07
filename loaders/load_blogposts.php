<?php
require_once('../php_classes/blog_class.php');
$params = array();
if(isset($username)){
    require_once('../php_classes/account_class.php');
    $params = array('username'=>$username);
    $account = new Account($params);
    $result = $account->loadAccount();
    if($result){
        $account_id = $account->account_id;
    }
    else{
        $account_id = 0;
    }
}
if(isset($account_id) && $account_id){
    $params['account_id'] = $account_id;
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