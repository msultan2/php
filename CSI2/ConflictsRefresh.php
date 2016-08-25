<?php
//$datetime = new DateTime('tomorrow');
//$tomorrowDate= $datetime->format('Y-m-d');
$tomorrowDate=$_GET['date'];
$sql1="call `Conflicts-BSS-Duplications`('".$tomorrowDate."')";
$sql2="call `Conflicts-Sites`('".$tomorrowDate."')";
$sql3="call `Conflicts-TX-BSS`('Hub','".$tomorrowDate."')";
$sql4="call `Conflicts-TX-BSS`('Node','".$tomorrowDate."')";
$sql5="call `Conflicts-TX-BSS`('Sub_Region','".$tomorrowDate."')";
$sql6="call `Conflicts-TX_Duplications`('".$tomorrowDate."')";
$conAsync=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
if($_GET['SQLNUM']==1)
$sql=$sql1;
if($_GET['SQLNUM']==2)
$sql=$sql2;
if($_GET['SQLNUM']==3)
$sql=$sql3;
if($_GET['SQLNUM']==4)
$sql=$sql4;
if($_GET['SQLNUM']==5)
$sql=$sql5;
if($_GET['SQLNUM']==6)
$sql=$sql6;

if ($conAsync->query($sql) === TRUE) {
//echo $tablename ;
echo json_encode("Record deleted successfully");
} else {
echo json_encode("Record deleted failed").$conAsync->error;
}