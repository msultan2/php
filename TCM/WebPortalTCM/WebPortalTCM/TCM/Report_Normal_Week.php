<?php // content="text/plain; charset=utf-8"

/* Specify the server and connection string attributes. */
		$serverName = "egzhr-wie2e01"; //10.230.95.87
		$connectionInfo = array( "Database"=>"SM_Change_Researching_DB");

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$data_year = array(); 
		$data_week = array(); 
		$data_Val_Normal = array(); 		
		$data_Val_Standard = array();
		$data_Val_Emergency = array();
		
		//Normal
		$sql = "select DATEPART(year,ch.Scheduled_Start_Date) year_,DATEPART(wk,ch.Scheduled_Start_Date) week_,count(*) CRQnum
				FROM dbo.vw_change_approval_details ch
				WHERE CRQ_Type = 'Normal'
				AND Status != 'Draft'
				AND (DATEPART(wk,ch.Scheduled_Start_Date) <= DATEPART(wk,getdate()) OR DATEPART(year,ch.Scheduled_Start_Date) < DATEPART(year,getdate()))
				GROUP BY DATEPART(year,ch.Scheduled_Start_Date),DATEPART(wk,ch.Scheduled_Start_Date)
				ORDER BY DATEPART(year,ch.Scheduled_Start_Date),DATEPART(wk,ch.Scheduled_Start_Date)";
		$stmt = sqlsrv_query( $conn, $sql );
		//echo $sql;
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Val_Normal , $row['CRQnum']);
			array_push($data_year , $row['year_']);
			array_push($data_week , $row['week_']);
		
		}
		sqlsrv_free_stmt( $stmt);
		
		//Standard
		$sql = "select DATEPART(year,ch.Scheduled_Start_Date) year_,DATEPART(wk,ch.Scheduled_Start_Date) week_,count(*) CRQnum
				FROM dbo.vw_change_approval_details ch
				WHERE CRQ_Type = 'Standard'
				AND Status != 'Draft'
				AND (DATEPART(wk,ch.Scheduled_Start_Date) <= DATEPART(wk,getdate()) OR DATEPART(year,ch.Scheduled_Start_Date) < DATEPART(year,getdate()))
				GROUP BY DATEPART(year,ch.Scheduled_Start_Date),DATEPART(wk,ch.Scheduled_Start_Date)
				ORDER BY DATEPART(year,ch.Scheduled_Start_Date),DATEPART(wk,ch.Scheduled_Start_Date)";
		$stmt = sqlsrv_query( $conn, $sql );
		//echo $sql;
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Val_Standard , $row['CRQnum']);
		}
		sqlsrv_free_stmt( $stmt);
		
		//Emergency
		$sql = "select DATEPART(year,ch.Scheduled_Start_Date) year_,DATEPART(wk,ch.Scheduled_Start_Date) week_,count(*) CRQnum
				FROM dbo.vw_change_approval_details ch
				WHERE CRQ_Type = 'Normal'
				AND Status != 'Draft'
				AND DATEADD(day, -DATEDIFF(day, 0, ch.[First Approval Date]), ch.[First Approval Date]) > '2:00:00 PM'
				AND dbo.DATEONLY( ch.[First Approval Date]) >= (dbo.DATEONLY( ch.Scheduled_Start_Date) -1)
				AND (DATEPART(wk,ch.Scheduled_Start_Date) <= DATEPART(wk,getdate()) OR DATEPART(year,ch.Scheduled_Start_Date) < DATEPART(year,getdate()))
				GROUP BY DATEPART(year,ch.Scheduled_Start_Date),DATEPART(wk,ch.Scheduled_Start_Date)
				ORDER BY DATEPART(year,ch.Scheduled_Start_Date),DATEPART(wk,ch.Scheduled_Start_Date)";
		$stmt = sqlsrv_query( $conn, $sql );
		//echo $sql;
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Val_Emergency , $row['CRQnum']);
		}
		sqlsrv_free_stmt( $stmt);
		
		$average = 0;
		for($i=0;$i<count($data_Val_Normal); $i++)
			$average += $data_Val_Normal[$i];
		
		$average = round($average/count($data_Val_Normal));
		
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {          
		var dataChart = google.visualization.arrayToDataTable([           
			/*	['Week', 'Number of Changes'],
				['2 2013',1,2,3,4,5,6],
				['1 2013',2,1,3,5,6,4],
				['12 2012',5,4,3,1,2,6],
			*/
			['Week - Year', 'Standard Changes','Normal Changes','Emergency Changes','Average of Normal Changes'],  
			<?php	for($i=0;$i<count($data_Val_Normal); $i++) {             
						echo "['".$data_week[$i]." - ".$data_year[$i]."',".$data_Val_Standard[$i].",".$data_Val_Normal[$i].",".$data_Val_Emergency[$i].",".$average."]";
						if ($i<count($data_Val_Normal)-1) echo ",";	//add ',' to all except last element
					}
			?>           
			
			] );	    
		
		//drawPieChart
		var options = { title: 'Weekly Changes Trend'  ,  chartArea:{left:40,top:30,width:"80%",height:"70%"}, vAxis: {gridlines:{count:8}}, //maxValue:3, minValue:1},
						hAxis: {title: 'Number of Changes per week', titleTextStyle: {color: 'red'}, gridlines:{count:6}}   };          
		var chart = new google.visualization.LineChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td class="iframe_td"><div id="chart_div" style="width: 800px; height: 450px;"></div>  </td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>





