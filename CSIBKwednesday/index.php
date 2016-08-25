<?php
session_start();
if(isset($_SESSION["authorized"]) ==true)
{
header('Location: Controller.php');
}else{
include 'header.php';
include 'login.html';
include 'footer.html';
}