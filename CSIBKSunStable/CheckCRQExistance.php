<?php
$con=mysqli_connect("CNPVAS04","Reader","Reader","SOC");

// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

   $sqlTable1 = "select CRQ from `Activity Log` where CRQ ='".$_GET['CRQ']."' limit 1";
  
//'Activity Impacted Sites','No. Sites'
$result = $con->query($sqlTable1);

if ($result->num_rows > 0) {

	// output data of each row
$CRQFlag="exist";
	
 } else {
	$CRQFlag="notexist";
}
echo $CRQFlag;
return ; 
?>