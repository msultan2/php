<link href="style_new.css" rel="stylesheet" type="text/css" />
<?php 
	$startDate = '4/1/2013';
	$endDate = date('m/d/Y', time() + (60 * 60 * 24 * -1));
	
	if(isset($_GET['from'])) $getFrom = $_GET['from']; else $getFrom = $startDate;
	if(isset($_GET['to'])) $getTo = $_GET['to']; else $getTo = $endDate;
	if(isset($_GET['team'])) {
		$team = str_replace("__"," ",$_GET['team']); 
		if ($team == "") echo "All Teams Changes: ";
		else echo $team." Changes Report: ";
		
		$sql = "SELECT CRQ,Status,Status_Reason ,[Description],[Justification],ch.[Support_Company],ch.[Support_Organization],ch.[Support_Group_Name],tsk.assignee_company,tsk.assignee_organization,tsk.assignee_group,Requester,CAST(ch.Scheduled_Start_Date AS VARCHAR) Scheduled_Start_Date,CAST(ch.Scheduled_End_Date AS VARCHAR) Scheduled_End_Date,Impact,Risk_Level,ChangeFor,Product_Categorization_Tier_1,Product_Categorization_Tier_2,Product_Categorization_Tier_3,CASE [Emergency] WHEN 0 THEN 'YES' ELSE '' END Emergency,[External_Customer],[Service_Impact],[Internal_Customer],[Business_Impact],[Nodes_Systems],[Technical_Impact],[Reporting],[DWH_Impact] FROM dbo.vw_Change_Approval_Details ch LEFT OUTER JOIN dbo.vw_Change_Task_Merged_New tsk ON ch.CRQ = tsk.Request_ID WHERE ch.Scheduled_Start_Date <= GETDATE() AND ( dbo.DateOnly(ch.Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(ch.Scheduled_Start_Date) >= '$getFrom') AND tsk.Assignee_Group like '%$team%' ORDER BY ch.Scheduled_Start_Date;";		
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		//echo $sql_encoded;
		echo '<a href="excel.php?name='.str_replace(" ","_",$team).'_CRQs&query='.$sql_encoded.'">';
	?>
<img width=24px height=24px src="images/excel.bmp" style="border-style: none"/></a>

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
		$data_Val_After = array();
		$data_Val_Normal_After = array();
		$data_Val_Standard = array();
		$data_Val_Exception = array();
		$data_Val_Fix = array();
		$data_Val_unauth = array();
		
		$data_month_Normal = array();
		$data_Val_INC = array();
		$data_Val_INC_DueChange = array();
		
		
		// Normal CRQs After Process

		$sql = "SELECT YEAR(ch.Scheduled_Start_Date) Scheduled_year,MONTH(ch.Scheduled_Start_Date) AS Scheduled_month,
				isnull(count(DISTINCT Standar.CRQ ),0) 'Standard', isnull(count(DISTINCT Normal.CRQ ),0) 'Normal', 
				isnull(count(DISTINCT Excep.CRQ ),0) 'Exceptions', isnull(count(DISTINCT Fix.CRQ ),0) 'Fix'
				FROM  dbo.vw_Change_Approval_Details ch
				LEFT OUTER JOIN dbo.vw_Change_Task_Merged_New tsk ON ch.CRQ = tsk.Request_ID
				LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details where CRQ_Type = 'Standard' AND Status NOT IN ('Request For Authorization','Cancelled','Rejected') ) Standar ON ch.CRQ = Standar.CRQ 
				LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details where CRQ_Type = 'Normal' AND Status NOT IN ('Request For Authorization','Cancelled','Rejected') ) Normal ON ch.CRQ = Normal.CRQ 
				LEFT OUTER JOIN (SELECT CRQ FROM  dbo.vw_Change_Approval_Details LEFT OUTER JOIN [SM_Change_Researching_DB].dbo.vw_Change_Approvers_Merged ap ON CRQ = ap.Infrastructure_Change_ID 
					where CRQ_Type = 'Normal' AND Status NOT IN ('Request For Authorization','Cancelled','Rejected')  
					AND (
						(( Scheduled_Start_Date < '1/10/2014' AND	DATEADD(day, -DATEDIFF(day, 0, [First Approval Date]), [First Approval Date]) > '2:00:00 PM' 
							AND [SM_Change_Researching_DB].dbo.DATEONLY( [First Approval Date]) >= [SM_Change_Researching_DB].dbo.DATEONLY( [SM_Change_Researching_DB].dbo.udf_GetPrevNextWorkDay(Scheduled_Start_Date, 'Previous'))   
						) 
						OR  
						(	Scheduled_Start_Date >= '1/10/2014' AND 
							([SM_Change_Researching_DB].dbo.DATEONLY( [First Approval Date]) >= [SM_Change_Researching_DB].dbo.DATEONLY( [SM_Change_Researching_DB].dbo.udf_GetPrevNextWorkDay(Scheduled_Start_Date, 'Previous'))   
							AND NOT DATEADD(day, -DATEDIFF(day, 0, Scheduled_Start_Date), Scheduled_Start_Date) > '3:00:00 PM' 
							)  
							AND ap.[Approval Aduit Trail] like '%CM_Authorized%'
						)
					)
					OR    Emergency != 1 ) 
					AND (Description LIKE ('%fix%') OR Justification LIKE ('%fix%') OR Description LIKE ('%problem%') OR Justification LIKE ('%problem%') OR Description LIKE ('%solve%') OR Justification LIKE ('%solve%'))) Fix ON ch.CRQ = Fix.CRQ 
				LEFT OUTER JOIN (SELECT CRQ FROM  dbo.vw_Change_Approval_Details LEFT OUTER JOIN [SM_Change_Researching_DB].dbo.vw_Change_Approvers_Merged ap ON CRQ = ap.Infrastructure_Change_ID 
					where Status NOT IN ('Request For Authorization','Cancelled','Rejected')  
					AND (
						(( Scheduled_Start_Date < '1/10/2014' AND	DATEADD(day, -DATEDIFF(day, 0, [First Approval Date]), [First Approval Date]) > '2:00:00 PM' 
							AND [SM_Change_Researching_DB].dbo.DATEONLY( [First Approval Date]) >= [SM_Change_Researching_DB].dbo.DATEONLY( [SM_Change_Researching_DB].dbo.udf_GetPrevNextWorkDay(Scheduled_Start_Date, 'Previous'))   
						) 
						OR  
						(	Scheduled_Start_Date >= '1/10/2014' AND 
							([SM_Change_Researching_DB].dbo.DATEONLY( [First Approval Date]) >= [SM_Change_Researching_DB].dbo.DATEONLY( [SM_Change_Researching_DB].dbo.udf_GetPrevNextWorkDay(Scheduled_Start_Date, 'Previous'))   
							AND NOT DATEADD(day, -DATEDIFF(day, 0, Scheduled_Start_Date), Scheduled_Start_Date) > '3:00:00 PM' 
							)  
							AND ap.[Approval Aduit Trail] like '%CM_Authorized%'
						)
					)
					OR   ( Emergency !=1 AND Emergency != 4 ) ) 
					AND NOT (Description LIKE ('%fix%') OR Justification LIKE ('%fix%') OR Description LIKE ('%problem%') OR Justification LIKE ('%problem%') OR Description LIKE ('%solve%') OR Justification LIKE ('%solve%'))) Excep ON ch.CRQ = Excep.CRQ 
				WHERE ch.Scheduled_Start_Date <= GETDATE()
				AND ( dbo.DateOnly(ch.Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(ch.Scheduled_Start_Date) >= '$getFrom')
				AND tsk.Assignee_Group like '%$team%'
				GROUP BY YEAR(ch.Scheduled_Start_Date),MONTH(ch.Scheduled_Start_Date)
				ORDER BY YEAR(ch.Scheduled_Start_Date),MONTH(ch.Scheduled_Start_Date);";
				//echo $sql;
		$stmt = sqlsrv_query( $conn, $sql );
		//echo $sql;
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$date = $row['Scheduled_month']."-".$row['Scheduled_year']; 
			$m = $row['Scheduled_month'];
			//$date = substr(date("F", strtotime("$m month")),0,3).' '.$row['Scheduled_year'];
			$date = substr(date("F", mktime(0, 0, 0, $m, 10)),0,3).' '.$row['Scheduled_year'];
			array_push($data_month_Normal,$date);
			array_push($data_month,$date);
			$data_Val_After[$date]= $row['Normal']+$row['Standard'];
			$data_Val_Normal_After[$date] = $row['Normal'];
			$data_Val_Standard[$date] = $row['Standard'];
			$data_Val_Exception[$date] = $row['Exceptions'];
			$data_Val_Fix[$date] = $row['Fix'];
		}
		sqlsrv_free_stmt( $stmt);
		
		//Incidents due to Change
		$sql_old = "SELECT YEAR(inc.[Start Date]) year_,MONTH(inc.[Start Date]) month_,count(*) CRQnum
				FROM dbo.tbl_Incident_TechIMReport inc
				WHERE inc.Dueto_Change = 1
				AND (dbo.DateOnly(inc.[Start Date]) <= '$getTo' AND dbo.DateOnly(inc.[Start Date]) >= '$getFrom')
				GROUP BY YEAR(inc.[Start Date]),MONTH(inc.[Start Date])
				ORDER BY YEAR(inc.[Start Date]),MONTH(inc.[Start Date]);";
		$sql = "SELECT YEAR(inc.[Start Date]) year_,MONTH(inc.[Start Date]) month_,count(*) CRQnum
				FROM dbo.tbl_Incident_IDC inc LEFT OUTER JOIN dbo.tbl_Incident_LK_Team_Mapping incMap
				ON inc.Owner_Team = incMap.INC_OwnerTeam
				WHERE inc.Dueto_Change = 1
				AND (dbo.DateOnly(inc.[Start Date]) <= '$getTo' AND dbo.DateOnly(inc.[Start Date]) >= '$getFrom')
				AND incMap.Support_Group like '%$team%'
				AND Category NOT IN ('IT Incident')
				GROUP BY YEAR(inc.[Start Date]),MONTH(inc.[Start Date])
				ORDER BY YEAR(inc.[Start Date]),MONTH(inc.[Start Date]);";
		$stmt = sqlsrv_query( $conn, $sql );
		//echo $sql;
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$date = $row['month_']."-".$row['year_']; 
			//array_push($data_month,$date);
			$m = $row['month_'];
			//$date = substr(date("F", strtotime("$m month")),0,3).' '.$row['year_'];
			$date = substr(date("F", mktime(0, 0, 0, $m, 10)),0,3).' '.$row['year_'];
			$data_Val_INC_DueChange[$date] = $row['CRQnum'];
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
			['Month', 'Authorized','Standard','Normal','Exceptions','Exceptions%','Fix','Fix%','IDC','IDC%'],  
			<?php	for($i=0;$i<count($data_month); $i++) {            
						$month = $data_month[$i];
						
						if ($data_Val_INC_DueChange[$month] == '') 
							echo "['".$data_month[$i]."',".
								$data_Val_After[$month].",".
								$data_Val_Standard[$month].",".
								$data_Val_Normal_After[$month].",".
								$data_Val_Exception[$month].",'".
								round(($data_Val_Exception[$month]/$data_Val_Normal_After[$month])*100,0)."\%',".
								$data_Val_Fix[$month].",'".
								round(($data_Val_Fix[$month]/$data_Val_Normal_After[$month])*100,1)."\%',".
								0 .",'0%']";
						else echo "['".$data_month[$i]."',".
								$data_Val_After[$month].",".
								$data_Val_Standard[$month].",".
								$data_Val_Normal_After[$month].",".
								$data_Val_Exception[$month].",'".
								round(($data_Val_Exception[$month]/$data_Val_Normal_After[$month])*100,0)."\%',".
								$data_Val_Fix[$month].",'".
								round(($data_Val_Fix[$month]/$data_Val_Normal_After[$month])*100,1)."\%',".
								$data_Val_INC_DueChange[$month].",'".
								round(($data_Val_INC_DueChange[$month]/$data_Val_Normal_After[$month])*100,1)."\%']";
						if ($i<count($data_month)-1) echo ",";	//add ',' to all except last element
					}
			?>           
			
			] );
		var dataChart_old = google.visualization.arrayToDataTable([   
			['Month', 'Normal','Exceptions','Fix','IDC'],  
			<?php	for($i=0;$i<count($data_month); $i++) {            
						$month = $data_month[$i];
						
						if ($data_Val_INC_DueChange[$month] == '') 
							echo "['".$data_month[$i]."',".
								$data_Val_Normal_After[$month].",".
								$data_Val_Exception[$month].",".
								$data_Val_Fix[$month].",".
								0 ."]";
						else echo "['".$data_month[$i]."',".
								$data_Val_Normal_After[$month].",".
								$data_Val_Exception[$month].",".
								$data_Val_Fix[$month].",".
								$data_Val_INC_DueChange[$month]."]";
						if ($i<count($data_month)-1) echo ",";	//add ',' to all except last element
					}
			?>           
			
			] );
		var dataChart = google.visualization.arrayToDataTable([   
			['Month', 'Authorized','Exceptions','Fix','IDC'],  
			<?php	for($i=0;$i<count($data_month); $i++) {            
						$month = $data_month[$i];
						
						if ($data_Val_INC_DueChange[$month] == '') 
							echo "['".$data_month[$i]."',".
								($data_Val_Normal_After[$month] + $data_Val_Standard[$month]).",".
								$data_Val_Exception[$month].",".
								$data_Val_Fix[$month].",".
								0 ."]";
						else echo "['".$data_month[$i]."',".
								($data_Val_Normal_After[$month] + $data_Val_Standard[$month]).",".
								$data_Val_Exception[$month].",".
								$data_Val_Fix[$month].",".
								$data_Val_INC_DueChange[$month]."]";
						if ($i<count($data_month)-1) echo ",";	//add ',' to all except last element
					}
			?>           
			
			] );

		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: false});       
		
		var options = { title : 'Monthly Trend',     
				chartArea:{left:60,top:30,right:30,width:"95%",height:"70%"},     
				vAxis: {gridlines:{count:8}},
				hAxis: {title: "Month"},    
				//curveType: "function" ,
				seriesType: "bars",    'isSlanted': true , 
				//series: { 0:{color:"green"},1:{color:"blue"}, 2:{type: "bars",color:"orange"},3:{type: "bars",color:"red"}} 
				series:{0:{type:"area"},1:{type:"bars"},2:{type:"bars"},3:{type:"bars"}}, 
				vAxes:{1:{title:'Incidents Due to Changes',maxValue:50,minValue:0,gridlines:{count:8}},2:{gridlines:{count:0}}},
				legend:{position: 'bottom', textStyle: {color: 'blue', fontSize: 16}}
				//,cht: 'lc', chds:'0,160', annotationColumns:[{column:2, size:12, type:'flag', priority:'high'}]

			};

		var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);   
		
		//document.getElementById("table_div").style.display = "none";
		//document.getElementById("yourIFrameid").style.display = "block";
		     
	} 
</script>   
<table >
	<tr><td class="iframe_td"><div id="chart_div" style="width: 550px; height: 350px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
</table>
<?php
	} // end if
?>



