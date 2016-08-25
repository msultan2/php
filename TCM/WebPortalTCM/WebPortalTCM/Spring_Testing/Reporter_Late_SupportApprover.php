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
		$sql = "Select COUNT(*)Count ,[Third Approver] from dbo.tbl_Change_Approval_Details_Ver7_6
			WHERE Datepart(Hour,[Third Approval Date]) > 17
			AND Scheduled_Start_Date >= GETDATE() - 7
			AND CRQ_Type = 'Normal'
			AND [Third Approver] NOT IN ('OSelim1','Demo','RKamal4','Agouda1','Remedy Application Service')
			GROUP BY [Third Approver];";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Count = array();
		$data_Approver = array();		
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Count,$row['Count']);
			array_push($data_Approver,$row['Third Approver']);
		}
		
		sqlsrv_free_stmt( $stmt);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	//google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataTable = google.visualization.arrayToDataTable([           
			['Count', 'Approver'],           
			<?php 
				//echo "[";
				for($i=0;$i<count($data_Count); $i++) {             
						echo "['".$data_Count[$i]."','".$data_Approver[$i]."']"; 
						if ($i<count($data_Count)-1) echo ",";	//add ',' to all except last element
					}  
				//echo "]";
			?>
			] ); 
			
				dataTable.setColumnProperty(0, {allowHtml: true});
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		//table.draw(dataChart, {showRowNumber: true});
		table.draw(dataTable, {allowHtml: true});
			
		
		var view = new google.visualization.DataView(dataTable);
		view.setColumns([0, 
						1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" }]);      
	} 

</script>   
<table  >
	<tr>
	<td ><div id="table_div" style="width: 300px;"></div></td>
	</tr>
</table>
<?php sqlsrv_close( $conn ); ?>