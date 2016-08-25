<?php 
$con=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
$conSP=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
$conTable2=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
$SiteListPiped ="";
$CRQNotFoundFlag = true ;
$TableArrayResult = array();
if(isset($_GET['ActivityUnderCheckCRQ'])){

$ActivityUnderCheckCRQ=$_GET['ActivityUnderCheckCRQ'] ;//SqL injection danger 
 $CRQ=$ActivityUnderCheckCRQ;
  $sqlActivityCheck="select SiteID from `Activity Log` where CRQ='".$ActivityUnderCheckCRQ."'";


$resultsqlActivityCheck = $con->query($sqlActivityCheck);
if ($resultsqlActivityCheck->num_rows > 0) {
$i=0;
	// output data of each row
	while($row = $resultsqlActivityCheck->fetch_assoc()) {
	$i++;
	if($i==0){
	$SiteListPiped=$row["SiteID"];
	}else
	{
	$SiteListPiped=$SiteListPiped."|".$row["SiteID"];
	}
	
	
	
	}

 } else {
 $CRQNotFoundFlag =false ;
	//echo " No data  ";
}








}else
{
$SiteIDs=$_GET['SiteIDs'];
$CRQ=$_GET['CRQ'];
if($_GET['CardType']=="TX"){
$CardType="Transmission Activity Card";
}else {
$CardType="BSS Activity Card";
}
$CRQ=$_GET['CRQ'];
$TypeofActivity= $_GET['ActivityType'];
$DownTimeHrs=$_GET['EndTime']-$_GET['StartTime'];






// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}




$sqlCall="Call Data_Anlyzer_WithoutLogEffect('".$_GET['StartTime']."','".$_GET['EndTime']."','".$SiteIDs."','".$TypeofActivity."','".$CRQ."')";
$SPresultCall = mysqli_query($conSP, $sqlCall);
$rowCall = mysqli_fetch_assoc($SPresultCall);
 $tablename=  $rowCall['Table_Rand'];






  $sqlSiteList="select SiteID from ".$tablename." where CRQ='".$CRQ."'";


$resultsqlSiteList = $con->query($sqlSiteList);
if ($resultsqlSiteList->num_rows > 0) {
$i=0;
	// output data of each row
	while($row = $resultsqlSiteList->fetch_assoc()) {
	$i++;
	if($i==0){
	$SiteListPiped=$row["SiteID"];
	}else
	{
	$SiteListPiped=$SiteListPiped."|".$row["SiteID"];
	}
	
	
	
	}

 } else {
	//echo "0 results";
}


$sqlDrop="Drop table ".$tablename;
if ($con->query($sqlDrop) === TRUE) {
//echo $tablename ;
//echo "Record deleted successfully";
} else {
//echo "Error deleting record: " . $conn->error;
}



	
}//end of the SiteListPiped

if($CRQNotFoundFlag){
   $sqlCall="Call DownSitesCheckAfter('".$SiteListPiped."','".$CRQ."')";

$result = $con->query($sqlCall);
if ($result->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()) {
	
	 $data = explode("|", $row["result"]);
	
	//echo $data = preg_split('|', $row["result"]);
	$Status=3;
	foreach($data as $item)
	{
	if($item !== ''){
	$question = array('SiteID' =>$item ,'SiteStatus' => 'down','Status' => $Status); //init
		$TableArrayResult[] = $question; 
		}
	}
	
	/*foreach($item in $data)
	{
	$question = array('No. Sites' => $row["NoOfSites"],'Status' => $Status); //init
		$TableArrayResult[$row["Total Impacted 2G Sites"]] = $question; 
	}*/
	 
	}
	
 } else {
	//echo "0 results";
}



$data = explode("|", $SiteListPiped);
	
	//echo $data = preg_split('|', $row["result"]);
	$Status=1;
	foreach($data as $item)
	{
	if($item !== ''&!isset($TableArrayResult[$item])){
	
$question = array('SiteID' =>$item ,'SiteStatus' => 'up','Status' => $Status); //init
		$TableArrayResult[] = $question; 
		}
	}
	

	
}//end the flag check condition  


	
	
$sqlDrop="Drop table ".$tablename;
if ($con->query($sqlDrop) === TRUE) {
//echo $tablename ;
//echo "Record deleted successfully";
} else {
//echo "Error deleting record: " . $conn->error;
}
	




mysqli_close($con);
mysqli_close($conSP);
mysqli_close($conTable2);




include 'header.php';
include 'DownSitesCheckDesign.php';
//include 'activity.php';
include 'footer.html';
