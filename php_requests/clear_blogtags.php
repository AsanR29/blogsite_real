<?php

session_start();
unset($_SESSION['blogtags']);
$_SESSION['blogtags'] = array();

require_once('../loaders/blogtag_box.php');
?>