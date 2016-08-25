<link href="style_new.css" rel="stylesheet" type="text/css" />
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
		$data_NW_Notif = array(); 
		$data_NW_Severity = array(); 
		$data_IT_Notif = array(); 		
		$data_IT_Severity = array();
		$data_Week = array();
		$data_All = array();
		

		$sql = "SET DATEFIRST 4;
				SELECT DATEPART(WEEK,inc.[Start Date]) 'Week',DATEPART(YEAR,inc.[Start Date]) 'Year',
					COUNT(NW_notif.[Problem ID]) 'NW Notification',COUNT(NW_sever.[Problem ID]) 'NW Severity',
					COUNT(IT_notif.[Problem ID]) 'IT Notification',COUNT(IT_sever.[Problem ID]) 'IT Severity',
					COUNT(*) 'ALL'
				FROM dbo.tbl_Incident_IDC inc 
						LEFT OUTER JOIN 
						   ( select * from dbo.tbl_Incident_IDC WHERE Category NOT IN ('IT Incident') AND ( NOT ( ( Notes_Serverity_SMS like '%Orange/%' OR Notes_Serverity_SMS like '%Yellow/%' OR Notes_Serverity_SMS like '%Red/%' )
								OR  ( Severity like '%Orange%' OR Severity like '%Yellow%' OR Severity like '%Red%' ) )OR Notes_Serverity_SMS IS NULL) ) NW_notif
						  ON inc.[Problem ID] = NW_notif.[Problem ID] 
						LEFT OUTER JOIN 
						   ( select * from dbo.tbl_Incident_IDC WHERE Category NOT IN ('IT Incident') AND ( ( Notes_Serverity_SMS like '%Orange/%' OR Notes_Serverity_SMS like '%Yellow/%' OR Notes_Serverity_SMS like '%Red/%' )
								OR  ( Severity like '%Orange%' OR Severity like '%Yellow%' OR Severity like '%Red%' ) ) ) NW_sever
						  ON inc.[Problem ID] = NW_sever.[Problem ID]
						LEFT OUTER JOIN 
						   ( select * from dbo.tbl_Incident_IDC WHERE Category IN ('IT Incident') AND ( NOT ( ( Notes_Serverity_SMS like '%Orange/%' OR Notes_Serverity_SMS like '%Yellow/%' OR Notes_Serverity_SMS like '%Red/%' )
								OR  ( Severity like '%Orange%' OR Severity like '%Yellow%' OR Severity like '%Red%' ) )OR Notes_Serverity_SMS IS NULL) ) IT_notif
						  ON inc.[Problem ID] = IT_notif.[Problem ID] 
						LEFT OUTER JOIN 
						   ( select * from dbo.tbl_Incident_IDC WHERE Category IN ('IT Incident') AND ( ( Notes_Serverity_SMS like '%Orange/%' OR Notes_Serverity_SMS like '%Yellow/%' OR Notes_Serverity_SMS like '%Red/%' )
								OR  ( Severity like '%Orange%' OR Severity like '%Yellow%' OR Severity like '%Red%' ) ) ) IT_sever
						  ON inc.[Problem ID] = IT_sever.[Problem ID]
						  WHERE DATEPART(WEEK,inc.[Start Date]) >= DATEPART(WEEK,GETDATE()) - 6
						  AND DATEPART(YEAR,inc.[Start Date]) = DATEPART(YEAR,GETDATE()) 
						  GROUP BY DATEPART(WEEK,inc.[Start Date]),DATEPART(YEAR,inc.[Start Date])
						  ORDER BY DATEPART(YEAR,inc.[Start Date]) DESC, DATEPART(WEEK,inc.[Start Date]);";
				
				$stmt = sqlsrv_query( $conn, $sql );
				//echo $sql;
				if( $stmt === false) {
					die( print_r( sqlsrv_errors(), true) );
				}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				array_push($data_Week,"W ".$row['Week']);
				array_push($data_NW_Notif,$row['NW Notification']);		
				array_push($data_NW_Severity,$row['NW Severity']);		
				array_push($data_IT_Notif,$row['IT Notification']);		
				array_push($data_IT_Severity,$row['IT Severity']);		
				array_push($data_All,$row['ALL']);		
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
		var dataChart = google.visualization.arrayToDataTable([           
			/*	['Month', 'team1', 'team2','team3',..,'team10'],
				['2 2013',1,2,3,4,5,6],
				['1 2013',2,1,3,5,6,4],
				['12 2012',5,4,3,1,2,6],
			*/
			['Week',  'NW Notification','NW Severity','IT Notification','IT Severity','Total'],           
			<?php for($i=0;$i<count($data_Week); $i++) {             
						echo "['".$data_Week[$i]."',".$data_NW_Notif[$i].",".$data_NW_Severity[$i].",".$data_IT_Notif[$i].",".$data_IT_Severity[$i].",".$data_All[$i]."]"; 
						if ($i<count($data_Week)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] );
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataChart, {showRowNumber: true});       
		
		//drawPieChart
		var options = { title: 'Incidents due to Changes (IDCs)'  ,  chartArea:{left:40,top:40,width:"75%",height:"75%"}, vAxis: {gridlines:{count:6}}, //maxValue:3, minValue:1},
						hAxis: {title: 'Weekly IDC', titleTextStyle: {color: 'red'},  gridlines:{count:6}} 
						//remove next 2 lines to remove Combo settings
						,seriesType: "bars",    
						series: { 4:{type: "area",color:"gray"}} };          
		var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td class="iframe_td" width="700px" height="400px">
		<div id="chart_div" style="width: 700px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" style="width: 700px;"></div></td></tr>
</table>





