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
		
		$sql = "SELECT  SUM(CRQ_Counts) CRQ_Counts,Month FROM dbo.vw_Emergency_Fixes
			GROUP BY Month
			ORDER BY SUM(CRQ_Counts)";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Assignee_Group = array();
		$data_Assignee_Organization= array();
		$data_Month = array();
		$data_CRQ = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Month,$row['Month']);
			array_push($data_CRQ,$row['CRQ_Counts']);
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
			['Month', 'Count'],           
			<?php for($i=0;$i<count($data_CRQ); $i++) {             
						//if(is_numeric($data_Val_ST_NO_CM[$i])) $CRQs_no_CM = $data_Val_ST_NO_CM[$i]; else $CRQs_no_CM = 0;
						echo "['".$data_Month[$i]."',".$data_CRQ[$i]."]"; 
						if ($i<count($data_CRQ)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] );       
		var dataTable = google.visualization.arrayToDataTable([           
			['Month', 'Count'],           
			<?php for($i=0;$i<count($data_CRQ); $i++) {             
						//if(is_numeric($data_Val_ST_NO_CM[$i])) $CRQs_no_CM = $data_Val_ST_NO_CM[$i]; else $CRQs_no_CM = 0;
						//echo "['".$data_Month[$i]."',".$data_CRQ[$i]."]"; 
						echo "['<a href=\"Month_Links.php?month=".$data_Month[$i]."\" target = \'_blank\'>".$data_Month[$i]."</a>','".$data_CRQ[$i]."']"; 
						if ($i<count($data_CRQ)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] ); 
		var options = {           title: 'CRQs Requested per Domain'  , is3D: true  , chartArea:{left:60,top:40,width:"100%",height:"80%"} , 'isStacked':false,
									colors:['green','royalblue','orange'] };          
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(data, options);       
		
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: false}); 
		table.draw(dataTable, {allowHtml: true});
	}
</script>   
	<table ><tr>
		<td class="iframe_td"><div id="chart_div" style="width: 1000px; height: 400px;"></div>  </td>
	</tr><tr>
		<td><div id="table_div" style="width: 500px;"></div></td>
	</tr>
</table>
<?php sqlsrv_close( $conn ); ?>