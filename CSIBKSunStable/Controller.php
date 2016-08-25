<?php		



include 'LDAPAuth.php';
include 'ActivityAuthorization.php'; 
$username =null;
$password =null;
$pageTitle ="Log Activity" ;

session_start();

	
	/*include 'header.php';
	//include 'general.php';
	include 'activity.php';
	include 'footer.html';
	//echo "uuuuu"; 
	*/
//الجاى ال issset يبقى حطها هنا  عشان نقراها من الفايلز 
if(isset($_SESSION["authorized"]) ==true
&&isset($_SESSION["radioActivityAllowed"])==true
&&isset($_SESSION["transmissionActivityAllowed"])==true
&&isset($_SESSION["activityLogAllowed"])==true
&&isset($_SESSION["mismatchReportActivityAllowed"])==true
&&isset($_SESSION["activityOperationAllowed"])==true
&&isset($_SESSION["cMStatisticsAllowed"])==true
&&isset($_SESSION["sitesStatusCheckAllowed"])==true
&&isset($_SESSION["activityOperationModifyAllowed"])==true
&&isset($_SESSION["sitesInfoAllowed"])==true
)
{
require('authorizationRules.php');
if($stopexection==true)
return;
	 $radioActivityAllowed=$_SESSION["radioActivityAllowed"];
	 $transmissionActivityAllowed=$_SESSION["transmissionActivityAllowed"] ;
	
	
	$activityLogAllowed=$_SESSION["activityLogAllowed"]  ;
    $mismatchReportActivityAllowed=$_SESSION["mismatchReportActivityAllowed"] ;
		 
		 
		 
	$activityOperationAllowed=$_SESSION["activityOperationAllowed"]  ;
	$cMStatisticsAllowed=$_SESSION["cMStatisticsAllowed"];
		 
	$sitesStatusCheckAllowed=$_SESSION["sitesStatusCheckAllowed"];

	$activityOperationModifyAllowed=$_SESSION["activityOperationModifyAllowed"];	 
	
	$sitesInfoAllowed=$_SESSION["sitesInfoAllowed"];
    $downSitesPerActivityAllowed=$_SESSION["downSitesPerActivityAllowed"];	
	
	
	include 'header.php';
	//include 'general.php'; 
	include 'activity.php';
	include 'footer.html';
	return ;
	//echo "uuuuu"; 
	
}else{
	
	if(isset($_POST['username'])&&isset($_POST['password'])&&$_POST['password']!=null&&$_POST['username']!=null){
		$username =$_POST['username'];
		$password =$_POST['password'];
		
		// control authintication and authorization and for ward to right activities
	$LDAPAuth = new LDAPAuth($username,$password);
	//remove ||true to activate authintication
	if($LDAPAuth->Authinticated){
		
	
		$ActivityAuthorization= new ActivityAuthorization($username);
		$radioActivityAllowed = $ActivityAuthorization->radioActivityAllowed;
		$transmissionActivityAllowed = $ActivityAuthorization->transmissionActivityAllowed;
		  $_SESSION["radioActivityAllowed"] =$radioActivityAllowed ;
		 $_SESSION["transmissionActivityAllowed"] =$transmissionActivityAllowed;
		 
		 
		 $activityLogAllowed = $ActivityAuthorization->activityLogAllowed;
		$mismatchReportActivityAllowed = $ActivityAuthorization->mismatchReportActivityAllowed;
		  $_SESSION["activityLogAllowed"] =$activityLogAllowed ;
		 $_SESSION["mismatchReportActivityAllowed"] =$mismatchReportActivityAllowed;
		 
		 
		 $activityOperationAllowed = $ActivityAuthorization->activityOperationAllowed;
		$_SESSION["activityOperationAllowed"] =$activityOperationAllowed ;
		$cMStatisticsAllowed = $ActivityAuthorization->cMStatisticsAllowed;
		 $_SESSION["cMStatisticsAllowed"] =$cMStatisticsAllowed;
		 
		$sitesStatusCheckAllowed = $ActivityAuthorization->sitesStatusCheckAllowed;
        $_SESSION["sitesStatusCheckAllowed"] =$sitesStatusCheckAllowed ;
		 
		 
		 $activityOperationModifyAllowed = $ActivityAuthorization->activityOperationModifyAllowed;
        $_SESSION["activityOperationModifyAllowed"] =$activityOperationModifyAllowed ;
		 
	     $sitesInfoAllowed = $ActivityAuthorization->sitesInfoAllowed;
        $_SESSION["sitesInfoAllowed"] =$sitesInfoAllowed ;
		
		   $downSitesPerActivityAllowed = $ActivityAuthorization->downSitesPerActivityAllowed;
        $_SESSION["downSitesPerActivityAllowed"] =$downSitesPerActivityAllowed ;
		 
		 
		 $_SESSION["authorized"] =true;
		
		include 'header.php';
		//include 'general.php';
		include 'activity.php';
		include 'footer.html';
	
	
	
	}else{
	
		include 'header.php';
		include 'login.html';
		include 'footer.html';
		return ;
		//redirect to loign page again
	}
	
	
		
	}else{
	include 'header.php';
		include 'login.html';
		include 'footer.html';
	}
	
}