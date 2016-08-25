<?php 

if(session_id() == '') {
    session_start();
}
require('authorizationRules.php');
if($stopexection==true)
return;

//echo $_GET['CRQ'];
//echo "eefe";
//recieve params and create DB connection and exec sql query 
//and get the array result  and forward it to the out put of radio activity 


//$radioActivityAllowed = true;
//$transmissionActivityAllowed =true;

//SiteIDs=&CRQ=cRQ&StartTime=13&EndTime=14&ActivityType=NodeLevel
/*$SiteIDs=$_GET['SiteIDs'];
if($_GET['CardType']=="TX"){
$CardType="Transmission Activity Card";
}else {
$CardType="BSS Activity Card";
}
$CRQ=$_GET['CRQ'];
$TypeofActivity= $_GET['ActivityType'];
$DownTimeHrs=$_GET['EndTime']-$_GET['StartTime'];*/

$CRQ="";$CardType="Activity Log";$TypeofActivity='Activity Log';$DownTimeHrs="";
$BSCName=null;
$SitesArrayResult = array();
$HubArrayResult = array();
$NodesArrayResult = array();
$CoverageArrayResult = array();
$TXDuplicationArrayResult = array();
$BSSDuplicationArrayResult = array();


$TotalImpactedSites=null;//DB
$impactedAreasPercentage=null;//DB
$AreasList=null;//DB

$TotalImpactedSitesTable2=null;//DB
$impactedAreasPercentageTable2=null;//DB
$AreasListTable2=null;//DB
$con=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
$conHub=mysqli_connect("CNPVAS04","Reader","Reader","SOC");


if(isset($_GET['MismatchReportDate'])&&$_GET['MismatchReportDate'] !="")
$MismatchReportDate=$_GET['MismatchReportDate'];
else
if (!isset($MismatchReportDate)) {
$MismatchReportDate=date("Y-m-d", time() + 86400);
}


//$conTable2=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
 //$sqlCall="Call Data_Anlyzer('".$_GET['StartTime']."','".$_GET['EndTime']."','".$SiteIDs."','".$TypeofActivity."','".$CRQ."')";



//$sqlCall="Call Data_Anlyzer ('3','9','1|5509|640','MW_Link','1234')";


//rty1hhhhhhhh
//$SPresultCall = mysqli_query($conSP, $sqlCall);
//$rowCall = mysqli_fetch_assoc($SPresultCall);
//$tablename=  $rowCall['Table_Rand'];

$tablename="`Activity Log`";

$sqlSiteS = "SELECT SiteID,BSS_CRQ,TX_CRQ from `Conflicts-Sites` WHERE DATE ='".$MismatchReportDate."'";
$sqlHubs="SELECT `Hub Name`,SiteID,CRQ,`Activity Owner` from `Conflicts-TX-BSS-Hub` WHERE DATE ='".$MismatchReportDate."'";
$sqlNodes="SELECT NE,SiteID,CRQ,`Activity Owner` from `Conflicts-TX-BSS-Node` WHERE DATE ='".$MismatchReportDate."'";
$sqlCoverage="SELECT Sub_Region,SiteID,CRQ,`Activity Owner` from `Conflicts-TX-BSS-SubRegion` WHERE DATE ='".$MismatchReportDate."'";	
$sqlBSSDuplications="SELECT SiteID,CRQ1,CRQ2,CRQ3,CRQ4,CRQ5 from `Conflict-BSS_Duplication` WHERE DATE ='".$MismatchReportDate."'";
$sqlTXDuplications="SELECT SiteID,CRQ1,CRQ2,CRQ3,CRQ4,CRQ5 from `Conflicts-TX_Duplications` WHERE DATE ='".$MismatchReportDate."'";


