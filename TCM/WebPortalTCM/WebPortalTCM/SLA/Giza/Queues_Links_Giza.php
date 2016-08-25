<link href="../css/style.css" rel="stylesheet" type="text/css" />

<?php	  
	
	
	if (isset($_GET['team'])) {
			
			if ($_GET['team'] === 'Alex') {
				$TeamCondition = "AND TT.Assigned_Group like '%Alex%Delta%Access%Service%FO%'";
			}
			else if ($_GET['team'] === 'Cairo') {
				$TeamCondition  = "AND TT.Assigned_Group like '%Cairo%Access%Service%FO%'";
			}
			else if ($_GET['team'] === 'HU') {
				$TeamCondition = "AND TT.Assigned_Group like  '%HU%Access%Service%FO%'";
			}
			else if ($_GET['team'] === 'BEP') {
				$TeamCondition = "AND TT.Assigned_Group like  '%BEP%FO%'";
			}
			else if ($_GET['team'] === 'PTN') {
				$TeamCondition = "AND TT.Assigned_Group like  '%PTN%RTN%FO%'";
			}
			else if ($_GET['team'] === 'TransportDC') {
				$TeamCondition = "AND TT.Assigned_Group like  '%Transport%FO%Datacom%'";
			}
			else if ($_GET['team'] === 'TransportTX') {
				$TeamCondition = "AND TT.Assigned_Group like  '%Transport%FO%Tx%'";
			}
			else if ($_GET['team'] === 'Others') {
				$TeamCondition = "AND TT.Assigned_Group NOT IN ('Alex & Delta Access Service FO','Cairo Access Service FO','HU Access Service FO','BEP FO','PTN-RTN FO','Transport FO Datacom','Transport FO Tx')
								  AND (TT.Assigned_Group NOT LIKE 'NFM%' AND TT.Assigned_Group NOT LIKE '%Site%Restoration%' AND TT.Assigned_Group NOT LIKE '%Site%Management%' AND lower(TT.Assigned_Group) NOT LIKE '%flapping%' AND TT.Assigned_Group NOT LIKE '%External%Affairs%')";
			}
			else if ($_GET['team'] === 'NFM') {
				$TeamCondition = "AND TT.Assigned_Group like 'NFM%'";
			}
			else if ($_GET['team'] === 'Restoration') {
				$TeamCondition = "AND TT.Assigned_Group like '%Site%Restoration%'";
			}
			else if ($_GET['team'] === 'Management') {
				$TeamCondition = "AND TT.Assigned_Group like '%Site%Management%'";
			}
			else if ($_GET['team'] === 'flapping') {
				$TeamCondition = "AND lower(TT.Assigned_Group) like '%flapping%'";
			}
			else if ($_GET['team'] === 'affairs') {
				$TeamCondition = "AND TT.Assigned_Group like '%External%Affairs%'";
			}
		}	
		
		//print $TeamCondition;
		/* Parse configuration file */
		$ini_array = parse_ini_file("../config.ini");
	
		/* Specify the server and connection string attributes. */

		$serverName = $ini_array['SERVER_NAME']; 
		$connectionInfo = array( "UID"=>$ini_array['DB_USER'], "PWD"=>$ini_array['DB_PASS'], "Database"=>$ini_array['DB_NAME']);

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$sql = "SELECT TT.Incident_ID,TT.Assigned_Group,CAST(TT.last_modified_date AS Varchar)last_modified_date,TT.Outage,TT.Status,TT.Region,TT.Sub_Region,TT.Priority,CAST(TT.[Submit Date] AS Varchar)Submit_Date,TT.SiteID,TT.TRUs_Affected,TT.Grade,
				  CASE WHEN  TT.SLM_Status >= 3
				  THEN 'Violated'
				  WHEN TT.SLM_Status < 3
				  THEN 'Not Violated Yet'
				  END SLM_Status,TT.NoOfSites
				  FROM dbo.[vw_SS_Remedy_TT_SLA_All] TT
				  WHERE TT.Assigned_Group IS NOT NULL
				  AND TT.Region like '%Giza%'
				  $TeamCondition 
				  AND TT.Status IN ('Assigned','Pending','In Progress')
				  AND TT.Incident_ID IS NOT NULL
				  AND TT.OUTAGE <> 'Yes';";
				  
				  //print $sql;
				  
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		
		$data_Incident_ID = array();
		$data_Team = array();
		$data_last_modified_date = array();
		$data_Outage = array();
		$data_Status = array();
		$data_Region= array();
		$data_Sub_Region = array();
		$data_Priority = array();
		$data_Submit_Date = array();
	    $data_SiteID = array();
		$data_SLM_Status = array();
		$data_Grade = array();
		$data_TRUs_Affected = array();
		$data_NoOfSites = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Incident_ID,$row['Incident_ID']);
			array_push($data_Team,$row['Assigned_Group']);
			array_push($data_last_modified_date,$row['last_modified_date']);
			array_push($data_Outage,$row['Outage']);
			array_push($data_Status,$row['Status']);
			array_push($data_Region,$row['Region']);
			array_push($data_Sub_Region,$row['Sub_Region']);
			array_push($data_Priority,$row['Priority']);	
			array_push($data_Submit_Date,$row['Submit_Date']);
			array_push($data_SiteID,$row['SiteID']);
			array_push($data_SLM_Status,$row['SLM_Status']);
			array_push($data_Grade,$row['Grade']);
			array_push($data_TRUs_Affected,$row['TRUs_Affected']);
			array_push($data_NoOfSites,$row['NoOfSites']);
						
		}
		//print $row['SLM_Status'];
        //print $row['Grade'];
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn ); 
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataChart = google.visualization.arrayToDataTable([   
				['Incident_ID','Assigned_Group','last_modified_date','Outage','Status','Region','Sub_Region','Priority','Submit_Date','SiteID','TRUs_Affected','SLM_Status','Grade','NoOfSites'],
				<?php 
				for($i=0;$i<count($data_Incident_ID); $i++) 
				{ 
					echo "['".$data_Incident_ID[$i]."','".$data_Team[$i]."','".$data_last_modified_date[$i]."','".$data_Outage[$i]."','".$data_Status[$i]."','".$data_Region[$i]."','".$data_Sub_Region[$i]."','".$data_Priority[$i]."','".$data_Submit_Date[$i]."','".$data_SiteID[$i]."','".$data_TRUs_Affected[$i]."','".$data_SLM_Status[$i]."','".$data_Grade[$i]."','".$data_NoOfSites[$i]."']";
					if ($i<count($data_Incident_ID)-1) echo ",";	//add ',' to all except last element
				}
			?>
			] );
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataChart, {showRowNumber: true});       
		
		var view = new google.visualization.DataView(dataChart);
		view.setColumns([0, 
						1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" }]);      
	} 
</script>   
<table  >
	<tr>
	<td ><div id="table_div"></div></td>
	</tr>
</table>
