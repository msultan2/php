<?php
$con=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
$Sites="";
// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if($_GET['Operation']=="Sites"){
if($_GET['CRQ']=="") echo "unable";
   $sql1 = "select SiteID  from `Activity Log` where CRQ ='".$_GET['CRQ']."'";
  
//'Activity Impacted Sites','No. Sites'

//$result = $con->query($sqlTable1);
$result1 = $con->query($sql1);

if ($result1->num_rows > 0) {
	// output data of each row
	while($row = $result1->fetch_assoc()) {
		if($Sites=="")
		$Sites=$Sites.$row["SiteID"];
		else
		$Sites=$Sites."|".$row["SiteID"];
		


	}echo $Sites;
} else {
	//echo "0 results";
}							


}//end sites operation 

if($_GET['Operation']=="CRQDetails"){
if($_GET['CRQ']=="") echo "unable";
    $sql2 = "select *  from `Activity Log` where CRQ ='".$_GET['CRQ']."' limit 1";
  
//'Activity Impacted Sites','No. Sites'

//$result = $con->query($sqlTable1);
$result2 = $con->query($sql2);

if ($result2->num_rows > 0) {
	// output data of each row
	while($row = $result2->fetch_assoc()) {
		
		$Details=$row["Hour_From"]."|".$row["Hour_To"]."|".$row["Activity Date"]
		."|".$row["Activity Implemented By"]."|".$row["Activity Owner"];

		


	}echo $Details;
} else {
	echo "0 results";
}							


}//end sites operation 


if($_GET['Operation']=="Schedule"){
if($_GET['CRQ']=="") {echo "unable"; return ;};
$NewSchedule="";
if(isset($_GET['NewStartTime'])&&$_GET['NewStartTime']!="")
$NewSchedule =$NewSchedule." `Hour_From`='".$_GET['NewStartTime']."' ";

if($NewSchedule=="")$Splitter="";else $Splitter=",";

if(isset($_GET['NewEndTime'])&&$_GET['NewEndTime']!="")
$NewSchedule =$NewSchedule.$Splitter." `Hour_To`='".$_GET['NewEndTime']."' ";

if($NewSchedule=="")$Splitter="";else $Splitter=",";

if(isset($_GET['NewImplementer'])&&$_GET['NewImplementer']!="")
$NewSchedule =$NewSchedule.$Splitter." `Activity Implemented By`='".$_GET['NewImplementer']."' ";
if($NewSchedule=="")$Splitter="";else $Splitter=",";
if(isset($_GET['NewExectionTime'])&&$_GET['NewExectionTime']!="")
$NewSchedule =$NewSchedule.$Splitter." `Activity Date`='".$_GET['NewExectionTime']."' ";

if($NewSchedule!=""){
echo $sqlNewSchedule ="UPDATE `Activity Log` SET ".$NewSchedule ."where CRQ ='".$_GET['CRQ']."'";
if ($con->query($sqlNewSchedule) === TRUE)
return "updated";
else 
echo "failed";

}							


}//end Schedule  


?>