//$sqlSiteS = "call `Conflicts-Sites`('".$MismatchReportDate."')";
//$sqlHubs="Call `Conflicts-TX-BSS`('Hub','".$MismatchReportDate."')";
//$sqlNodes="Call `Conflicts-TX-BSS`('Node','".$MismatchReportDate."')";
//$sqlCoverage="Call `Conflicts-TX-BSS`('Sub_Region','".$MismatchReportDate."') ";	
//$sqlBSSDuplications="call `Conflicts-BSS-Duplications`('".$MismatchReportDate."')";
//$sqlTXDuplications="call `Conflicts-TXDuplications`('".$MismatchReportDate."')";

$resultSites = $con->query($sqlSiteS);

if ($resultSites->num_rows > 0) {
	// output data of each row
	while($row = $resultSites->fetch_assoc()) {
				$Status=1;		
		$question = array( 'SiteID' =>$row["SiteID"],'TX_CRQ' =>$row["TX_CRQ"],'RD_CRQ' =>$row["BSS_CRQ"],'Status' => $Status); //init
		$SitesArrayResult[] = $question;				
	}
	//print_r($SitesArrayResult);
 } else {
	//echo "0 results";
}

/*
$result = mysqli_query($conHub, 
     $sqlHubs) or die("Query fail: " . mysqli_error());

  //loop the result set
  while ($row = mysqli_fetch_array($result)){   
     $Status=2;	
		$question = array('Hub Name' =>$row["Hub Name"],'SiteID' =>$row["SiteID"],'CRQ' =>$row["CRQ"],'Activity Owner' =>$row["Activity Owner"],'Status' => $Status); //init
		$HubArrayResult[] = $question;	
  }*/


  
  $con->next_result(); 
  


$resultHubs = $con->query($sqlHubs);

if ($resultHubs->num_rows > 0) {
	// output data of each row
	while($row = $resultHubs->fetch_assoc()) {
				$Status=1;	
		$question = array('Hub Name' =>$row["Hub Name"],'SiteID' =>$row["SiteID"],'CRQ' =>$row["CRQ"],'Activity Owner' =>$row["Activity Owner"],'Status' => $Status); //init
		$HubArrayResult[] = $question;		
	
	}
 } else {
	//echo "0 results";
}


$con->next_result(); 

$resultNodes = $con->query($sqlNodes);

if ($resultNodes->num_rows > 0) {
	// output data of each row
	while($row = $resultNodes->fetch_assoc()) {
				$Status=1;	
		$question = array('NE' =>$row["NE"],'SiteID' =>$row["SiteID"],'CRQ' =>$row["CRQ"],'Activity Owner' =>$row["Activity Owner"],'Status' => $Status); //init
		$NodesArrayResult[] = $question;				
	}
 } else {
	//echo "0 results";
}




$con->next_result(); 


$resultCoverage = $con->query($sqlCoverage);

if ($resultCoverage->num_rows > 0) {
	// output data of each row
	while($row = $resultCoverage->fetch_assoc()) {
				$Status=1;	
		$question = array('Sub_Region' =>$row["Sub_Region"],'SiteID' =>$row["SiteID"],'CRQ' =>$row["CRQ"],'Activity Owner' =>$row["Activity Owner"],'Status' => $Status); //init
		$CoverageArrayResult[] = $question;				
	}
 } else {
	//echo "0 results";
}

$con->next_result(); 



$resultBSSDuplications = $con->query($sqlBSSDuplications);

if ($resultBSSDuplications->num_rows > 0) {
	// output data of each row
	while($row = $resultBSSDuplications->fetch_assoc()) {
				$Status=1;	
		$question = array('siteID' =>$row["SiteID"],
		'CRQ1' =>$row["CRQ1"],
		'CRQ2' =>$row["CRQ2"],
		'CRQ3' =>$row["CRQ3"],
		'CRQ4' =>$row["CRQ4"],
		'CRQ5' =>$row["CRQ5"],
		'Status' => $Status); //init
		$BSSDuplicationArrayResult[] = $question;				
	}
 } else {
	//echo "0 results";
}


