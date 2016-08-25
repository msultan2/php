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
		$sql = "SELECT TOP 10 Product_Categorization_Tier_1 tier,cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name, count(*) CRQnum
					FROM  dbo.vw_Change_Approval_Details cap
					WHERE cap.Scheduled_Start_Date <= getdate() 
					AND cap.CRQ_Type = 'Standard'
					AND [First Approval Date] IS NOT NULL
					AND Status <> 'Request For Authorization'
					GROUP BY Product_Categorization_Tier_1,cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name
					ORDER BY CRQnum DESC;	";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$top10 = 0;
		$data_Desc = array();
		$data_Val = array();
		$data_dept = array();
		$data_team = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,str_replace("'","",$row['tier']));
			array_push($data_dept,$row['Support_Company']);
			array_push($data_team,$row['Support_Group_Name']);
			array_push($data_Val,$row['CRQnum']);
			$top10+=$row['CRQnum'];
		}
		
		sqlsrv_free_stmt( $stmt);
		
		$sql="SELECT count(*) CRQnum FROM  dbo.vw_Change_Approval_Details WHERE Scheduled_Start_Date <= getdate() AND CRQ_Type = 'Standard' AND [First Approval Date] IS NOT NULL;";
		$stmt = sqlsrv_query( $conn, $sql );
		$data_total = 0;
		if (sqlsrv_fetch($stmt)=== false){
			die( print_r( sqlsrv_errors(), true));
		}
		$data_total = sqlsrv_get_field( $stmt, 0);
		sqlsrv_free_stmt( $stmt);
		
		$top10_percent=round(($top10/$data_total)*100,0);
		
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataTable = google.visualization.arrayToDataTable([           
			['Change Tier', 'Department','Team', 'Number of Changes'],           
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
			['Change Tier', 'Number of Changes'],
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
		var options = { title: 'Top 10 Change Tiers: <?php echo $top10_percent;?>%'  ,  chartArea:{left:200,top:40,bottom:20,width:"75%",height:"80%"}, colors:['darkgreen'], //vAxis: {maxValue:3, minValue:1},
						hAxis: {title: 'High Usage Change Tiers for Standard Changes', titleTextStyle: {color: 'red'}, gridlines:{count:7}}  };          
		var chart = new google.visualization.BarChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td  class="iframe_td"><div id="chart_div" style="width: 600px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>