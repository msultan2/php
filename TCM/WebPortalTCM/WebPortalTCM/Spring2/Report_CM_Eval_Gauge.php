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
		$sql = "SELECT Approval_Pending, count(DISTINCT CRQ) CRQnum FROM dbo.vw_Change_Daily_CAB cap WHERE Approval_Pending IN ('CM_Eval','CM_Authorized','Fully Approved') GROUP BY Approval_Pending;";
		$sql_Total = "SELECT count(DISTINCT CRQ) CRQnum FROM dbo.vw_Change_Daily_CAB cap;";
		$stmt = sqlsrv_query( $conn, $sql );
		
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['Approval_Pending']);
			array_push($data_Val,$row['CRQnum']);
		}
		sqlsrv_free_stmt( $stmt);
		
		$stmt = sqlsrv_query( $conn, $sql_Total);
		if (sqlsrv_fetch($stmt)=== false){
			die( print_r( sqlsrv_errors(), true));
		}
		array_push($data_Desc,'Total');
		array_push($data_Val,sqlsrv_get_field( $stmt, 0));
		
		sqlsrv_free_stmt( $stmt);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:['gauge']});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(draw_ChangeFor);
	
	function draw_ChangeFor(){
		var data = google.visualization.arrayToDataTable([  
   /*['Label', 'Value'],           ['Memory', 80],           ['CPU', 55],           ['Network', 68] */		
			['Label', 'Value'],           
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] ); 
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(data, {showRowNumber: true});       
		
		//drawGauge    
		var options = { redFrom: 30, redTo: 50, yellowFrom:10, yellowTo: 30, greenFrom: 0, greenTo: 10, minorTicks: 5,max:50, textStyle: {fontSize: 8},
						majorTicks:['0','10','20','30','40','50'],chartArea:{left:10,top:10,width:"90%",height:"90%"} }; //fontSize:2
		var chart = new google.visualization.Gauge(document.getElementById('chart_div'));         
		chart.draw(data, options);       
	}
</script>   
	<table ><tr>
		<td><div id="chart_div" style="width: 700px; height: 200px;"></div>  </td>
		<td ><div id="table_div" style="width: 300px; height: 150px;" ></div>  </td>
	</tr></table>
<?php sqlsrv_close( $conn ); ?>