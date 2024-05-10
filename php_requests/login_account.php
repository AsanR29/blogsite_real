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
    else if($account->account_type == 1){   //logs you in
        $location = '../blogdaily/verify_email.php';
        $_SESSION['temp_id'] = $account->account_id;
        echo json_encode([
            'request_outcome'=>true,
            'redirect'=>$location
        ]);
    }
    else if($account->account_type == 3){
        $location = '../blogdaily/address_comment_reports.php';
        $_SESSION['account_id'] = $account->account_id;
        $_SESSION['account_type'] = $account->account_type;
        $_SESSION['username'] = $account->username;
        echo json_encode([
            'request_outcome'=>true,
            'redirect'=>$location
        ]);
    }
    else{
        $location = '../blogdaily/search.php';
        $_SESSION['account_id'] = $account->account_id;
        $_SESSION['account_type'] = $account->account_type;
        $_SESSION['username'] = $account->username;
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