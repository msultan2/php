<?php session_start();  $pagePrivValue=50; require 'approve.php'; ?>
<link href="style_new.css" rel="stylesheet" type="text/css" />
<table><tr><td width="90%"><div class="body_text">Number of Changes per Day in the last 30 days </div></td>
<td align=right >
<?php 
		$sql = "SELECT DATENAME(dw,ch.Scheduled_Start_Date) weekDay , CONVERT(VARCHAR(10), dbo.dateOnly(ch.Scheduled_Start_Date), 103) 'myDay',dbo.dateOnly(ch.Scheduled_Start_Date),count(*) 'Normal',count(emergency_cap.CRQ) 'Exceptions' FROM dbo.tbl_Change_Approval_Details ch LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Normal' AND STATUS != 'Request For Authorization' AND ( (DATEADD(day, -DATEDIFF(day, 0, [First Approval Date]), [First Approval Date]) > '2:00:00 PM' AND dbo.DATEONLY( [First Approval Date]) >= (dbo.DATEONLY( Scheduled_Start_Date) -1)) OR Emergency = 0 )) emergency_cap ON ch.CRQ = emergency_cap.CRQ WHERE dbo.dateOnly(ch.Scheduled_Start_Date) BETWEEN dbo.dateOnly(getdate()) -30 AND dbo.dateOnly(getdate()) AND ch.CRQ_Type = 'Normal' AND ch.STATUS != 'Request For Authorization' GROUP BY DATENAME(dw,ch.Scheduled_Start_Date),CONVERT(VARCHAR(10), dbo.dateOnly(ch.Scheduled_Start_Date), 103),dbo.dateOnly(ch.Scheduled_Start_Date) ORDER BY dbo.dateOnly(ch.Scheduled_Start_Date);";
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		echo '<a href="excel.php?name=Daily&query='.$sql_encoded.'">';
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
		$data_weekDay = array(); 
		$data_date = array(); 
		$data_Val_Exceptions = array(); 		
		$data_Val_Normal = array();
		
		//Normal
		$sql = "SELECT DATENAME(dw,crq.Scheduled_Start_Date) weekDay , CONVERT(VARCHAR(10), dbo.dateOnly(crq.Scheduled_Start_Date), 103) 'myDay',dbo.dateOnly(crq.Scheduled_Start_Date),count(*) 'Normal',count(emergency_cap.CRQ) 'Exceptions'
				FROM dbo.vw_Change_Approval_Details crq 
				LEFT OUTER JOIN 
								  (SELECT crq FROM  dbo.vw_Change_Approval_Details ch
										LEFT OUTER JOIN dbo.vw_Change_Approvers_Merged ap ON ch.CRQ = ap.Infrastructure_Change_ID 
											WHERE CRQ_Type = 'Normal'
											AND STATUS != 'Request For Authorization'
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
					AND NOT (Description LIKE ('%fix%') OR Justification LIKE ('%fix%') OR Description LIKE ('%problem%') OR Justification LIKE ('%problem%') OR Description LIKE ('%solve%') OR Justification LIKE ('%solve%')) ) emergency_cap ON crq.CRQ = emergency_cap.CRQ 
				WHERE dbo.dateOnly(crq.Scheduled_Start_Date) BETWEEN dbo.dateOnly(getdate()) -30 AND dbo.dateOnly(getdate())
				AND crq.CRQ_Type = 'Normal'
				AND crq.STATUS != 'Request For Authorization'
				GROUP BY DATENAME(dw,crq.Scheduled_Start_Date),CONVERT(VARCHAR(10), dbo.dateOnly(crq.Scheduled_Start_Date), 103),dbo.dateOnly(crq.Scheduled_Start_Date)
				ORDER BY dbo.dateOnly(crq.Scheduled_Start_Date)";
		$stmt = sqlsrv_query( $conn, $sql );
		//echo $sql;
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Val_Normal , $row['Normal']);
			array_push($data_Val_Exceptions , $row['Exceptions']);
			array_push($data_weekDay , $row['weekDay']);
			array_push($data_date , $row['myDay']);
			//echo $row['myDay']."|";
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
			/*	['Week', 'Number of Changes'],
				['2 2013',1,2,3,4,5,6],
				['1 2013',2,1,3,5,6,4],
				['12 2012',5,4,3,1,2,6],
			*/
			['Day','Date', 'Normal Changes','Emergency Changes', 'Emergency %'],  
			<?php	for($i=0;$i<count($data_Val_Normal); $i++) {             
						echo "['".$data_weekDay[$i]."','".$data_date[$i]."',".$data_Val_Normal[$i].",".$data_Val_Exceptions[$i].", '". round(($data_Val_Exceptions[$i] / $data_Val_Normal[$i])*100)."\%' ]";
						if ($i<count($data_Val_Normal)-1) echo ",";	//add ',' to all except last element
					}
			?>           
			
			] ); 
		var dataChart = google.visualization.arrayToDataTable([           
			/*	['Week', 'Number of Changes'],
				['2 2013',1,2,3,4,5,6],
				['1 2013',2,1,3,5,6,4],
				['12 2012',5,4,3,1,2,6],
			*/
			['Day - Date', 'Normal Changes','Emergency Changes'], /*,'Annotation'],  */
			<?php	for($i=0;$i<count($data_Val_Normal); $i++) {             
						echo "['".substr($data_weekDay[$i],0,3)." ".$data_date[$i]."',".$data_Val_Normal[$i].",".$data_Val_Exceptions[$i]."]";
						if ($i<count($data_Val_Normal)-1) echo ",";	//add ',' to all except last element
					}
			?>           
			
			] );	
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});       
		
		//drawPieChart
		/*var options = { title: 'Weekly Changes Trend'  ,  chartArea:{left:60,top:30,width:"84%",height:"70%"}, vAxis: {gridlines:{count:8}}, //maxValue:3, minValue:1},
						hAxis: {title: 'Number of Changes per week', titleTextStyle: {color: 'red'}, gridlines:{count:6}} ,
						vAxes:[
{}, // Nothing specified for axis 0
{title:'Losses',textStyle:{color: 'red'}} // Axis 1
]};       */   

		var options = { title : 'Weekly Changes Trend',     
				chartArea:{left:60,top:30,width:"84%",height:"70%"},     
				vAxis: {gridlines:{count:8}},
				hAxis: {title: "Last 30 Days"},           
				curveType: 'function',
				seriesType: "bars",    'isStacked': false, 
				series: { 0: {type: "line",color:"green",curveType:'function' }} 
				
				//series:{0:{targetAxisIndex:1},3:{targetAxisIndex:1, type:"line"}}, 
				//vAxes:{1:{title:'Normal',textStyle:{color: 'yellow'}}}
				//,cht: 'lc', chds:'0,160', annotationColumns:[{column:2, size:12, type:'flag', priority:'high'}]

			};

		var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td class="iframe_td"><div id="chart_div" style="width: 1200px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
	<tr><td>
	<?php 

		$sql = "SELECT DATEPART(year,ch.Scheduled_Start_Date) 'YEAR',DATEPART(wk,ch.Scheduled_Start_Date) 'WEEK', CRQ_Type, count(*) Number_of_CRQs FROM  dbo.vw_Change_Approval_Details ch WHERE (DATEPART(wk,ch.Scheduled_Start_Date) <= DATEPART(wk,getdate()) OR DATEPART(year,ch.Scheduled_Start_Date) < DATEPART(year,getdate())) GROUP BY DATEPART(year,ch.Scheduled_Start_Date),DATEPART(wk,ch.Scheduled_Start_Date),CRQ_Type ORDER BY DATEPART(year,ch.Scheduled_Start_Date),DATEPART(wk,ch.Scheduled_Start_Date);";
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		$data_array_string = "";
		for ($i = 0; $i < count($data_arr); $i++){
			$data_array_string .= implode(",",$data_arr[$i]);
			$data_array_string .= ";";
			//echo $data_array_string."----";
		}
		//echo '<a href="excel_array.php?name=Weekly&array='.$data_array_string.'">Export to Excel</a> ';
	?>
	</td></tr>
</table>





