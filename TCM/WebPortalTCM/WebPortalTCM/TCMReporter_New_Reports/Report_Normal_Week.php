<?php session_start();  $pagePrivValue=50; require 'approve.php'; ?>
<?php include 	("newtemplate.php"); ?>
<table><tr><td width="90%"><div class="body_text">Number of Changes per Week since 12 Aug 2012 </div></td>
<td align=right >
<?php 
		$sql = "SELECT DATEPART(year,ch.Scheduled_Start_Date) 'YEAR',DATEPART(wk,ch.Scheduled_Start_Date) 'WEEK', CRQ_Type, count(*) Number_of_CRQs FROM  dbo.vw_Change_Approval_Details ch WHERE STATUS NOT IN ('Draft','Request For Authorization') AND (DATEPART(wk,ch.Scheduled_Start_Date) <= DATEPART(wk,getdate()) OR DATEPART(year,ch.Scheduled_Start_Date) < DATEPART(year,getdate())) GROUP BY DATEPART(year,ch.Scheduled_Start_Date),DATEPART(wk,ch.Scheduled_Start_Date),CRQ_Type ORDER BY DATEPART(year,ch.Scheduled_Start_Date),DATEPART(wk,ch.Scheduled_Start_Date);";
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		echo '<a href="excel.php?name=Weekly&query='.$sql_encoded.'">';
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
		$data_week = array(); 
		$data_Val_Normal = array(); 		
		$data_Val_Standard = array();
		$data_Val_Emergency = array();
		$data_Val_Total = array();
		
		//Normal
		$sql = "SELECT DATEPART(year,ch.Scheduled_Start_Date) year_,DATEPART(wk,ch.Scheduled_Start_Date) week_,count(*) CRQnum
				FROM dbo.vw_change_approval_details ch
				WHERE CRQ_Type = 'Normal'
				AND STATUS NOT IN ('Draft','Request For Authorization')
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
		$sql = "SELECT DATEPART(year,ch.Scheduled_Start_Date) year_,DATEPART(wk,ch.Scheduled_Start_Date) week_,count(*) CRQnum
				FROM dbo.vw_change_approval_details ch
				WHERE CRQ_Type = 'Standard'
				AND STATUS NOT IN ('Draft','Request For Authorization')
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
		$sql0 = "select DATEPART(year,ch.Scheduled_Start_Date) year_,DATEPART(wk,ch.Scheduled_Start_Date) week_,count(*) CRQnum
				FROM dbo.vw_change_approval_details ch
				WHERE CRQ_Type = 'Normal'
				AND STATUS NOT IN ('Draft','Request For Authorization')
				AND ( (DATEADD(day, -DATEDIFF(day, 0, [First Approval Date]), [First Approval Date]) > '2:00:00 PM'
								AND dbo.DATEONLY( [First Approval Date]) >= (dbo.DATEONLY( Scheduled_Start_Date) -1) ) 
							OR	Emergency = 0	 )
				AND (DATEPART(wk,ch.Scheduled_Start_Date) <= DATEPART(wk,getdate()) OR DATEPART(year,ch.Scheduled_Start_Date) < DATEPART(year,getdate()))
				GROUP BY DATEPART(year,ch.Scheduled_Start_Date),DATEPART(wk,ch.Scheduled_Start_Date)
				ORDER BY DATEPART(year,ch.Scheduled_Start_Date),DATEPART(wk,ch.Scheduled_Start_Date)";
				
		$sql = "SELECT DATEPART(year,ch.Scheduled_Start_Date) year_,DATEPART(wk,ch.Scheduled_Start_Date) week_,count(*) CRQnum
				FROM dbo.vw_change_approval_details ch
				LEFT OUTER JOIN dbo.vw_Change_Approvers_Merged ap ON ch.CRQ = ap.Infrastructure_Change_ID 
				WHERE CRQ_Type = 'Normal'
				AND STATUS NOT IN ('Draft','Request For Authorization')
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
					AND NOT (Description LIKE ('%fix%') OR Justification LIKE ('%fix%') OR Description LIKE ('%problem%') OR Justification LIKE ('%problem%') OR Description LIKE ('%solve%') OR Justification LIKE ('%solve%'))
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
		var dataTable = google.visualization.arrayToDataTable([           
			/*	['Week', 'Number of Changes'],
				['2 2013',1,2,3,4,5,6],
				['1 2013',2,1,3,5,6,4],
				['12 2012',5,4,3,1,2,6],
			*/
			['Week','Year', 'Standard Changes','Normal Changes','Emergency (Normal) Changes', 'Emergency %','Total'],  
			<?php	for($i=0;$i<count($data_Val_Normal); $i++) {             
						echo "['".$data_week[$i]."','".$data_year[$i]."',".$data_Val_Standard[$i].",".$data_Val_Normal[$i].",".$data_Val_Emergency[$i].", '". round(($data_Val_Emergency[$i] / $data_Val_Normal[$i])*100)."\%' ,".$data_Val_Total[$i]."]";
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
			['Week - Year', 'Standard Changes','Normal Changes','Emergency Changes','Total'], /*,'Annotation'],  */
			<?php	for($i=0;$i<count($data_Val_Normal); $i++) {             
						echo "['".$data_week[$i]." - ".$data_year[$i]."',".$data_Val_Standard[$i].",".$data_Val_Normal[$i].",".$data_Val_Emergency[$i].",".$data_Val_Total[$i]."]";
						//if ($data_week[$i]==1 && $data_year[$i]==2013) echo ",'Freeze']"; else echo ",'undefined']";
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
				hAxis: {title: "Week"},           
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
	<tr><td class="iframe_td"><div id="chart_div" style="width: 1200px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
	<tr><td>
	<?php 
	$data_arr = array( array('Week','Year', 'Standard_Changes','Normal_Changes','Emergency_(Normal)_Changes','Total'),
				array("33","2012",1,62,29,63),
				array("34","2012",287,62,35,349),
				array("35","2012",127,98,40,225),
				array("36","2012",1240,108,45,1348),
				array("37","2012",364,127,60,491),
				array("38","2012",458,144,75,602),
				array("39","2012",843,135,45,978),
				array("40","2012",579,113,34,692),
				array("41","2012",604,168,42,772),
				array("42","2012",405,176,36,589) );
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
<?php sqlsrv_close( $conn ); ?>
<?php include ("footer_new.php"); ?>





