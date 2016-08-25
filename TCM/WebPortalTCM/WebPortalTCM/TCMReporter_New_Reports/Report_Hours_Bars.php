<link href="style_new.css" rel="stylesheet" type="text/css" />
<div class="body_text">Changes per Scheduled Start Hour </div>
<?php
		/* Parse configuration file */
		$ini_array = parse_ini_file("config.ini");
		
		/* Specify the server and connection string attributes. */

		$serverName = $ini_array['SERVER_NAME']; 
		$connectionInfo = array( "Database"=>$ini_array['DB_NAME']);

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$sql = "SELECT DATEPART(hour,ap.Scheduled_Start_Date) sc_hour,count(*) CRQnum
				FROM dbo.vw_Change_Approval_Details ap
				WHERE ap.CRQ_Type = 'Normal'
				GROUP BY DATEPART(hour,ap.Scheduled_Start_Date)
				ORDER BY DATEPART(hour,ap.Scheduled_Start_Date);";
					
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_hour = array();
		$data_Val = array();
		
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_hour,$row['sc_hour']);
			array_push($data_Val,$row['CRQnum']);
		}
		
		sqlsrv_free_stmt( $stmt);
?>
  
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataTable = google.visualization.arrayToDataTable([           
			['Scheduled Start Hour','Changes'],                
			<?php 
				for($i=0;$i<count($data_hour); $i++) {             
						echo "['".$data_hour[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_hour)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] ); 

			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});       
		
		//drawPieChart
		var options = { title: 'IT Changes per week days'  ,  chartArea:{left:40,top:40,width:"70%",height:"70%"}, //legendTextStyle: {color:'#00FF00'}, //vAxis: {maxValue:3, minValue:1},
						vAxis: { gridlines:{count:10}} , is3D:true, 'isStacked':true , hAxis: {slantedText:true} };          
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(dataTable, options);       
	} 
</script>   
	<table ><tr>
		<td><div id="chart_div" style="width: 300px; height: 200px;"></div>  </td>
	</tr>
	<tr>
		<td ><div id="table_div" style="width: 320px; height: 100px;" ></div>  </td>
	</tr></table>
<?php sqlsrv_close( $conn ); ?>