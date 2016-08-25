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
		$sql = "SELECT  CASE WHEN TT.Grade IN ('P1','P2') THEN 'P1 & P2'
					ELSE 'P3 & P4'
					END Severity, 
				CASE WHEN TT.Grade IN ('P1','P2') THEN 1
					ELSE 2
					END Severity_Order, 
					COUNT(vio.Incident_ID) Violated_TTs,
					COUNT(*) Total_TT
				FROM dbo.vw_SS_Remedy_TT_SLA_Assigned TT
			    LEFT OUTER JOIN dbo.[vw_SS_Remedy_TT_SLA_Assigned_Violated] vio
			    ON TT.Incident_ID = vio.Incident_ID
				WHERE TT.Outage = 'No'
				GROUP BY CASE WHEN TT.Grade IN ('P1','P2') THEN 'P1 & P2'
					ELSE 'P3 & P4'
					END, 
					CASE WHEN TT.Grade IN ('P1','P2') THEN 1
						ELSE 2
					END 
					ORDER BY 2;";
		$stmt = sqlsrv_query( $conn, $sql );
		
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val_P1P2 = 0;
		$data_Val_P3P4 = 0;
		$data_Val_P1P2_Total = 0;
		$data_Val_P3P4_Total = 0;
		$data_Val_P1P2_Per = 0;
		$data_Val_P3P4_Per = 0;
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['Severity']);
			//array_push($data_Val,$row['Total_TT']);
			if($row['Severity'] == 'P1 & P2') { 
				$data_Val_P1P2 = $row['Violated_TTs'];
				$data_Val_P1P2_Total = $row['Total_TT'];
				$data_Val_P1P2_Per = round(($data_Val_P1P2 / $data_Val_P1P2_Total)*100 ,0);
			}
			else if($row['Severity'] == 'P3 & P4') { 
				$data_Val_P3P4 = $row['Violated_TTs']; 
				$data_Val_P3P4_Total = $row['Total_TT'];
				$data_Val_P3P4_Per = round(($data_Val_P3P4 / $data_Val_P3P4_Total)*100 ,0);
			}	
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
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(draw_ChangeFor);
	
	function draw_ChangeFor(){
		var data = google.visualization.arrayToDataTable([  
			['Label', 'Value'],           
			<?php echo "['P1 & P2',". $data_Val_P1P2_Per."],['P3 & P4',". $data_Val_P3P4_Per."]";  
			?>
			] );     
		
		var dataTable = google.visualization.arrayToDataTable([      
			<?php 
					echo "['','P1 & P2','P3 & P4'],";
					echo "['Violated',".$data_Val_P1P2.",".$data_Val_P3P4 ."],"; 
					echo "['Total',".$data_Val_P1P2_Total.",".$data_Val_P3P4_Total ."],"; 
					echo "['Compliance %','".$data_Val_P1P2_Per."%','".$data_Val_P3P4_Per ."%']"; 
 
			?>
			] );  
		//drawGauge    
		var options = { redFrom: 0, redTo: 25, yellowFrom:25, yellowTo: 75, greenFrom: 75, greenTo: 100, minorTicks: 5, min:0, max:100, textStyle: {fontSize: 4},
						majorTicks:['0','25','50','75','100'],chartArea:{left:10,top:10,width:"60%",height:"90%"} }; //fontSize:2
		var chart = new google.visualization.Gauge(document.getElementById('chart_div'));         
		chart.draw(data, options);    

		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: false});  		
	}
</script>   
	<table ><tr>
		<td><div id="chart_div" style="width: 400px; height: 200px; float: middle"></div>  </td>
		<?php if($_GET['context']==='DVD'){ ?><td ><div id="table_div" style="width: 260px; height: 200px; float: middle"></div></td><?php } ?>
	</tr></table>
