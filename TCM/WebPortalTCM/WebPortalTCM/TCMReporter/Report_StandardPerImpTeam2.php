<link href="style_new.css" rel="stylesheet" type="text/css" />
<table><tr><td width="90%"><div class="body_text">Authorized Standard Changes per Implementing Team </div></td>
<td align=right >
<?php 
		$sql = "SELECT YEAR(cap.Scheduled_Start_Date) Scheduled_year,MONTH(cap.Scheduled_Start_Date) AS Scheduled_month,tsk.Assignee_Organization, count(*) CRQnum FROM  dbo.vw_Change_Approval_Details cap,dbo.tbl_Change_Task_Merged tsk WHERE cap.CRQ = tsk.Request_ID AND cap.Status NOT IN ('Draft', 'Request For Authorization') AND cap.CRQ_Type = 'Standard' GROUP BY YEAR(cap.Scheduled_Start_Date),MONTH(cap.Scheduled_Start_Date),tsk.Assignee_Organization ORDER BY YEAR(cap.Scheduled_Start_Date),MONTH(cap.Scheduled_Start_Date),tsk.Assignee_Organization;";
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		echo '<a href="excel.php?name=Monthly_Standard_Implemented&query='.$sql_encoded.'">';
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
		$array_teams = array(); 
		$data_Val = array(); 
		$data_Date = array(); 		
		$sql_teams="SELECT TOP 5 tsk.Assignee_Organization team, count(*) CRQnum
					FROM  dbo.vw_Change_Approval_Details cap,dbo.tbl_Change_Task_Merged tsk
					WHERE cap.CRQ = tsk.Request_ID
					AND cap.Scheduled_Start_Date <= getdate() AND cap.Scheduled_Start_Date >= '1/1/2013'
					AND cap.Status NOT IN ('Draft', 'Request For Authorization')
					AND cap.CRQ_Type = 'Standard'
					GROUP BY tsk.Assignee_Organization
					ORDER BY CRQnum DESC;";
		$stmt_teams = sqlsrv_query( $conn, $sql_teams );
			if( $stmt_teams === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			while( $row = sqlsrv_fetch_array( $stmt_teams, SQLSRV_FETCH_ASSOC) ) {
				  array_push($array_teams, $row['team']);
			}
			sqlsrv_free_stmt( $stmt_teams);
		
			//$data_Val = array(); 
		foreach ($array_teams as &$team) {
			$data_Val[$team] = array();
			$m = $ini_array['NUM_OF_MONTHS'] - 1; //7;
			for ($i=0; $i < $ini_array['NUM_OF_MONTHS']; $i++) {
				$sql = "SELECT YEAR(cap.Scheduled_Start_Date) Scheduled_year,MONTH(cap.Scheduled_Start_Date) AS Scheduled_month,tsk.Assignee_Organization, count(*) CRQnum
					FROM  dbo.vw_Change_Approval_Details cap,dbo.tbl_Change_Task_Merged tsk
					WHERE cap.CRQ = tsk.Request_ID
					AND tsk.Assignee_Organization = '".$team."'
					AND dbo.dateOnly(cap.Scheduled_Start_Date) BETWEEN dbo.dateOnly(DATEADD(month,-$m,getdate()-(DATEPART(d,getdate()) - 1)))
						AND DATEADD(second,-1,dbo.dateOnly(DATEADD(month,-$m+1,getdate()-(DATEPART(d,getdate()) - 1))))
					AND cap.Status NOT IN ('Draft', 'Request For Authorization')
					AND cap.CRQ_Type = 'Standard'
					GROUP BY YEAR(cap.Scheduled_Start_Date),MONTH(cap.Scheduled_Start_Date),tsk.Assignee_Organization;";
				$stmt = sqlsrv_query( $conn, $sql );
				//echo $sql;
				if( $stmt === false) {
					die( print_r( sqlsrv_errors(), true) );
				}
				if ( sqlsrv_fetch($stmt) === false){
					die( print_r( sqlsrv_errors(), true));
				}
				$year = sqlsrv_get_field( $stmt, 0);
				$month = sqlsrv_get_field( $stmt, 1);
				$numof_CRQs = sqlsrv_get_field( $stmt, 3);
				//$data_month = date("F", mktime(0, 0, 0, $month, 10))." ".$year;
				$data_month = substr(date("F", strtotime("-$m month")),0,3).' '.date("Y", strtotime("-$m month"));
				$data_Val[$team][$data_month] = $numof_CRQs;
				$data_Date[$i] = $data_month;
				sqlsrv_free_stmt( $stmt);
				
				$m = $m -1;
			}
			
			
		}
		
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataTable = google.visualization.arrayToDataTable([           
			/*	['Month', 'team1', 'team2','team3',..,'team10'],
				['2 2013',1,2,3,4,5,6],
				['1 2013',2,1,3,5,6,4],
				['12 2012',5,4,3,1,2,6],
			*/
			['Month',  
			<?php	for($i=0;$i<count($array_teams); $i++) {             
						echo "'".$array_teams[$i]."'";
						if ($i<count($array_teams)-1) echo ",";	//add ',' to all except last element
					}
			?>
			],           
			<?php 
				$i=0;
				foreach ($data_Date as &$month) {             
					echo "['".$month."',"; 
					$j=0;
					foreach ($array_teams as &$dept) {            
						echo $data_Val[$dept][$month]; 
						if ($j<count($array_teams)-1) echo ",";	
						$j=$j+1;
					}
					echo "]";
					if ($i<count($data_Date)-1) echo ",";	//add ',' to all except last element
					$i=$i+1;
				}
			?>
			] ); 
					
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});       
		
		//drawPieChart
		var options = { title: 'Standard Changes'  ,  chartArea:{left:40,top:30,width:"70%",height:"70%"}, vAxis: {gridlines:{count:8}}, //maxValue:3, minValue:1},
						hAxis: {title: 'Number of Standard Scheduled Changes by top 5 Implementing Teams', titleTextStyle: {color: 'red'}, gridlines:{count:6}}   };          
		var chart = new google.visualization.LineChart(document.getElementById('chart_div'));         
		chart.draw(dataTable, options);       
	} 
</script>   
<table >
	<tr><td width="650px" class="iframe_td"><div id="chart_div" style="width: 650px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>





