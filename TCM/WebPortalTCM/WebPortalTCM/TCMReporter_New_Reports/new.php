<?php  include ("templateReporter.php"); ?>
<div class="ubercolortabs">
<ul>
<li><a href="http://www.dynamicdrive.com" style="margin-left: 12px"><span>Home</span></a></li>
<li><a href="http://www.dynamicdrive.com/new.htm"><span>New</span></a></li>
<li class="selected"><a href="http://www.dynamicdrive.com/revised.htm"><span>Revised</span></a></li>
<li><a href="http://tools.dynamicdrive.com"><span>Tools</span></a></li>	
<li><a href="http://www.dynamicdrive.com/forums/"><span>Forums</span></a></li>	
</ul>
</div>

<div class="ubercolordivider"> </div>

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
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var data = google.visualization.arrayToDataTable([           
			['Type of Changes', 'Number of Changes'],           
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
		var options = {           title: 'Types of Changes'  , is3D: true  , chartArea:{left:20,top:20,width:"100%",height:"75%"} };          
		var chart = new google.visualization.PieChart(document.getElementById('chart_div'));         
		chart.draw(data, options);       
	} 
</script>   
	<table width=100%><tr>
		<td width=500px><div id="chart_div" style="width: 500px; height: 300px; "></div>  </td>
		<td width=500px><div id="table_div" style="width: 200px; height: 300px;"></div>  </td>
	</tr></table>
<?php sqlsrv_close( $conn ); ?>
<?php include ("footer.php"); ?>