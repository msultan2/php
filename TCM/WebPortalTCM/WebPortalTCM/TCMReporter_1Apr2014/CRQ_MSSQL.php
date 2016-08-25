<?php include ("templateReporter.php"); ?>
				<h1>Search Remedy CRQs:</h1>
		<div style="height:15px;"></div>
		<table>
			<form action="CRQ_MSSQL.php" name="myForm" method="post">
				<tr>
					<td align=center><h3>Change ID: </h3></td>
					<td align=left>
						<input type="text" name="CRQnum" value='<?php echo $_POST['CRQnum'];?>'/>
					</td>
					<td>
						<input type="submit" name="searchCRQ" value="Search" />
					</td>
				</tr>
			</form>		
		</table>
		<div style="height:10px"></div>
<?php
	//This part displays the Search CRQ result
	if (isset($_POST['CRQnum'])) {
	
		$CRQnum = $_POST['CRQnum'];
		if(strlen($CRQnum)!=5 OR !is_numeric($CRQnum)){
			echo "Not a valid number, please enter the last 5 digits in the CRQ Number";
		}
		else{
			// get the file contents, assuming the file to be readable (and exist) 
			$contents = file_get_contents($CRQfile); 
				
			//phpinfo();
			error_reporting(-1);$conf['error_level'] = 2;ini_set('display_errors', TRUE);ini_set('display_startup_errors', TRUE);
			
			/* Specify the server and connection string attributes. */
			$serverName = "egoct-wirws01"; //10.230.95.87
			$connectionInfo = array( "Database"=>"SM_Change_Researching_DB");

			/* Connect using Windows Authentication. */
			$conn = sqlsrv_connect( $serverName, $connectionInfo);
			if( !$conn ) {
				 echo "Connection could not be established.<br />";
				 die( print_r( sqlsrv_errors(), true));
			}
			$sql = "SELECT cab.CRQ,Requester,Support_Company,Support_Organization,Support_Group_Name,Description,Status,
			CAST(Scheduled_Start_Date AS varchar) Scheduled_Start_Date,CAST(Scheduled_End_Date AS varchar) Scheduled_End_Date,Impact ,Approval_Pending, ChangeFor,
			Product_Categorization_Tier_1,Product_Categorization_Tier_2,Product_Categorization_Tier_3,auth.Authorized,auth.CM_Comment
			FROM dbo.vw_Change_Daily_CAB cab LEFT OUTER JOIN  dbo.tbl_Change_Daily_CAB_Authorize auth
			ON cab.CRQ = auth.CRQ 
			WHERE cab.CRQ = 'CRQ0000000".$CRQnum."';";
			$stmt = sqlsrv_query( $conn, $sql );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			echo "<table class=blue width=90% align=center >
					<tr>
						<th>CRQ</th>
						<th>Submitter</th>
						<th>Initiator Team</th>
						<th>Scheduled Date</th>
						<th>Description</th>
						<th>Impact</th>
						<th>Pending At</th>
						<th>Change Type</th>
						<th>Status</th>
						<th>Authorized</th>
						<th>CM Comment</th>
					</tr>";
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$CRQ = $row['CRQ'];
				$Submitter = $row['Requester'];
				$SupportCompany = $row['Support_Company'];
				$SupportOrganization = $row['Support_Organization'];
				$SupportGroup = $row['Support_Group_Name'];
				$Description = $row['Description'];
				$ChangeFor = $row['ChangeFor'];
				$ProductTier1 = $row['Product_Categorization_Tier_1'];
				$ProductTier2 = $row['Product_Categorization_Tier_2'];
				$ProductTier3 = $row['Product_Categorization_Tier_3'];
				$PendingAt = $row['APApprovers'];
				$Status = $row['Status'];
				$ScheduledStartDate = $row['Scheduled_Start_Date'];
				$ScheduledEndDate = $row['Scheduled_End_Date'];
				$Authorized = $row['Authorized'];
				$CM_Comment = $row['CM_Comment'];
				preg_match('/(?P<x>\d+)-(?P<impact_level>\w+)\/(?P<y>\w+)/', $row['Impact'],$Impact_Exp);
				$Impact = $Impact_Exp['impact_level'];
				$is_Auth=($Authorized == 1)? 'checked':'';
				
				echo "<tr>
					<td>".substr($CRQ, -5)."</td>
					<td>".$Submitter."</td>
					<td width=140px><table><tr><td>".$SupportCompany."</td></tr><tr><td>".$SupportOrganization."</td></tr><tr><td>".$SupportGroup."</td></tr></table></td>
					<td width=200px>".$ScheduledStartDate."<br> to <br>".$ScheduledEndDate."</td>
					<td>".$Description."</td>
					<td class=".$Impact.">".$Impact."</td>
					<td>".$PendingAt."</td>
					<td>".$ChangeFor."<table width=100%><tr><td>".$ProductTier1."</td></tr><tr><td>".$ProductTier2."</td></tr><tr><td>".$ProductTier3."</td></tr></table></td>
					<td>".$Status."</td>
					<td><input type='checkbox' name='if_Auth' value=1 ".$is_Auth."/></td>
					<td><textarea name='new_comment' rows=4 cols=20>".$CM_Comment."</textarea> </td>";
					//echo "nmnm: ".$new_comment;
				echo "</tr>";
			}

			echo "</table>";
		}
	}
