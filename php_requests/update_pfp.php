<?php
require_once('../php_classes/file_class.php');
session_start();
if(isset($_SESSION['account_id'])){
    $account_id = $_SESSION['account_id'];

    $params = array(
        'account_id'=>$account_id,
        'file_use'=>"pfp"
    );
    $result_array = UserFile::createFiles($params, $_FILES["imageSubmission"]);
    //print_r($result_array);
}
header('Location: ../blogdaily/upload_pfp.php');
?>