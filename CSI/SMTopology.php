<?php 
$con=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
$TableArrayResult = array();

if(isset($_GET['ActivityUnderCheckCRQ'])){

$ActivityUnderCheckCRQ=$_GET['ActivityUnderCheckCRQ'] ;//SqL injection danger 
 $CRQ=$ActivityUnderCheckCRQ;
  $sqlActivityCheck="select SiteID from `Activity Log` where CRQ='".$ActivityUnderCheckCRQ."' and SiteStatusAfterActivity = 1 and SiteStatusAfterActivity = 0";


$resultsqlActivityCheck = $con->query($sqlActivityCheck);
if ($resultsqlActivityCheck->num_rows > 0) {
$i=0;
	// output data of each row
	while($row = $resultsqlActivityCheck->fetch_assoc()) {

	
	
	$Status=3;
	if($row['SiteID'] !== ''){
	$question = array('SiteStatus' => 'down','Status' => $Status); //init
		$TableArrayResult[$row['SiteID']] = $question; 
	}
	
	
	
	
	
	
	}
	
	
	 
	//echo $data = preg_split('|', $row["result"]);
	
	

 } else {
	//echo " No data  ";
}








}

mysqli_close($con);





include 'header.php';
include 'SMTopologyDesign.php';
//include 'activity.php';
include 'footer.html';
