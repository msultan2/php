<?php
	$startDate = '4/1/2013';
	$endDate = date('m/d/Y', time() + (60 * 60 * 24 * -1));
	//echo $weekback." ".$yesterday;

	if(isset($_GET['from'])) $getFrom = $_GET['from']; else $getFrom = $startDate;
	if(isset($_GET['to'])) $getTo = $_GET['to']; else $getTo = $endDate;
	
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
		
		$sql = "SELECT Support_Organization,count(*) CRQnum 
				FROM dbo.vw_Change_Approval_Details ch 
				LEFT OUTER JOIN dbo.vw_Change_Approvers_Merged ap 
				ON ch.CRQ = ap.Infrastructure_Change_ID 
				WHERE Status NOT IN ('Cancelled','Rejected') 
				AND [SM_Change_Researching_DB].dbo.DATEONLY( [First Approval Date]) >= [SM_Change_Researching_DB].dbo.DATEONLY( [SM_Change_Researching_DB].dbo.udf_GetPrevNextWorkDay(ch.Scheduled_Start_Date, 'Previous'))   
					AND(Emergency = 0 OR Emergency = 2 OR Emergency = 3 ) 
					AND ChangeFor = 'Network'
					AND dbo.DateOnly(Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(Scheduled_Start_Date) >= '$getFrom'
				GROUP BY Support_Organization
				ORDER BY CRQnum DESC;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		$data_Month = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['Support_Organization']);
			array_push($data_Val,$row['CRQnum']);
			array_push($data_Month,$row['Month']);
		}
		
		sqlsrv_free_stmt( $stmt);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1",{packages:['table']}); 
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(draw_ChangeFor);
	
	function draw_ChangeFor(){
		var data = google.visualization.arrayToDataTable([           
			['Team', 'Exceptions'],           
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] ); 	
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(data, {showRowNumber: true});
		var options = {            is3D: true  , chartArea:{left:60,top:40,width:"20%",height:"80%"} , 'isStacked':false,
									colors:['green','royalblue','orange'] }; 		 
	}
</script>   
	<table >
	<tr>
		<td ><div id="table_div" style="width: 500px; height: 700px;" ></div>  </td>
		
	</tr>
	
	
	
	</table>
<?php sqlsrv_close( $conn ); ?>