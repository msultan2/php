<link href="style_new.css" rel="stylesheet" type="text/css" />
<?php // content="text/plain; charset=utf-8"

	$weekback = date('m/d/Y', time() + (60 * 60 * 24 * -7));
	$yesterday = date('m/d/Y', time() + (60 * 60 * 24 * -1));
	//echo $weekback." ".$yesterday;

	if(isset($_GET['from'])) $getFrom = $_GET['from']; else $getFrom = $weekback;
	if(isset($_GET['to'])) $getTo = $_GET['to']; else $getTo = $yesterday;
	
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
		$data_week = array(); 
		$data_Val_Normal = array(); 		
		$data_Val_Standard = array();
		$data_Val_Emergency = array();
		$data_Val_Total = array();
		
		//Normal
		$sql = "select DATEPART(year,ch.Scheduled_Start_Date) year_,DATEPART(wk,ch.Scheduled_Start_Date) week_,count(*) CRQnum
				FROM dbo.vw_change_approval_details ch
				WHERE CRQ_Type = 'Normal'
				AND STATUS NOT IN ('Draft','Request For Authorization')
				AND dbo.DateOnly(Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(Scheduled_Start_Date) >= '$getFrom'
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
				AND STATUS NOT IN ('Draft','Request For Authorization')
				AND dbo.DateOnly(Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(Scheduled_Start_Date) >= '$getFrom'
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
				AND STATUS NOT IN ('Draft','Request For Authorization')
				AND ( (DATEADD(day, -DATEDIFF(day, 0, [First Approval Date]), [First Approval Date]) > '2:00:00 PM'
								AND dbo.DATEONLY( [First Approval Date]) >= (dbo.DATEONLY( Scheduled_Start_Date) -1) ) 
							OR	Emergency = 0	 )
				AND dbo.DateOnly(Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(Scheduled_Start_Date) >= '$getFrom'
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
		sqlsrv_close( $conn );
		
		$average = 0;
		for($i=0;$i<count($data_Val_Normal); $i++){
			$average += $data_Val_Normal[$i];
			$data_Val_Total[$i] = $data_Val_Standard[$i]+$data_Val_Normal[$i];
		}
		
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
			['Week - Year', 'Standard Changes','Non-Standard Changes','Emergency Changes'], /*,'Annotation'],  */
			<?php	for($i=0;$i<count($data_Val_Normal); $i++) {             
						echo "['".$data_week[$i]." - ".$data_year[$i]."',".$data_Val_Standard[$i].",".$data_Val_Normal[$i].",".$data_Val_Emergency[$i]."]";
						//if ($data_week[$i]==1 && $data_year[$i]==2013) echo ",'Freeze']"; else echo ",'undefined']";
						if ($i<count($data_Val_Normal)-1) echo ",";	//add ',' to all except last element
					}
			?>           
			] );	
		var options = { title : 'Weekly Changes Trend',     
				chartArea:{left:60,top:30,width:"55%",height:"70%"},     
				vAxis: {gridlines:{count:8}},
				hAxis: {title: "Week", slantedText:true},           
				seriesType: "bars",    'isStacked': false, 
				series: { 1:{color:"green"},2:{color:"red"}, 3: {type: "area",color:"orange"}} 
				//series:{0:{targetAxisIndex:1},3:{targetAxisIndex:1, type:"line"}}, 
				//vAxes:{1:{title:'Normal',textStyle:{color: 'yellow'}}}
				//,cht: 'lc', chds:'0,160', annotationColumns:[{column:2, size:12, type:'flag', priority:'high'}]
			};

		var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td class="iframe_td"><div id="chart_div" style="width: 750px; height: 300px;"></div>  </td></tr>
	<tr><td> <a href="Report_Normal_Week.php" style="margin-left: 20px" target="_blank">More..</a></td></tr>
</table>






