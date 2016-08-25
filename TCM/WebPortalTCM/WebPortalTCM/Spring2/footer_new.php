
</div>
</div>
</div>

<div id="leftcolumn">
<div class="innerlefttube">
<!--left menu goes here-->
<ul class="vert-one">
<?php 

$css = "";
	switch ($_SESSION['priv']) {
    case 10:
				echo 	'<li><a href="#" class="menu">Reports</a></li>';
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Report_dashboard.php") $css="class=current"; else $css=""; 
				echo "<li><a href=CAB_Report_dashboard.php $css>CAB Report</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Yesterday_Report.php") $css="class=current"; else $css=""; 
				echo "<li><a href=CAB_Yesterday_Report.php $css>Last Night Changes</a></li>";	
				
				echo 	'<li><a href="#" class="menu">Tools</a></li>';
				if($_SERVER['PHP_SELF']=="/TCMReporter/CRQ_Search.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CRQ_Search.php $css>CRQ Search</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CRQ_Advanced_Search.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CRQ_Advanced_Search.php $css>Pattern Search</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Report_Interval.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CAB_Report_Interval.php $css>Interval Search</a></li>";			
				break;
    case 20:
				echo 	'<li><a href="#" class="menu">Daily CAB Meeting</a></li>';
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Report_dashboard.php") $css="class=current"; else $css=""; 
				echo "<li><a href=CAB_Report_dashboard.php $css>CAB Report</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Report_IT.php") $css="class=current"; else $css=""; 
				echo "<li><a href=CAB_Report_IT.php $css>CAB IT Report</a></li>";	

				echo 	'<li><a href="#" class="menu">Tools</a></li>';		
				if($_SERVER['PHP_SELF']=="/TCMReporter/CRQ_Search.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CRQ_Search.php $css>CRQ Search</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CRQ_Advanced_Search.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CRQ_Advanced_Search.php $css>Pattern Search</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Report_Interval.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CAB_Report_Interval.php $css>Interval Search</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Yesterday_Report.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CAB_Yesterday_Report.php $css>Last Night Changes</a></li>";				
				break;
	case 25:
				echo 	'<li><a href="#" class="menu">Reports</a></li>';
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Report_dashboard.php") $css="class=current"; else $css=""; 
				echo "<li><a href=CAB_Report_dashboard.php $css>CAB Report</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Yesterday_Report.php") $css="class=current"; else $css=""; 
				echo "<li><a href=CAB_Yesterday_Report.php $css>Last Night Changes</a></li>";		

				echo 	'<li><a href="#" class="menu">Tools</a></li>';		
				if($_SERVER['PHP_SELF']=="/TCMReporter/CRQ_Search.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CRQ_Search.php $css>CRQ Search</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CRQ_Advanced_Search.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CRQ_Advanced_Search.php $css>Pattern Search</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Report_Interval.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CAB_Report_Interval.php $css>Interval Search</a></li>";			
				break;
    case 30:
				echo 	'<li><a href="#" class="menu">Reports</a></li>';
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Report_dashboard.php") $css="class=current"; else $css=""; 
				echo "<li><a href=CAB_Report_dashboard.php $css>CAB Report</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Yesterday_Report.php") $css="class=current"; else $css=""; 
				echo "<li><a href=CAB_Yesterday_Report.php $css>Last Night Changes</a></li>";		

				echo 	'<li><a href="#" class="menu">Tools</a></li>';		
				if($_SERVER['PHP_SELF']=="/TCMReporter/CRQ_Search.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CRQ_Search.php $css>CRQ Search</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CRQ_Advanced_Search.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CRQ_Advanced_Search.php $css>Pattern Search</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Report_Interval.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CAB_Report_Interval.php $css>Interval Search</a></li>";			
				break;
	case 50:		//MSheta
				echo 	'<li><a href="#" class="menu">Daily CAB Meeting</a></li>';
				if($_SERVER['PHP_SELF']=="/TCMReporter/CRQ_Status.php") $css="class=current"; else $css=""; 
				echo "<li><a href=CRQ_Status.php $css>CAB Status</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Report_dashboard.php") $css="class=current"; else $css=""; 
				echo "<li><a href=CAB_Report_dashboard.php $css>CAB Report</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Report_Impacting.php") $css="class=current"; else $css=""; 
				echo "<li><a href=Report_Impacting.php $css>Impacting Report</a></li>";
				
				echo 	'<li><a href="#" class="menu">Tools</a></li>';
				if($_SERVER['PHP_SELF']=="/TCMReporter/CRQ_Search.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CRQ_Search.php $css>CRQ Search</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CRQ_Advanced_Search.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CRQ_Advanced_Search.php $css>Pattern Search</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Report_Interval.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CAB_Report_Interval.php $css>Interval Search</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Yesterday_Report.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CAB_Yesterday_Report.php $css>Last Night Changes</a></li>";
				break;
	case 51:
				echo 	'<li><a href="#" class="menu">Daily CAB Meeting</a></li>';
				if($_SERVER['PHP_SELF']=="/TCMReporter/CRQ_Status.php") $css="class=current"; else $css=""; 
				echo "<li><a href=CRQ_Status.php $css>CAB Status</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Report_dashboard.php") $css="class=current"; else $css=""; 
				echo "<li><a href=CAB_Report_dashboard.php $css>CAB Report</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Report_Impacting.php") $css="class=current"; else $css=""; 
				echo "<li><a href=Report_Impacting.php $css>Impacting Report</a></li>";
				
				echo 	'<li><a href="#" class="menu">Tools</a></li>';
				if($_SERVER['PHP_SELF']=="/TCMReporter/CRQ_Search.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CRQ_Search.php $css>CRQ Search</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CRQ_Advanced_Search.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CRQ_Advanced_Search.php $css>Pattern Search</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Report_Interval.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CAB_Report_Interval.php $css>Interval Search</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Yesterday_Report.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CAB_Yesterday_Report.php $css>Last Night Changes</a></li>";
				
				echo "<li><a href='#' class='menu'>Statistics</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_IncidentDue2Changes.php") $css="class=current"; else $css="";
				echo "<li><a href='Reporter_IncidentDue2Changes.php' $css>Incidents Due to Changes</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_Normal_Domain.php") $css="class=current"; else $css=""; 
				echo "<li><a href=Reporter_Normal_Domain.php $css>Changes Domains<span style='color:yellow'><I>  New</I></span></a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_CRQType.php") $css="class=current"; else $css=""; 
				echo "<li><a href=Reporter_CRQType.php $css>Changes Types<span style='color:yellow'><I>  New</I></span></a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_Status.php") $css="class=current"; else $css=""; 
				echo "<li><a href=Reporter_Status.php $css>Changes Status</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_HU_Tiers.php") $css="class=current"; else $css=""; 
				echo "<li><a href=Reporter_HU_Tiers.php $css>Changes Tiers</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_Requesters.php") $css="class=current"; else $css=""; 
				echo "<li><a href=Reporter_Requesters.php $css>Top Requesters</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_Late_Approvers.php") $css="class=current"; else $css=""; 
				echo "<li><a href=Reporter_Late_Approvers.php $css>Late Approvers</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_Emergency.php") $css="class=current"; else $css=""; 
				echo "<li><a href=Reporter_Emergency.php $css>Emergency Changes</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_TaskStatus.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Reporter_TaskStatus.php $css>Tasks Status</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_TCM_Weekly.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Reporter_TCM_Weekly.php $css>TCM Weekly</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_TCM_Weekly2.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Reporter_TCM_Weekly2.php $css>TCM Weekly <span style='color:yellow'><I>  New</I></span></a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_MonthlyKPIs.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Reporter_MonthlyKPIs.php $css>KPI Summary <span style='color:yellow'><I>  New</I></span></a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_SupportTeamKPIs.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Reporter_SupportTeamKPIs.php $css>Support Team KPIs<span style='color:yellow'><I>  New</I></span></a></li>";
				break;
    case 100:
				echo 	'<li><a href="#" class="menu">Daily CAB Meeting</a></li>';
				if($_SERVER['PHP_SELF']=="/TCMReporter/CRQ_Status.php") $css="class=current"; else $css=""; 
				echo "<li><a href=CRQ_Status.php $css>CAB Status</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Report_dashboard.php") $css="class=current"; else $css=""; 
				echo "<li><a href=CAB_Report_dashboard.php $css>CAB Report</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Report_Impacting.php") $css="class=current"; else $css=""; 
				echo "<li><a href=Report_Impacting.php $css>Impacting Report</a></li>";
				
				if($_SERVER['PHP_SELF']=="/TCMReporter/CRQ_Auth2.php") $css="class=current"; else $css=""; 
				echo "<li><a href=CRQ_Auth2.php $css>CAB Authorization</a></li>";
				
				echo 	'<li><a href="#" class="menu">Tools</a></li>';
				if($_SERVER['PHP_SELF']=="/TCMReporter/CRQ_Search.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CRQ_Search.php $css>CRQ Search</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CRQ_Advanced_Search.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CRQ_Advanced_Search.php $css>Pattern Search</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Report_Interval.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CAB_Report_Interval.php $css>Interval Search</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Yesterday_Report.php") $css="class=current"; else $css=""; 
					echo "<li><a href=CAB_Yesterday_Report.php $css>Last Night Changes</a></li>";
				
				echo "<li><a href='#' class='menu'>Statistics</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_IncidentDue2Changes.php") $css="class=current"; else $css="";
					echo "<li><a href='Reporter_IncidentDue2Changes.php' $css>Incidents Due to Changes</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_Normal_Domain.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Reporter_Normal_Domain.php $css>Changes Domains<span style='color:yellow'><I>  New</I></span></a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_CRQType.php") $css="class=current"; else $css=""; 
				echo "<li><a href=Reporter_CRQType.php $css>Changes Types<span style='color:yellow'><I>  New</I></span></a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_Status.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Reporter_Status.php $css>Changes Status</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_HU_Tiers.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Reporter_HU_Tiers.php $css>Changes Tiers</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_Requesters.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Reporter_Requesters.php $css>Top Requesters</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Report_TCM_Approvals.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Report_TCM_Approvals.php $css>TCM Approvals</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_Late_Approvers.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Reporter_Late_Approvers.php $css>Late Approvers</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_Emergency.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Reporter_Emergency.php $css>Emergency Changes</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_Fields.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Reporter_Fields.php $css>Remedy Fields</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_TaskStatus.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Reporter_TaskStatus.php $css>Tasks Status</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_TCM_Weekly.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Reporter_TCM_Weekly.php $css>TCM Weekly</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_TCM_Weekly2.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Reporter_TCM_Weekly2.php $css>TCM Weekly</a></li>";
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_MonthlyKPIs.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Reporter_MonthlyKPIs.php $css>KPI Summary<span style='color:yellow'><I>  New</I></span></a></li>";	
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_SupportTeamKPIs.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Reporter_SupportTeamKPIs.php $css>Support Team KPIs<span style='color:yellow'><I>  New</I></span></a></li>";					
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_TeamKPIs_IT.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Reporter_TeamKPIs_IT.php $css>IT Teams KPIs<span style='color:yellow'><I>  New</I></span></a></li>";					
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_TeamKPIs_NE.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Reporter_TeamKPIs_NE.php $css>Network Engineering KPIs<span style='color:yellow'><I>  New</I></span></a></li>";					
				if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_TeamKPIs_RO.php") $css="class=current"; else $css=""; 
					echo "<li><a href=Reporter_TeamKPIs_RO.php $css>Regional Operations KPIs<span style='color:yellow'><I>  New</I></span></a></li>";		
					
				break;				
		}
		if ($_SESSION['mylogin'] == 'TRUE'){
			if($_SERVER['PHP_SELF']=="/TCMReporter/logout.php") $css="class=current"; else $css=""; 
			echo "<li><a href=logout.php $css><span>Logout</span></a></li>";			
		}

?>
<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>
<BR><BR><BR><BR><BR><BR><BR><BR><BR>
<!--left menu ends here-->
</div>

</div>

<div id="footer">Copyright&copy; 2013 VF-EG Technology Change Management</div>

</div>
</body>
</html>
<?php
	$myFile = "log/login.log";
	$fh = fopen($myFile, 'a') or die("can't open file");
	$stringData = 	date('d-m-Y H:i:s')						." | ". 
					$_SERVER['REMOTE_ADDR']					." | ". 
					gethostbyaddr($_SERVER['REMOTE_ADDR']) 	." | ".
					$_COOKIE["user"]						." | ".
					//$_SERVER['REMOTE_USER']				." | ".
					//$_SERVER['LOGON_USER']				." | ".
					//$_SERVER['AUTH_USER']					." | ".
					$_SERVER['PHP_SELF'];
	
	//Hraslan: enc8clr
	fwrite($fh, $stringData. "\r\n");
	fclose($fh);

?>