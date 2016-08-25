<link href="style_new.css" rel="stylesheet" type="text/css" />
<table><tr><td width="100%"><div class="body_text">Number of Changes & Incidents per Month since 12 Aug 2012 </div></td>
<td align=right >
<?php 
		$sql = "SELECT DATEPART(year,ch.Scheduled_Start_Date) 'YEAR',DATEPART(wk,ch.Scheduled_Start_Date) 'WEEK', CRQ_Type, count(*) Number_of_CRQs FROM  dbo.vw_Change_Approval_Details ch WHERE (DATEPART(wk,ch.Scheduled_Start_Date) <= DATEPART(wk,getdate()) OR DATEPART(year,ch.Scheduled_Start_Date) < DATEPART(year,getdate())) GROUP BY DATEPART(year,ch.Scheduled_Start_Date),DATEPART(wk,ch.Scheduled_Start_Date),CRQ_Type ORDER BY DATEPART(year,ch.Scheduled_Start_Date),DATEPART(wk,ch.Scheduled_Start_Date);";
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		echo '<a href="excel.php?name=Weekly&query='.$sql_encoded.'">';
	?>
<!--img width=24px height=24px src="images/excel.bmp" style="border-style: none"/--></a>
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
		$data_month = array(); 
		$data_Val_Standard_noCM = array(); 
		$data_Desc = array();
		
		//Standard with no CM Process
		$sql = "SELECT YEAR(ap.Scheduled_Start_Date) year_,MONTH(ap.Scheduled_Start_Date) month_,Product_Categorization_Tier_1 tier,count(*) CRQnum
				FROM vw_Change_Approval_Details ap   
        WHERE ap.Product_Categorization_Tier_1 IN ( select innq.Product_Categorization_Tier_1 FROM (SELECT TOP 10 cap.Product_Categorization_Tier_1,count(*) CRQnum
					FROM  dbo.vw_Change_Approval_Details cap
					WHERE cap.Scheduled_Start_Date <= getdate() 
					AND cap.CRQ_Type = 'Standard'
					AND [First Approval Date] IS NULL
					AND Status <> 'Request For Authorization'
					GROUP BY cap.Product_Categorization_Tier_1
					ORDER BY CRQnum DESC) innq )
				GROUP BY YEAR(ap.Scheduled_Start_Date),MONTH(ap.Scheduled_Start_Date),ap.Product_Categorization_Tier_1
				ORDER BY YEAR(ap.Scheduled_Start_Date),MONTH(ap.Scheduled_Start_Date);";
		$stmt = sqlsrv_query( $conn, $sql );
		//echo $sql;
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$date1 = $row['month_']."-".$row['year_']; 
			$m = $row['month_'];
			$date = substr(date("F", mktime(0, 0, 0, $m, 10)),0,3).' '.$row['year_'];
			//$date = substr(date("F", strtotime("$m month")),0,3).' '.$row['year_'];
			//if($date != 'Aug 2012')
			array_push($data_month,$date);
			$data_Desc[$date] = $row['tier'];
			$data_Val_Standard_noCM[$date] = $row['CRQnum'];
			echo $date1."=".$date.' ';
			echo $row['tier']."=".$data_Desc[$date]."\n";
		}
		sqlsrv_free_stmt( $stmt);
		
		sqlsrv_close( $conn ); 
		
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	//google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         

		var dataChart_All = google.visualization.arrayToDataTable([           
				['Week', 'Tier','Number of Changes'],
				['2 2013','tt',12],
				['1 2013','tt',24],
				['12 2012','tt',52],
				['2 2013','tt1',12],
				['1 2013','tt1',24],
				['12 2012','tt1',52]
			/*
			['Month', 'Change Tier','Standard CRQs with no CM'], 
			<?php	for($i=0;$i<count($data_month); $i++) {     
						$month = $data_month[$i];
						echo "['".$data_month[$i]."','".$data_Desc[$month]."',".$data_Val_Standard_noCM[$month]."]";
						//if ($data_month[$i]==1 && $data_year[$i]==2013) echo ",'Freeze']"; else echo ",'undefined']";
						if ($i<count($data_month)-1) echo ",";	//add ',' to all except last element
					}
			?>           
			*/
			] );	

		//drawTable
		//var table = new google.visualization.Table(document.getElementById('table_div'));         
		//table.draw(dataTable, {showRowNumber: true});       

		var options = { title : 'Trend of Authorized Changes',     
				chartArea:{left:60,top:30,right:0,width:"85%",height:"60%"},     
				vAxis: {gridlines:{count:8}},
				hAxis: {title: "Month", slantedText: true},    
				//curveType: "function" ,
				'isSlanted': true , 
				legend:{position: 'bottom', textStyle: {color: 'blue', fontSize: 16}}
				//,cht: 'lc', chds:'0,160', annotationColumns:[{column:2, size:12, type:'flag', priority:'high'}]

			};

		var chart = new google.visualization.LineChart(document.getElementById('chart_div'));         
		chart.draw(dataChart_All, options);       
	} 
</script>   
<table >
	<tr><td class="iframe_td"><div id="chart_div" style="width: 900px; height: 500px;"></div>  </td></tr>
</table>




