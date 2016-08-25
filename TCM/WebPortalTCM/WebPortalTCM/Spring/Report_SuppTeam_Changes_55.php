<link href="style_new.css" rel="stylesheet" type="text/css" />
<?php 
	$startDate = '4/1/2015';
	$endDate = date('m/d/Y', time() + (60 * 60 * 24 * -1));
	
	if(isset($_GET['from'])) $getFrom = $_GET['from']; else $getFrom = $startDate;
	if(isset($_GET['to'])) $getTo = $_GET['to']; else $getTo = $endDate;
	if(isset($_GET['team'])) {
		$team = str_replace("__"," ",$_GET['team']); 
		if ($team == "") echo "All Teams Changes: ";
		else echo $team."Changes Report: ";
		
		$sql = "select cab.CRQ,CRQ_Type,cab.Requester,cab.Description,cab.Support_Company,cab.Support_Organization,cab.Support_Group_Name,cab.Assignee_Company,cab.Assignee_Organization,cab.Assignee_Group,cab.Product_Categorization_Tier_1,cab.Product_Categorization_Tier_2,cab.Product_Categorization_Tier_3,cab.Scheduled_Start_Date,CASE WHEN Status = 'Request For Authorization' THEN Approval_Pending ELSE 'Fully Approved' END ApPending from vw_Change_Daily_CAB_All cab where Assignee_Group = '%$team%' AND ( dbo.DateOnly(Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(Scheduled_Start_Date) >= '$getFrom') AND Status NOT IN ('Cancelled','Rejected');";		
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		//echo $sql_encoded;
		echo '<a href="excel.php?name='.str_replace(" ","_",$team).'_CRQs&query='.$sql_encoded.'">';
	?>
<img width=24px height=24px src="images/excel.bmp" style="border-style: none"/></a>

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
		$data_Requester = array(); 
		$data_Description = array(); 		
		$data_Support_Company = array();
		$data_Support_Organization = array();
		$data_Support_Group_Name = array();
		$data_Assignee_Organization = array();
		$data_Assignee_Group = array();
		$data_Assignee_Company = array();
		$data_Product_Categorization_Tier_1= array();
		$data_Product_Categorization_Tier_2 = array();
		$data_Product_Categorization_Tier_3 = array();
		$data_Scheduled_Start_Date = array();
		$data_ApPending = array();

		$sql = "select cab.CRQ,CRQ_Type,cab.Requester,cab.Description,cab.Support_Company,cab.Support_Organization,cab.Support_Group_Name,cab.Assignee_Company,cab.Assignee_Organization,cab.Assignee_Group,cab.Product_Categorization_Tier_1,cab.Product_Categorization_Tier_2,cab.Product_Categorization_Tier_3,cab.Scheduled_Start_Date,CASE WHEN Status = 'Request For Authorization' THEN Approval_Pending ELSE 'Fully Approved' END ApPending from vw_Change_Daily_CAB_All cab where Assignee_Group = '%$team%' AND ( dbo.DateOnly(Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(Scheduled_Start_Date) >= '$getFrom') AND Status NOT IN ('Cancelled','Rejected');";
				//echo $sql;
		$stmt = sqlsrv_query( $conn, $sql );
		//echo $sql;
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {	
			array_push($data_Requester,$row['Requester']);
			array_push($data_Description,$row['Description']);
			array_push($data_Support_Organization,$row['Support_Organization']);
			array_push($data_Support_Group_Name,$row['Support_Group_Name']);
			array_push($data_Support_Company,$row['Support_Company']);
			array_push($data_Assignee_Company,$row['Assignee_Company']);
			array_push($data_Assignee_Organization,$row['Assignee_Organization']);
			array_push($data_Assignee_Group,$row['Assignee_Group']);
			array_push($data_Product_Categorization_Tier_1,$row['Product_Categorization_Tier_1']);
			array_push($data_Product_Categorization_Tier_2,$row['Product_Categorization_Tier_2']);
			array_push($data_Product_Categorization_Tier_3,$row['Product_Categorization_Tier_3']);
			array_push($data_Scheduled_Start_Date,$row['Scheduled_Start_Date']);
			array_push($data_ApPending,$row['ApPending']);
		}
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn );
		
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1",{packages:['table']}); 
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataTable = google.visualization.arrayToDataTable([   
				['Requester','Description','Support_Company','Support_Organization','Support_Group_Name','Assignee_Company','Assignee_Organization','Assignee_Group','Product_Categorization_Tier_1','Product_Categorization_Tier_2','Product_Categorization_Tier_3','Scheduled_Start_Date','Approval Pending'],
				
		<?php 
				for($i=0;$i<count($data_Requester); $i++) 
				{ 
					echo "['".$data_Requester[$i]."','".$data_Description[$i]."','".$data_Support_Company[$i]."','".$data_Support_Organization[$i]."','".$data_Support_Group_Name[$i]."','".$data_Assignee_Company[$i]."','".$data_Assignee_Organization[$i]."','".$data_Assignee_Group[$i]."','".$data_Product_Categorization_Tier_1[$i]."','".$data_Product_Categorization_Tier_2[$i]."','".$data_Product_Categorization_Tier_3[$i]."',".$data_Scheduled_Start_Date[$i].",'".$data_ApPending[$i]."']",
					if ($i<count($data_Requester)-1) echo ",";	//add ',' to all except last element
				}
			?>
			
			] );
			
		//drawTable
		var options = {           title: 'CRQs Requested per Domain'  , is3D: true  , chartArea:{left:60,top:40,width:"20%",height:"80%"} , 'isStacked':false,
									colors:['green','royalblue','orange'] };          
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});  
		
	} 
</script>   
<table >
	<tr><td ><div id="table_div" ></div></td></tr>
</table>
<?php
	}
?>



