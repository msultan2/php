<link href="style_new.css" rel="stylesheet" type="text/css" />
<table><tr><td><div class="body_text">Authorized Changes per Type (Normal, Standard, Standard with no Approvals) per team</div></td>
<td align=right >
<?php 
		//$sql = "SELECT cap.Requester,ISNULL(ap.Approver_Name,LTRIM(cap.[First On Behalf of])) Manager,cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name,count(normal_cap.CRQ) Normal_CRQs, count(standard_cap.CRQ) Standard_CRQs, count(reqForAuth_cap.CRQ) ReqForAuth_CRQs,count(scheduled_cap.CRQ) Scheduled_CRQs, count(completed_cap.CRQ) Completed_CRQs, count(closed_cap.CRQ) Closed_CRQs,count(otherStatus_cap.CRQ) OtherStatus_CRQs, count(*) Total_CRQs FROM  dbo.vw_Change_Approval_Details cap LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Normal') normal_cap ON cap.CRQ = normal_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Standard') standard_cap ON cap.CRQ = standard_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Status = 'Request For Authorization') reqForAuth_cap ON cap.CRQ = reqForAuth_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Status = 'Scheduled') scheduled_cap ON cap.CRQ = scheduled_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Status = 'Completed') completed_cap ON cap.CRQ = completed_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Status = 'Closed') closed_cap ON cap.CRQ = closed_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Status NOT IN ('Request For Authorization','Scheduled','Completed','Closed')) otherStatus_cap ON cap.CRQ = otherStatus_cap.CRQ LEFT OUTER JOIN dbo.tbl_Change_LK_Approvers ap ON LOWER(CASE cap.[First On Behalf of] WHEN 'Approved' THEN cap.[First Approver] WHEN 'Rejected' THEN cap.[First Approver] ELSE LTRIM(cap.[First On Behalf of]) END) = LOWER(ap.Approver_Alias) WHERE cap.Status != 'Draft' GROUP BY cap.Requester , ISNULL(ap.Approver_Name,LTRIM(cap.[First On Behalf of])),cap.Support_Company, cap.Support_Organization,cap.Support_Group_Name ORDER BY cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name,Requester;";
		//$sql = "SELECT cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name,count(normal_cap.CRQ) Normal_CRQs,count(standard_cap.CRQ) Standard_CRQs,count(*) Total_CRQs FROM  dbo.vw_Change_Approval_Details cap LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Normal') normal_cap ON cap.CRQ = normal_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Standard') standard_cap ON cap.CRQ = standard_cap.CRQ WHERE cap.Status != 'Draft' GROUP BY cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name ORDER BY cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name;";
		$sql = "SELECT cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name,count(normal_cap.CRQ) Normal_CRQs,count(standard_cap.CRQ) Standard_CRQs,count(standard_noCM.CRQ) Standard_noCM, count(*) Total_CRQs FROM  dbo.vw_Change_Approval_Details cap LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Normal') normal_cap ON cap.CRQ = normal_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Standard' AND [First Approval Date] IS NOT NULL) standard_cap ON cap.CRQ = standard_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Standard' AND [First Approval Date] IS NULL) standard_noCM ON cap.CRQ = standard_noCM.CRQ WHERE cap.Status != 'Request For Authorization' GROUP BY cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name ORDER BY cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name;";
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		//echo $sql;
		echo '<a href="excel.php?name=RequesterTeam&query='.$sql_encoded.'">';
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
		$data_month = array(); 
		$data_Val_Standard_noCM = array(); 		
		$data_Val_Standard = array();
		$data_Val_Normal = array();
		$data_month_Normal = array();
		$data_Val_INC = array();
		$data_Val_INC_DueChange = array();
		
		//Standard with no CM Process
		$sql = "SELECT YEAR(ch.Scheduled_Start_Date) year_,MONTH(ch.Scheduled_Start_Date) month_,count(*) CRQnum
				FROM dbo.tbl_Change_Approval_Details ch
				WHERE dbo.dateOnly(Scheduled_Start_Date) BETWEEN dbo.dateOnly('8/12/2012') AND dbo.dateOnly(getdate())
				AND CRQ_Type = 'Standard'
				AND [First Approval Date] IS NULL
				AND Status NOT IN ('Draft','Request For Authorization') 
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
			//if($date != 'Aug 2012')
			array_push($data_month,$date);
			$data_Val_Standard_noCM[$date] = $row['CRQnum'];
			//echo $date1."=".$date.' ';
		
		}
		sqlsrv_free_stmt( $stmt);
		
		//Standard Changes
		$sql = "SELECT YEAR(ch.Scheduled_Start_Date) year_,MONTH(ch.Scheduled_Start_Date) month_,count(*) CRQnum
				FROM dbo.tbl_Change_Approval_Details ch
				WHERE dbo.dateOnly(Scheduled_Start_Date) BETWEEN dbo.dateOnly('8/12/2012') AND dbo.dateOnly(getdate())
				AND CRQ_Type = 'Standard'
				AND [First Approval Date] IS NOT NULL
				AND Status NOT IN ('Draft','Request For Authorization') 
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
			//array_push($data_month,$date);
			$data_Val_Standard[$date] = $row['CRQnum'];
		}
		sqlsrv_free_stmt( $stmt);
		
		// Normal Changes 
		$sql = "SELECT YEAR(ch.Scheduled_Start_Date) year_,MONTH(ch.Scheduled_Start_Date) month_,count(*) CRQnum
				FROM dbo.tbl_Change_Approval_Details ch
				WHERE dbo.dateOnly(Scheduled_Start_Date) BETWEEN dbo.dateOnly('8/12/2012') AND dbo.dateOnly(getdate())
				AND CRQ_Type = 'Normal'
				AND Status NOT IN ('Draft','Request For Authorization') 
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
			//array_push($data_month_Normal,$date);
			$data_Val_Normal[$date] = $row['CRQnum'];
		}
		sqlsrv_free_stmt( $stmt);
		
		//Incidents
		$sql = "SELECT YEAR(inc.[Start Date]) year_,MONTH(inc.[Start Date]) month_,count(*) CRQnum
				FROM dbo.tbl_Incident_TechIMReport inc
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
			$date = substr(date("F", mktime(0, 0, 0, $m, 10)),0,3).' '.$row['year_'];
			//$date = substr(date("F", strtotime("$m month")),0,3).' '.$row['year_'];
			$data_Val_INC[$date] = $row['CRQnum'];
		}
		sqlsrv_free_stmt( $stmt);
		
		//Incidents due to Change
		$sql = "SELECT YEAR(inc.[Start Date]) year_,MONTH(inc.[Start Date]) month_,count(*) CRQnum
				FROM dbo.tbl_Incident_TechIMReport inc
				WHERE inc.Dueto_Change = 1
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
			/*	['Week', 'Number of Changes'],
				['2 2013',1,2,3,4,5,6],
				['1 2013',2,1,3,5,6,4],
				['12 2012',5,4,3,1,2,6],
			*/
			['Month', 'Standard Changes','Standard no CM','Normal Changes','Number of Incidents','Incidents due to Changes (IDC)','IDC % in Normal Changes'],  
			<?php	for($i=0;$i<count($data_month); $i++) {            
						$month = $data_month[$i];
						if ($data_Val_INC_DueChange[$month] == '') echo "['".$data_month[$i]."',".$data_Val_Standard[$month].",".$data_Val_Standard_noCM[$month].",".$data_Val_Normal[$month].",".$data_Val_INC[$month].",".$data_Val_INC_DueChange[$month].",' ']";
						else echo "['".$data_month[$i]."',".$data_Val_Standard[$month].",".$data_Val_Standard_noCM[$month].",".$data_Val_Normal[$month].",".$data_Val_INC[$month].",".$data_Val_INC_DueChange[$month].",'".round(($data_Val_INC_DueChange[$month]/$data_Val_Normal[$month])*100,1)."\%']";
						if ($i<count($data_month)-1) echo ",";	//add ',' to all except last element
					}
			?>           
			
			] );
		var dataChart_All = google.visualization.arrayToDataTable([           
			/*	['Week', 'Number of Changes'],
				['2 2013',1,2,3,4,5,6],
				['1 2013',2,1,3,5,6,4],
				['12 2012',5,4,3,1,2,6],
			*/
			['Month', 'Standard Changes','Standard no CM','Normal Changes','Incidents','IDCs'], 
			<?php	for($i=0;$i<count($data_month); $i++) {     
						$month = $data_month[$i];
						echo "['".$data_month[$i]."',".$data_Val_Standard[$month].",".$data_Val_Standard_noCM[$month].",".$data_Val_Normal[$month].",".$data_Val_INC[$month].",".$data_Val_INC_DueChange[$month]."]";
						//if ($data_month[$i]==1 && $data_year[$i]==2013) echo ",'Freeze']"; else echo ",'undefined']";
						if ($i<count($data_month)-1) echo ",";	//add ',' to all except last element
					}
			?>           
			
			] );	

		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});       
		  

		var options = { title : 'Trend of Authorized Changes',     
				chartArea:{left:60,top:30,right:0,width:"85%",height:"60%"},     
				vAxis: {gridlines:{count:8}},
				hAxis: {title: "Month", slantedText: true},    
				//curveType: "function" ,
				seriesType: "bars",    'isSlanted': true , 'isStacked':true,
				//series: { 0:{color:"green"},1:{color:"blue"}, 2:{type: "bars",color:"orange"},3:{type: "bars",color:"red"}} 
				series:{1:{color:"yellow"},2:{color:"green"},3:{type:"area",color:"orange"},4:{targetAxisIndex:1, type:"area",color:"red"}}, 
				vAxes:{1:{title:'Incidents Due to Changes',maxValue:400},2:{maxValue:4000,gridlines:{count:0}}},
				legend:{position: 'bottom', textStyle: {color: 'blue', fontSize: 16}}
				//,cht: 'lc', chds:'0,160', annotationColumns:[{column:2, size:12, type:'flag', priority:'high'}]

			};

		var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));         
		chart.draw(dataChart_All, options);       
	} 
</script>   
<table >
	<tr><td class="iframe_td"><div id="chart_div" style="width: 900px; height: 500px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
</table>




