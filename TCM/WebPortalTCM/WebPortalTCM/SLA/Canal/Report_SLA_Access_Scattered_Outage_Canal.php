<style type="text/css">
    <!-- Theme style -->
.text-red {
  color: #f56954 !important;
}
.bg-orange {
  background-color: #ff851b !important;
}
.text-yellow {
  color: #f39c12 !important;
}
.text-blue {
  color: #0073b7 !important;
}
.text-green {
  color: #00a65a !important;
}
</style>
        <!-- Theme style -->
        <!--link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" /-->
<?php
		/* Parse configuration file */
		$ini_array = parse_ini_file("../config.ini");
		
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
		$sql = "SELECT  CASE WHEN TT.Grade = 'P1' THEN 'Red'
							WHEN TT.Grade = 'P2' THEN 'Orange'
							WHEN TT.Grade = 'P3' THEN 'Yellow'
							WHEN TT.Grade = 'P4' THEN 'Blue'
							END Severity, 
						CASE WHEN TT.Grade = 'P1' THEN 1
							WHEN TT.Grade = 'P2' THEN 2
							WHEN TT.Grade = 'P3' THEN 3
							WHEN TT.Grade = 'P4' THEN 4
							END Severity_Order, 
							COUNT(vio.Incident_ID) Violated_TTs,
							COUNT(*) Total_TT
						  FROM dbo.vw_SS_Remedy_TT_SLA_Assigned TT
						  LEFT OUTER JOIN dbo.[vw_SS_Remedy_TT_SLA_Assigned_Violated] vio
						  ON TT.Incident_ID = vio.Incident_ID
							WHERE TT.Outage = 'No'
							AND TT.Region like '%Canal%'
						  AND TT.NoOfSites IS NOT NULL
						  GROUP BY CASE WHEN TT.Grade = 'P1' THEN 'Red'
							WHEN TT.Grade = 'P2' THEN 'Orange'
							WHEN TT.Grade = 'P3' THEN 'Yellow'
							WHEN TT.Grade = 'P4' THEN 'Blue'
							END, 
						CASE WHEN TT.Grade = 'P1' THEN 1
							WHEN TT.Grade = 'P2' THEN 2
							WHEN TT.Grade = 'P3' THEN 3
							WHEN TT.Grade = 'P4' THEN 4
							END
						ORDER BY 2;";
		$stmt = sqlsrv_query( $conn, $sql );
		
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		$data_Val_Total = array();
		$data_Val_Per = array();
		$severity_arr = array('Red','Orange','Yellow','Blue');
		
		foreach($severity_arr as $sev){
			$data_Val[$sev] = 0;
			$data_Val_Total[$sev] = 0;
			$data_Val_Per[$sev] = 100;
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$Severity = $row['Severity'];
			array_push($data_Desc,$row['Severity']);
			$data_Val[$Severity] = $row['Violated_TTs'];
			$data_Val_Total[$Severity] = $row['Total_TT'];
			if ($data_Val[$Severity] == 0) 
				$data_Val_Per[$Severity] = 100;
			else
				$data_Val_Per[$Severity] = (100 -round (($data_Val[$Severity] / $data_Val_Total[$Severity] )*100, 0));
			//echo "<p class=text-$Severity>".$Severity.": ".$data_Val[$Severity]."/".$data_Val_Total[$Severity]."</p>";
		}
		sqlsrv_free_stmt( $stmt);
		/*
		$stmt = sqlsrv_query( $conn, $sql_Total);
		if (sqlsrv_fetch($stmt)=== false){
			die( print_r( sqlsrv_errors(), true));
		}
		array_push($data_Desc,'Total');
		array_push($data_Val,sqlsrv_get_field( $stmt, 0));
		
		sqlsrv_free_stmt( $stmt);
		*/
		sqlsrv_close( $conn ); 
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:['gauge']});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(draw_ChangeFor);
	
	function draw_ChangeFor(){
		var data = google.visualization.arrayToDataTable([  
   /*['Label', 'Value'],           ['Memory', 80],           ['CPU', 55],           ['Network', 68] */		
			['Label', 'Value'],           
			<?php for($i=0;$i<count($severity_arr); $i++) { 
						$severity = $severity_arr[$i];
						echo "['".$severity."',". (100 -round (($data_Val[$severity] / $data_Val_Total[$severity] )*100, 0))."]"; 
						if ($i<count($severity_arr)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] );     
		
		var dataTable = google.visualization.arrayToDataTable([      
			<?php 
					echo "['','Red','Orange','Yellow','Blue'],";
					echo "['Violated',".$data_Val[Red].",".$data_Val[Orange] .",".$data_Val[Yellow] .",".$data_Val[Blue] ."],"; 
					echo "['Total',".$data_Val_Total[Red].",".$data_Val_Total[Orange] .",".$data_Val_Total[Yellow] .",".$data_Val_Total[Blue] ."],"; 
					echo "['Compliance %','".$data_Val_Per[Red]."%','".$data_Val_Per[Orange] ."%','".$data_Val_Per[Yellow] ."%','".$data_Val_Per[Blue] ."%']"; 
 
			?>
			] );     
		
		//drawGauge    
		var options = { redFrom: 0, redTo: 25, yellowFrom:25, yellowTo: 75, greenFrom: 75, greenTo: 100, minorTicks: 5, min:0, max:100, textStyle: {fontSize: 4},
						majorTicks:['0','25','50','75','100'],chartArea:{left:10,top:10,width:"60%",height:"90%"} }; //fontSize:2
		var chart = new google.visualization.Gauge(document.getElementById('chart_div'));         
		chart.draw(data, options);       
		
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: false});  
	}
</script>   
	<table ><tr>
		<td colspan=2><div style="background-color:white; id="chart_div" style="width: 700px; height: 200px; float: middle"></div>  </td></tr>
		<tr><td width=25px>&nbsp;</td><td ><div style="background-color:white; id="table_div" style="width: 650px; height: 200px; float: middle"></div></td>
	</tr></table>
