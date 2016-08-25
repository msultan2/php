<?php
	$startDate = '4/1/2013';
	$endDate = date('m/d/Y', time() + (60 * 60 * 24 * -1));
	//echo $weekback." ".$yesterday;

	if(isset($_GET['from'])) $getFrom = $_GET['from']; else $getFrom = $startDate;
	if(isset($_GET['to'])) $getTo = $_GET['to']; else $getTo = $endDate;
	if(isset($_GET['team'])) $team = str_replace("__"," ",$_GET['team']); else $team = "";
	
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
		$sql = "SELECT Product_Categorization_Tier_1,Product_Categorization_Tier_2,Product_Categorization_Tier_3,count(*) CRQnum 
				FROM  dbo.vw_Change_Approval_Details ch
				LEFT OUTER JOIN [SM_Change_Researching_DB].dbo.vw_Change_Approvers_Merged ap ON ch.CRQ = ap.Infrastructure_Change_ID 
				WHERE CRQ_Type = 'Normal' AND Status NOT IN ('Request For Authorization','Cancelled','Rejected') 
					AND ( dbo.DateOnly(ch.Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(ch.Scheduled_Start_Date) >= '$getFrom')
					AND ch.Support_Organization like '%$team%'
					AND (
						(( ch.Scheduled_Start_Date < '1/10/2014' AND	DATEADD(day, -DATEDIFF(day, 0, [First Approval Date]), [First Approval Date]) > '2:00:00 PM' 
							AND [SM_Change_Researching_DB].dbo.DATEONLY( [First Approval Date]) >= [SM_Change_Researching_DB].dbo.DATEONLY( [SM_Change_Researching_DB].dbo.udf_GetPrevNextWorkDay(ch.Scheduled_Start_Date, 'Previous'))   
						) 
						OR  
						(	ch.Scheduled_Start_Date >= '1/10/2014' AND 
							([SM_Change_Researching_DB].dbo.DATEONLY( [First Approval Date]) >= [SM_Change_Researching_DB].dbo.DATEONLY( [SM_Change_Researching_DB].dbo.udf_GetPrevNextWorkDay(ch.Scheduled_Start_Date, 'Previous'))   
							AND NOT DATEADD(day, -DATEDIFF(day, 0, ch.Scheduled_Start_Date), ch.Scheduled_Start_Date) > '3:00:00 PM' 
							)  
							AND ap.[Approval Aduit Trail] like '%CM_Authorized%'
						)
					)
					OR    Emergency = 0 ) 
					AND (Description LIKE ('%fix%') OR Justification LIKE ('%fix%') OR Description LIKE ('%problem%') OR Justification LIKE ('%problem%') OR Description LIKE ('%solve%') OR Justification LIKE ('%solve%'))
					AND ch.Support_Company IN ('Products & Services Delivery','IT Operations')
				GROUP BY Product_Categorization_Tier_1,Product_Categorization_Tier_2,Product_Categorization_Tier_3
				ORDER BY CRQnum DESC;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['Product_Categorization_Tier_1']." > ".$row['Product_Categorization_Tier_2']." > ".$row['Product_Categorization_Tier_3']);
			array_push($data_Val,$row['CRQnum']);
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
			['Change Type', 'Emergency Fix'],           
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] ); 
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(data, {showRowNumber: true});       
		
		//drawPieChart
		var options = {           title: 'Emergency Fix'  , is3D: true  , chartArea:{left:20,top:20,width:"60%",height:"90%"} };          
		var chart = new google.visualization.PieChart(document.getElementById('chart_div'));         
		chart.draw(data, options);       
	}
</script>   
	<table ><tr>
		<td><div id="chart_div" style="width: 600px; height: 200px;"></div>  </td>
	</tr>
	<tr>
		<td ><div id="table_div" style="width: 400px; height: 150px;" ></div>  </td>
	</tr></table>
<?php sqlsrv_close( $conn ); ?>