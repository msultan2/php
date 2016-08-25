<?php 


require('authorizationRules.php');
if($stopexection==true)
return;

$con=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
$SiteListPiped ="";
$CRQ="";
$TableArrayResult = array();
if(isset($_GET['Sites'])){
$SiteListPiped=$_GET['Sites'];
 $sqlCall="Call DownSitesCheck('".$SiteListPiped."','','2')";
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
	

	
//end the flag check condition  


}




mysqli_close($con);



$pageTitle ="Down Sites Check" ;
include 'header.php';
include 'DownSitesCheckDesign.php';
//include 'activity.php';
include 'footer.html';
