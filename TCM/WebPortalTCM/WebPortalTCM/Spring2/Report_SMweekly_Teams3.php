<link href="style_new.css" rel="stylesheet" type="text/css" />
<?php
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
		// get Network CRQs both Normal & Standard from today till last week (ex: from yesterday Wednesday till last Thursday) 7 days
		$sql = "SELECT CASE WHEN tsk.Assignee_Company = 'Regional Operations' THEN 2
							WHEN tsk.Assignee_Company = 'Service Management' THEN 1
							ELSE 3 END TeamOrder,
					   CASE WHEN tsk.Assignee_Organization like 'SOC%' THEN 'SOC'
							WHEN tsk.Assignee_Organization = 'Network Information' THEN 'VAS & Payments'
							WHEN tsk.Assignee_Company = 'Service Management' THEN tsk.Assignee_Organization
							WHEN tsk.Assignee_Company = 'Regional Operations' THEN 'Regional Operations' 
							ELSE 'Others'
							END Team,count(DISTINCT normal.CRQ) Normal_CRQs,count(DISTINCT standard.CRQ) Standard_CRQs,count(DISTINCT ch.CRQ) Total
				FROM dbo.vw_Change_Approval_Details ch LEFT OUTER JOIN dbo.vw_Change_Task_Merged_New tsk ON ch.CRQ = tsk.Request_ID
				LEFT OUTER JOIN (select * from dbo.vw_Change_Approval_Details ch where ch.CRQ_Type = 'Normal') normal ON ch.CRQ = normal.CRQ
				LEFT OUTER JOIN (select * from dbo.vw_Change_Approval_Details ch where ch.CRQ_Type = 'Standard') standard ON ch.CRQ = standard.CRQ
				where ch.ChangeFor = 'Network'
				AND dbo.DateOnly(ch.Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(ch.Scheduled_Start_Date) >= '$getFrom'
				and ch.Status NOT IN ('Request For Authorization','Rejected','Cancelled')
				group by CASE WHEN tsk.Assignee_Company = 'Regional Operations' THEN 2
							WHEN tsk.Assignee_Company = 'Service Management' THEN 1
							ELSE 3 END,
						CASE WHEN tsk.Assignee_Organization like 'SOC%' THEN 'SOC'
							WHEN tsk.Assignee_Organization = 'Network Information' THEN 'VAS & Payments'
							WHEN tsk.Assignee_Company = 'Service Management' THEN tsk.Assignee_Organization
							WHEN tsk.Assignee_Company = 'Regional Operations' THEN 'Regional Operations'
							ELSE 'Others'
							END
				order by TeamOrder,Team;";
		$sql_temp = "SELECT CASE WHEN tsk.Assignee_Company = 'Regional Operations'  OR tsk.Assignee_Company like 'Access%' THEN 2
							WHEN tsk.Assignee_Organization = 'Network Management, Planning & Support' OR tsk.Assignee_Organization like 'E2E%' THEN 3 
							  WHEN tsk.Assignee_Company = 'Service Management' THEN 1
							  ELSE 3 END TeamOrder,
									   CASE WHEN tsk.Assignee_Organization = 'Network Information' THEN 'VAS & Payments'
											WHEN tsk.Assignee_Organization = 'Mobile Internet & Enterprise' THEN 'Data'
											WHEN tsk.Assignee_Organization = 'Charging IN & Mediation' THEN 'Charging'
											WHEN tsk.Assignee_Organization like 'SOC%' THEN 'SOC'
											WHEN tsk.Assignee_Organization = 'Transport  & MTX SM' THEN 'Transport'
											WHEN tsk.Assignee_Organization = 'Voice SM' THEN 'Voice'
											WHEN tsk.Assignee_Company = 'Regional Operations' THEN 'Regional Ops'
							  WHEN tsk.Assignee_Company like 'Access%' THEN 'Regional Ops'
											ELSE 'Others'
											END Team,count(DISTINCT normal.CRQ) Normal_CRQs,count(DISTINCT standard.CRQ) Standard_CRQs,count(DISTINCT ch.CRQ) Total
								FROM dbo.tbl_Change_Approval_Details ch LEFT OUTER JOIN dbo.tbl_Change_Task_Merged tsk ON ch.CRQ = tsk.Request_ID
								LEFT OUTER JOIN (select * from dbo.tbl_Change_Approval_Details ch where ch.CRQ_Type = 'Normal') normal ON ch.CRQ = normal.CRQ
								LEFT OUTER JOIN (select * from dbo.tbl_Change_Approval_Details ch where ch.CRQ_Type = 'Standard') standard ON ch.CRQ = standard.CRQ
								where ch.ChangeFor = 'Network'
								AND ch.Status NOT IN ('Request For Authorization','Cancelled')
								AND dbo.DateOnly(ch.Scheduled_Start_Date) >= '8/1/2013' AND dbo.DateOnly(ch.Scheduled_Start_Date) < '9/1/2013'
								group by CASE WHEN tsk.Assignee_Company = 'Regional Operations' OR tsk.Assignee_Company like 'Access%' THEN 2
											WHEN tsk.Assignee_Organization = 'Network Management, Planning & Support' OR tsk.Assignee_Organization like 'E2E%' THEN 3 
							  WHEN tsk.Assignee_Company = 'Service Management' THEN 1
							  ELSE 3 END,
											CASE WHEN tsk.Assignee_Organization = 'Network Information' THEN 'VAS & Payments'
											WHEN tsk.Assignee_Organization = 'Mobile Internet & Enterprise' THEN 'Data'
											WHEN tsk.Assignee_Organization = 'Charging IN & Mediation' THEN 'Charging'
											WHEN tsk.Assignee_Organization like 'SOC%' THEN 'SOC'
											WHEN tsk.Assignee_Organization = 'Transport  & MTX SM' THEN 'Transport'
											WHEN tsk.Assignee_Organization = 'Voice SM' THEN 'Voice'
											WHEN tsk.Assignee_Company = 'Regional Operations' THEN 'Regional Ops'
											WHEN tsk.Assignee_Company like 'Access%' THEN 'Regional Ops'
							  ELSE 'Others'
											END
								order by TeamOrder,Team;";		
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Team = array();
		$data_Val_NR = array();
		$data_Val_ST = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Team,$row['Team']);
			array_push($data_Val_NR,$row['Normal_CRQs']);
			array_push($data_Val_ST,$row['Standard_CRQs']);
		}
		
		sqlsrv_free_stmt( $stmt);
		
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(draw_ChangeFor);
	
	function draw_ChangeFor(){
		var data = google.visualization.arrayToDataTable([           
			['Team', 'Non-Standard Changes','Standard Changes'],           
			<?php for($i=0;$i<count($data_Team); $i++) {             
						echo "['".$data_Team[$i]."',".$data_Val_NR[$i].",".$data_Val_ST[$i]."]"; 
						if ($i<count($data_Team)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] ); 
		var data_table = google.visualization.arrayToDataTable([           
			['Team', 'Non-Standard Changes','Standard Changes','Total'],           
			<?php for($i=0;$i<count($data_Team); $i++) {             
						echo "['".$data_Team[$i]."',".$data_Val_NR[$i].",".$data_Val_ST[$i].",".($data_Val_ST[$i]+$data_Val_NR[$i])."]"; 
						if ($i<count($data_Team)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] ); 
		
		var options = {           title: 'NW CRQs Authorized per Team'  , is3D: true  , chartArea:{left:160,top:40,width:"70%",height:"75%"} , 'isStacked':true};          
		var options_new = { 	title: 'NW CRQs Authorized per Team'  , 
					is3D: true  , chartArea:{left:120,top:40,width:"60%",height:"65%"} , 
					vAxis: {title:'Normal Changes',gridlines:{count:7},maxValue:100},
					seriesType: "bars",'isStacked':false,
					series:{0:{type:"bars",color:"green"},1:{type:"bars", color:"royalblue"}}, 
					legend:{position: 'bottom', textStyle: {color: 'blue', fontSize: 16}}
			}; 
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(data, options_new);  
		
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(data_table, {showRowNumber: true}); 
	}
</script>   
	<table ><tr>
		<td class="iframe_td"><div id="chart_div" style="width: 650px; height: 500px;"></div>  </td>
		</tr><tr>
		<td><div id="table_div" style="width: 650px;"></div></td>
	</tr>
</table>
<?php sqlsrv_close( $conn ); ?>