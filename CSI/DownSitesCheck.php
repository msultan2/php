<?php 


require('authorizationRules.php');
if($stopexection==true)
return;
$con=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
$SiteListPiped ="";
$CRQNotFoundFlag = true ;
$TableArrayResult = array();
$CheckStatus=$_GET['CheckStatus'];
if(isset($_GET['ActivityUnderCheckCRQ'])){

$ActivityUnderCheckCRQ=$_GET['ActivityUnderCheckCRQ'] ;//SqL injection danger 
 $CRQ=$ActivityUnderCheckCRQ;
  $sqlActivityCheck="select SiteID from `Activity Log` where CRQ='".$ActivityUnderCheckCRQ."'";


$resultsqlActivityCheck = $con->query($sqlActivityCheck);
if ($resultsqlActivityCheck->num_rows > 0) {
$i=0;
	// output data of each row
	while($row = $resultsqlActivityCheck->fetch_assoc()) {
	
	if($i==0){
	$SiteListPiped=$row["SiteID"];
	}else
	{
	$SiteListPiped=$SiteListPiped."|".$row["SiteID"];
	}
	$i++;
	
	
	}

 } else {
 $CRQNotFoundFlag =false ;
	//echo " No data  ";
}



if($CRQNotFoundFlag){
if($CheckStatus==1)
$sqlCall="Call DownSitesCheck('".$SiteListPiped."','".$CRQ."','1')";
else
$sqlCall="Call DownSitesCheck('".$SiteListPiped."','".$CRQ."','0')";

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


}




mysqli_close($con);



$pageTitle ="Down Sites Check" ;
include 'header.php';
include 'DownSitesCheckDesign.php';
//include 'activity.php';
include 'footer.html';
