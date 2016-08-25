<?php
$con=mysqli_connect("CNPVAS04","Reader","Reader","SOC");

// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if($_GET['CRQ']=="")echo"unable";

   $sqlselectExecTime = "select `Activity Date`  from `Activity Log` where CRQ ='".$_GET['CRQ']."' limit 1";
$executiontime="";
   $resultselectExecTime = $con->query($sqlselectExecTime);

if ($resultselectExecTime->num_rows > 0) {

	// output data of each row
	while($row = $resultselectExecTime->fetch_assoc()) {
	
	$executiontime=$row["Activity Date"];
	$executiontime=substr($executiontime,0,10);
	}
 } else {
	//echo "0 results";
}



								  


  $sqlTable1 = "Delete  from `Activity Log` where CRQ ='".$_GET['CRQ']."'";
   
//'Activity Impacted Sites','No. Sites'

//$result = $con->query($sqlTable1);
if ($con->query($sqlTable1) === TRUE) {
									if($con->affected_rows>0)
									$CRQFlag=$executiontime;
									else
									$CRQFlag="notexist";   
                                  }
echo $CRQFlag;
?>