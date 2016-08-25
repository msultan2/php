<?php
/* Specify the server and connection string attributes. */
		$serverName = "egzhr-wie2e01"; //10.230.95.87
		$connectionInfo = array( "Database"=>"SM_Change_Researching_DB");

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$sql = "WITH Temp_Impacts AS ( SELECT CASE 
					WHEN [External Customer] IS NULL AND [Internal Customer] IS NULL AND [Nodes/Systems] IS NULL AND [Reporting] IS NULL 
					  THEN 'No Impacts'
					WHEN [External Customer] IS NOT NULL  
					  THEN 'Service Impact'
					WHEN [Internal Customer] IS NOT NULL 
					  THEN 'Business Impact'
					WHEN [Nodes/Systems]  IS NOT NULL 
					  THEN 'Technical Impact'
					WHEN [Internal Customer] IS NOT NULL 
					  THEN 'Reporting'  
					ELSE
					  'N/A'
					  END Impact_Detail
				FROM [vw_Change_Approval_Details]
				WHERE CRQ_Type = 'Normal')
				SELECT Impact_Detail,count(*) CRQnum
				FROM Temp_Impacts
				WHERE Impact_Detail <> 'N/A'
				GROUP BY Impact_Detail
				ORDER BY Impact_Detail";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['Impact_Detail']);
			array_push($data_Val,$row['CRQnum']);
		}
		sqlsrv_free_stmt( $stmt);
		
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(draw_ChangeTypes);  
	
	function draw_ChangeTypes() {         
		var data = google.visualization.arrayToDataTable([           
			['Impact Details', 'Number of Changes'],           
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] ); 
			     
		
		//drawPieChart
		var options = {           title: 'Impact Details of Changes'  , is3D: true  , chartArea:{left:0,top:20,width:"90%",height:"90%"} };          
		var chart = new google.visualization.PieChart(document.getElementById('chart_div'));         
		chart.draw(data, options);       
	} 
</script>   
	<table ><tr>
		<td><div id="chart_div" style="width: 300px; height: 200px;"></div>  </td>
	</tr>
</table>
<?php sqlsrv_close( $conn ); ?>