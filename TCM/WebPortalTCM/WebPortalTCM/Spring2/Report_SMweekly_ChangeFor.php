<link href="style_new.css" rel="stylesheet" type="text/css" />
<?php

	$weekback = date('m/d/Y', time() + (60 * 60 * 24 * -7));
	$yesterday = date('m/d/Y', time() + (60 * 60 * 24 * -1));
	//echo $weekback." ".$yesterday;

	if(isset($_GET['from'])) $getFrom = $_GET['from']; else $getFrom = $weekback;
	if(isset($_GET['to'])) $getTo = $_GET['to']; else $getTo = $yesterday;
	
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
		// get IT & NW CRQs Normal from today till last week (ex: from yesterday Wednesday till last Thursday) 7 days
		$sql = "SELECT CASE WHEN ".$ini_array['IT_CONDITION']." THEN 'IT' ELSE 'NETWORK' END ChangeFor,count(*) CRQnum FROM dbo.vw_Change_Approval_Details ch
				WHERE CRQ_Type = 'Normal'
				AND Status NOT IN ('Request For Authorization','Cancelled','Rejected')
				AND dbo.DateOnly(Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(Scheduled_Start_Date) >= '$getFrom'
				GROUP BY CASE WHEN ".$ini_array['IT_CONDITION']." THEN 'IT' ELSE 'NETWORK' END  
				ORDER BY ChangeFor DESC;";
		$sql_temp = "SELECT CASE WHEN ChangeFor IN ('','General') THEN 'Network' ELSE ChangeFor END ChangeFor,count(*) CRQnum FROM dbo.vw_Change_Approval_Details ch
				WHERE Support_Company IN ('Regional Operations','Network Engineering','Products & Services Delivery','Service Management','IT Operations')
				AND CRQ_Type = 'Normal'
				AND Status NOT IN ('Request For Authorization','Cancelled')
				AND dbo.DateOnly(Scheduled_Start_Date) >= '8/1/2013' AND dbo.DateOnly(Scheduled_Start_Date) < '9/1/2013'
				GROUP BY CASE WHEN ChangeFor IN ('','General') THEN 'Network' ELSE ChangeFor END  
				ORDER BY ChangeFor DESC;";
		//echo $sql;
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val_NR = array();
		$data_Val_ST = array();
		$data_Val_ST_NO_CM = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['ChangeFor']);
			array_push($data_Val_NR,$row['CRQnum']);
		}
		
		sqlsrv_free_stmt( $stmt);
		
		// get IT & NW CRQs Standard from today till last week (ex: from yesterday Wednesday till last Thursday) 7 days
		//Support_Company IN ('Regional Operations','Network Engineering','Products & Services Delivery','Service Management','IT Operations')
		$sql = "SELECT CASE WHEN ".$ini_array['IT_CONDITION']." THEN 'IT' ELSE 'NETWORK' END ChangeFor,count(*) CRQnum FROM dbo.vw_Change_Approval_Details ch
				WHERE CRQ_Type = 'Standard'
				AND Status NOT IN ('Request For Authorization','Cancelled','Rejected')
				AND dbo.DateOnly(Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(Scheduled_Start_Date) >= '$getFrom'
				GROUP BY CASE WHEN ".$ini_array['IT_CONDITION']." THEN 'IT' ELSE 'NETWORK' END  
				ORDER BY ChangeFor DESC;";
		$sql_temp = "SELECT CASE WHEN ChangeFor IN ('','General') THEN 'Network' ELSE ChangeFor END ChangeFor,count(*) CRQnum FROM dbo.vw_Change_Approval_Details ch
				WHERE Support_Company IN ('Regional Operations','Network Engineering','Products & Services Delivery','Service Management','IT Operations')
				AND CRQ_Type = 'Standard'
				AND Status NOT IN ('Request For Authorization','Cancelled')
				AND dbo.DateOnly(Scheduled_Start_Date) >= '8/1/2013' AND dbo.DateOnly(Scheduled_Start_Date) < '9/1/2013'
				GROUP BY CASE WHEN ChangeFor IN ('','General') THEN 'Network' ELSE ChangeFor END  
				ORDER BY ChangeFor DESC;";
		//echo $sql;
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			//array_push($data_Desc,$row['ChangeFor']);
			array_push($data_Val_ST,$row['CRQnum']);
		}
		
		sqlsrv_free_stmt( $stmt);
		
		// get IT & NW CRQs Standard_WN_CM from today till last week (ex: from yesterday Wednesday till last Thursday) 7 days
		$sql = "SELECT CASE WHEN ".$ini_array['IT_CONDITION']." THEN 'IT' ELSE 'NETWORK' END ChangeFor,count(*) CRQnum FROM dbo.vw_Change_Approval_Details ch
				WHERE CRQ_Type = 'Standard'
				AND [First Approval Date] IS NULL
				AND Status NOT IN ('Request For Authorization','Cancelled')
				AND dbo.DateOnly(Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(Scheduled_Start_Date) >= '$getFrom'
				GROUP BY CASE WHEN ".$ini_array['IT_CONDITION']." THEN 'IT' ELSE 'NETWORK' END  
				ORDER BY ChangeFor DESC;";

		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			//array_push($data_Desc,);
			//echo $row['ChangeFor'].": ".$row['CRQnum'];
			if ($row['ChangeFor']='Standard') array_push($data_Val_ST_NO_CM,$row['CRQnum']);
			else array_push($data_Val_ST_NO_CM,0);
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
			['Changes For', 'Non-Standard Changes','Standard Changes','Standard With No CM'],           
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						if(is_numeric($data_Val_ST_NO_CM[$i])) $CRQs_no_CM = $data_Val_ST_NO_CM[$i]; else $CRQs_no_CM = 0;
						echo "['".$data_Desc[$i]."',".$data_Val_NR[$i].",".($data_Val_ST[$i]-$data_Val_ST_NO_CM[$i]).",".$CRQs_no_CM."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] );       
		var dataTable = google.visualization.arrayToDataTable([           
			['Changes For', 'Non-Standard Changes','Standard Changes','Standard With No CM','Total'],           
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val_NR[$i].",".($data_Val_ST[$i]-$data_Val_ST_NO_CM[$i]).",".$data_Val_ST_NO_CM[$i].",".($data_Val_NR[$i]+$data_Val_ST[$i])."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] ); 
		var options = {           title: 'CRQs Requested per Domain'  , is3D: true  , chartArea:{left:60,top:40,width:"50%",height:"80%"} , 'isStacked':false,
									colors:['green','royalblue','orange'] };          
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(data, options);       
		
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: false}); 
	}
</script>   
	<table ><tr>
		<td class="iframe_td"><div id="chart_div" style="width: 500px; height: 400px;"></div>  </td>
	</tr><tr>
		<td><div id="table_div" style="width: 500px;"></div></td>
	</tr>
</table>
<?php sqlsrv_close( $conn ); ?>