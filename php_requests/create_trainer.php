<?php
require_once('../php_classes/account_class.php');
session_start();
$form = json_decode(file_get_contents('php://input'), true);


$new_trainer = new Trainer($form);

if(isset($_SESSION['account_id'])){
    $account_id = $_SESSION['account_id'];
    $new_trainer->account_id = $account_id;
    $result = $new_trainer->createTrainer();

    $location = '../blogdaily/trainer_menu.php';
    if($result){
        $_SESSION['trainer_id'] = $new_trainer->trainer_id;
        $location = '../blogdaily/trainer.php';
    }
    if($result){ $result = true; }  // to be sure
    echo json_encode([
        'request_outcome'=>$result,
        'redirect'=>$location
    ]);
}
else{
    echo json_encode(['request_outcome'=>false]);
}

?>