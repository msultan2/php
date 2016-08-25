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
		$sql = "SELECT  COUNT(PAN_No) COUNT,
			CASE WHEN DATEPART(HOUR, Submit_Date) <= 14 THEN 'Before 2'
			WHEN DATEPART(HOUR, Submit_Date) > 14  THEN 'After 2'
			END 'Time'
			FROM dbo.tbl_Change_Change_Merged_Ver7_6
			WHERE PAN_no is not null
			AND lower(ChangeFor) IS NULL
			AND Submit_Date < Scheduled_Start_Date
			AND Scheduled_Start_Date >= DATEADD(day,-7, GETDATE())
			GROUP BY CASE WHEN DATEPART(HOUR, Submit_Date) <= 14 THEN 'Before 2'
			WHEN DATEPART(HOUR, Submit_Date) > 14  THEN 'After 2'
			END;";
					
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		//$data_Coordinator = array();
		$data_Count = array();
		//$data_Start_Date = array();	
		//$data_Submit_Date = array();
		$data_Time = array();
		
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			//array_push($data_Coordinator,$row['Change_Coordinator']);
			array_push($data_Count,$row['COUNT']);
			//array_push($data_Start_Date,$row['Scheduled_Start_Date']);
			//array_push($data_Submit_Date,$row['Submit_Date']);
			array_push($data_Time,$row['Time']);
		}
		
		sqlsrv_free_stmt( $stmt);
?>
  
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		
		var dataChart = google.visualization.arrayToDataTable([           
			['Time','Count'],                
			<?php 
				for($i=0;$i<count($data_Count); $i++) {             
						echo "['".$data_Time[$i]."',".$data_Count[$i]."]"; 
						if ($i<count($data_Count)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] ); 
			
		var dataTable = google.visualization.arrayToDataTable([           
			['Time','Count'],                
			<?php 
				for($i=0;$i<count($data_Count); $i++) {             
						echo "['".$data_Time[$i]."',".$data_Count[$i]."]"; 
						if ($i<count($data_Count)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] ); 

		var options = {           title: 'Planned Activities Timings'  , is3D: true  , chartArea:{left:60,top:40,width:"50%",height:"80%"} , 'isStacked':false,
									colors:['green','royalblue','orange'] };          
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       	
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});       
		
		//drawPieChart
		
		//chart.draw(dataTable, options);       
	} 
</script>   
	<table ><tr>
		<td><div id="chart_div" style="width: 300px; height: 300px;"></div>  </td>
	</tr>
	<tr></tr>
	<tr>
		<td ><div id="table_div" style="width: 320px; height: 300px;" ></div>  </td>
	</tr></table>