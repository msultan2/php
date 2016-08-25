<?php
$con=mysqli_connect("CNPVAS04","Reader","Reader","SOC");

// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if($_GET['Sites']==""){echo"unable"; return ;};
 $sqlTable1 = "Delete  from `Activity Log` where CRQ ='".$_GET['CRQ']."' and SiteID IN(".$_GET['Sites'].")";
  
//'Activity Impacted Sites','No. Sites'

//$result = $con->query($sqlTable1);
if ($con->query($sqlTable1) === TRUE) {
									if($con->affected_rows>0)
									$CRQFlag="deleted";
									else
									$CRQFlag="notexist";   
                                  }
echo $CRQFlag;
?>