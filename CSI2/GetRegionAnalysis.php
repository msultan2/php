<?php


require('authorizationRules.php');
	if($stopexection==true)
return;
	
if(isset($_GET['ChangeStatisticsDate'])&&$_GET['ChangeStatisticsDate'] !="")
 $ChangeStatisticsDate=$_GET['ChangeStatisticsDate'];
else
 $ChangeStatisticsDate=date("Y-m-d", time() + 86400);

 if(isset($_GET['Region'])&&$_GET['Region'] !="")
 $Region=$_GET['Region'];
 
$CRQsWithSitesNum="";
$con=mysqli_connect("CNPVAS04","Reader","Reader","SOC");

// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
  $sql = "select AL.CRQ ,count(distinct AL.SiteID) `Count` ,(select count(distinct SiteID) from `Activity Log`where Sub_Region ='".$Region."' 
and date_format(`Activity Date`,'%Y-%m-%d')='".$ChangeStatisticsDate."') Total from `Activity Log` AL   where AL.Sub_Region ='".$Region."' 
and date_format(`Activity Date`,'%Y-%m-%d')='".$ChangeStatisticsDate."'
group by  AL.CRQ";
$total="";
$result = $con->query($sql);

if ($result->num_rows > 0){

while($row = $result->fetch_assoc()) {
		$CRQsWithSitesNum=$CRQsWithSitesNum."".$row['CRQ']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row['Count']."</br>" ;
		$total=$row['Total'];
	}
$CRQsWithSitesNum=$CRQsWithSitesNum." Total &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$total."</br>" ;
echo $CRQsWithSitesNum ;
}

?>