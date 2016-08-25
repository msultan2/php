<?php session_start();  $pagePrivValue=10; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<div class="body_text"><B>Impacting Activities till 48 hours</B></div>
<?php
	//This part displays the Search CRQ result
	
	//$CRQnums = preg_split('/\n/',$_POST['CRQnums']);
	
	echo "<table class=red width=90% >
			<tr>
				<th>CRQ</th>
				<th>Submitter</th>
				<th>Requesting Team</th>
				<th>Implementing Team</th>
				<th width=150px>Scheduled Date</th>
				<th>Description</th>
				<th>Impact</th>
				<th>Change Type</th>
				<th>Status</th>
				<th>Impact Details</th>
			</tr>";
				
			//phpinfo();
			error_reporting(-1);$conf['error_level'] = 2;ini_set('display_errors', TRUE);ini_set('display_startup_errors', TRUE);
			
		/* Parse configuration file */
		$ini_array = parse_ini_file("config.ini");
		
		/* Specify the server and connection string attributes. */

		$serverName = $ini_array['SERVER_NAME']; 
		$connectionInfo = array( "UID"=>$ini_array['DB_USER'],
								"PWD"=>$ini_array['DB_PASS'],
								"Database"=>$ini_array['DB_NAME']);

			/* Connect using Windows Authentication. */
			$conn = sqlsrv_connect( $serverName, $connectionInfo);
			if( !$conn ) {
				 echo "Connection could not be established.<br />";
				 die( print_r( sqlsrv_errors(), true));
			}
			
				$sql = "SELECT DISTINCT ch.CRQ,Requester,ch.Support_Company,ch.Support_Organization,ch.Support_Group_Name,tsk.Assignee_Company , tsk.Assignee_Organization, tsk.Assignee_Group,
							Description,Justification,Status, CAST(ch.Scheduled_Start_Date AS varchar) Scheduled_Start_Date,CAST(ch.Scheduled_End_Date AS varchar) Scheduled_End_Date,Impact ,Approval_Pending, ChangeFor,
							Product_Categorization_Tier_1,Product_Categorization_Tier_2,Product_Categorization_Tier_3, Risk_Level,
							External_Customer,Internal_Customer,Nodes_Systems,Reporting,Service_Impact,Business_Impact,Technical_Impact,DWH_Impact
						FROM dbo.vw_Change_Tomorrow_CAB ch LEFT OUTER JOIN dbo.vw_Change_Task_Merged_New tsk
						ON ch.CRQ = tsk.Request_ID 
						WHERE status = 'Request For Authorization' 
						AND (External_Customer IS NOT NULL OR Internal_Customer IS NOT NULL OR Nodes_Systems IS NOT NULL OR Reporting IS NOT NULL
						OR Service_Impact  IS NOT NULL OR Business_Impact IS NOT NULL OR Technical_Impact IS NOT NULL OR DWH_Impact IS NOT NULL) ;";

				$stmt = sqlsrv_query( $conn, $sql );
				if( $stmt === false) {
					die( print_r( sqlsrv_errors(), true) );
				}
				$found = false;
				while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
					$found = true;
					$CRQ = $row['CRQ'];
					$Submitter = $row['Requester'];
					$SupportCompany = $row['Support_Company'];
					$SupportOrganization = $row['Support_Organization'];
					$SupportGroup = $row['Support_Group_Name'];
					$Assignee_Company = $row['Assignee_Company'];
					$Assignee_Organization = $row['Assignee_Organization'];
					$Assignee_Group = $row['Assignee_Group'];
					$Description = $row['Description'];
					$Justification = $row['Justification'];
					$ChangeFor = $row['ChangeFor'];
					$ProductTier1 = $row['Product_Categorization_Tier_1'];
					$ProductTier2 = $row['Product_Categorization_Tier_2'];
					$ProductTier3 = $row['Product_Categorization_Tier_3'];
					$PendingAt = $row['Approval_Pending'];
					$Status = $row['Status'];
					$ScheduledStartDate = $row['Scheduled_Start_Date'];
					$ScheduledEndDate = $row['Scheduled_End_Date'];
					$Risk = $row['Risk_Level'];
					preg_match('/(?P<x>\d+)-(?P<impact_level>\w+)\/(?P<y>\w+)/', $row['Impact'],$Impact_Exp);
					$Impact = $Impact_Exp['impact_level'];
					if($row['External_Customer']!="") $Impact_Service=$row['External_Customer'].": ".$row['Service_Impact'];
						else $Impact_Service = "";
					if($row['Internal_Customer']!="") $Impact_Business=$row['Internal_Customer'].": ".$row['Business_Impact'];
						else $Impact_Business = "";
					if($row['Nodes_Systems']!="") $Impact_Technical=$row['Nodes_Systems'].": ".$row['Technical_Impact'];
						else $Impact_Technical = "";
					if($row['Reporting']!="") $Impact_DWH=$row['Reporting'].": ".$row['DWH_Impact'];
						else $Impact_DWH = "";
					
					echo "<tr>
						<td>".substr($CRQ, -6)."</td>
						<td>".$Submitter."</td>
						<td width=140px><table><tr><td>".$SupportCompany."</td></tr><tr><td>".$SupportOrganization."</td></tr><tr><td>".$SupportGroup."</td></tr></table></td>";
					echo ($Assignee_Company == null)?"<td></td>":"<td width=140px><table><tr><td>".$Assignee_Company."</td></tr><tr><td>".$Assignee_Organization."</td></tr><tr><td>".$Assignee_Group."</td></tr></table></td>";
					echo	"<td>".$ScheduledStartDate."<br> to <br>".$ScheduledEndDate."</td>
						<td>".$Description."</td>

						<td class=".$Impact.">".$Impact."</td>
						<td>".$ChangeFor."<table width=100%><tr><td>".$ProductTier1."</td></tr><tr><td>".$ProductTier2."</td></tr><tr><td>".$ProductTier3."</td></tr></table></td>
						<td>".$Status."<BR>". ( ($Status==="Scheduled")? '':"(".$PendingAt.")" )  ."</td>
						<td>";
						
						if($Impact_Service!="") echo "<BR><B>Service Impact:</B> ".$Impact_Service;
						if($Impact_Business!="") echo "<BR><B>Business Impact:</B> ".$Impact_Business;
						if($Impact_Technical!="") echo "<BR><B>Technical Impact:</B> ".$Impact_Technical;
						if($Impact_DWH!="") echo "<BR><B>DWH Impact:</B> ".$Impact_DWH;
						
						echo "</td></tr>";
						
				/*	echo	"<table class=myTable>
								<tr><th class=CRQ>Activity</th><td class=CRQ>".$Description."</td></tr>
								<tr><th>Justification</th><td>".$Justification."</td></tr>
								<tr><th>CRQ</th><td>".$CRQ."</td></tr>
								<tr><th>Requesting Team</th><td>".$SupportGroup." (".$Submitter.")</td></tr>
								<tr><th>Implementing Team</th><td>".$Assignee_Group."</td></tr>
								<tr><th>Scheduled Date</th><td> $ScheduledStartDate    to    $ScheduledEndDate </td>
								</tr><tr><th>Risk Level</th><td> $Risk </td></tr>
								<tr><th>Impact Level</th><td> $Impact </td></tr>"; 
								if($Impact_Service != "") print "<tr><th><B>Service Impact</th><td>
									<table class=innerTable><tr><th>External Customer: </th><td></td></tr><tr><td>Impact</td><td>$Impact_Service</td></tr></table>
									</td></tr>"; 
								if($Impact_Business != "") print "<tr><th>Business Impact</th><td>
									<table class=innerTable><tr><th>Internal Customer: </th><td></td></tr><tr><td>Impact</td><td>$Impact_Business</td></tr></table>
									</td></tr>"; 
								if($Impact_Technical != "") print "<tr><th>Technical Impact</th><td>
									<table class=innerTable><tr><th>Nodes or Systems: </th><td></td></tr><tr><td>Impact</td><td>$Impact_Technical</td></tr></table>
									</td></tr>"; 
								if($Impact_DWH != "") print "<tr><th>DWH Impact</th><td>
									<table class=innerTable><tr><th>DWH Reporting: </th><td></td></tr><tr><td>Impact</td><td>$Impact_DWH</td></tr></table>
									</td></tr>"; 
								print "</table><BR>";
					*/
				}
								
	echo "</table>";
//}
?>		
	
<?php include ("footer_new.php"); ?>