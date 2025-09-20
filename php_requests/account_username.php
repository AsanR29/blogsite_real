<?php
if(isset($blog) && isset($blog->account_id) && $blog->account_id){
    require_once('../php_classes/account_class.php');
    $account = new Account(array('account_id' => $blog->account_id));
    $result = $account->loadAccount();
    if($account->username){
        echo $account->username;
    }
}




?>