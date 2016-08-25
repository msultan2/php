<?php 


require('authorizationRules.php');
if($stopexection==true)
return;
$con=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
$TableArrayResult = array();

if(isset($_GET['ActivityUnderCheckCRQ'])){

$ActivityUnderCheckCRQ=$_GET['ActivityUnderCheckCRQ'] ;//SqL injection danger 
 $CRQ=$ActivityUnderCheckCRQ;
   $sqlActivityCheck="select SiteID from `Activity Log` where CRQ='".$ActivityUnderCheckCRQ."' and SiteStatusBeforeActivity = 1 and SiteStatusAfterActivity = 0";


$resultsqlActivityCheck = $con->query($sqlActivityCheck);
if ($resultsqlActivityCheck->num_rows > 0) {
$i=0;
	// output data of each row
	while($row = $resultsqlActivityCheck->fetch_assoc()) {

	
	
	$Status=3;
	if($row['SiteID'] !== ''){
	$question = array('SiteID' => $row['SiteID'],
	'SiteStatus' => 'down','Status' => $Status); //init
		$TableArrayResult[] = $question; 
	}
	
	
	
	
	
	
	}
	
	
	 
	//echo $data = preg_split('|', $row["result"]);
	
	

 } else {
	//echo " No data  ";
}








}

mysqli_close($con);




$pageTitle ="Activity Impacted Sites " ;
include 'header.php';
include 'ActivityDownSitesDesign.php';
//include 'activity.php';
include 'footer.html';
