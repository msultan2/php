<link href="style_new.css" rel="stylesheet" type="text/css" />
<table><tr><td><div class="body_text">Network Changes per Days of the Week </div></td>
<td align=right >
<?php 
		$sql = "SELECT DATENAME(dw,cap.Scheduled_Start_Date) 'Day', DATEPART(dw,cap.Scheduled_Start_Date) Day_num,count(normal_cap.CRQ) CRQ_normal,count(standard_cap.CRQ) CRQ_standard,count(emergency_cap.CRQ) CRQ_emergency FROM dbo.vw_Change_Approval_Details cap LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Normal') normal_cap ON cap.CRQ = normal_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Standard') standard_cap ON cap.CRQ = standard_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Normal' AND STATUS NOT IN ('Draft','Request For Authorization') AND ( (DATEADD(day, -DATEDIFF(day, 0, [First Approval Date]), [First Approval Date]) > '2:00:00 PM' AND dbo.DATEONLY( [First Approval Date]) >= (dbo.DATEONLY( Scheduled_Start_Date) -1) ) OR (DATEADD(day, -DATEDIFF(day, 0, Scheduled_Start_Date), Scheduled_Start_Date) <= '2:00:00 PM' AND DATEADD(day, -DATEDIFF(day, 0, Scheduled_Start_Date), Scheduled_Start_Date) >= '8:00:00 AM' ) )) emergency_cap ON cap.CRQ = emergency_cap.CRQ WHERE cap.ChangeFor = 'Network' GROUP BY DATENAME(dw,cap.Scheduled_Start_Date), DATEPART(dw,cap.Scheduled_Start_Date) ORDER BY DATEPART(dw,cap.Scheduled_Start_Date)";
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		//echo $sql;
		echo '<a href="excel.php?name=WeekDays_NW&query='.$sql_encoded.'">';
	?>
<img width=24px height=24px src="images/excel.bmp" style="border-style: none"/></a>
</td></tr></table>
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
		$sql = "SELECT DATENAME(dw,cap.Scheduled_Start_Date) 'Day', DATEPART(dw,cap.Scheduled_Start_Date) Day_num,
				count(normal_cap.CRQ) CRQ_normal,count(standard_cap.CRQ) CRQ_standard,count(emergency_cap.CRQ) CRQ_emergency 
				FROM dbo.vw_Change_Approval_Details cap LEFT OUTER JOIN 
				(SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Normal') normal_cap ON cap.CRQ = normal_cap.CRQ LEFT OUTER JOIN 
				(SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Standard') standard_cap ON cap.CRQ = standard_cap.CRQ LEFT OUTER JOIN 
				  (SELECT crq FROM  dbo.vw_Change_Approval_Details ch
							LEFT OUTER JOIN dbo.vw_Change_Approvers_Merged ap ON ch.CRQ = ap.Infrastructure_Change_ID 
							WHERE CRQ_Type = 'Normal'
							AND STATUS NOT IN ('Draft','Request For Authorization')
							AND CRQ_Type = 'Normal'
							AND (
						(( ch.Scheduled_Start_Date < '1/10/2014' AND	DATEADD(day, -DATEDIFF(day, 0, [First Approval Date]), [First Approval Date]) > '2:00:00 PM' 
							AND dbo.DATEONLY( [First Approval Date]) >= dbo.DATEONLY( dbo.udf_GetPrevNextWorkDay(ch.Scheduled_Start_Date, 'Previous'))   
						) 
						OR  
						(	ch.Scheduled_Start_Date >= '1/10/2014' AND 
							(dbo.DATEONLY( [First Approval Date]) >= dbo.DATEONLY( dbo.udf_GetPrevNextWorkDay(ch.Scheduled_Start_Date, 'Previous'))   
							AND NOT DATEADD(day, -DATEDIFF(day, 0, ch.Scheduled_Start_Date), ch.Scheduled_Start_Date) > '3:00:00 PM' 
							)  
							AND ap.[Approval Aduit Trail] like '%CM_Authorized%'
						)
					)
					OR    ( Emergency IN (2,3,0) ) ) 
					AND NOT (Description LIKE ('%fix%') OR Justification LIKE ('%fix%') OR Description LIKE ('%problem%') OR Justification LIKE ('%problem%') OR Description LIKE ('%solve%') OR Justification LIKE ('%solve%')) ) emergency_cap ON cap.CRQ = emergency_cap.CRQ 
				WHERE cap.ChangeFor = 'Network'
				GROUP BY DATENAME(dw,cap.Scheduled_Start_Date), DATEPART(dw,cap.Scheduled_Start_Date)
				ORDER BY DATEPART(dw,cap.Scheduled_Start_Date)";
					
		//echo $sql;
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Day = array();
		$data_Val = array();
		$data_Val_Standard = array();
		$data_Val_Emergency = array();
		
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Day,$row['Day']);
			array_push($data_Val,$row['CRQ_normal']);
			array_push($data_Val_Standard,$row['CRQ_standard']);
			//array_push($data_total,$row['CRQ_normal']+$row['CRQ_standard']);
			array_push($data_Val_Emergency,$row['CRQ_emergency']);
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
			['Day','Standard Changes','Emergency Changes','Normal Changes','Total'],                
			<?php 
				for($i=0;$i<count($data_Day); $i++) {             
						echo "['".$data_Day[$i]."',".$data_Val_Standard[$i].",".$data_Val_Emergency[$i].",".$data_Val[$i].",".($data_Val[$i]+$data_Val_Standard[$i])."]"; 
						if ($i<count($data_Day)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] ); 
		var dataChart = google.visualization.arrayToDataTable([           
			['Day','Standard Changes','Emergency Changes','Normal Changes'],                
			<?php 
				for($i=0;$i<count($data_Day); $i++) {             
						echo "['".$data_Day[$i]."',".$data_Val_Standard[$i].",".$data_Val_Emergency[$i].",".$data_Val[$i]."]"; 
						if ($i<count($data_Day)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] );
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});       
		
		//drawPieChart
		var options = { title: 'Network Changes per week days'  ,  chartArea:{left:40,top:40,width:"70%",height:"70%"}, //legendTextStyle: {color:'#00FF00'}, //vAxis: {maxValue:3, minValue:1},
						vAxis: { gridlines:{count:10}} , is3D:true, 'isStacked':true , hAxis: {slantedText:true} };          
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td  class="iframe_td"><div id="chart_div" style="width: 440px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>