?>		
		<div style="height:15px;"></div>
		<h1>Daily CAB Report:</h1>
		<div style="height:15px;"></div>
			
<?php
	
			//phpinfo();
			error_reporting(-1);$conf['error_level'] = 2;ini_set('display_errors', TRUE);ini_set('display_startup_errors', TRUE);
			
			/* Specify the server and connection string attributes. */
			$serverName = "egoct-wirws01"; //10.230.95.87
			$connectionInfo = array( "Database"=>"SM_Change_Researching_DB");

			/* Connect using Windows Authentication. */
			$conn = sqlsrv_connect( $serverName, $connectionInfo);
			if( !$conn ) {
				 echo "Connection could not be established.<br />";
				 die( print_r( sqlsrv_errors(), true));
			}
			$sql = "SELECT cab.CRQ,Requester,Support_Company,Support_Organization,Support_Group_Name,Description,Status,
			CAST(Scheduled_Start_Date AS varchar) Scheduled_Start_Date,CAST(Scheduled_End_Date AS varchar) Scheduled_End_Date,Impact ,APApprovers, ChangeFor,
			Product_Categorization_Tier_1,Product_Categorization_Tier_2,Product_Categorization_Tier_3,auth.Authorized,auth.CM_Comment
			FROM dbo.vw_Change_Daily_CAB cab LEFT OUTER JOIN  dbo.tbl_Change_Daily_CAB_Authorize auth
			ON cab.CRQ = auth.CRQ ";
			$stmt = sqlsrv_query( $conn, $sql );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			echo "<table class=blue width=90% align=center >
					<tr>
						<th>CRQ</th>
						<th>Submitter</th>
						<th>Initiator Team</th>
						<th>Scheduled Date</th>
						<th>Description</th>
						<th>Impact</th>
						<th>Pending At</th>
						<th>Change Type</th>
						<th>Status</th>
						<th>Authorized</th>
						<th>CM Comment</th>
						<th></th>
					</tr>";
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$CRQ = $row['CRQ'];
				$Submitter = $row['Requester'];
				$SupportCompany = $row['Support_Company'];
				$SupportOrganization = $row['Support_Organization'];
				$SupportGroup = $row['Support_Group_Name'];
				$Description = $row['Description'];
				$ChangeFor = $row['ChangeFor'];
				$ProductTier1 = $row['Product_Categorization_Tier_1'];
				$ProductTier2 = $row['Product_Categorization_Tier_2'];
				$ProductTier3 = $row['Product_Categorization_Tier_3'];
				$PendingAt = $row['APApprovers'];
				$Status = $row['Status'];
				$ScheduledStartDate = $row['Scheduled_Start_Date'];
				$ScheduledEndDate = $row['Scheduled_End_Date'];
				$Authorized = $row['Authorized'];
				$CM_Comment = $row['CM_Comment'];
				preg_match('/(?P<x>\d+)-(?P<impact_level>\w+)\/(?P<y>\w+)/', $row['Impact'],$Impact_Exp);
				$Impact = $Impact_Exp['impact_level'];
				$is_Auth=($Authorized == 1)? 'checked':'';
				
				echo "<tr>
					<td>".substr($CRQ, -5)."</td>
					<td>".$Submitter."</td>
					<td width=140px><table><tr><td>".$SupportCompany."</td></tr><tr><td>".$SupportOrganization."</td></tr><tr><td>".$SupportGroup."</td></tr></table></td>
					<td width=200px>".$ScheduledStartDate."<br> to <br>".$ScheduledEndDate."</td>
					<td>".$Description."</td>
					<td class=".$Impact.">".$Impact."</td>
					<td>".$PendingAt."</td>
					<td class='".$ChangeFor."'>".$ChangeFor."<table width=100%><tr><td>".$ProductTier1."</td></tr><tr><td>".$ProductTier2."</td></tr><tr><td>".$ProductTier3."</td></tr></table></td>
					<td>".$Status."</td>
					<td><input type='checkbox' name='if_Auth' ".$is_Auth."/></td>
					<td><textarea name='new_comment' rows=4 cols=20>".$CM_Comment."</textarea> </td>
					<td><a href='CRQ_MSSQL.php?CRQ=".$CRQ."'>Save</a></td>
					";
					//echo "nmnm: ".$new_comment;
				echo "</tr>";
			}

			echo "</table>";
			
			// escape special characters in the query 
			//$pattern = preg_quote($CRQnum, '/'); 
			
			// finalise the regular expression, matching the whole line 
			//$pattern = "/^.*$pattern.*\$/m"; 
			
			// search, and store all matching occurences in $matches 
			//if(preg_match_all($pattern, $contents, $matches)){ 
				//echo implode("\n", $matches[0]);
				//list($ChangeID,$Status,$Submitter,$SupportCompany,$SupportOrganization,$SupportGroup,$ScheduledStartDate,$ScheduledEndDate,$Description,$Justification,$Notes,
					//	$Impact,$Urgency,$Risk,$ProductTier1,$ProductTier2,$ProductTier3) = str_getcsv(implode("\n", $matches[0]), ",", '"');
				
				
				
			 
			//else{    
				//echo "No Matches Found"; 
			//} 
			sqlsrv_free_stmt( $stmt);
	
			// Close the connection.
			sqlsrv_close( $conn );
		//}
	//}
?>
<?php include ("footer.php"); ?>