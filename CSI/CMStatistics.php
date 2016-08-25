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


$TableArrayResult = array();
$Table2ArrayResult = array();
$Table3ArrayResult = array();
$TableConflictAnalyzeArrayResult = array();
$AreasList=null;//DB

$AreasListTable2=null;//DB 

if(isset($_GET['ChangeStatisticsDate'])&&$_GET['ChangeStatisticsDate'] !="")
 $ChangeStatisticsDate=$_GET['ChangeStatisticsDate'];
else
 $ChangeStatisticsDate=date("Y-m-d", time() + 86400);
 
 
if(isset($_GET['ConflictStatisticsDateFrom'])&&$_GET['ConflictStatisticsDateFrom'] !="")
 $ConflictStatisticsDateFrom=$_GET['ConflictStatisticsDateFrom'];
else
 $ConflictStatisticsDateFrom=date("Y-m-d", time() + 86400);
 
 
if(isset($_GET['ConflictStatisticsDateTo'])&&$_GET['ConflictStatisticsDateTo'] !="")
 $ConflictStatisticsDateTo=$_GET['ConflictStatisticsDateTo'];
else
 $ConflictStatisticsDateTo=date("Y-m-d", time() + 86400);
 

$con=mysqli_connect("CNPVAS04","Reader","Reader","SOC");

// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

          $sqlTable1 = "
SELECT 'Total Impacted 2G Sites' Activity, Count(`Activity Log`.SiteID) Counts
FROM `Activity Log`,`One Cell DB - With 2G/3G`
where `One Cell DB - With 2G/3G`.SiteID=`Activity Log`.SiteID
and Technology='2G'
and date_format(`Activity Date`,'%Y-%m-%d')='".$ChangeStatisticsDate."'
union all
SELECT 'Total Impacted 3G Sites' ,Count(`Activity Log`.SiteID) Counts
FROM `Activity Log`,`One Cell DB - With 2G/3G`
where `One Cell DB - With 2G/3G`.SiteID=`Activity Log`.SiteID
and Technology='3G'
and date_format(`Activity Date`,'%Y-%m-%d')='".$ChangeStatisticsDate."'
union all
SELECT 'Total Impacted Sites' ,Count(`Activity Log`.SiteID) Counts
FROM `Activity Log`,`One Cell DB - With 2G/3G`
where `One Cell DB - With 2G/3G`.SiteID=`Activity Log`.SiteID
and date_format(`Activity Date`,'%Y-%m-%d')='".$ChangeStatisticsDate."'
Union all
SELECT 'Availability Impact' ,concat(round(Count(`Activity Log`.SiteID)*100/(16000*24),2),'%') Counts
FROM `Activity Log`,`One Cell DB - With 2G/3G`
where `One Cell DB - With 2G/3G`.SiteID=`Activity Log`.SiteID
            and date_format(`Activity Date`,'%Y-%m-%d')='".$ChangeStatisticsDate."'"


;





         $sqlTable2 = "  Select CRQ,Description,`Activity Owner`,Postponed,round(Total_SPEECH_TRAFFIC/1000,2) Total_SPEECH_TRAFFIC_KErlg,
round(sum(NW_SPEECH_TRAFFIC)/1000,2) NW_SPEECH_TRAFFIC_KErlg,
concat(round(Total_SPEECH_TRAFFIC/sum(NW_SPEECH_TRAFFIC)*100,3),'%') `Activity_Impact_Speech(%)`,
round(DATA_MB/1024,2) DATA_GB,
round(sum(NW_DATA_MB)/1024,2) NW_DATA_GB,
concat(round(DATA_MB/sum(NW_DATA_MB)*100,3),'%') `Activity_Impact_Data(%)`,Site_Count
from
(SELECT `Activity Log`.CRQ,`Activity Owner`,Postponed,Hour_From,Hour_To,sum(`Activity Log`.Total_SPEECH_TRAFFIC) Total_SPEECH_TRAFFIC,sum(`Activity Log`.DATA_MB) DATA_MB,count(SiteID) Site_Count, CM_Details.Description
FROM `Activity Log` LEFT OUTER JOIN CM_Details
on CM_Details.CRQ=`Activity Log`.CRQ
WHERE  date_format(`Activity Date`,'%Y-%m-%d')='".$ChangeStatisticsDate."'
group by `Activity Log`.CRQ,Hour_From,Hour_To) Date_Data,
(select Hour_ID,sum(Traffic.SPEECH_TRAFFIC) NW_SPEECH_TRAFFIC,sum(Traffic.DATA_MB) NW_DATA_MB
From Traffic
group by Hour_ID) NW_Traffic
where Hour_ID between Hour_From and Hour_To
group by CRQ

