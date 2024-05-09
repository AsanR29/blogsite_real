<?php
require_once('../php_classes/account_class.php');
session_start();
$form = json_decode(file_get_contents('php://input'), true);

$account = new Account($form);
$result = $account->loadAccount();
if($result){
    if($account->account_type == 0){    //banned
        echo json_encode(['request_outcome'=>false]);
    }
    else{   //logs you in
        $location = '../blogdaily/search.php';
        $_SESSION['account_id'] = $account->account_id;
        $_SESSION['account_type'] = $account->account_type;
        $_SESSION['username'] = $account->username;
        if($account->account_type == 1){    //unverified email
            $location = '../blogdaily/verify_email.php';
        }
        echo json_encode([
            'request_outcome'=>true,
            'redirect'=>$location
        ]);
    }
}
else{
    $account->removeIV();
    echo json_encode(['request_outcome'=>false, 'class'=>$account]);
}

?>