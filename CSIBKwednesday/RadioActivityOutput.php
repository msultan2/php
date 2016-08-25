<?php 

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
$SiteIDs=$_GET['SiteIDs'];
if($_GET['CardType']=="TX"){
$CardType="Transmission Activity Card";
}else {
$CardType="BSS Activity Card";
}
$CRQ=$_GET['CRQ'];
$ExectionTime=$_GET['ExectionTime'];
$Implementer=$_GET['Implementer'];
$TypeofActivity= $_GET['ActivityType'];
$DownTimeHrs=$_GET['EndTime']-$_GET['StartTime'];
$BSCName=null;
$TableArrayResult = array();
$Table2ArrayResult = array();
$TableTempArrayResult = array();
$TableProtectedSitesArrayResult=$TableRiskSitesArrayResult=array();
$TotalImpactedSites=null;//DB
$impactedAreasPercentage=null;//DB
$AreasList=null;//DB

$TotalImpactedSitesTable2=null;//DB
$impactedAreasPercentageTable2=null;//DB
$AreasListTable2=null;//DB



$con=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
$conSP=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
$conTable2=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


// check crq existance 
if(!(isset($_GET['Operation'])and $_GET['Operation']=="Modify")){
if(!isset($_GET['Affect'])){
require('CheckCRQExistance.php');ob_clean();

if($CRQFlag=="exist")
{
$errorMsg="CRQ Dublication ";
include 'header.php';
		include 'error.php';
		include 'footer.html';
		return ;
}}else{
if($_GET['Affect']=="True"){
require('CheckCRQExistance.php');ob_clean();
if($CRQFlag=="exist")
{
$errorMsg="CRQ Dublication ";
include 'header.php';
		include 'error.php';
		include 'footer.html';
		return ;
}
}else{

}
}
}


if(!isset($_GET['Affect']))
   $sqlCall="Call Data_Anlyzer('".$_GET['StartTime']."','".$_GET['EndTime']."','".$SiteIDs."','".$TypeofActivity."','".$CRQ."','".$_SESSION["Username"]."','".$Implementer."','".$ExectionTime."',1)";
else
if($_GET['Affect']=="True")
   $sqlCall="Call Data_Anlyzer('".$_GET['StartTime']."','".$_GET['EndTime']."','".$SiteIDs."','".$TypeofActivity."','".$CRQ."','".$_SESSION["Username"]."','".$Implementer."','".$ExectionTime."',1)";
else 
   $sqlCall="Call Data_Anlyzer('".$_GET['StartTime']."','".$_GET['EndTime']."','".$SiteIDs."','".$TypeofActivity."','".$CRQ."','".$_SESSION["Username"]."','".$Implementer."','".$ExectionTime."',0)";

   
   

//$sqlCall="Call Data_Anlyzer ('3','9','1|5509|640','MW_Link','1234')";

//echo $sqlCall ;
//exit();
//rty1hhhhhhhh
$SPresultCall = mysqli_query($conSP, $sqlCall);
$rowCall = mysqli_fetch_assoc($SPresultCall);
$tablename=  $rowCall['Table_Rand'];



 $sql = "select Affected.Sub_Region,Affected_Count,All_Count,round(Affected_Count*100/All_Count,2) `Area Impact %`
from
(select Sub_Region,count(*) Affected_Count from ".$tablename."
group by Sub_Region) Affected,
(select Sub_Region Sub_Region_Updated,count(*) All_Count from `One Cell DB`
group by Sub_Region) All_
where Affected.Sub_Region=All_.Sub_Region_Updated order by  Affected_Count desc";


//echo "</br> </br></br></br></br></br>";
  $sqlTable2 = "select Affected.Sub_Region,
ifnull(Affected_2G.Count,0) Impacted_2G_Sites,
ifnull(All_2G.All_Count,0) Total_2G_Sites,
ifnull(Affected_3G.Count,0) Impacted_3G_Sites,
ifnull(All_3G.All_Count,0) Total_3G_Sites,

ifnull(round(ifnull(Affected_2G.Count,0)*100/ifnull(All_2G.All_Count,0),2),0) `Area 2G Impact %`,
ifnull(round(ifnull(Affected_3G.Count,0)*100/ifnull(All_3G.All_Count,0),2),0) `Area 3G Impact %`

from
(select Sub_Region,count(*) Count
from ".$tablename."
group by Sub_Region) Affected

left join
(select Sub_Region,count(*) Count
from ".$tablename."
WHERE left(SiteID,1)<>'G' and left(SiteID,1)<>'M'
group by Sub_Region) Affected_2G
on Affected.Sub_Region=Affected_2G.Sub_Region

left join
(select Sub_Region,count(*) Count
from ".$tablename."
WHERE left(SiteID,1)='G' or left(SiteID,1)='M'
group by Sub_Region) Affected_3G
on Affected.Sub_Region=Affected_3G.Sub_Region

