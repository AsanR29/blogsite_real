<!DOCTYPE html>
<html>
<head>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/horse_style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../javascript_imports/forms.js"></script>
</head>
<div id="super">
<?php
session_start();
$account_id = false;
$account_type = false;
if(isset($_SESSION['account_id'])){
    $account_id = $_SESSION['account_id'];
    $account_type = $_SESSION['account_type'];
}
?>