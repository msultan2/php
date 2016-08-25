<link href="style_new.css" rel="stylesheet" type="text/css" />
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
		$sql = "SELECT CASE Support_Company WHEN 'Products & Services Delivery' THEN 'IT'
											WHEN 'IT Operations' THEN 'IT'
											ELSE Support_Company
						END Support_Company,count(*) CRQnum FROM dbo.vw_Change_Approval_Details 
				WHERE CRQ_Type = 'Normal'
				AND Status NOT IN ('Draft','Request For Authorization','Pending','Cancelled','Rejected')
				AND Support_Company IN ('Regional Operations','Network Engineering','Products & Services Delivery','Service Management','IT Operations')
				GROUP BY CASE Support_Company WHEN 'Products & Services Delivery' THEN 'IT'
											WHEN 'IT Operations' THEN 'IT'
											ELSE Support_Company
						END
				ORDER BY CRQnum DESC;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['Support_Company']);
			array_push($data_Val,$row['CRQnum']);
		}
		
		sqlsrv_free_stmt( $stmt);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(draw_ChangeFor);
	
	function draw_ChangeFor(){
		var data = google.visualization.arrayToDataTable([           
			['Requesting Department', 'Number of Changes'],           
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] );     
		
		//drawPieChart
		var options = {           title: 'Non-Standard Authorized Changes'  , is3D: true  , chartArea:{left:40,top:30,width:"80%",height:"90%"}, slices: {0: {offset: 0.2}}};          
		var chart = new google.visualization.PieChart(document.getElementById('chart_div'));         
		chart.draw(data, options);       
	}
</script>   
	<table ><tr>
		<td class="iframe_td"><div id="chart_div" style="width: 350px; height: 300px;"></div>  </td>
		<tr><td> <a href="Reporter_home.php" style="margin-left: 20px" target="_blank">More..</a></td></tr>
	</tr>
	</table>
<?php sqlsrv_close( $conn ); ?>