left join
(select Sub_Region Sub_Region_Updated,count(*) All_Count
from `One Cell DB`
WHERE left(SiteID,1)<>'G' and left(SiteID,1)<>'M'
group by Sub_Region) All_2G
on Affected.Sub_Region=All_2G.Sub_Region_Updated

left join
(select Sub_Region Sub_Region_Updated,count(*) All_Count
from `One Cell DB`
WHERE left(SiteID,1)='G' OR left(SiteID,1)='M'
group by Sub_Region) All_3G
on Affected.Sub_Region=All_3G.Sub_Region_Updated
";



//echo "</br> </br></br></br></br></br>";



 $sql2="SELECT NE , count(*) as totalImpacted FROM `".$tablename."` group by NE order by  totalImpacted desc";

//echo "</br> </br></br></br></br></br>";

 $sql3="SELECT round(sum(`Total_SPEECH_TRAFFIC`),3) as `Total_SPEECH_TRAFFIC` ,  round(sum(`DATA_MB`),3) as `DATA_MB`  FROM `".$tablename."`";	
//echo "</br> </br></br></br></br></br>";



  $sqlUnion = "select 'Total Impacted 2G Sites',count(*)  as 'NoOfSites'
from `".$tablename."`
WHERE left(SiteID,1)<>'G' and left(SiteID,1)<>'M'
union all
select 'Total Impacted 3G Sites',count(*) Count
from `".$tablename."`
WHERE left(SiteID,1)='G' or left(SiteID,1)='M'
Union all
select 'Total Impacted Sites',count(*) Count
      from `".$tablename."`
";


  //$sqlRisk="select * from `LLD ALL - Impact` where CRQ ='"."xx"."'";//exit();
  
																				
   $showRiskProtectedTables=($TypeofActivity=="MTX_BEP_Service_Node" or $TypeofActivity=="MTX_PTN_Service_Node")?  true:false; 
	 // exit();
	

	  if( $showRiskProtectedTables==true){
  $NodeType=($TypeofActivity=="MTX_BEP_Service_Node")? "BEP" : "PTN";
      $sqlprotected="SELECT  distinct Temp.*,LLD.*
FROM `LLD ALL - Impact` LLD,`One Cell DB`,`".$tablename."` Temp
where LLD.`RAN Node`=`One Cell DB`.NE
      and `One Cell DB`.SiteID=Temp.SiteID
	  and  LLD.CRQ ='".$CRQ."' and LLD.".$NodeType."_State='Protected'  "
	 ;
	  //echo "</br>";
      $sqlrisk="SELECT  distinct Temp.*,LLD.*
FROM `LLD ALL - Impact` LLD,`One Cell DB`,`".$tablename."` Temp
where LLD.`RAN Node`=`One Cell DB`.NE
      and `One Cell DB`.SiteID=Temp.SiteID
	  and  LLD.CRQ ='".$CRQ."' and LLD.".$NodeType."_State='Single Point Of Failure' "
	  ;
	//exit(); 
	  }
  
  
$sqlTemp="select * from `".$tablename."`";

$result = $con->query($sql);
$i=0;
if ($result->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()) {
$i++;
		//echo $row["Sub_Region"].$row["Affected_Count"].$row["All_Count"].$row["Area Impact %"];
		//echo "name: " . $row["name"]. " - Name: " . $row["activity"]."<br>";
		$Status=2;
		if($row["Area Impact %"]<50)
		$Status=999;
		if((50<$row["Area Impact %"]&&$row["Area Impact %"]<75))
		$Status=2;
		if($row["Area Impact %"]>85 )
		$Status=3;
		
		/*$question = array('ImpactedSites' => $row["Affected_Count"], 'TotalSitesperarea' =>$row["All_Count"],'AreaImpact' =>$row["Area Impact %"],'Status' => $Status); //init
		
		
		$TableArrayResult[$row["Sub_Region"]] = $question;
		*/
		
		
if(is_null($AreasList))
			$AreasList="'".preg_replace('/\s+/', '</br>',$row["Sub_Region"])."'";
		else
		if(($i%2)==0){
			$AreasList=$AreasList.",'</br></br>".preg_replace('/\s+/', '</br>',$row["Sub_Region"])."'";
		}else{
		$AreasList=$AreasList.",'".preg_replace('/\s+/', '</br>',$row["Sub_Region"])."'";
		}
		
		
		
		
		
		
		if(is_null($impactedAreasPercentage))
			$impactedAreasPercentage=$row["Affected_Count"];
		else
			$impactedAreasPercentage=$impactedAreasPercentage.",".$row["Affected_Count"];
		
		
		
	
		
		
		
		
	}
 } else {
	//echo "0 results";
}
$Chart1Width = $i+3 ; 
//'Activity Impacted Sites','No. Sites'
$resultUnion = $con->query($sqlUnion);

