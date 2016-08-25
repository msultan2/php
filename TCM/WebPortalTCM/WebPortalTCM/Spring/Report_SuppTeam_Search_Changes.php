<link href="style_new.css" rel="stylesheet" type="text/css" />


<?php
	$startDate = '1/1/2015';
	$endDate = date('m/d/Y', time() + (60 * 60 * 24 * -1));
	
	if(isset($_GET['from'])) $getFrom = $_GET['from']; else $getFrom = $startDate;
	if(isset($_GET['to'])) $getTo = $_GET['to']; else $getTo = $endDate;
	
	if(isset($_GET['team'])) {
		$team = str_replace("__"," ",$_GET['team']); 
		if ($team == "") echo "All Teams Changes: ";
		else echo $team." Changes Report: ";
	?>


<?php // content="text/plain; charset=utf-8"

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
		$data_Description = array();
		$data_CRQ = array();
		$data_Last_Modified_By = array();
		$data_Status = array();
 		$data_CRQ_Type = array();
		$data_Support_Company = array();
		$data_Support_Organization = array();
		$data_Support_Group_Name = array();
		$data_Assignee_Organization = array();
		$data_Assignee_Group = array();
		$data_Assignee_Company = array();
		$data_Scheduled_Start_Date = array();
		$data_ApPending = array();
		$data_Requester = array();
		$data_PC1 = array();
		$data_PC2 = array();
		$data_PC3 = array();
		$sql = "select ch.CRQ,ch.Requester,ch.Product_Categorization_Tier_1,ch.Product_Categorization_Tier_2,ch.Product_Categorization_Tier_3,ch.CRQ_Type,replace(replace(replace (ch.Description, '''',''),CHAR(13),' ... '),CHAR(10),' ')Description,ch.Support_Company,ch.Support_Organization,ch.Support_Group_Name,tsk.Assignee_Group,CAST(ch.Scheduled_Start_Date AS VARCHAR)Scheduled_Start_Date,ch.APApprovers,ch.Last_Modified_By,ch.Status from dbo.tbl_Change_Approval_Details_Ver7_6 ch,dbo.tbl_Change_Task_Merged_Ver7_6 tsk where tsk.Request_ID = ch.CRQ AND tsk.Assignee_Group like '%$team%' AND ( dbo.DateOnly(ch.Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(ch.Scheduled_Start_Date) >= '$getFrom') AND Status NOT IN ('Cancelled','Rejected') AND ch.ChangeFor IS NOT NULL;";
		$stmt = sqlsrv_query( $conn, $sql );
		//echo $sql;
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {	
	
			array_push($data_CRQ,$row['CRQ']);
			array_push($data_Last_Modified_By,$row['Last_Modified_By']);
			array_push($data_Status,$row['Status']);
			array_push($data_CRQ_Type,$row['CRQ_Type']);
			array_push($data_Description,$row['Description']);
			array_push($data_Support_Organization,$row['Support_Organization']);
			array_push($data_Support_Group_Name,$row['Support_Group_Name']);
			array_push($data_Support_Company,$row['Support_Company']);
			array_push($data_Assignee_Group,$row['Assignee_Group']);
			array_push($data_Scheduled_Start_Date,$row['Scheduled_Start_Date']);
			array_push($data_Requester,$row['Requester']);
			array_push($data_PC1,$row['Product_Categorization_Tier_1']);
			array_push($data_PC2,$row['Product_Categorization_Tier_2']);
			array_push($data_PC3,$row['Product_Categorization_Tier_3']);
			
		}
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn );
		
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataTable = google.visualization.arrayToDataTable([   
				['Assignee_Group','CRQ','CRQ_Type','Tier2','Description','Tier3','Scheduled_Start_Date','Status','Requester','Last Modified By','Support_Group_Name','Tier1'],
				
		<?php 
				for($i=0;$i<count($data_CRQ); $i++) 
				{ 
					echo "['".$data_Assignee_Group[$i]."','".$data_CRQ[$i]."','".$data_CRQ_Type[$i]."','".$data_PC2[$i]."','".$data_Description[$i]."','".$data_PC3[$i]."','".$data_Scheduled_Start_Date[$i]."','".$data_Status[$i]."','".$data_Requester[$i]."','".$data_Last_Modified_By[$i]."','".$data_Support_Group_Name[$i]."','".$data_PC1[$i]."']";
					if ($i<count($data_CRQ)-1) echo ",";	//add ',' to all except last element
				}
			?>
			
			] ); 
			
		//drawTable     
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true}); 

		var view = new google.visualization.DataView(dataTable);
		view.setColumns([0, 
						1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" }]);      
		
	} 
</script>   
<table >
	<tr><td ><div id="table_div" style="width: 3000px; height: 1000px;"></div></td></tr>
</table>
<?php
	}
?>



