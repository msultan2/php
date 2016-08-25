<?php include ("index_tools.php");  ?>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
	<p><B> SDS Cell Tasks: mismatch report</B><BR>

<?php
		$sumSites = 0;
		$SDS = 0;
		$sumAccepted = 0;
		
	/************************** Excel ***********************/

		$sql = "SELECT Site_ID,Request_Status,OSS_Status,Site_Acceptance_Status,[Number of Cells],[Down Cells],Last_CellTask_Date,Halting_Reason,Last_Updated_From_OSS FROM dbo.vw_SS_Remedy_TT_CellTask WHERE OSS_Status != Request_Status;";		 
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		//echo $sql_encoded;
		echo '<a href="excel.php?name=SDS_CellTask&query='.$sql_encoded.'">';
		echo 'Export to Excel: <img width=24px height=24px src="images/excel.bmp" style="border-style: none"/></a>';
	/************************** Excel ***********************/
	//5135-5195-5002
		echo "<div id='main'>
				<table class='features-table'>
				<tr>
					<td>Site ID</td>
					<td class='ol-cell col-cell1 col-cellh'>Requested to be</td>
					<td class='ol-cell col-cell3 col-cellh'>OSS Status</td>
					<td class='ol-cell col-cell2 col-cellh'>Number of Cells</td>
					<td class='ol-cell col-cell3 col-cellh'>Down Cells</td>
					<td class='ol-cell col-cell2 col-cellh'>Last CellTask Date</td>
					<td class='ol-cell col-cell3 col-cellh'>Halting Reason</td>					
					<td class='ol-cell col-cell2 col-cellh'>Site Status</td>
					<td class='ol-cell col-cell2 col-cellh'>OSS LastUpdate</td>
				</tr>";

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
				
				$sql0 = "SELECT tsk.Site_ID,
							CASE Request_Status WHEN 0 THEN 'Halt' WHEN 1 THEN 'Active'
							END Request_Status,
							CASE Site_Acceptance_Status 
								WHEN 0 THEN 'Accepted' 
								WHEN 1 THEN 'Under Test 48 Hrs'
								WHEN 2 THEN 'Under Test with Alarm'
								WHEN 3 THEN 'In Progress'
								WHEN 10 THEN 'Not Accepted'
							END Site_Acceptance_Status, COUNT(*) 'Number of Cells',DS.CellsCount 'Down Cells',
						CAST(Last_CellTask_Date AS VARCHAR) Last_CellTask_Date,Halting_Reason,
						CASE OSS_Status WHEN 0 THEN 'Halt' WHEN 1 THEN 'Active' END OSS_Status,
						CAST(Last_Updated_From_OSS AS VARCHAR) Last_Updated_From_OSS
					    FROM [dbo].[tbl_SS_Remedy_TT_CellTask] tsk
					    LEFT OUTER JOIN dbo.tbl_SS_DownSites DS
									  ON  tsk.Site_ID = DS.Site_ID
					    WHERE tsk.Request_Status <> tsk.OSS_Status
					    GROUP BY tsk.Site_ID,CASE Request_Status WHEN 0 THEN 'Halt' WHEN 1 THEN 'Active'
							END ,
							CASE Site_Acceptance_Status 
								WHEN 0 THEN 'Accepted' 
								WHEN 1 THEN 'Under Test 48 Hrs'
								WHEN 2 THEN 'Under Test with Alarm'
								WHEN 3 THEN 'In Progress'
								WHEN 10 THEN 'Not Accepted'
							END , DS.CellsCount ,
						CAST(Last_CellTask_Date AS VARCHAR) ,Halting_Reason,
						CASE OSS_Status WHEN 0 THEN 'Halt' WHEN 1 THEN 'Active' END ,
						CAST(Last_Updated_From_OSS AS VARCHAR) ;";
				
				$sql = "SELECT [Site_ID]
						  ,[Request_Status]
						  ,[Site_Acceptance_Status]
						  ,[Number of Cells]
						  ,[Down Cells]
						  ,[Last_CellTask_Date]
						  ,[Halting_Reason]
						  ,[OSS_Status]
						  ,[Last_Updated_From_OSS]
					  FROM [dbo].[vw_SS_Remedy_TT_CellTask]
					  WHERE OSS_Status <> Request_Status;";
				$stmt = sqlsrv_query( $conn, $sql );
				if( $stmt === false) {
					die( print_r( sqlsrv_errors(), true) );
				}
				$found = false;
				while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
					$found = true;
					$Site_ID = $row['Site_ID'];
					$Request_Status = $row['Request_Status'];
					$Site_Acceptance_Status = $row['Site_Acceptance_Status'];
					$cellsTaskcount = $row['Number of Cells'];
					$downCells = $row['Down Cells'];
					$Last_CellTask_Date = $row['Last_CellTask_Date'];
					$Halting_Reason = $row['Halting_Reason'];
					$OSS_Status = $row['OSS_Status'];
					$LastModified_OSS_Date = $row['Last_Updated_From_OSS'];
					
					$sumSites ++;
					if(strlen($downCells) > 0) $SDS ++;
					if($Site_Acceptance_Status==='Accepted') $sumAccepted ++;
					
					//preg_match('/(?P<x>\d+)-(?P<impact_level>\w+)\/(?P<y>\w+)/', $row['Impact'],$Impact_Exp);
					//$Impact = $Impact_Exp['impact_level'];
					//$is_Auth=($Authorized == 1)? 'checked':'';
					
					echo "<tr>
						<td>".$Site_ID."</td>
						<td class='col-cell col-cell1'>". (($Request_Status==='Halt')? "<B>$Request_Status</B>":$Request_Status) ."</td>
						<td class='col-cell col-cell3'>".(($OSS_Status==='Halt')? "<B>$OSS_Status</B>":$OSS_Status) ."</td>
						<td class='col-cell col-cell1'>".$cellsTaskcount."</td>
						<td class='col-cell col-cell3'><a href=index.php>".( (strlen($downCells)==0)? '<img src=images\cross.png width=16 height=16 alt=check>': ((strlen($downCells)>0)?'<img src=images\check.png width=16 height=16 alt=check>':'' ) )." ".$downCells."</a></td>
						<td class='col-cell col-cell1'>".$Last_CellTask_Date. "</td>
						<td class='col-cell col-cell3'>$Halting_Reason</td>		
						<td class='col-cell col-cell1'>".(($Site_Acceptance_Status!='Accepted')? "<B>$Site_Acceptance_Status</B>":$Site_Acceptance_Status)."</td>
						<td class='col-cell col-cell1'>$LastModified_OSS_Date</td>";
					echo "</tr>";
				}
				if(!$found)
					echo "<tr><td class='col-cell col-cell1'>".$siteID."</td><td colspan=12 class='col-cell col-cell2'>Not found in the Database</td></tr>";
				
			sqlsrv_free_stmt( $stmt);
			//}
		
		
		echo "<tr class='no-border'>
						  <td></td>
						  <td class='col-cell col-cell1 col-cellf' colspan=2>Number of mismatches: $sumSites</td>
						  <td class='col-cell col-cell1 col-cellf'></td>
						  <td class='col-cell col-cell3 col-cellf'>SDS: $SDS</td>
						  <td class='col-cell col-cell1 col-cellf'></td>
						  <td class='col-cell col-cell3 col-cellf'></td>
						  <td class='col-cell col-cell1 col-cellf'>Accepted: $sumAccepted</td>
						  <td class='col-cell col-cell1 col-cellf'></td>
						</tr>
				
				</table></div>";
	
		// Close the connection.
		sqlsrv_close( $conn );
	
?>		
<?php //include ("footer_tools.php");  ?>