<?php include ("template.php"); ?>
<div id="templatemo_content_wrapper">
<div id="templatemo_content">
<div id="main_content">
<div id="templatemo_content_wrapper"><!-- Start of Content -->
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
			$sql = "SELECT CRQ,Requester,Support_Company,Support_Organization,Support_Group_Name,Description,Status,
			Product_Categorization_Tier_1,Product_Categorization_Tier_2,Product_Categorization_Tier_3,
			CAST(Scheduled_Start_Date AS varchar) Scheduled_Start_Date,CAST(Scheduled_End_Date AS varchar) Scheduled_End_Date,Impact,APApprovers 
			FROM dbo.vw_Change_Daily_CAB;";
			//echo $sql;
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
						<th>Pending at</th>
						<th>Change Type</th>
						<th>Status</th>
					</tr>";
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$CRQ = $row['CRQ'];
				$Submitter = $row['Requester'];
				$SupportCompany = $row['Support_Company'];
				$SupportOrganization = $row['Support_Organization'];
				$SupportGroup = $row['Support_Group_Name'];
				$Description = $row['Description'];
				$ProductTier1 = $row['Product_Categorization_Tier_1'];
				$ProductTier2 = $row['Product_Categorization_Tier_2'];
				$ProductTier3 = $row['Product_Categorization_Tier_3'];
				$Pending = $row['APApprovers'];
				$Status = $row['Status'];
				$ScheduledStartDate = $row['Scheduled_Start_Date'];
				$ScheduledEndDate = $row['Scheduled_End_Date'];
				//preg_match('/(?P<x>\d+)-(?P<impact_level>\w+)\/(?P<y>\w+)/', $row['Impact'],$Impact_Exp);
				$Impact = $row['Impact']; //$Impact_Exp[impact_level];
				
				
				echo "<tr>
					<td>".$CRQ."</td>
					<td>".$Submitter."</td>
					<td width=140px><table><tr><td>".$SupportCompany."</td></tr><tr><td>".$SupportOrganization."</td></tr><tr><td>".$SupportGroup."</td></tr></table></td>
					<td width=200px>".$ScheduledStartDate."<br> to <br>".$ScheduledEndDate."</td>
					<td>".$Description."</td>
					<td class=".$Impact.">".$Impact."</td>
					<td>".$Pending."</td>
					<td><table width=100%><tr><td>".$ProductTier1."</td></tr><tr><td>".$ProductTier2."</td></tr><tr><td>".$ProductTier3."</td></tr></table></td>
					<td>".$Status."</td>
				</tr>";
			}

			echo "</table>";		
				 
			//} 
			sqlsrv_free_stmt( $stmt);
	
			// Close the connection.
			sqlsrv_close( $conn );
	
?>	
</div>
</div>
</div>
</div>
<?php include ("footer.php"); ?>	