if ($resultUnion->num_rows > 0) {

	// output data of each row
	while($row = $resultUnion->fetch_assoc()) {
	
		$Status=2;
		/*if($row["Activity Impacted Sites"]<50)
		$Status=999;
		if((50<$row["Activity Impacted Sites"]&&$row["Activity Impacted Sites"]<75))
		$Status=2;
		if($row["Activity Impacted Sites"]>85 )
		$Status=3;*/
		$question = array('No. Sites' => $row["NoOfSites"],'Status' => $Status); //init
		$TableArrayResult[$row["Total Impacted 2G Sites"]] = $question;
	}
 } else {
	//echo "0 results";
}





$result2 = $con->query($sql2);

if ($result2->num_rows > 0) {
$i=0;
	// output data of each row
	while($row = $result2->fetch_assoc()) {
	$i++;

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


$Chart2Width = $i+3 ;

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
		$Status=1;
		if((50<$row["Area 2G Impact %"]&&$row["Area 2G Impact %"]<75) or (50<$row["Area 3G Impact %"]&&$row["Area 3G Impact %"]<75))
		$Status=2;
		if($row["Area 2G Impact %"]>85 or $row["Area 3G Impact %"]>85)
		$Status=3;
		
		$question = array(
		'Sub_Region' => $row["Sub_Region"],
		'Impacted_2G_Sites' => $row["Impacted_2G_Sites"], 'Total_2G_Sites' =>$row["Total_2G_Sites"],
		'Impacted_3G_Sites' =>$row["Impacted_3G_Sites"],
		'Total_3G_Sites' =>$row["Total_3G_Sites"],
		'Area 2G Impact %' =>$row["Area 2G Impact %"],
		'Area 3G Impact %' =>$row["Area 3G Impact %"],
		'Status' => $Status ); //init
		
		
		$Table2ArrayResult[] = $question;
		
		
		/*
		if(is_null($AreasListTable2))
			$AreasListTable2="'".$row["Sub_Region"]."'";
		else
			$AreasListTable2=$AreasListTable2.",'".$row["Sub_Region"]."'";
		
		
		
		
		
		
		if(is_null($impactedAreasPercentageTable2))
			$impactedAreasPercentageTable2=$row["Area Impact %"];
		else
			$impactedAreasPercentageTable2=$impactedAreasPercentageTable2.",".$row["Area Impact %"];
		
		
		
	
		*/
		
		
		
	}
 } else {
	//echo "0 results";
}

//end table here 




//start updating activity log  
$SiteListPiped="";

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








/*
//$sqlCallDownsiteCheck="Call DownSitesCheckBefore('".$SiteListPiped."','".$CRQ."')";

$resultDownsiteCheck = $con->query($sqlCallDownsiteCheck);

if ($resultDownsiteCheck->num_rows > 0) {
	// output data of each row
	while($row = $resultDownsiteCheck->fetch_assoc()) {
	
	 $data = explode("|", $row["result"]);
	
	//echo $data = preg_split('|', $row["result"]);
	$Status=3;
	foreach($data as $item)
	{
	if($item !== ''){
	$question = array('SiteStatus' => 'down','Status' => $Status); //init
		$TableArrayResult[$item] = $question; 
		}
	}
	
	
	 
	}
	
 } else {
	//echo "0 results";
}

*/














//end updating activity log



// get data temp 
$con->next_result(); 
$resultTempTeble = $con->query($sqlTemp);

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
		'Total_SPEECH_TRAFFIC' => $row["Total_SPEECH_TRAFFIC"],
		'DATA_MB' => $row["DATA_MB"],
		'CRQ' => $row["CRQ"],
		'Status' => $Status
		
		
		); //init
		$TableTempArrayResult[] = $question;
	}
 } else {
	//echo "0 results";
}

// risk tables BEP PTN 


 if( $showRiskProtectedTables==true){
$con->next_result();

$resultTempTeble = $con->query($sqlprotected);

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
		'Total_SPEECH_TRAFFIC' => $row["Total_SPEECH_TRAFFIC"],
		'DATA_MB' => $row["DATA_MB"],
		'CRQ' => $row["CRQ"],
		'Status' => $Status
		
		
		); //init
		$TableRiskSitesArrayResult[] = $question;
	}
 } else {
	//echo "0 results";
}



$con->next_result();

$resultTempTeble = $con->query($sqlrisk);

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
		'Total_SPEECH_TRAFFIC' => $row["Total_SPEECH_TRAFFIC"],
		'DATA_MB' => $row["DATA_MB"],
		'CRQ' => $row["CRQ"],
		'Status' => $Status
		
		
		); //init
		$TableProtectedSitesArrayResult[] = $question;
	}
 } else {
	//echo "0 results";
}


 }//show tables 



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


$pageTitle ="Activity Card" ;
include 'header.php';
include 'RadioActivityOutputDesign.php';
//include 'activity.php';
include 'footer.html';
