<?php
require_once('../php_classes/account_class.php');
session_start();
$form = json_decode(file_get_contents('php://input'), true);
$account_id = $_SESSION['temp_id'];

$new_account = new Account(array('account_id'=>$account_id));
$new_account->loadAccount();

if($new_account->account_type == 1){
    $params = array('account_type'=>2);
    $result = $new_account->updateAccount($params);
    if($result){
        $location = '../blogdaily/login.php';
        echo json_encode([
            'request_outcome'=>true,
            'redirect'=>$location
        ]);
    }
    else{
        $new_account->removeIV();
        $new_account->removeID();
        echo json_encode(['request_outcome'=>false, 'class'=>$new_account]);
    }
}
else{
    echo json_encode(['request_outcome'=>false]);
}

?>