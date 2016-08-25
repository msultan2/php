<?php
$stopexection=false;
if(session_id() == '') {
    session_start();
}
/*if(!isset($_SESSION["firstauthorization"]))
{
    $_SESSION["authorized"]=false ;
unset($_SESSION["radioActivityAllowed"]);
unset($_SESSION["transmissionActivityAllowed"]);
unset($_SESSION["radioActivityAllowed"]);
unset($_SESSION["Username"]);
unset($_SESSION["activityLogAllowed"]);
unset($_SESSION["mismatchReportActivityAllowed"]);
unset($_SESSION["activityOperationAllowed"]);
unset($_SESSION["cMStatisticsAllowed"]);

	session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();  
        include 'header.php';
		include 'login.html';
		include 'footer.html';
		$stopexection=true;
		$_SESSION["firstauthorization"]="getouted";
		return ;
}*/
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] >28800)) {
    // last request was more than 30 minutes ago
    $_SESSION["authorized"]=false ;
unset($_SESSION["radioActivityAllowed"]);
unset($_SESSION["transmissionActivityAllowed"]);
unset($_SESSION["radioActivityAllowed"]);
unset($_SESSION["Username"]);
unset($_SESSION["activityLogAllowed"]);
unset($_SESSION["mismatchReportActivityAllowed"]);
unset($_SESSION["activityOperationAllowed"]);
unset($_SESSION["cMStatisticsAllowed"]);

	session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();  
        include 'header.php';
		include 'login.html';
		include 'footer.html';
		$stopexection=true;
		return ;	// destroy session data in storage
}
if(isset($_SESSION["authorized"]) ==true
&&isset($_SESSION["radioActivityAllowed"])==true
&&isset($_SESSION["transmissionActivityAllowed"])==true
&&isset($_SESSION["activityLogAllowed"])==true
&&isset($_SESSION["mismatchReportActivityAllowed"])==true
&&isset($_SESSION["activityOperationAllowed"])==true
&&isset($_SESSION["cMStatisticsAllowed"])==true)
{
	 $radioActivityAllowed=$_SESSION["radioActivityAllowed"];
	 $transmissionActivityAllowed=$_SESSION["transmissionActivityAllowed"] ;
	
	
	$activityLogAllowed=$_SESSION["activityLogAllowed"]  ;
    $mismatchReportActivityAllowed=$_SESSION["mismatchReportActivityAllowed"] ;
		 
		 
		 
	$activityOperationAllowed=$_SESSION["activityOperationAllowed"]  ;
	$cMStatisticsAllowed=$_SESSION["cMStatisticsAllowed"];
    $downSitesPerActivityAllowed=$_SESSION["downSitesPerActivityAllowed"];
	$sitesInfoAllowed=$_SESSION["sitesInfoAllowed"];
}else{
	
		include 'header.php';
		include 'login.html';
		include 'footer.html';$stopexection=true;
		return ;
		//redirect to loign page again
	}
	