";


$sqlTable3="select Affected.Sub_Region,
ifnull(Affected_2G.Count,0) Impacted_2G_Sites,
ifnull(All_2G.All_Count,0) Total_2G_Sites,
ifnull(Affected_3G.Count,0) Impacted_3G_Sites,
ifnull(All_3G.All_Count,0) Total_3G_Sites,

ifnull(round(ifnull(Affected_2G.Count,0)*100/ifnull(All_2G.All_Count,0),2),0) `Area 2G Impact %`,
ifnull(round(ifnull(Affected_3G.Count,0)*100/ifnull(All_3G.All_Count,0),2),0) `Area 3G Impact %`

from
(select Sub_Region,count(distinct SiteID) Count
from `Activity Log`
where date_format(`Activity Date`,'%Y-%m-%d')='".$ChangeStatisticsDate."'
group by Sub_Region) Affected

left join
(select Sub_Region,count(distinct SiteID) Count
from `Activity Log`
where date_format(`Activity Date`,'%Y-%m-%d')='".$ChangeStatisticsDate."'
AND (left(SiteID,1)<>'G' and left(SiteID,1)<>'M')
group by Sub_Region) Affected_2G
on Affected.Sub_Region=Affected_2G.Sub_Region

left join
(select Sub_Region,count(distinct SiteID) Count
from `Activity Log`
where date_format(`Activity Date`,'%Y-%m-%d')='".$ChangeStatisticsDate."'
AND (left(SiteID,1)='G' or left(SiteID,1)='M')
group by Sub_Region) Affected_3G
on Affected.Sub_Region=Affected_3G.Sub_Region

left join
(select Sub_Region Sub_Region_Updated,count(distinct SiteID) All_Count
from `One Cell DB`
WHERE (left(SiteID,1)<>'G' and left(SiteID,1)<>'M')
group by Sub_Region) All_2G
on Affected.Sub_Region=All_2G.Sub_Region_Updated

left join
(select Sub_Region Sub_Region_Updated,count(distinct SiteID) All_Count
from `One Cell DB`
WHERE (left(SiteID,1)='G' OR left(SiteID,1)='M')
group by Sub_Region) All_3G
on Affected.Sub_Region=All_3G.Sub_Region_Updated
";
    $sqlTable4="select `Implementation Date`, SiteConflicts,HubConflicts ,NodeConflicts ,SubRegions ,BSS_Sites ,TX_Sites
from `Conflict Statistics`
WHERE date_format(`Implementation Date`,'%Y-%m-%d')>='".$ConflictStatisticsDateFrom."' "."&&date_format(`Implementation Date`,'%Y-%m-%d')<='".$ConflictStatisticsDateTo."'". "union select \"Total Conflicts\", sum(SiteConflicts),sum(HubConflicts) ,sum(NodeConflicts) ,sum(SubRegions) ,sum(BSS_Sites) ,sum(TX_Sites) from `Conflict Statistics` WHERE date_format(`Implementation Date`,'%Y-%m-%d')>='".$ConflictStatisticsDateFrom."' "."&&date_format(`Implementation Date`,'%Y-%m-%d')<='".$ConflictStatisticsDateTo."'";

//'Activity Impacted Sites','No. Sites'
$resultUnion = $con->query($sqlTable1);

if ($resultUnion->num_rows > 0) {

	// output data of each row
	while($row = $resultUnion->fetch_assoc()) {
	
		$Status=999;
		$question = array('Counts' => $row["Counts"],'Status' => $Status); //init
		$TableArrayResult[$row["Activity"]] = $question;
	}
 } else {
	//echo "0 results";
}



 


$resultTable2 = $con->query($sqlTable2);

