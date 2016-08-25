<?php 


require('authorizationRules.php');
if($stopexection==true)
return;
$con=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
$TableArrayResult = array();


$sqlTemp="SELECT * FROM `Down Sites CRQ Effect`";
$con->next_result(); 
$resultTeble = $con->query($sqlTemp);

if ($resultTeble->num_rows > 0) {

	// output data of each row
	while($row = $resultTeble->fetch_assoc()) {
	
		$Status=1;
		/*if($row["Activity Impacted Sites"]<50)
		$Status=999;
		if((50<$row["Activity Impacted Sites"]&&$row["Activity Impacted Sites"]<75))
		$Status=2;
		if($row["Activity Impacted Sites"]>85 )
		$Status=3;*/
		$question = array(
		'SiteID'=>$row["Site_ID"],
		'OSS Down Time' => $row["OSS Down Time"],
		'Activity Date' => $row["Activity Date"],
		'Activity Start Date' => $row["Activity Start Date"],
		'Activity End Date'=>$row["Activity End Date"],
		'CRQ'=>$row["CRQ"],
		'Activity Owner'=>$row["Activity Owner"],
		'NE'=>$row["NE"],
		'Status' => $Status
		
		
		); //init
		$TableArrayResult[] = $question;
	}
 } else {
}




$pageTitle ="DownSite-Activity" ;
include 'header.php';
include 'downSitesPerActivityDesign.php';
//include 'activity.php';
include 'footer.html';
