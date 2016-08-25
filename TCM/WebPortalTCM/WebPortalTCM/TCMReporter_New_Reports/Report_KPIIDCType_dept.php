<?php
	$startDate = '4/1/2013';
	$endDate = date('m/d/Y', time() + (60 * 60 * 24 * -1));
	//echo $weekback." ".$yesterday;

	if(isset($_GET['from'])) $getFrom = $_GET['from']; else $getFrom = $startDate;
	if(isset($_GET['to'])) $getTo = $_GET['to']; else $getTo = $endDate;
	if(isset($_GET['team'])) $team = str_replace("__"," ",$_GET['team']); else $team = "";
	if(isset($_GET['dept'])) {
	
		$dept = $_GET['dept']; 
		//echo $dept;
		if ( $dept == 'NE') $dept_condition = " Category IN ('Core Network','Voice','GPRS','Fixed Network','International & Roaming ') ";
		if ( $dept == 'RO') $dept_condition = " Category IN ('Coverage') ";
		if ( $dept == 'IT') $dept_condition = " Category NOT IN ('Core Network','Voice','GPRS','Fixed Network','Coverage','International & Roaming ') ";		//P&SD
		if ( $dept == 'SM') $dept_condition = " Category NOT IN ('IT Incident') ";
		
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
			 die( print_r( sqlsrv_errors(), true));
		}
		$sql = "SELECT inc.Problem_Type, count(*) INCnum
				FROM dbo.tbl_Incident_IDC inc LEFT OUTER JOIN dbo.tbl_Incident_LK_Team_Mapping incMap
				ON inc.Owner_Team = incMap.INC_OwnerTeam
				WHERE inc.Dueto_Change = 1
				AND (dbo.DateOnly(inc.[Start Date]) <= '$getTo' AND dbo.DateOnly(inc.[Start Date]) >= '$getFrom')
				AND $dept_condition
				GROUP BY inc.Problem_Type
				ORDER BY INCnum DESC;";
		//echo $sql;
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['Problem_Type']);
			array_push($data_Val,$row['INCnum']);
		}
		
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn );
	}
	else echo "No department identified";
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(draw_ChangeFor);
	
	function draw_ChangeFor(){
		var data = google.visualization.arrayToDataTable([           
			['Problem Type', 'IDC'],           
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] ); 
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(data, {showRowNumber: true});       
		
		//drawPieChart
		var options = {           title: ' <?php echo $dept; ?> Incidents Due to Change'  , is3D: true  , chartArea:{left:20,top:20,width:"60%",height:"90%"} };          
		var chart = new google.visualization.PieChart(document.getElementById('chart_div'));         
		chart.draw(data, options);       
	}
</script>   
	<table ><tr>
		<td><div id="chart_div" style="width: 600px; height: 200px;"></div>  </td>
	</tr>
	<tr>
		<td ><div id="table_div" style="width: 400px; height: 150px;" ></div>  </td>
	</tr></table>
