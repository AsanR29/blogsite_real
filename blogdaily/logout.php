<?php
session_start();
session_unset();
header('location: ../blogdaily/search.php');
?>