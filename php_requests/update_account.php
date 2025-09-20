<?php
require_once('../php_classes/account_class.php');
session_start();
$form = json_decode(file_get_contents('php://input'), true);
$account_id = $_SESSION['account_id'];
if(false && ($form['account_type'] && !(isset($_SESSION['account_type']) && $_SESSION['account_type'] == 3))){
    echo json_encode(['request_outcome'=>false]);
}
else{
    $new_account = new Account(array('account_id'=>$account_id));
    $new_account->loadAccount();
    $result = $new_account->updateAccount($form);
    if($result){
        $location = '../blogdaily/verify_email.php';
        if($new_account->account_type == 3){
            $location = '../blogdaily/search.php';
        }
        if($new_account->account_type == 1){    //redirect people who've been newly unverified
            $_SESSION['temp_id'] = $new_account->account_id;
            echo json_encode([
                'request_outcome'=>true,
                'redirect'=>$location
            ]);
        }
        else{
            echo json_encode([
                'request_outcome'=>true
            ]);
        }
    }
    else{
        $new_account->removeIV();
        echo json_encode(['request_outcome'=>false, 'class'=>$new_account]);
    }
}

?>