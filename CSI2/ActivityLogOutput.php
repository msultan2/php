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
$TableArrayResult = array();
$Table2ArrayResult = array();
$TotalImpactedSites=null;//DB
$impactedAreasPercentage=null;//DB
$AreasList=null;//DB
$TableTempArrayResult = array();//not needed 
$TotalImpactedSitesTable2=null;//DB
$impactedAreasPercentageTable2=null;//DB
$AreasListTable2=null;//DB



$con=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
$conTable2=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
$conUnion=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
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

$sql = "select Affected.Sub_Region,Affected_Count,All_Count,round(Affected_Count*100/All_Count,2) `Area Impact %`
from
(select Sub_Region,count(*) Affected_Count from ".$tablename."
group by Sub_Region) Affected,
(select ifnull(`Combined SubRegion`,Sub_Region) Sub_Region_Updated,count(*) All_Count from `One Cell DB`
group by ifnull(`Combined SubRegion`,Sub_Region)) All_
where Affected.Sub_Region=All_.Sub_Region_Updated order by  Affected_Count desc limit 30";



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
(select ifnull(`Combined SubRegion`,Sub_Region) Sub_Region_Updated,count(*) All_Count
from `One Cell DB`
WHERE left(SiteID,1)<>'G' and left(SiteID,1)<>'M'
group by ifnull(`Combined SubRegion`,Sub_Region)) All_2G
on Affected.Sub_Region=All_2G.Sub_Region_Updated

left join
(select ifnull(`Combined SubRegion`,Sub_Region) Sub_Region_Updated,count(*) All_Count
from `One Cell DB`
WHERE left(SiteID,1)='G' OR left(SiteID,1)='M'
group by ifnull(`Combined SubRegion`,Sub_Region)) All_3G
on Affected.Sub_Region=All_3G.Sub_Region_Updated limit 30
";







$sql2="SELECT NE , count(*) as totalImpacted FROM ".$tablename." group by NE order by  totalImpacted desc limit 30";
$sql3="SELECT round(sum(`Total_SPEECH_TRAFFIC`),3) as `Total_SPEECH_TRAFFIC` ,  round(sum(`DATA_MB`),3) as `DATA_MB`  FROM ".$tablename;	




$sqlUnion = "select 'Total Impacted 2G Sites',count(*) as 'NoOfSites'
from ".$tablename."
WHERE left(SiteID,1)<>'G' and left(SiteID,1)<>'M'
union all
select 'Total Impacted 3G Sites',count(*) Count
from ".$tablename."
WHERE left(SiteID,1)='G' or left(SiteID,1)='M'
Union all
select 'Total Impacted Sites',count(*) Count
      from ".$tablename."
";

$i=0;
$result = $con->query($sql);

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
		
		
		/*
		
		$question = array('ImpactedSites' => $row["Affected_Count"], 'TotalSitesperarea' =>$row["All_Count"],'AreaImpact' =>$row["Area Impact %"],'Status' => $Status); //init
		
		
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

$Chart1Width = $i ; 
//'Activity Impacted Sites','No. Sites'

$resultUnion = $conUnion->query($sqlUnion);

if ($resultUnion->num_rows > 0) {
	// output data of each row
	while($row = $resultUnion->fetch_assoc()) {
		$Status=2;
		if($row["Total Impacted 2G Sites"]<50)
		$Status=999;
		if((50<$row["Total Impacted 2G Sites"]&&$row["Total Impacted 2G Sites"]<75))
		$Status=2;
		if($row["Total Impacted 2G Sites"]>85 )
		$Status=3;
		$question = array('No. Sites' => $row["NoOfSites"],'Status' => $Status); //init
		$TableArrayResult[$row["Total Impacted 2G Sites"]] = $question;
	}
 } else {
	//echo "0 results";
}





$result2 = $con->query($sql2);
$i=0;
if ($result2->num_rows > 0) {
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

$Chart2Width = $i ; 

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
		
		$question = array(
		'Sub_Region' =>$row["Sub_Region"],
		'Impacted_2G_Sites' => $row["Impacted_2G_Sites"], 'Total_2G_Sites' =>$row["Total_2G_Sites"],
		'Impacted_3G_Sites' =>$row["Impacted_3G_Sites"],
		'Total_3G_Sites' =>$row["Total_3G_Sites"],
		'Area 2G Impact %' =>$row["Area 2G Impact %"],
		'Area 3G Impact %' =>$row["Area 3G Impact %"],
		'Status' => $Status ); //init
		
		
		$Table2ArrayResult[] = $question;
		
	
		
		
		
	}
 } else {
	//echo "0 results";
}

//end table here 



mysqli_close($con);
mysqli_close($conTable2);


$pageTitle ="Activities Log" ;
include 'header.php';
include 'RadioActivityOutputDesign.php';
//include 'activity.php';
include 'footer.html';
