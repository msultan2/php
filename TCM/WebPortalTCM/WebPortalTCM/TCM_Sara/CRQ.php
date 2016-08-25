<?php include ("templateTools.php"); ?>
<?php
	$CRQfile = 'txt/PA_Report.csv';
	$CRQs = file('txt/PA_Report.csv');
	$num_crq = count($CRQs);
?>
<div id="content">
		<h1>Search Remedy CRQs:</h1>
		<div style="height:15px;"></div>
		<table>
			<form action="CRQ.php" name="myForm" method="post">
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
			$sql = "SELECT CRQ,STATUS FROM dbo.vw_Change_Approval_Details WHERE CRQ = 'CRQ000000082561';"; //".$CRQnum."';";
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
						<th>Urgency</th>
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
				$ProductTier1 = "1";
				$ProductTier2 = "2";
				$ProductTier3 = "3";
				$Urgency = "test";
				$Status = $row['Change_Request_Status'];
				$ScheduledStartDate = $row['Scheduled_Start_Date'];
				$ScheduledEndDate = $row['Scheduled_End_Date'];
				//preg_match('/(?P<x>\d+)-(?P<impact_level>\w+)\/(?P<y>\w+)/', $row['Impact'],$Impact_Exp);
				$Impact = "Minor";//$Impact_Exp[impact_level];
				
				
				echo "<tr>
					<td>".substr($ChangeID, -5)."</td>
					<td>".$Submitter."</td>
					<td width=140px><table><tr><td>".$SupportCompany."</td></tr><tr><td>".$SupportOrganization."</td></tr><tr><td>".$SupportGroup."</td></tr></table></td>
					<td width=200px>".$ScheduledStartDate."<br> to <br>".$ScheduledEndDate."</td>
					<td>".$Description."</td>
					<td class=".$Impact.">".$Impact."</td>
					<td>".substr($Urgency,2)."</td>
					<td><table width=100%><tr><td>".$ProductTier1."</td></tr><tr><td>".$ProductTier2."</td></tr><tr><td>".$ProductTier3."</td></tr></table></td>
					<td>".$Status."</td>
				</tr>";
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
		}
	}
?>
	<div style="height:10px"></div>
	<div class="razd_h"></div>
	<div style="height:10px"></div>
	
	<h1>List of Remedy CRQs:</h1>
	<div style="height:15px;"></div>
<?php	  
	//This part displays All the CRQs Table Details//
	// search for Remedy CRQs by query 'Support Company*+'   = "Products & Services Delivery"   OR  "Support Company*+"   = "Network Engineering"  OR  "Support Company*+"   =  "Service Management"  OR "Support Company*+"   =  "IT Operations"  OR "Support Company*+"   =  "Regional Operations"  OR "Support Company*+"   =  "Customer Experience "
	echo "<table class=blue width=90% align=center >";	
	echo "<tr>
			<th>CRQ</th>
			<th>Submitter</th>
			<th>Initiator Team</th>
			<th>Scheduled Date</th>
			<th>Description</th>
			<th>Impact</th>
			<th>Urgency</th>
			<th>Change Type</th>
			<th>Status</th>
		</tr>";
	for($index=1; $index< $num_crq; $index++)
	{ 
	//	list($ChangeID,$Status,$Submitter,$SupportCompany,$SupportOrganization,$SupportGroup,$ScheduledStartDate,$ScheduledEndDate,$Description,$Justification,$Notes,
	//		$Impact,$Urgency,$Risk,$ProductTier1,$ProductTier2,$ProductTier3)= preg_split("/[,]*\\\"([^\\\"]+)\\\"[,]*|[,]+/",$CRQs[$index],0,PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);	

		list($ChangeID,$Status,$Submitter,$SupportCompany,$SupportOrganization,$SupportGroup,$ScheduledStartDate,$ScheduledEndDate,$Description,$Justification,$Notes,
			$Impact,$Urgency,$Risk,$ProductTier1,$ProductTier2,$ProductTier3) = str_getcsv($CRQs[$index], ",", '"');
			
		preg_match('/(?P<x>\d+)-(?P<impact_level>\w+)\/(?P<y>\w+)/', $Impact, $matches);
		$Impact = $matches[impact_level];
		if($SupportOrganization != 'Technology'){
			echo "<tr>
					<td>".substr($ChangeID, -5)."</td>
					<td>".$Submitter."</td>
					<td width=140px><table><tr><td>".$SupportCompany."</td></tr><tr><td>".$SupportOrganization."</td></tr><tr><td>".$SupportGroup."</td></tr></table></td>
					<td width=200px>".$ScheduledStartDate."<br> to <br>".$ScheduledEndDate."</td>
					<td>".$Description."</td>
					<td class=".$Impact.">".$Impact."</td>
					<td>".substr($Urgency,2)."</td>
					<td><table width=100%><tr><td>".$ProductTier1."</td></tr><tr><td>".$ProductTier2."</td></tr><tr><td>".$ProductTier3."</td></tr></table></td>
					<td>".$Status."</td>
				</tr>";
		}
	}
	echo "</table>";
?>
</div>
<?php include ("footer.php"); ?>
				