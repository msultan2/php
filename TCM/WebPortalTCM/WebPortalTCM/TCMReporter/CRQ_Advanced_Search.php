<?php //session_start();  $pagePrivValue=10; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
		<table>
			<form action="CRQ_Advanced_Search.php" name="myForm" method="post">
				<tr>
					<td align=center valign=top><b>Keywords: </b></td>
					<td align=left valign=bottom>
						<textarea wrap="hard" rows="08" cols="13" name="searchText"><?php echo $_POST['searchText'];?></textarea>
					</td>
					<td valign=top>
						<input type="submit" name="searchCRQ" value="Search" />
					</td>
				</tr>
				<tr style="height:10px"></tr>
			</form>		
		</table>	
<?php
	//This part displays the Search CRQ result
if (isset($_POST['searchText'])) {	
	
	$searchText = preg_split('/ /',$_POST['searchText']);
	
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
				<th width=70px>Scheduled Date</th>
				<th width=150px>First Approval</th>
				<th colspan=2>Approvers</th>
			</tr>";
	for ($i=0; $i<sizeof($searchText); $i++){
	
		$searchStr=chop($searchText[$i]);
		
				
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

			$sql = "SELECT ch.CRQ,Requester,ch.Support_Company,ch.Support_Organization,ch.Support_Group_Name,tsk.Assignee_Company , tsk.Assignee_Organization, tsk.Assignee_Group,
						Description,Status, CAST(ch.Scheduled_Start_Date AS varchar) Scheduled_Start_Date,CAST(ch.Scheduled_End_Date AS varchar) Scheduled_End_Date,Impact ,APApprovers, ChangeFor,
						Product_Categorization_Tier_1,Product_Categorization_Tier_2,Product_Categorization_Tier_3, 
						CAST(ch.[First Approval Date] AS varchar) First_Approval_Date,ch.[First Approver] First_Approver,ch.[First On Behalf of] FOBO,
						ch.[Second Approver] Approver2,ch.[Second On Behalf of] OBO2, ch.[Third Approver] Approver3,ch.[Third On Behalf of] OBO3, ch.[Fourth Approver] Approver4,ch.[Fourth On Behalf of] OBO4,
						ch.[Fifth Approver] Approver5,ch.[Fifth On Behalf of] OBO5, ch.[Sixth Approver] Approver6,ch.[Sixth On Behalf of] OBO6
					FROM dbo.vw_Change_Approval_Details ch LEFT OUTER JOIN  dbo.tbl_Change_Task_Merged tsk
					ON ch.CRQ = tsk.Request_ID 
					WHERE LOWER(ch.Description) like '%".$searchStr."%' 
						OR LOWER(ch.Product_Categorization_Tier_1) like '%".$searchStr."%' 
						OR LOWER(ch.Product_Categorization_Tier_2) like '%".$searchStr."%' 
						OR LOWER(ch.Product_Categorization_Tier_3) like '%".$searchStr."%';";
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
				$ChangeFor = $row['ChangeFor'];
				$ProductTier1 = $row['Product_Categorization_Tier_1'];
				$ProductTier2 = $row['Product_Categorization_Tier_2'];
				$ProductTier3 = $row['Product_Categorization_Tier_3'];
				$PendingAt = $row['APApprovers'];
				$Status = $row['Status'];
				$ScheduledStartDate = $row['Scheduled_Start_Date'];
				$ScheduledEndDate = $row['Scheduled_End_Date'];
				preg_match('/(?P<x>\d+)-(?P<impact_level>\w+)\/(?P<y>\w+)/', $row['Impact'],$Impact_Exp);
				$Impact = $Impact_Exp['impact_level'];
				$First_Approval_Date = $row['First_Approval_Date'];
				$First_Approver = $row['First_Approver'];
				$FOBO = $row['FOBO'];
				$Approver2 = $row['Approver2'];
				$OBO2 =$row['OBO2'];
				$Approver3 = $row['Approver3'];
				$OBO3 =$row['OBO3'];
				$Approver4 = $row['Approver4'];
				$OBO4 =$row['OBO4'];
				$Approver5 = $row['Approver5'];
				$OBO5 =$row['OBO5'];
				$Approver6 = $row['Approver6'];
				$OBO6 =$row['OBO6'];
				
				echo "<tr>
					<td>".substr($CRQ, -6)."</td>
					<td>".$Submitter."</td>
					<td width=140px><table><tr><td>".$SupportCompany."</td></tr><tr><td>".$SupportOrganization."</td></tr><tr><td>".$SupportGroup."</td></tr></table></td>";
				echo ($Assignee_Company == null)?"<td></td>":"<td width=140px><table><tr><td>".$Assignee_Company."</td></tr><tr><td>".$Assignee_Organization."</td></tr><tr><td>".$Assignee_Group."</td></tr></table></td>";
				echo	"<td>".$ScheduledStartDate."<br> to <br>".$ScheduledEndDate."</td>
					<td>".$Description."</td>
					<td class=".$Impact.">".$Impact."</td>
					<td>".$ChangeFor."<table width=100%><tr><td>".$ProductTier1."</td></tr><tr><td>".$ProductTier2."</td></tr><tr><td>".$ProductTier3."</td></tr></table></td>
					<td>".$Status."</td>
					<td>".$ScheduledStartDate. "</td>
					<td>".$First_Approval_Date."<BR>".$First_Approver."<BR>(".$FOBO.")</td>
					<td valign=top><table  width=100%><tr><td>".$Approver2."</td><td>".$OBO2."</td></tr>
								<tr><td>".$Approver3."</td><td>".$OBO3."</td></tr>
								<tr><td>".$Approver4."</td><td>".$OBO4."</td></tr>
								<tr><td>".$Approver5."</td><td>".$OBO5."</td></tr>
								<tr><td>".$Approver6."</td><td>".$OBO6."</td></tr>
					</table></td>
					</tr>";
			}
			if(!$found)
					echo "<tr><td>".$searchStr."</td><td colspan=11>Not found in the Database</td></tr>";
							
		
	}
	echo "</table>";
}
?>		
	
<?php include ("footer_new.php"); ?>