$con->next_result(); 
$resultTXDuplications = $con->query($sqlTXDuplications);

if ($resultTXDuplications->num_rows > 0) {
	// output data of each row
	while($row = $resultTXDuplications->fetch_assoc()) {
				$Status=1;	
$question = array('SiteID' =>$row["SiteID"],
		'CRQ1' =>$row["CRQ1"],
		'CRQ2' =>$row["CRQ2"],
		'CRQ3' =>$row["CRQ3"],
		'CRQ4' =>$row["CRQ4"],
		'CRQ5' =>$row["CRQ5"],
		'Status' => $Status); //init		
		$TXDuplicationArrayResult[] = $question;				
	}
 } else {
	//echo "0 results";
}






/*

$result2 = $con->query($sql2);

if ($result2->num_rows > 0) {
	// output data of each row
	while($row = $result2->fetch_assoc()) {

		//echo $row["Sub_Region"].$row["Affected_Count"].$row["All_Count"].$row["Area Impact %"];
		//echo "name: " . $row["name"]. " - Name: " . $row["activity"]."<br>";
		

		
		
		if(is_null($BSCName))
			$BSCName="'".$row["NE"]."'";
		else
			$BSCName=$BSCName.",'".$row["NE"]."'";
		
		
		
		if(is_null($TotalImpactedSites))
			$TotalImpactedSites=$row["totalImpacted"];
		else
			$TotalImpactedSites=$TotalImpactedSites.",".$row["totalImpacted"];
		
		
		
	}
} else {
	//echo "0 results";
}



$result3 = $con->query($sql3);

if ($result3->num_rows > 0) {
	// output data of each row
	while($row = $result3->fetch_assoc()) {
		
		
		//echo $row["Total_SPEECH_TRAFFIC"].$row["DATA_MB"];
		 $TotalSpeechTrafficImpactedErlg=$row["Total_SPEECH_TRAFFIC"];//DB
		 $TotalDataTrafficImpactedMB=$row["DATA_MB"];//DB
		


	}
} else {
	//echo "0 results";
}


//table 2 from here 


$resultTable2 = $conTable2->query($sqlTable2);

if ($resultTable2->num_rows > 0) {
	// output data of each row
	while($row = $resultTable2->fetch_assoc()) {

		//echo $row["Sub_Region"].$row["Affected_Count"].$row["All_Count"].$row["Area Impact %"];
		//echo "name: " . $row["name"]. " - Name: " . $row["activity"]."<br>";
		$Status=2;
		if($row["Area 2G Impact %"]<50 or $row["Area 3G Impact %"]<50)
		$Status=999;
		if((50<$row["Area 2G Impact %"]&&$row["Area 2G Impact %"]<75) or (50<$row["Area 3G Impact %"]&&$row["Area 3G Impact %"]<75))
		$Status=2;
		if($row["Area 2G Impact %"]>85 or $row["Area 3G Impact %"]>85)
		$Status=3;
		
		$question = array('Impacted_2G_Sites' => $row["Impacted_2G_Sites"], 'Total_2G_Sites' =>$row["Total_2G_Sites"],
		'Impacted_3G_Sites' =>$row["Impacted_3G_Sites"],
		'Total_3G_Sites' =>$row["Total_3G_Sites"],
		'Area 2G Impact %' =>$row["Area 2G Impact %"],
		'Area 3G Impact %' =>$row["Area 3G Impact %"],
		'Status' => $Status ); //init
		
		
		$Table2ArrayResult[$row["Sub_Region"]] = $question;
		
	
		
		
		
	}
 } else {
	//echo "0 results";
}

//end table here 



mysqli_close($con);
mysqli_close($conTable2);

*/
$pageTitle ="Conflict Report" ;
include 'header.php';
include 'MismatchOutputDesign.php';
//include 'activity.php';
include 'footer.html';
