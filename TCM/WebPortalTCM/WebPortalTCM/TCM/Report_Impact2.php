<?php
/* Specify the server and connection string attributes. */
		$serverName = "egzhr-wie2e01"; //10.230.95.87
		$connectionInfo = array( "Database"=>"SM_Change_Researching_DB");

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$sql = "SELECT Impact, count(*) CRQnum
				FROM dbo.vw_Change_Approval_Details
				WHERE CRQ_Type = 'Normal'
				GROUP BY  Impact
				ORDER BY  Impact;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			preg_match('/(?P<impact_level>\w+)\/(?P<y>\w+)/', $row['Impact'],$Impact_Exp); //(?P<x>\d+)-
			$Impact = $Impact_Exp['impact_level'];
			array_push($data_Desc,$Impact);
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
			['Impact Level', 'Number of Changes'],           
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] ); 
			    
		
		//drawPieChart
		var options = {           title: 'Impact Levels of Changes'  , is3D: true  , chartArea:{left:0,top:20,width:"90%",height:"90%"} };          
		var chart = new google.visualization.PieChart(document.getElementById('chart_div'));         
		chart.draw(data, options);       
	} 
</script>   
	<table ><tr>
		<td><div id="chart_div" style="width: 300px; height: 200px;"></div>  </td>
	</tr>
</table>
<?php sqlsrv_close( $conn ); ?>