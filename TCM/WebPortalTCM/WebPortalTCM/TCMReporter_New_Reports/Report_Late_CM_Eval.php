<link href="style_new.css" rel="stylesheet" type="text/css" />
<?php
		/* Parse configuration file */
		$ini_array = parse_ini_file("config.ini");
	
		/* Specify the server and connection string attributes. */

		$serverName = $ini_array['SERVER_NAME']; 
		$connectionInfo = array( "UID"=>$ini_array['DB_USER'],
								"PWD"=>$ini_array['DB_PASS'],
								"Database"=>$ini_array['DB_NAME']);

		if(isset($_GET['from'])) $getFrom = $_GET['from']; else $getFrom = '1/1/2013';
		echo 'Analysis From: '.$getFrom. "<BR> To Change  start date, add to the URL: ?from=12/31/2012";
			
		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}

		$sql = "SELECT approver,[Before CAB day] 'Before CAB day',[Before 2:30 PM] 'Before 2:30 PM',[After CAB meeting] 'After CAB meeting',[On same Scheduled Day] 'On same Scheduled Day',[After Scheduled Date] 'After Scheduled Date'
				  FROM (
				  SELECT approver,
				  CASE WHEN dbo.DATEONLY( ap.AppDateTime) < (dbo.DATEONLY( Scheduled_Start_Date) -1) THEN 'Before CAB day'
						WHEN DATEADD(day, -DATEDIFF(day, 0, ap.AppDateTime), ap.AppDateTime) <= '2:30:00 PM' AND (ap.AppDateTime <  Scheduled_Start_Date) THEN 'Before 2:30 PM'
						WHEN DATEADD(day, -DATEDIFF(day, 0, ap.AppDateTime), ap.AppDateTime) > '2:30:00 PM' AND (dbo.DATEONLY( ap.AppDateTime) = (dbo.DATEONLY( Scheduled_Start_Date) -1)) THEN 'After CAB meeting'
						WHEN (dbo.DATEONLY( ap.AppDateTime) = (dbo.DATEONLY( Scheduled_Start_Date)) AND ap.AppDateTime < Scheduled_Start_Date) THEN 'On same Scheduled Day'
						WHEN ap.AppDateTime >= Scheduled_Start_Date THEN 'After Scheduled Date'
				  END hourInterval--,ap.AppDateTime,Scheduled_Start_Date,ch.CRQ --
					, count(*) CRQnum
					from dbo.tbl_Splited_Approval_Audit_Trail ap LEFT OUTER JOIN dbo.tbl_Change_Approval_Details ch ON ap.CRQ=ch.CRQ
					where Approval_On_Behalf = 'CM_Eval'
					AND dbo.DATEONLY( AppDateTime) >= '".$getFrom."'
					AND ch.Emergency <> 0
					--AND dbo.DATEONLY( ap.AppDateTime) <= (dbo.DATEONLY( Scheduled_Start_Date) -1)
					--AND DATEADD(day, -DATEDIFF(day, 0, ap.AppDateTime), ap.AppDateTime) > '2:30:00 PM'
					and ch.Missing_Fields <> 0
					group by Approver,
						  CASE WHEN dbo.DATEONLY( ap.AppDateTime) < (dbo.DATEONLY( Scheduled_Start_Date) -1) THEN 'Before CAB day'
								WHEN DATEADD(day, -DATEDIFF(day, 0, ap.AppDateTime), ap.AppDateTime) <= '2:30:00 PM' AND (ap.AppDateTime <  Scheduled_Start_Date) THEN 'Before 2:30 PM'
								WHEN DATEADD(day, -DATEDIFF(day, 0, ap.AppDateTime), ap.AppDateTime) > '2:30:00 PM' AND (dbo.DATEONLY( ap.AppDateTime) = (dbo.DATEONLY( Scheduled_Start_Date) -1)) THEN 'After CAB meeting'
								WHEN (dbo.DATEONLY( ap.AppDateTime) = (dbo.DATEONLY( Scheduled_Start_Date)) AND ap.AppDateTime < Scheduled_Start_Date) THEN 'On same Scheduled Day'
								WHEN ap.AppDateTime >= Scheduled_Start_Date THEN 'After Scheduled Date'
						  END 
							) queryA
							PIVOT 
								( max(CRQnum)
									for hourInterval in ([Before CAB day],[Before 2:30 PM],[After CAB meeting] ,[On same Scheduled Day],[After Scheduled Date])
								) queryP  ";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		for ($i=0;$i<=4;$i++)
			$data_Desc[$i] = array();
		//$data_Val = array();
		$data_approver = array();		
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc[0],$row['Before CAB day']);
			array_push($data_Desc[1],$row['Before 2:30 PM']);
			array_push($data_Desc[2],$row['After CAB meeting']);
			array_push($data_Desc[3],$row['On same Scheduled Day']);
			array_push($data_Desc[4],$row['After Scheduled Date']);
			array_push($data_approver,$row['approver']);
			//array_push($data_Val,$row['CRQnum']);
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
			['Approver', 'Before CAB day','Before 2:30 PM','After CAB meeting' ,'On same Scheduled Day','After Scheduled Date','Total','Eval \%'],           
			<?php 
				for($i=0;$i<count($data_approver); $i++) {             
						$data_total = $data_Desc[0][$i]+$data_Desc[1][$i]+$data_Desc[2][$i]+$data_Desc[3][$i]+$data_Desc[4][$i];
						echo "['".$data_approver[$i]."',".$data_Desc[0][$i].",".$data_Desc[1][$i].",".$data_Desc[2][$i].",".$data_Desc[3][$i].",".$data_Desc[4][$i].",".
						$data_total.",'". round((($data_Desc[0][$i]+$data_Desc[1][$i])/$data_total)*100)." \%']"; 
						if ($i<count($data_approver)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] ); 
			
		var dataChart = google.visualization.arrayToDataTable([   
			['Approver', 'Before CAB day','Before 2:30 PM','After CAB meeting' ,'On same Scheduled Day','After Scheduled Date'],           
			<?php 
				for($i=0;$i<count($data_approver); $i++) {             
						echo "['".$data_approver[$i]."',".$data_Desc[0][$i].",".$data_Desc[1][$i].",".$data_Desc[2][$i].",".$data_Desc[3][$i].",".$data_Desc[4][$i]."]"; 
						if ($i<count($data_approver)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] ); 
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});       
		
		//drawPieChart
		var options = { title: 'CM Evaluation Approvals Analysis'  ,  chartArea:{left:60,top:40,bottom:120,width:"75%",height:"65%"}, 
						 //colors:['darkgreen'], //vAxis: {maxValue:3, minValue:1},
						hAxis: {title: 'CM Approver', titleTextStyle: {color: 'red'}, gridlines:{count:7}, slantedText:true}  };          
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td  class="iframe_td"><div id="chart_div" style="width: 650px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>