<?php
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
		$sql = "SELECT ChangeFor,count(DISTINCT CRQ) CRQnum FROM dbo.vw_Change_Daily_CAB GROUP BY ChangeFor ORDER BY CRQnum DESC;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		$Total = 0;
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['ChangeFor']);
			array_push($data_Val,$row['CRQnum']);
			$Total += $row['CRQnum'];
		}
		array_push($data_Desc,'Total');
		array_push($data_Val,$Total);
		sqlsrv_free_stmt( $stmt);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(draw_ChangeFor);
	
	function draw_ChangeFor(){
		var dataChart = google.visualization.arrayToDataTable([           
			['Changes For', 'Number of Changes'],           
			<?php for($i=0;$i<count($data_Desc)-1; $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_Desc)-2) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] ); 
		var data = google.visualization.arrayToDataTable([           
			['Changes For', 'Number of Changes'],           
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
		var options = {           title: 'Changes For'  , is3D: true  , chartArea:{left:20,top:20,width:"90%",height:"90%"} };          
		var chart = new google.visualization.PieChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	}
</script>   
	<table ><tr>
		<td><div id="chart_div" style="width: 300px; height: 200px;"></div>  </td>
	</tr>
	<tr>
		<td ><div id="table_div" style="width: 320px; height: 150px;" ></div>  </td>
	</tr></table>
<?php sqlsrv_close( $conn ); ?>