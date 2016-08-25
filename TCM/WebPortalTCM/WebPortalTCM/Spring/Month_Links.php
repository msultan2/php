	<link href="style_new.css" rel="stylesheet" type="text/css" />
<?php
		
			if (isset($_GET['month'])) {
			
			if ($_GET['month'] === 'Jan') {
				$month = "AND MONTH(ch.Scheduled_Start_Date) = 1 ";
			}
			if ($_GET['month'] === 'Feb') {
				$month = "AND MONTH(ch.Scheduled_Start_Date) = 2 ";
			}
			if ($_GET['month'] === 'Mar') {
				$month = "AND MONTH(ch.Scheduled_Start_Date) = 3 ";
			}
			if ($_GET['month'] === 'Apr') {
				$month = "AND MONTH(ch.Scheduled_Start_Date) = 4 ";
			}
			if ($_GET['month'] === 'May') {
				$month = "AND MONTH(ch.Scheduled_Start_Date) = 5 ";
			}
			if ($_GET['month'] === 'Jun') {
				$month = "AND MONTH(ch.Scheduled_Start_Date) = 6 ";
			}
			if ($_GET['month'] === 'Jul') {
				$month = "AND MONTH(ch.Scheduled_Start_Date) = 7 ";
			}
			if ($_GET['month'] === 'Aug') {
				$month = "AND MONTH(ch.Scheduled_Start_Date) = 8 ";
			}
			if ($_GET['month'] === 'Sep') {
				$month = "AND MONTH(ch.Scheduled_Start_Date) = 9 ";
			}
			if ($_GET['month'] === 'Oct') {
				$month = "AND MONTH(ch.Scheduled_Start_Date) = 10 ";
			}
			if ($_GET['month'] === 'Nov') {
				$month = "AND MONTH(ch.Scheduled_Start_Date) = 11 ";
			}
			if ($_GET['month'] === 'Dec') {
				$month = "AND MONTH(ch.Scheduled_Start_Date) = 12 ";
			}
		}	
		
		
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
		$sql = "SELECT  CRQ,CRQ_Type,CAST(ch.Scheduled_Start_Date AS Varchar)Scheduled_Start_Date,REPLACE(REPLACE(Description,'''',''),'\t','') Description,Assignee_Company,Assignee_Group,Assignee_Organization FROM dbo.tbl_Change_Task_Merged_Ver7_6 tsk,dbo.tbl_Change_Approval_Details_Ver7_6 ch
			WHERE ch.CRQ = tsk.Request_ID
			$month
			AND Emergency = 4
			AND Assignee_Company = 'Service Management';";
				
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		
		$data_CRQ = array();
		$data_Type = array();
		$data_Scheduled_Start_Date = array();
		$data_Description = array();
		$data_Company = array();
		$data_Group = array();
		$data_Organization = array();
		
		
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) 
		{
			
			array_push($data_CRQ,$row['CRQ']);
			array_push($data_Type,$row['CRQ_Type']);
			array_push($data_Scheduled_Start_Date,$row['Scheduled_Start_Date']);
			array_push($data_Description,$row['Description']);
			array_push($data_Company,$row['Assignee_Company']);
			array_push($data_Group,$row['Assignee_Group']);
			array_push($data_Organization ,$row['Assignee_Organization']);
			
			}
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn );

?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataChart = google.visualization.arrayToDataTable([   
				['CRQ','CRQ_Type','Scheduled_Start_Date','Description','Assignee_Company','Assignee_Group','Assignee_Organization'],
				<?php 
				for($i=0;$i<count($data_CRQ); $i++) 
				{ 
					echo "['".$data_CRQ[$i]."','".$data_Type[$i]."','".$data_Scheduled_Start_Date[$i]."','".$data_Description[$i]."','".$data_Company[$i]."','".$data_Group[$i]."','".$data_Organization[$i]."']";
					if ($i<count($data_CRQ)-1) echo ",";	//add ',' to all except last element
				}
			?>
			] );
			
			
				dataChart.setColumnProperty(0, {allowHtml: true});
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		//table.draw(dataChart, {showRowNumber: true});
		table.draw(dataChart, {allowHtml: true});
			
		
		var view = new google.visualization.DataView(dataChart);
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
	<td ><div id="table_div" style="width: 1500px;"></div></td>
	</tr>
</table>


	
	