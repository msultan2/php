<?php include ("newtemplate_IT.php"); ?>
<?php
session_start();
session_unset();
session_destroy();

header("location:index.php");
exit();
?>
<?php include ("footer_new_IT.php"); ?>