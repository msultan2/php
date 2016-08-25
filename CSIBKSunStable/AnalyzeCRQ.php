<?php 


require('authorizationRules.php');
if($stopexection==true)
return;
$con=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
$SiteListPiped ="";
$CRQNotFoundFlag = true ;
$TableArrayResult = array();
if(isset($_GET['CRQ'])){

$ActivityUnderCheckCRQ=$_GET['CRQ'] ;//SqL injection danger 
 $CRQ=$ActivityUnderCheckCRQ;
   $sqlActivityCheck="select SiteID from `Activity Log` where CRQ='".$CRQ."'";


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
	}$i++;
	}
 } else {
 $CRQNotFoundFlag =false ;
	//echo " No data  ";
}
}
mysqli_close($con);
header("Location: ./RadioActivityOutput.php?SiteIDs=".$SiteListPiped."&CRQ=mahtest6&StartTime=0&EndTime=7&ActivityType=BSS_Site&CardType=TX&ExectionTime=2015-11-12&Implementer=&Affect=False");