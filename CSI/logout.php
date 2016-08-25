<?php 
session_start();
$_SESSION["authorized"]=false ;
unset($_SESSION["radioActivityAllowed"]);
unset($_SESSION["transmissionActivityAllowed"]);
unset($_SESSION["radioActivityAllowed"]);
unset($_SESSION["Username"]);
unset($_SESSION["activityLogAllowed"]);
unset($_SESSION["mismatchReportActivityAllowed"]);
unset($_SESSION["activityOperationAllowed"]);
unset($_SESSION["cMStatisticsAllowed"]);
// remove all session variables
//session_unset();

// destroy the session
//session_destroy();
header('Location: index.php');
include 'header.html';
include 'login.html';
include 'footer.html';


?>