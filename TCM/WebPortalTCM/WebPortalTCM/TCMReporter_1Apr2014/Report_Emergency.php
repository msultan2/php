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
		$sql = "SELECT  Top 10 Support_Company,Support_Organization,count(*) CRQnum
				FROM dbo.vw_Change_Approval_Details cap
				WHERE CRQ_Type = 'Normal'
				AND STATUS NOT IN ('Draft','Request For Authorization')
				--AND YEAR(Scheduled_Start_Date) >= 2013
				AND ( (DATEPART(hour, [First Approval Date]) > '14'
					AND dbo.DATEONLY( cap.[First Approval Date]) >= dbo.DATEONLY( dbo.udf_GetPrevNextWorkDay(cap.Scheduled_Start_Date, 'Previous'))   )
					OR	cap.Emergency = 0 )
				GROUP BY  Support_Company,Support_Organization
				ORDER BY  CRQnum DESC;	";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Total = array();
		$data_Val = array();
		$data_dept = array();
		$data_team = array();		
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_dept,$row['Support_Company']);
			array_push($data_team,$row['Support_Organization']);
			array_push($data_Val,$row['CRQnum']);
		}
		sqlsrv_free_stmt( $stmt);
		
		foreach ($data_team as &$team) {
			$sql = "SELECT  count(*) CRQnum
					FROM dbo.vw_Change_Approval_Details ch
					WHERE CRQ_Type = 'Normal'
					AND YEAR(Scheduled_Start_Date) >= 2013
					AND Support_Organization = '".$team."'
					AND STATUS NOT IN ('Draft','Request For Authorization')
			AND Support_Organization = '".$team."';";
			$stmt = sqlsrv_query( $conn, $sql );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			if (sqlsrv_fetch($stmt)=== false){
				die( print_r( sqlsrv_errors(), true));
			}	 
			array_push($data_Total,sqlsrv_get_field( $stmt, 0));
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
			['Department','Team', 'Emergency Changes', 'Total Changes','Emergency Percentage'],           
			<?php 
				//echo "[";
				for($i=0;$i<count($data_team); $i++) {             
						echo "['".$data_dept[$i]."','".$data_team[$i]."',".$data_Val[$i].",".$data_Total[$i].",'". round(($data_Val[$i]/$data_Total[$i])*100)."\%']"; 
						if ($i<count($data_team)-1) echo ",";	//add ',' to all except last element
					}  
				//echo "]";
			?>
			] ); 
			
		var dataChart = google.visualization.arrayToDataTable([   
			['Team', 'Percent of Emergency Changes'],
			<?php 
				for($i=0;$i<count($data_team); $i++) {             
						echo "['".$data_team[$i]."',". round(($data_Val[$i]/$data_Total[$i])*100) ."]"; 
						if ($i<count($data_team)-1) echo ",";	//add ',' to all except last element
					} 
			?>
			] ); 
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});       
		
		//drawPieChart
		var options = { title: 'Top 10 Exception Requesting Teams in 2013'  ,  chartArea:{left:200,top:40,bottom:20,width:"75%",height:"80%"}, colors:['darkgreen'], //vAxis: {maxValue:3, minValue:1},
						hAxis: {title: 'Top 10 Teams requesting Emergency Changes', titleTextStyle: {color: 'red'}, gridlines:{count:7}}  };          
		var chart = new google.visualization.BarChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td  class="iframe_td"><div id="chart_div" style="width: 600px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>