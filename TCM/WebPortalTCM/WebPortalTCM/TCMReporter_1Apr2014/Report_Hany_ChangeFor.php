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
		// get IT & NW CRQs from today till last week (ex: from yesterday Wednesday till last Thursday) 7 days
		$sql = "SELECT CASE WHEN ChangeFor IN ('','General') THEN 'Network' ELSE ChangeFor END ChangeFor,count(*) CRQnum FROM dbo.vw_Change_Approval_Details 
				WHERE Support_Company IN ('Regional Operations','Network Engineering','Products & Services Delivery','Service Management','IT Operations')
				--AND ChangeFor IN ('Network','IT')
				AND dbo.DateOnly(Scheduled_Start_Date) <= ( getdate() -1 ) AND dbo.DateOnly(Scheduled_Start_Date) > getdate() - 8
				GROUP BY CASE WHEN ChangeFor IN ('','General') THEN 'Network' ELSE ChangeFor END  
				ORDER BY CRQnum DESC;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['ChangeFor']);
			array_push($data_Val,$row['CRQnum']);
		}
		
		sqlsrv_free_stmt( $stmt);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(draw_ChangeFor);
	
	function draw_ChangeFor(){
		var data = google.visualization.arrayToDataTable([           
			['Changes For', 'Number of Changes'],           
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] );       
		
		var options = {           title: 'CRQs/Domain'  , is3D: true  , chartArea:{left:60,top:40,width:"80%",height:"80%"} };          
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(data, options);       
	}
</script>   
	<table ><tr>
		<td><div id="chart_div" style="width: 400px; height: 300px;"></div>  </td>
	</tr>
</table>
<?php sqlsrv_close( $conn ); ?>