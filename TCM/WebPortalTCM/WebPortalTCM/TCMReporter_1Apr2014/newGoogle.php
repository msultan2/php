<?php include ("newtemplate.php"); ?>
<?php
/* Specify the server and connection string attributes. */
		$serverName = "egoct-wirws01"; //10.230.95.87
		$connectionInfo = array( "Database"=>"SM_Change_Researching_DB");

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$sql = "SELECT CRQ_TYPE,count(*) CRQnum FROM dbo.vw_Change_Approval_Details GROUP BY CRQ_TYPE ORDER BY CRQnum DESC;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['CRQ_TYPE']);
			array_push($data_Val,$row['CRQnum']);
		}
		
		sqlsrv_free_stmt( $stmt);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(draw_ChangeTypes);      
	google.setOnLoadCallback(draw_ChangeFor);
	
	function draw_ChangeTypes() {         
		var data = google.visualization.arrayToDataTable([           
			['Type of Changes', 'Number of Changes'],           
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] ); 
			
		//drawTable
		var table_types = new google.visualization.Table(document.getElementById('table_div_types'));         
		table_types.draw(data, {showRowNumber: true});       
		
		//drawPieChart
		var options = {           title: 'Types of Changes'  , is3D: true  , chartArea:{left:20,top:20,width:"90%",height:"90%"} };          
		var chart_types = new google.visualization.PieChart(document.getElementById('chart_div_types'));         
		chart_types.draw(data, options);       
	} 
	function draw_ChangeFor(){
		alert('go');
	}
</script>   
	<table ><tr>
		<td class="iframe_td"><div id="chart_div_types" style="width: 300px; height: 200px;"></div>  </td>
	</tr>
	<tr>
		<td ><div id="table_div_types" style="width: 320px; height: 200px;" ></div>  </td>
	</tr></table>
<?php sqlsrv_close( $conn ); ?>
<?php include ("footer_new.php"); ?>