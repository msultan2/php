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
		
		$data_First_Name = array();
		$data_Last_Name = array();
		$data_Count = array();
		$data_Missing_Fields = array();	
		
		$sql = "SELECT COUNT(CRQ) COUNT,
			CASE 
			WHEN Missing_Fields = 0 THEN 'Missing fields'
			WHEN Missing_Fields != 0  THEN 'No missing fields'
			END 'Missing_Fields'
			FROM dbo.vw_Change_Approval_Details_Ver7_6 CCM
			WHERE Scheduled_Start_Date >= DATEADD(day,-7, GETDATE())
			AND ChangeFor is not null
			AND CRQ_Type = 'Normal'
			GROUP BY CASE 
			WHEN Missing_Fields = 0 THEN 'Missing fields'
			WHEN Missing_Fields != 0  THEN 'No missing fields'
			END";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}


		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			
			array_push($data_Count,$row['COUNT']);
			array_push($data_Missing_Fields,$row['Missing_Fields']);

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
				['Missing_Fields','Count'],
				
				<?php 
				for($i=0;$i<count($data_Count); $i++) 
				{ 
					echo "['".$data_Missing_Fields[$i]."',".$data_Count[$i]."]";
					if ($i<count($data_Count)-1) echo ",";	//add ',' to all except last element
				}
			?>
			] );
			
			var dataChart = google.visualization.arrayToDataTable([   
				['Missing_Fields','Count'],
				
				<?php 
				for($i=0;$i<count($data_Count); $i++) 
				{ 
					echo "['".$data_Missing_Fields[$i]."',".$data_Count[$i]."]";
					if ($i<count($data_Count)-1) echo ",";	//add ',' to all except last element
				}
			?>
			] );
			
			
		//drawTable
		var options = {           title: 'CRQs Requested per Domain'  , is3D: true  , chartArea:{left:60,top:40,width:"20%",height:"80%"} , 'isStacked':false,
									colors:['green','royalblue','orange'] };          
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
		
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: false}); 
		table.draw(dataTable, {allowHtml: true});      
	} 
</script>   
	<table ><tr>
		<td class="iframe_td"><div id="chart_div" style="width: 1000px; height: 400px;"></div>  </td>
	</tr><tr>
		<td><div id="table_div" style="width: 500px;"></div></td>
	</tr>
</table>
<?php sqlsrv_close( $conn ); ?>

