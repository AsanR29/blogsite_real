<?php

session_start();
$form = json_decode(file_get_contents('php://input'), true);

if(!isset($_SESSION['blogtags'])){
    $_SESSION['blogtags'] = array();
}

if(isset($form['blogtag'])){
    $_SESSION['blogtags'][] = $form['blogtag'];
    return;
}
else if(isset($form['index'])){
    array_splice($_SESSION['blogtags'],$form['index'],1);
    return;
}

?>