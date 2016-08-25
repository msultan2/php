<?php

require('authorizationRules.php');
	if($stopexection==true)
return;
	$con=mysqli_connect("CNPVAS04","Reader","Reader","SOC");

	if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sqlPlannedAll="UPDATE `Activity Log`
SET Postponed=0";
$con->query($sqlPlannedAll);

if($_GET['CRQs']){
 $sqlPostponed="UPDATE `Activity Log` SET Postponed=1 WHERE CRQ IN (".$_GET['CRQs'].");";

if ($con->query($sqlPostponed) === TRUE) {
									if($con->affected_rows>0)
									echo $CRQFlag="Postponed";
									else
								 	echo $CRQFlag="failed";  

									return;
                                  }


}//end crq check 
echo "Postponed";
?>