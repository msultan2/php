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
		$sql = "SELECT CASE Approval_Pending
							WHEN 'CM_Eval' THEN 'P1 & P2'
							ELSE 'P3 & P4'
						END Approval_Pending, 
						CASE Approval_Pending
							WHEN 'CM_Eval' THEN '1'
							ELSE '2'
						END Sort_ID, count(DISTINCT CRQ) CRQnum 
				FROM dbo.vw_Change_Daily_CAB cap 
				WHERE Approval_Pending IN ('CM_Eval','CM_Authorized') 
				GROUP BY CASE Approval_Pending
							WHEN 'CM_Eval' THEN 'P1 & P2'
							ELSE 'P3 & P4'
						END, 
						CASE Approval_Pending
							WHEN 'CM_Eval' THEN '1'
							ELSE '2'
						END 
				ORDER BY Sort_ID";
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
		/*
		$stmt = sqlsrv_query( $conn, $sql_Total);
		if (sqlsrv_fetch($stmt)=== false){
			die( print_r( sqlsrv_errors(), true));
		}
		array_push($data_Desc,'Total');
		array_push($data_Val,sqlsrv_get_field( $stmt, 0));
		
		sqlsrv_free_stmt( $stmt);
		*/
		sqlsrv_close( $conn ); 
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:['gauge']});
	google.setOnLoadCallback(draw_ChangeFor);
	
	function draw_ChangeFor(){
		var data = google.visualization.arrayToDataTable([  	
			['Label', 'Value'],           
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] );     
		
		//drawGauge    
		var options = { redFrom: 75, redTo: 100, yellowFrom:25, yellowTo: 75, greenFrom: 0, greenTo: 25, minorTicks: 5, min:0, max:100, textStyle: {fontSize: 4},
						majorTicks:['0','10','20','30','40','50','60','70','80','90','100'],chartArea:{left:10,top:10,width:"90%",height:"90%"} }; //fontSize:2
		var chart = new google.visualization.Gauge(document.getElementById('chart_div'));         
		chart.draw(data, options);       
	}
</script>   
	<table><tr width=700px>
		<td width=150px>&nbsp;</td>
		<td><div id="chart_div" style="width: 400px; height: 200px;"></div>  </td>
	</tr></table>
