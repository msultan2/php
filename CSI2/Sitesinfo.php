<?php 


require('authorizationRules.php');
if($stopexection==true)
return;
$SiteIDs=$_GET['SiteIDs'];
$TypeofActivity= $_GET['ActivityType'];
$con=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
$con2=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
$TableTempArrayResult = array();
 $sqlCall="Call Data_Anlyzer('0','0','".$SiteIDs."','".$TypeofActivity."','rrr','".$_SESSION["Username"]."','none','2015-12-13',0)";


//$sqlCall="Call Data_Anlyzer ('3','9','1|5509|640','MW_Link','1234')";

//echo $sqlCall ;
//rty1hhhhhhhh
$SPresultCall = mysqli_query($con, $sqlCall);
$rowCall = mysqli_fetch_assoc($SPresultCall);
$tablename=  $rowCall['Table_Rand'];

$sqlTemp="select * from `".$tablename."`";
//$con->next_result(); 
$resultTempTeble = $con2->query($sqlTemp);

if ($resultTempTeble->num_rows > 0) {

	// output data of each row
	while($row = $resultTempTeble->fetch_assoc()) {
	
		$Status=1;
		/*if($row["Activity Impacted Sites"]<50)
		$Status=999;
		if((50<$row["Activity Impacted Sites"]&&$row["Activity Impacted Sites"]<75))
		$Status=2;
		if($row["Activity Impacted Sites"]>85 )
		$Status=3;*/
		$question = array(
		'SiteID'=>$row["SiteID"],
		'Hub Name' => $row["Hub Name"],
		'Sub_Region' => $row["Sub_Region"],
		'NE' => $row["NE"],
		'Status' => $Status
		
		
		); //init
		$TableTempArrayResult[] = $question;
	}
 } else {
}


//$con->next_result(); 


$sqlDrop="Drop table ".$tablename;
if ($con2->query($sqlDrop) === TRUE) {
//echo $tablename ;
//echo "Record deleted successfully";
} else {
//echo "Error deleting record: " . $con->error;
}


mysqli_close($con);
mysqli_close($con2);
$pageTitle ="Site Info" ;
include 'header.php';
include 'SitesinfoDesign.php';
//include 'activity.php';
include 'footer.html';
