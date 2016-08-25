<link href="style_new.css" rel="stylesheet" type="text/css" />
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
		$sql = "SELECT TOP 15  CASE ch.[First Approver]
								  WHEN 'AR_ESCALATOR' THEN ch.[First On Behalf of]
								  ELSE ch.[First Approver]
								END Approver, 
                ap.Approver_Name,
                Support_Company,Support_Organization,Support_Group_Name,count(*) CRQnum
				FROM dbo.vw_Change_Approval_Details ch LEFT OUTER JOIN dbo.tbl_Change_LK_Approvers ap
				ON (CASE ch.[First Approver]
								  WHEN 'AR_ESCALATOR' THEN ch.[First On Behalf of]
								  ELSE ch.[First Approver]
								END) = ap.Approver_Alias
				WHERE CRQ_Type = 'Normal'
				AND DATEADD(day, -DATEDIFF(day, 0, ch.[First Approval Date]), ch.[First Approval Date]) > '2:00:00 PM'
				AND dbo.DATEONLY( ch.[First Approval Date]) >= (dbo.DATEONLY( ch.Scheduled_Start_Date) -1)
				AND [First On Behalf of] NOT IN ('Hraslan','CM_Eval')
				GROUP BY  CASE ch.[First Approver]
								  WHEN 'AR_ESCALATOR' THEN ch.[First On Behalf of]
								  ELSE ch.[First Approver]
								END , ap.Approver_Name,Support_Company,Support_Organization,Support_Group_Name
				ORDER BY  CRQnum DESC;	";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		$data_dept = array();
		$data_team = array();		
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['Approver_Name']);
			array_push($data_dept,$row['Support_Company']);
			array_push($data_team,$row['Support_Group_Name']);
			array_push($data_Val,$row['CRQnum']);
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
			['Approver', 'Department','Team', 'Changes'],           
			<?php 
				//echo "[";
				for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."','".$data_dept[$i]."','".$data_team[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  
				//echo "]";
			?>
			] ); 
			
		var dataChart = google.visualization.arrayToDataTable([   
			['Approver', 'Number of Changes'],
			<?php 
				for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					} 
			?>
			] ); 
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});       
		
		//drawPieChart
		var options = { title: 'Top 15 Late First Approvers for Normal Changes'  ,  chartArea:{left:160,top:40,bottom:20,width:"85%",height:"80%"}, colors:['darkgreen'], //vAxis: {maxValue:3, minValue:1},
						hAxis: {title: 'Top 15 Late First Approvers (after 2:00 PM)', titleTextStyle: {color: 'red'}, gridlines:{count:7}}  };          
		var chart = new google.visualization.BarChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td  class="iframe_td"><div id="chart_div" style="width: 750px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>