if ($resultTable2->num_rows > 0) {
	// output data of each row
	while($row = $resultTable2->fetch_assoc()) {

		//echo $row["Sub_Region"].$row["Affected_Count"].$row["All_Count"].$row["Area Impact %"];
		//echo "name: " . $row["name"]. " - Name: " . $row["activity"]."<br>";
		$Status=2;
		if(floatval($row["Activity_Impact_Data(%)"])<50)
		$Status=1;
		if(floatval($row["Activity_Impact_Data(%)"])>50)
		$Status=2;
		if(floatval($row["Activity_Impact_Data(%)"])>85)
		$Status=3;
		
		/*if($row["Area 2G Impact %"]<50 or $row["Area 3G Impact %"]<50)
		$Status=1;
		if((50<$row["Area 2G Impact %"]&&$row["Area 2G Impact %"]<75) or (50<$row["Area 3G Impact %"]&&$row["Area 3G Impact %"]<75))
		$Status=2;
		if($row["Area 2G Impact %"]>85 or $row["Area 3G Impact %"]>85)
		$Status=3;
		*/
		$question = array(
		'CRQ' => $row["CRQ"],
		'Description' => $row["Description"]
		,'NW_SPEECH_TRAFFIC_KErlg' =>$row["NW_SPEECH_TRAFFIC_KErlg"],
		'Activity_Impact_Speech(%)' =>$row["Activity_Impact_Speech(%)"],
		'DATA_GB' =>$row["DATA_GB"],
		'NW_DATA_GB' =>$row["NW_DATA_GB"],
		'Activity_Impact_Data(%)' =>$row["Activity_Impact_Data(%)"],
		'Site_count' =>$row["Site_Count"],
		'Activity Owner' => $row["Activity Owner"],
		'Postponded' => ($row["Postponed"]==1)? "Conf-Post":"Planned",
		'Status' => $Status ,'Checked' => true ); //init
		
		
		$Table2ArrayResult[] = $question;
		

	}
 } else {
	//echo "0 results";
}




$Tonight_Activities_Impact_AnlaysisResult = $con->query($sqlTable3);

if ($Tonight_Activities_Impact_AnlaysisResult->num_rows > 0) {

	// output data of each row
	while($row = $Tonight_Activities_Impact_AnlaysisResult->fetch_assoc()) {
	
		$Status=2;
		if($row["Area 2G Impact %"]<50 or $row["Area 3G Impact %"]<50)
		$Status=1;
		if((50<$row["Area 2G Impact %"]&&$row["Area 2G Impact %"]<75) or (50<$row["Area 3G Impact %"]&&$row["Area 3G Impact %"]<75))
		$Status=2;
		if($row["Area 2G Impact %"]>85 or $row["Area 3G Impact %"]>85)
		$Status=3;


	$question = array(
		//'Sub_Region' => "<a href='GetRegionAnalysis.php?ChangeStatisticsDate=".$ChangeStatisticsDate."&Region=".$row["Sub_Region"]."'>".$row["Sub_Region"]."</a>",
		'Sub_Region' => $row["Sub_Region"],

		'Impacted_2G_Sites' => $row["Impacted_2G_Sites"]
		,'Total_2G_Sites' =>$row["Total_2G_Sites"],
		'Impacted_3G_Sites' =>$row["Impacted_3G_Sites"],
		'Total_3G_Sites' =>$row["Total_3G_Sites"],
		'Area 2G Impact %' =>$row["Area 2G Impact %"],
		'Area 3G Impact %' =>$row["Area 3G Impact %"],
		'Status' => $Status ); //init



		$Table3ArrayResult[] = $question;
	}
 } else {
	//echo "0 results";
}

$resultConflictAnalyze = $con->query($sqlTable4);

if ($resultConflictAnalyze->num_rows > 0) {

	// output data of each row|$row["SiteConflicts"]>0 |$row["HubConflicts"]>0|$row["NodeConflicts"]>0 |$row["BSS_Sites"]>0|$row["TX_Sites"]>0
	$Status=999;
	while($row = $resultConflictAnalyze->fetch_assoc()) {
	// $row["SiteConflicts"] ;
	//if($row["SiteConflicts"]>0|$row["SiteConflicts"]>0 |$row["HubConflicts"]>0|$row["NodeConflicts"]>0 |$row["BSS_Sites"]>0|$row["TX_Sites"]>0)
	//	 $Status=3;
	//	else 
	//	$Status=999;
		if($row["Implementation Date"]=="Total Conflicts")
		$Status=2;
		
		$question = array('Implementation Date' => $row["Implementation Date"],
		'TX_Sites' => $row["TX_Sites"],
		'BSS_Sites' => $row["BSS_Sites"],
		'SiteConflicts' => $row["SiteConflicts"],
		'HubConflicts ' => $row["HubConflicts"],
		'NodeConflicts ' => $row["NodeConflicts"],
		'SubRegions ' => $row["SubRegions"],
		
		
		'Status' => $Status); //init
		$TableConflictAnalyzeArrayResult[] = $question;
	}
 } else {
	//echo "0 results";
}

mysqli_close($con);

$pageTitle ="Change Statistic" ;
include 'header.php';
include 'CMStatisticsDesign.php';
//include 'activity.php';
include 'footer.html';
