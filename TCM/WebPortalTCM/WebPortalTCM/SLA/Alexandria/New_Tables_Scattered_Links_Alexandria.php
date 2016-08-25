	<link href="../style_new.css" rel="stylesheet" type="text/css" />
<?php
		
			if (isset($_GET['color'])) {
			
			if ($_GET['color'] === 'Grade4') {
				$ColorCondition = "TT.Grade = 'P4' ";
			}
			else if ($_GET['color'] === 'Grade1') {
				$ColorCondition = "TT.Grade = 'P1'";
			}
			else if ($_GET['color'] === 'Grade2') {
				$ColorCondition = "TT.Grade = 'P2'";
			}
			else if ($_GET['color'] === 'Grade3') {
				$ColorCondition = "TT.Grade = 'P3' ";
			}
		}	
		
		
		/* Parse configuration file */
		$ini_array = parse_ini_file("../config.ini");
	
		/* Specify the server and connection string attributes. */

		$serverName = $ini_array['SERVER_NAME']; 
		$connectionInfo = array( "UID"=>$ini_array['DB_USER'],
								"PWD"=>$ini_array['DB_PASS'],
								"Database"=>$ini_array['DB_NAME']);

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$sql = "SELECT vio.Incident_ID,vio.Assigned_Group,CAST(vio.last_modified_date AS Varchar)last_modified_date,vio.Outage,vio.Status,vio.Region,vio.Sub_Region,vio.Priority,CAST(vio.[Submit Date] AS Varchar)Submit_Date,vio.SiteID,vio.TRUs_Affected,vio.Outage_Site,TT.Grade,
				CASE WHEN  TT.SLM_Status >= 3
				  THEN 'Violated'
				  WHEN TT.SLM_Status < 3
				  THEN 'Not Violated Yet'
				  END SLM_Status,vio.NoOfSites
				FROM dbo.vw_SS_Remedy_TT_SLA_All TT
				LEFT OUTER JOIN dbo.[vw_SS_Remedy_TT_SLA_Assigned_Violated] vio
				ON TT.Incident_ID = vio.Incident_ID
				WHERE $ColorCondition
				  AND TT.Region like '%Alexandria%'
				AND TT.Outage = 'No'
				AND vio.Incident_ID IS NOT NULL;";
				
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		
		$data_Incident_ID = array();
		$data_Team = array();
		$data_last_modified_date = array();
		$data_Outage = array();
		$data_Status = array();
		$data_SLM_Status = array();
		$data_Grade = array();
		$data_Region= array();
		$data_Sub_Region = array();
		$data_Priority = array();
		$data_Submit_Date = array();
	    $data_SiteID = array();
		$data_TRUs_Affected = array();
		$data_Outage_Site = array();
		$data_NoOfSites = array();
		
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) 
		{
			
			array_push($data_Incident_ID,$row['Incident_ID']);
			array_push($data_Team,$row['Assigned_Group']);
			array_push($data_last_modified_date,$row['last_modified_date']);
			array_push($data_Outage,$row['Outage']);
			array_push($data_Status,$row['Status']);
			array_push($data_SLM_Status,$row['SLM_Status']);
			array_push($data_Grade,$row['Grade']);
			array_push($data_Region,$row['Region']);
			array_push($data_Sub_Region,$row['Sub_Region']);
			array_push($data_Priority,$row['Priority']);
			array_push($data_Submit_Date,$row['Submit_Date']);
			array_push($data_SiteID,$row['SiteID']);
			array_push($data_TRUs_Affected,$row['TRUs_Affected']);
			array_push($data_Outage_Site,$row['Outage_Site']);
			array_push($data_NoOfSites,$row['NoOfSites']);
			
			}
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
				['Incident_ID','Assigned_Group','last_modified_date','Outage','Status','Region','Sub_Region','Priority','Submit_Date','SiteID','TRUs_Affected','Outage_Site','SLM_Status','Grade','NoOfSites'],
				<?php 
				for($i=0;$i<count($data_Incident_ID); $i++) 
				{ 
					echo "['".$data_Incident_ID[$i]."','".$data_Team[$i]."','".$data_last_modified_date[$i]."','".$data_Outage[$i]."','".$data_Status[$i]."','".$data_Region[$i]."','".$data_Sub_Region[$i]."','".$data_Priority[$i]."','".$data_Submit_Date[$i]."','".$data_SiteID[$i]."','".$data_TRUs_Affected[$i]."','".$data_Outage_Site[$i]."','".$data_SLM_Status[$i]."','".$data_Grade[$i]."','".$data_NoOfSites[$i]."']";
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


	
	