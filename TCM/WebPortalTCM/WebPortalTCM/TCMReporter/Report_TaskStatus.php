<link href="style_new.css" rel="stylesheet" type="text/css" />
<table><tr><td><div class="body_text">Status of SM Tasks in Normal Changes per Implementing Teams </div></td>
<td align=right >
<?php 
		//$sql = "SELECT CASE WHEN tsk.Assignee_Organization like 'SOC%' THEN 'SOC Fixed, SOC Transport, SOC Voice' ELSE tsk.Assignee_Organization END Domain, tsk.Assignee_Group Team,CAST(ch.Scheduled_Start_Date as varchar) 'Scheduled Date',tsk.Request_ID,tsk.Task_ID,tsk.[Status*] FROM dbo.vw_Change_Task_Merged_New tsk LEFT OUTER JOIN dbo.vw_Change_Approval_Details ch ON ch.CRQ = tsk.Request_ID WHERE ch.Scheduled_Start_Date <= getdate() AND ch.Status NOT IN ('Draft', 'Request For Authorization','Rejected','Cancelled') AND Assignee_Company = 'Service Management' AND tsk.Assignee_Organization != 'Technology Change Management' AND ( [Status*]='Assigned' OR [Status*]='Staged' ) ORDER BY 1,2;";		
		$sql = "SELECT CASE WHEN tsk.Assignee_Organization like 'SOC%' THEN 'SOC Fixed, SOC Transport, SOC Voice' ELSE tsk.Assignee_Organization END Domain, tsk.Assignee_Group Team,CAST(ch.Scheduled_Start_Date as varchar) 'Scheduled Date',tsk.Request_ID,tsk.Task_ID,tsk.[Status*] FROM dbo.tbl_Change_Task_Merged_Ver7_6 tsk LEFT OUTER JOIN dbo.tbl_Change_Approval_Details_Ver7_6 ch ON ch.CRQ = tsk.Request_ID WHERE ch.Scheduled_Start_Date <= getdate() AND ch.Status NOT IN ('Draft', 'Request For Authorization','Rejected','Cancelled') AND Assignee_Company = 'Service Management' AND tsk.Assignee_Organization != 'Technology Change Management' AND ( [Status*]='Assigned' OR [Status*]='Staged' ) ORDER BY 1,2;";		
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		//echo $sql;
		echo '<a href="excel.php?name=SM_OpenedTasks&query='.$sql_encoded.'">';
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
		$sql0 = "SELECT CASE WHEN tsk.Assignee_Organization like 'SOC%' THEN 'SOC Fixed, SOC Transport & SOC Voice' ELSE tsk.Assignee_Organization END team,count(TSK_assigned.Request_ID) TSKs_assigned,count(TSK_staged.Request_ID) TSKs_staged,count(TSK_closed.Request_ID) TSKs_closed
				FROM dbo.tbl_Change_Approval_Details ch LEFT OUTER JOIN dbo.tbl_Change_Task_Merged tsk
				ON ch.CRQ = tsk.Request_ID LEFT OUTER JOIN 
				  (SELECT Request_ID FROM dbo.tbl_Change_Task_Merged WHERE [Status*]='Assigned' AND Assignee_Company = 'Service Management') TSK_assigned
				ON ch.CRQ = TSK_assigned.Request_ID LEFT OUTER JOIN 
				  (SELECT Request_ID FROM dbo.tbl_Change_Task_Merged WHERE [Status*]='Staged' AND Assignee_Company = 'Service Management') TSK_staged
				ON ch.CRQ = TSK_staged.Request_ID LEFT OUTER JOIN 
				  (SELECT Request_ID FROM dbo.tbl_Change_Task_Merged WHERE [Status*]='Closed' AND Assignee_Company = 'Service Management') TSK_closed
				ON ch.CRQ = TSK_closed.Request_ID
				WHERE ch.Scheduled_Start_Date <= getdate() 
						AND ch.Status NOT IN ('Draft', 'Request For Authorization','Rejected','Cancelled')
						AND ch.CRQ_Type = 'Normal'
					AND Assignee_Company = 'Service Management'
					AND tsk.Assignee_Organization != 'Technology Change Management'
					--AND tsk.[Status*]='Assigned'
						GROUP BY CASE WHEN tsk.Assignee_Organization like 'SOC%' THEN 'SOC Fixed, SOC Transport & SOC Voice' ELSE tsk.Assignee_Organization END
						ORDER BY 1;";
		$sql = "SELECT CASE WHEN tsk.Assignee_Organization like 'SOC%' THEN 'SOC Fixed, SOC Transport & SOC Voice' ELSE tsk.Assignee_Organization END team,
						count(TSK_assigned.Task_ID) TSKs_assigned,count(TSK_staged.Task_ID) TSKs_staged,count(TSK_closed.Task_ID) TSKs_closed
				FROM dbo.tbl_Change_Task_Merged_Ver7_6 tsk LEFT OUTER JOIN dbo.tbl_Change_Approval_Details_Ver7_6 ch 
				ON ch.CRQ = tsk.Request_ID LEFT OUTER JOIN 
				  (SELECT Task_ID FROM dbo.tbl_Change_Task_Merged_Ver7_6 WHERE [Status*]='Assigned') TSK_assigned
				ON tsk.Task_ID = TSK_assigned.Task_ID LEFT OUTER JOIN 
				  (SELECT Task_ID FROM dbo.tbl_Change_Task_Merged_Ver7_6 WHERE [Status*]='Staged') TSK_staged
				ON tsk.Task_ID = TSK_staged.Task_ID LEFT OUTER JOIN 
				  (SELECT Task_ID FROM dbo.tbl_Change_Task_Merged_Ver7_6 WHERE [Status*]='Closed') TSK_closed
				ON tsk.Task_ID = TSK_closed.Task_ID
				WHERE ch.Scheduled_Start_Date <= getdate() 
						AND ch.Status NOT IN ('Draft', 'Request For Authorization','Rejected','Cancelled')
						AND ch.CRQ_Type = 'Normal'
					  AND Assignee_Company = 'Service Management'
					  AND tsk.Assignee_Organization != 'Technology Change Management'
				GROUP BY CASE WHEN tsk.Assignee_Organization like 'SOC%' THEN 'SOC Fixed, SOC Transport & SOC Voice' ELSE tsk.Assignee_Organization END
				ORDER BY 1;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Val_assigned = array();
		$data_Val_staged = array();
		$data_Val_closed = array();
		$data_team = array();
		$data_Val_total = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_team,$row['team']);
			array_push($data_Val_assigned,$row['TSKs_assigned']);
			array_push($data_Val_staged,$row['TSKs_staged']);
			array_push($data_Val_closed,$row['TSKs_closed']);
			$total = $row['TSKs_assigned']+$row['TSKs_staged']+$row['TSKs_closed'];
			array_push($data_Val_total,$total);
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
			['Implementing Team','Closed Tasks','Staged Tasks','Assigned Tasks'],                
			<?php 
				for($i=0;$i<count($data_team); $i++) {             
						echo "['".$data_team[$i]."',".$data_Val_closed[$i].",".$data_Val_staged[$i].",".$data_Val_assigned[$i]."]"; 
						if ($i<count($data_team)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] ); 
			
		var dataTable = google.visualization.arrayToDataTable([           
			['Implementing Team','Closed Tasks','Staged Tasks','Assigned Tasks','Total'],                
			<?php 
				for($i=0;$i<count($data_team); $i++) {             
						echo "['".$data_team[$i]."',".$data_Val_closed[$i].",".$data_Val_staged[$i].",".$data_Val_assigned[$i].",".$data_Val_total[$i]."]"; 
						if ($i<count($data_team)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] ); 
			
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});       
		
		//drawPieChart
		var options = { title: 'SM Implementing Teams Normal Changes'  ,  chartArea:{left:80,top:40,width:"60%",height:"70%"}, //legendTextStyle: {color:'#00FF00'}, //vAxis: {maxValue:3, minValue:1},
						vAxis: { gridlines:{count:10}} , is3D:true, 'isStacked':true };          
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td  class="iframe_td"><div id="chart_div" style="width: 650px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
</table>