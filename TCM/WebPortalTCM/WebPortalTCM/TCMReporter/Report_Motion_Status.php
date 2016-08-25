<?php //session_start();  $pagePrivValue=50; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<table><tr><td width="90%"><div class="body_text">Statistics of Change Requests since 12 Aug 2012 </div></td>
<td align=right >
<?php 
		$sql = "SELECT cap.[Support_Company], YEAR(cap.Scheduled_Start_Date) year_,MONTH(cap.Scheduled_Start_Date) month_, count(*) CRQnum,Status FROM dbo.vw_Change_Approval_Details cap WHERE CRQ_Type = 'Normal' and dbo.dateOnly(cap.Scheduled_Start_Date) <= dbo.dateOnly(getdate()) GROUP BY cap.[Support_Company], YEAR(cap.Scheduled_Start_Date),MONTH(cap.Scheduled_Start_Date), Status";
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		echo '<a href="excel.php?name=Statistics&query='.$sql_encoded.'">';
	?>
<img width=24px height=24px src="images/excel.bmp" style="border-style: none"/></a>
</td></tr></table>
<?php // content="text/plain; charset=utf-8"

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
		$data_year = array(); 
		$data_dept = array(); 
		$data_month = array(); 		
		$data_day = array(); 	
		$data_Val = array(); 
		$data_Status = array(); 
	
	//$data_Val = array(); 
		$sql = "SELECT cap.[Support_Company], YEAR(cap.Scheduled_Start_Date) year_,MONTH(cap.Scheduled_Start_Date) month_, DAY(cap.Scheduled_Start_Date) day_, count(*) CRQnum,Status
			  FROM dbo.vw_Change_Approval_Details cap
			  WHERE Support_Company IN ('IT Operations', 'Network Engineering','Products & Services Delivery','Regional Operations','Service Management')
			  AND CRQ_Type = 'Normal' 
			  AND Status = 'Scheduled'
			  AND dbo.dateOnly(cap.Scheduled_Start_Date) <= dbo.dateOnly(getdate())
			  GROUP BY cap.[Support_Company], YEAR(cap.Scheduled_Start_Date),MONTH(cap.Scheduled_Start_Date), DAY(cap.Scheduled_Start_Date),Status";
			  
		$sql0 = "SELECT cap.[Support_Company], dbo.dateOnly(cap.Scheduled_Start_Date) chDate, count(*) CRQnum,Status
			  FROM dbo.vw_Change_Approval_Details cap
			  WHERE Support_Company IN ('IT Operations', 'Network Engineering','Products & Services Delivery','Regional Operations','Service Management')
			  AND CRQ_Type = 'Normal' 
			  AND Status = 'Scheduled'
			  AND dbo.dateOnly(cap.Scheduled_Start_Date) <= dbo.dateOnly(getdate())
			  GROUP BY cap.[Support_Company], dbo.dateOnly(cap.Scheduled_Start_Date), Status";
		$stmt = sqlsrv_query( $conn, $sql );
		//echo $sql;
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_year,$row['year_']);
			array_push($data_dept,$row['Support_Company']);
			array_push($data_month,$row['month_']);
			array_push($data_day,$row['day_']);
			array_push($data_Val,$row['CRQnum']);
			array_push($data_Status,$row['Status']);
		}
		
		sqlsrv_free_stmt( $stmt);
		
		$data_year_all = array(); 
		$data_month_all = array(); 
		$data_Val_ITOperations = array();
		$data_Val_NetworkEngineering = array();
		$data_Val_Products = array();
		$data_Val_Regional = array();
		$data_Val_NWOperations = array();
		//$data_Status = array(); 
	
	//$data_Val = array(); 
		$sql = "SELECT chMonth, chYear,[IT Operations] 'IT Operations',[Network Engineering] 'Network Engineering',[Products & Services Delivery] 'Products & Services Delivery',[Regional Operations] 'Regional Operations',[Service Management] 'Service Management'
			FROM(
			SELECT cap.[Support_Company], YEAR(cap.Scheduled_Start_Date) chYear,MONTH(cap.Scheduled_Start_Date) chMonth, count(*) CRQnum
						  FROM dbo.vw_Change_Approval_Details cap
						  WHERE Support_Company IN ('IT Operations', 'Network Engineering','Products & Services Delivery','Regional Operations','Service Management')
						  AND CRQ_Type = 'Normal' 
						  AND Status = 'Scheduled'
						  AND dbo.dateOnly(cap.Scheduled_Start_Date) <= dbo.dateOnly(getdate())
						  GROUP BY cap.[Support_Company], YEAR(cap.Scheduled_Start_Date),MONTH(cap.Scheduled_Start_Date)
				) queryA
			PIVOT 
				( max(CRQnum)
					for Support_Company in ([IT Operations],[Network Engineering],[Products & Services Delivery],[Regional Operations],[Service Management])
				) queryP 
				ORDER BY chYear,chMonth;";
		$sql0 = "SELECT cap.[Support_Company], YEAR(cap.Scheduled_Start_Date) year_,MONTH(cap.Scheduled_Start_Date) month_, count(*) CRQnum
			  FROM dbo.vw_Change_Approval_Details cap
			  WHERE Support_Company IN ('IT Operations', 'Network Engineering','Products & Services Delivery','Regional Operations','Service Management')
			  AND CRQ_Type = 'Normal' 
			  AND Status = 'Scheduled'
			  AND dbo.dateOnly(cap.Scheduled_Start_Date) <= dbo.dateOnly(getdate())
			  GROUP BY cap.[Support_Company], YEAR(cap.Scheduled_Start_Date),MONTH(cap.Scheduled_Start_Date);";

		$stmt = sqlsrv_query( $conn, $sql );
		//echo $sql;
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_year_all,$row['chYear']);
			array_push($data_Val_ITOperations,$row['IT Operations']);
			array_push($data_Val_NetworkEngineering,$row['Network Engineering']);
			array_push($data_Val_Products,$row['Products & Services Delivery']);
			array_push($data_Val_Regional,$row['Regional Operations']);
			array_push($data_Val_NWOperations,$row['Service Management']);
			array_push($data_month_all,$row['chMonth']);
		}
		
		sqlsrv_free_stmt( $stmt);
		
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load('visualization', '1', {'packages':['motionchart']}); 
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var data = new google.visualization.DataTable();         
		data.addColumn('string', 'Department');         
		data.addColumn('date', 'Date');         
		data.addColumn('number', 'Number of Changes');               
		data.addColumn('string', 'Status');         
		data.addRows([           
			/*	['Department', 'Month Year','Number of Changes','Status'],
				['IT Operations','2 2013',1,'Scheduled'],
				['IT Operations','1 2013',2,'Scheduled'],
				['IT Operations','12 2012',5,'Scheduled'],
				['Network Engineering','2 2013',10,'Scheduled'],
				['Network Engineering','1 2013',9,'Scheduled'],
				['Network Engineering','12 2012',15,'Scheduled']
			*/
			<?php	for($i=0;$i<count($data_dept); $i++) {             
						echo "['".$data_dept[$i]."', new Date (".$data_year[$i]."," . intval($data_month[$i] -1) .",".$data_day[$i]."), ".$data_Val[$i].",'".$data_Status[$i]."']";
						if ($i<count($data_dept)-1) echo ",";	//add ',' to all except last element
					}
			?>
			          
			
			] ); 
		var dataTable = new google.visualization.DataTable();                  
		dataTable.addColumn('string', 'Month');         
		dataTable.addColumn('number', 'IT Operations');     
		dataTable.addColumn('number', 'Network Engineering');
		dataTable.addColumn('number', 'Products & Services Delivery'); 
		dataTable.addColumn('number', 'Regional Operations'); 
		dataTable.addColumn('number', 'Service Management'); 
		dataTable.addRows([           
			<?php	for($i=0;$i<count($data_month_all); $i++) {             
						echo "['".date("F", mktime(0, 0, 0, $data_month_all[$i], 10))." ".$data_year_all[$i]."', ".$data_Val_ITOperations[$i].", ".$data_Val_NetworkEngineering[$i].", ".$data_Val_Products[$i].", ".$data_Val_Regional[$i].", ".$data_Val_NWOperations[$i]."]";
						if ($i<count($data_month_all)-1) echo ",";	//add ',' to all except last element
					}		
			?>
			          
			
			] ); 
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});       
		
		
		var options = {};
		options['width'] = 1000; 
		options['height'] = 400; 
		options['state'] = '{"orderedByX":true,"colorOption":"_UNIQUE_COLOR","yZoomedDataMax":230,"showTrails":false,"orderedByY":false,"yZoomedDataMin":0,"uniColorForNonSelected":false,"yLambda":1,"xZoomedIn":false,"iconType":"VBAR","xZoomedDataMin":0,"yZoomedIn":false,"xAxisOption":"_ALPHABETICAL","playDuration":15000,"yAxisOption":"2","sizeOption":"_UNISIZE","iconKeySettings":[],"xLambda":1,"nonSelectedAlpha":0.4,"xZoomedDataMax":5,"dimensions":{"iconDimensions":["dim0"]},"duration":{"timeUnit":"D","multiplier":1},"time":"2013-03-01"}';
		var chart = new google.visualization.MotionChart(document.getElementById('chart_div'));         
		chart.draw(data, options);       
	} 
</script>   
<table >
	<tr><td width="750px" class="iframe_td"><div id="chart_div" style="width: 750px; height: 450px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>
<?php include ("footer_new.php"); ?>




