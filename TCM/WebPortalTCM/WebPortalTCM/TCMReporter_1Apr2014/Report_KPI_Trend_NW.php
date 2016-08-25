<link href="style_new.css" rel="stylesheet" type="text/css" />
<table><tr><td width="100%"><div class="body_text"><B><span style="color:darkred;">NW</span> KPIs Trend</B></div></td>
<td align=right >
<?php 
	$startDate = '4/1/2013';
	$endDate = date('m/d/Y', time() + (60 * 60 * 24 * -1));
	//echo $weekback." ".$yesterday;

	if(isset($_GET['from'])) $getFrom = $_GET['from']; else $getFrom = $startDate;
	if(isset($_GET['to'])) $getTo = $_GET['to']; else $getTo = $endDate;
	
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
		$data_Val_Before = array(); 		
		$data_Val_After = array();
		$data_Val_Normal_After = array();
		$data_Val_Standard = array();
		$data_Val_Exception = array();
		$data_Val_Fix = array();
		$data_Val_OffCM = array();
		$data_Val_unauth = array();
		$$data_Val_Late = array();
		
		$data_month_Normal = array();
		$data_Val_INC = array();
		$data_Val_INC_DueChange = array();
		
		//Before Process
		$sql = "SELECT YEAR(ch.Scheduled_Start_Date) year_,MONTH(ch.Scheduled_Start_Date) month_,count(*) CRQnum
				FROM dbo.tbl_Change_Change_Merged ch
				WHERE dbo.dateOnly(Scheduled_Start_Date) BETWEEN dbo.dateOnly('1/1/2012') AND dbo.dateOnly('8/31/2012')
				AND (dbo.DateOnly(ch.Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(ch.Scheduled_Start_Date) >= '$getFrom')
				AND ch.ChangeFor <> 'IT'
				AND Change_Request_Status NOT IN ('Draft','Request For Authorization') 
				GROUP BY YEAR(ch.Scheduled_Start_Date),MONTH(ch.Scheduled_Start_Date)
				ORDER BY YEAR(ch.Scheduled_Start_Date),MONTH(ch.Scheduled_Start_Date);";
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
			if($date != 'Aug 2012')
				array_push($data_month,$date);
			$data_Val_Before[$date] = $row['CRQnum'];
			//echo $date1."=".$date.' ';
		
		}
		sqlsrv_free_stmt( $stmt);
		
		//After Process
		$sql_old = "SELECT YEAR(ch.Scheduled_Start_Date) year_,MONTH(ch.Scheduled_Start_Date) month_,count(*) CRQnum
				FROM dbo.tbl_Change_Change_Merged ch
				WHERE dbo.dateOnly(Scheduled_Start_Date) BETWEEN dbo.dateOnly('8/1/2012') AND dbo.dateOnly(getdate())
				AND Change_Request_Status NOT IN ('Draft','Request For Authorization') 
				GROUP BY YEAR(ch.Scheduled_Start_Date),MONTH(ch.Scheduled_Start_Date)
				ORDER BY YEAR(ch.Scheduled_Start_Date),MONTH(ch.Scheduled_Start_Date);";
				
		$sql = "SELECT YEAR(ch.Scheduled_Start_Date) year_,MONTH(ch.Scheduled_Start_Date) month_,count(*) CRQnum
				FROM vw_Change_Approval_Details ch
				WHERE dbo.dateOnly(Scheduled_Start_Date) BETWEEN dbo.dateOnly('8/1/2012') AND dbo.dateOnly(getdate())
				AND (dbo.DateOnly(ch.Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(ch.Scheduled_Start_Date) >= '$getFrom')
				AND ch.ChangeFor <> 'IT'
				AND Status NOT IN ('Request For Authorization','Cancelled','Rejected')
				GROUP BY YEAR(ch.Scheduled_Start_Date),MONTH(ch.Scheduled_Start_Date)
				ORDER BY YEAR(ch.Scheduled_Start_Date),MONTH(ch.Scheduled_Start_Date);";
		$stmt = sqlsrv_query( $conn, $sql );
		//echo $sql;
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$date = $row['month_']."-".$row['year_']; 
			$m = $row['month_'];
			//$date = substr(date("F", strtotime("$m month")),0,3).' '.$row['year_'];
			$date = substr(date("F", mktime(0, 0, 0, $m, 10)),0,3).' '.$row['year_'];
			array_push($data_month,$date);
			$data_Val_After[$date] = $row['CRQnum'];
		}
		sqlsrv_free_stmt( $stmt);
		
		// Normal CRQs After Process
		$sql_nr = "SELECT YEAR(ch.Scheduled_Start_Date) year_,MONTH(ch.Scheduled_Start_Date) month_,count(*) CRQnum
				FROM dbo.tbl_Change_Change_Merged ch LEFT OUTER JOIN dbo.tbl_Change_Approvers_Merged app ON ch.Infrastructure_Change_ID = app.Infrastructure_Change_ID
				WHERE dbo.dateOnly(Scheduled_Start_Date) BETWEEN dbo.dateOnly('8/12/2012') AND dbo.dateOnly(getdate())
				AND Change_Request_Status NOT IN ('Draft','Request For Authorization','Rejected') 
				AND ( app.[Approval Aduit Trail] like '%CM_%' OR app.[Approval Aduit Trail] like '%raslan%' )
				GROUP BY YEAR(ch.Scheduled_Start_Date),MONTH(ch.Scheduled_Start_Date)
				ORDER BY YEAR(ch.Scheduled_Start_Date),MONTH(ch.Scheduled_Start_Date);";
				
		$sql_old = "SELECT YEAR(ch.Scheduled_Start_Date) Scheduled_year,MONTH(ch.Scheduled_Start_Date) AS Scheduled_month,
				isnull(count(Standar.CRQ ),0) 'Standard', isnull(count(Normal.CRQ ),0) 'Normal', 
				isnull(count(Excep.CRQ ),0) 'Exceptions', isnull(count(Fix.CRQ ),0) 'Fix',
				isnull(count(Unauth.CRQ ),0) 'Unauthorized', isnull(count(Off_CM.CRQ ),0) 'Off CM Process', 
				isnull(count(LateSubmit.CRQ ),0) 'Late Submitted'
				FROM  dbo.vw_Change_Approval_Details ch
				LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details where CRQ_Type = 'Standard' AND Status NOT IN ('Request For Authorization','Cancelled','Rejected') ) Standar ON ch.CRQ = Standar.CRQ 
				LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details where CRQ_Type = 'Normal' AND Status NOT IN ('Request For Authorization','Cancelled','Rejected')) Normal ON ch.CRQ = Normal.CRQ 
				LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details where CRQ_Type = 'Normal' AND Status NOT IN ('Request For Authorization','Cancelled','Rejected') AND ( (DATEADD(day, -DATEDIFF(day, 0, [First Approval Date]), [First Approval Date]) > '2:00:00 PM' AND dbo.DATEONLY( [First Approval Date]) >= dbo.DATEONLY( dbo.udf_GetPrevNextWorkDay(Scheduled_Start_Date, 'Previous'))   ) OR    Emergency = 0 )  AND (Description LIKE ('%fix%') OR Justification LIKE ('%fix%') OR Description LIKE ('%problem%') OR Justification LIKE ('%problem%') OR Description LIKE ('%solve%') OR Justification LIKE ('%solve%'))) Fix ON ch.CRQ = Fix.CRQ 
				LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details where CRQ_Type = 'Normal' AND Status NOT IN ('Request For Authorization','Cancelled','Rejected') AND ( (DATEADD(day, -DATEDIFF(day, 0, [First Approval Date]), [First Approval Date]) > '2:00:00 PM' AND dbo.DATEONLY( [First Approval Date]) >= dbo.DATEONLY( dbo.udf_GetPrevNextWorkDay(Scheduled_Start_Date, 'Previous'))   ) OR    Emergency = 0 ) AND NOT (Description LIKE ('%fix%') OR Justification LIKE ('%fix%') OR Description LIKE ('%problem%') OR Justification LIKE ('%problem%') OR Description LIKE ('%solve%') OR Justification LIKE ('%solve%'))) Excep ON ch.CRQ = Excep.CRQ 
				LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details where CRQ_Type = 'Normal' AND Status = 'Request For Authorization' ) Unauth ON ch.CRQ = Unauth.CRQ 
				LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details where [First Approval Date] IS NULL AND Status NOT IN ('Request For Authorization','Cancelled') AND ChangeFor <> 'General') Off_CM ON ch.CRQ = Off_CM.CRQ 
				LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details where Status NOT IN ('Request For Authorization','Cancelled','Rejected') AND dbo.DateOnly(Submit_Date) >= dbo.DateOnly(dbo.udf_GetPrevNextWorkDay(Scheduled_Start_Date,'Previous'))) LateSubmit ON ch.CRQ = LateSubmit.CRQ 
				WHERE ch.Scheduled_Start_Date <= GETDATE()
				AND ( dbo.DateOnly(ch.Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(ch.Scheduled_Start_Date) >= '$getFrom')
				AND ch.ChangeFor <> 'IT'
				--AND ch.Support_Company NOT IN ('Products & Services Delivery','IT Operations')
				GROUP BY YEAR(ch.Scheduled_Start_Date),MONTH(ch.Scheduled_Start_Date)
				ORDER BY YEAR(ch.Scheduled_Start_Date),MONTH(ch.Scheduled_Start_Date);";
				
		$sql = "SELECT YEAR(ch.Scheduled_Start_Date) Scheduled_year,MONTH(ch.Scheduled_Start_Date) AS Scheduled_month,
				isnull(count(Standar.CRQ ),0) 'Standard', isnull(count(Normal.CRQ ),0) 'Normal', 
				isnull(count(Excep.CRQ ),0) 'Exceptions', isnull(count(Fix.CRQ ),0) 'Fix',
				isnull(count(Unauth.CRQ ),0) 'Unauthorized', isnull(count(Off_CM.CRQ ),0) 'Off CM Process', 
				isnull(count(LateSubmit.CRQ ),0) 'Late Submitted'
				FROM  dbo.vw_Change_Approval_Details ch
				LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details where CRQ_Type = 'Standard' AND Status NOT IN ('Request For Authorization','Cancelled','Rejected') ) Standar ON ch.CRQ = Standar.CRQ 
				LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details where CRQ_Type = 'Normal' AND Status NOT IN ('Request For Authorization','Cancelled','Rejected') ) Normal ON ch.CRQ = Normal.CRQ 
				LEFT OUTER JOIN (SELECT CRQ FROM  dbo.vw_Change_Approval_Details LEFT OUTER JOIN [SM_Change_Researching_DB].dbo.vw_Change_Approvers_Merged ap ON CRQ = ap.Infrastructure_Change_ID where CRQ_Type = 'Normal' AND Status NOT IN ('Request For Authorization','Cancelled','Rejected')  
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
					OR    Emergency = 0 ) 
					AND (Description LIKE ('%fix%') OR Justification LIKE ('%fix%') OR Description LIKE ('%problem%') OR Justification LIKE ('%problem%') OR Description LIKE ('%solve%') OR Justification LIKE ('%solve%'))) Fix ON ch.CRQ = Fix.CRQ 
				LEFT OUTER JOIN (SELECT CRQ FROM  dbo.vw_Change_Approval_Details LEFT OUTER JOIN [SM_Change_Researching_DB].dbo.vw_Change_Approvers_Merged ap ON CRQ = ap.Infrastructure_Change_ID where CRQ_Type = 'Normal' AND Status NOT IN ('Request For Authorization','Cancelled','Rejected')  
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
					OR    Emergency = 0 ) 
					AND NOT (Description LIKE ('%fix%') OR Justification LIKE ('%fix%') OR Description LIKE ('%problem%') OR Justification LIKE ('%problem%') OR Description LIKE ('%solve%') OR Justification LIKE ('%solve%'))) Excep ON ch.CRQ = Excep.CRQ 
				LEFT OUTER JOIN (SELECT CRQ FROM  dbo.vw_Change_Approval_Details where CRQ_Type = 'Normal' AND Status = 'Request For Authorization' ) Unauth ON ch.CRQ = Unauth.CRQ 
				LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details where [First Approval Date] IS NULL AND Status NOT IN ('Request For Authorization','Cancelled') AND ChangeFor <> 'General') Off_CM ON ch.CRQ = Off_CM.CRQ 
				LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details where Status != 'Request For Authorization' AND dbo.DateOnly(Submit_Date) >= dbo.DateOnly(dbo.udf_GetPrevNextWorkDay(Scheduled_Start_Date,'Previous'))) LateSubmit ON ch.CRQ = LateSubmit.CRQ 
				WHERE ch.Scheduled_Start_Date <= GETDATE()
				AND ( dbo.DateOnly(ch.Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(ch.Scheduled_Start_Date) >= '$getFrom')
				AND ch.ChangeFor <> 'IT'
				--AND ch.Support_Company NOT IN ('Products & Services Delivery','IT Operations')
				GROUP BY YEAR(ch.Scheduled_Start_Date),MONTH(ch.Scheduled_Start_Date)
				ORDER BY YEAR(ch.Scheduled_Start_Date),MONTH(ch.Scheduled_Start_Date);";

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
			$data_Val_Normal_After[$date] = $row['Normal'];
			$data_Val_Standard[$date] = $row['Standard'];
			$data_Val_Exception[$date] = $row['Exceptions'];
			$data_Val_Fix[$date] = $row['Fix'];
			$data_Val_OffCM[$date] = $row['Off CM Process'];
			$data_Val_unauth[$date] = $row['Unauthorized'];
			$data_Val_Late[$date] = $row['Late Submitted'];
		}
		sqlsrv_free_stmt( $stmt);
		
		//Incidents due to Change
		$sql_old = "SELECT YEAR(inc.[Start Date]) year_,MONTH(inc.[Start Date]) month_,count(*) CRQnum
				FROM dbo.tbl_Incident_TechIMReport inc
				WHERE inc.Dueto_Change = 1
				AND Category != 'IT Incident'
				AND (dbo.DateOnly(inc.[Start Date]) <= '$getTo' AND dbo.DateOnly(inc.[Start Date]) >= '$getFrom')
				GROUP BY YEAR(inc.[Start Date]),MONTH(inc.[Start Date])
				ORDER BY YEAR(inc.[Start Date]),MONTH(inc.[Start Date]);";
		$sql = "SELECT YEAR(inc.[Start Date]) year_,MONTH(inc.[Start Date]) month_,count(*) CRQnum
				FROM dbo.tbl_Incident_IDC inc
				WHERE inc.Dueto_Change = 1
				AND Category != 'IT Incident'
				AND (dbo.DateOnly(inc.[Start Date]) <= '$getTo' AND dbo.DateOnly(inc.[Start Date]) >= '$getFrom')
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
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataTable = google.visualization.arrayToDataTable([           
			['Month', 'Authorized','Standard','Normal','Exceptions','Exceptions%','Fix','Fix%','Off Process','Off%','Unauthorized NR','Unauthorized NR%','Adhoc','Adhoc%','IDC','IDC%'],  
			<?php	for($i=0;$i<count($data_month); $i++) {            
						$month = $data_month[$i];
						if($data_month[$i]=='Jan 2012' || $data_month[$i]=='Feb 2012' || $data_month[$i]=='Mar 2012' || $data_month[$i]=='Apr 2012' || 
							$data_month[$i]=='May 2012' || $data_month[$i]=='Jun 2012' || $data_month[$i]=='Jul 2012') 
							echo "['".$data_month[$i]."',".
								$data_Val_Before[$month].",".
								",".
								",".
								",".
								",".
								",".
								",".
								",".
								",".
								",".
								",".
								",".
								",".
								$data_Val_INC_DueChange[$month].",' ']";
						elseif ($data_Val_INC_DueChange[$month] == '') 
							echo "['".$data_month[$i]."',".
								$data_Val_After[$month].",".
								$data_Val_Standard[$month].",".
								$data_Val_Normal_After[$month].",".
								$data_Val_Exception[$month].",'".
								round(($data_Val_Exception[$month]/$data_Val_Normal_After[$month])*100,0)."\%',".
								$data_Val_Fix[$month].",'".
								round(($data_Val_Fix[$month]/$data_Val_Normal_After[$month])*100,1)."\%',".
								$data_Val_OffCM[$month].",'".
								round(($data_Val_OffCM[$month]/$data_Val_After[$month])*100,0)."\%',".
								$data_Val_unauth[$month].",'".
								round(($data_Val_unauth[$month]/($data_Val_unauth[$month]+$data_Val_Normal_After[$month]))*100,0)."\%',".
								$data_Val_Late[$month].",'".
								round(($data_Val_Late[$month]/$data_Val_After[$month])*100,0)."\%',".
								$data_Val_INC_DueChange[$month].",' ']";
						
						else echo "['".$data_month[$i]."',".
								$data_Val_After[$month].",".
								$data_Val_Standard[$month].",".
								$data_Val_Normal_After[$month].",".
								$data_Val_Exception[$month].",'".
								round(($data_Val_Exception[$month]/$data_Val_Normal_After[$month])*100,0)."\%',".
								$data_Val_Fix[$month].",'".
								round(($data_Val_Fix[$month]/$data_Val_Normal_After[$month])*100,1)."\%',".
								$data_Val_OffCM[$month].",'".
								round(($data_Val_OffCM[$month]/$data_Val_After[$month])*100,0)."\%',".
								$data_Val_unauth[$month].",'".
								round(($data_Val_unauth[$month]/($data_Val_unauth[$month]+$data_Val_Normal_After[$month]))*100,0)."\%',".
								$data_Val_Late[$month].",'".
								round(($data_Val_Late[$month]/$data_Val_After[$month])*100,0)."\%',".
								$data_Val_INC_DueChange[$month].",'".
								round(($data_Val_INC_DueChange[$month]/$data_Val_Normal_After[$month])*100,1)."\%']";
						if ($i<count($data_month)-1) echo ",";	//add ',' to all except last element
					}
			?>           
			
			] );

		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});       
		     
	} 
</script>   
<table >
	<tr><td ><div id="table_div" ></div></td></tr>
</table>




