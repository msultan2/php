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
		
		$data_Coordinator = array();
		$data_Count = array();
		$data_Start_Date = array();	
		$data_Submit_Date = array();
		$data_Time = array();	
		
		$sql = "SELECT COUNT(PAN_No) COUNT
			,CASE 
			WHEN DATEPART(HOUR, Submit_Date) <= 14 THEN 'Before 2'
			WHEN DATEPART(HOUR, Submit_Date) > 14  THEN 'After 2'
			END 'Time'
			FROM dbo.tbl_Change_Change_Merged_Ver7_6
			WHERE PAN_no is not null
			AND lower(ChangeFor) IS NULL
			AND Submit_Date < Scheduled_Start_Date
			AND Scheduled_Start_Date >= DATEADD(day,-7, GETDATE())
			GROUP BY CASE 
			WHEN DATEPART(HOUR, Submit_Date) <= 14 THEN 'Before 2'
			WHEN DATEPART(HOUR, Submit_Date) > 14  THEN 'After 2'
			END;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}


		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Coordinator,$row['Change_Coordinator']);
			array_push($data_Count,$row['COUNT']);
			array_push($data_Time,$row['Time']);

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
		var dataTable = google.visualization.arrayToDataTable([   
				['Change_Coordinator','COUNT','Time'],
				
		<?php 
				for($i=0;$i<count($data_Count); $i++) 
				{ 
					echo "['".$data_Coordinator[$i]."',".$data_Count[$i].",'".$data_Time[$i]."']";
					if ($i<count($data_Count)-1) echo ",";	//add ',' to all except last element
				}
			?>
			
			] );
			var dataChart = google.visualization.arrayToDataTable([           
			['Time','Count'],
				
			<?php 
				for($i=0;$i<count($data_Count); $i++) 
				{ 
					echo "['".$data_Time[$i]."',".$data_Count[$i]."]";
					if ($i<count($data_Count)-1) echo ",";	//add ',' to all except last element
				}
			?>
			
			] ); 
		//drawTable
		var options = {           title: 'CRQs Requested per Domain'  , is3D: true  , chartArea:{left:60,top:40,width:"20%",height:"80%"} , 'isStacked':false,
									colors:['green','royalblue','orange'] };  
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);
		
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});       
		
		var view = new google.visualization.DataView(dataTable);
		view.setColumns([0, 
						1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" }]);      
	} 
</script>   
	<table ><tr>
		<td class="iframe_td"><div id="chart_div" style="width: 1000px; height: 400px;"></div>  </td>
	</tr><tr>
		<td><div id="table_div" style="width: 500px;"></div></td>
	</tr>
</table>
<?php sqlsrv_close( $conn ); ?>

