<?php
require_once('../php_classes/horse_classes.php');

require_once('../php_classes/account_class.php');
require_once('../php_classes/file_class.php');
session_start();


$account_id = false; $trainer_id = false;
if(isset($_SESSION['account_id'])){
    $account_id = $_SESSION['account_id'];
}
if(isset($_SESSION['trainer_id'])){
    $trainer_id = $_SESSION['trainer_id'];
}

if($account_id && $trainer_id){
    $results_array = [];
    $result;

    $grades = [
        "g" => 0,
        "f" => 1,
        "e" => 2,
        "d" => 3,
        "c" => 4,
        "b" => 5,
        "a" => 6,
        "s" => 7
    ];
    $graded_values = ["turf","dirt","sprint","mile","medium","long","front","pace","late","end"];
    foreach($_POST as $key => $value) {
        if(in_array($key,$graded_values)) {
            $_POST[$key] = $grades[$_POST[$key]];
        }
    }
    $_POST['front_runner'] = $_POST['front'];
    $_POST['pace_chaser'] = $_POST['pace'];
    $_POST['late_surger'] = $_POST['late'];
    $_POST['end_closer'] = $_POST['end'];

    $_POST['trainer_id'] = $trainer_id;
    $_POST["horse_type"] = $_POST["trainee_enum"];

    $error_holder = ["hello"=>"world"];
    $error_holder["reformatted_form"] = $_POST;

    $new_horse = new Horse($_POST);
    $result = $new_horse->createHorse();

    $error_holder['files_Stuff'] = $_FILES["imageSubmission"];
    if($result) {
        $result = $new_horse->createHorseStats();
        $params = array(
            'roster_id'=>$new_horse->roster_id,
            'account_id'=>$account_id,
            'file_use'=>"horse_icon"
        );
        $result_array = UserFile::createFiles($params, $_FILES["imageSubmission"]);
        $error_holder['file_results'] = $result_array;
    }
}
echo json_encode(['request_outcome'=>false, 'class'=>$error_holder]);


?>