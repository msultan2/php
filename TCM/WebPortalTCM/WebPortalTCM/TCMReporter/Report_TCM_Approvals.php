<?php session_start();  $pagePrivValue=100; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<table><tr><td><div class="body_text"><b>TCM Evaluation Approvals per Month <b></div></td>
<td align=right >
<?php 
		$sql = "SELECT MONTH(tr.AppDateTime) month_, YEAR(tr.AppDateTime) year_, tr.Approver, count(*) CRQnum FROM dbo.tbl_Splited_Approval_Audit_Trail tr WHERE (tr.Approval_On_Behalf = 'CM_Eval' OR LOWER(tr.Approval_On_Behalf) = 'hraslan') AND Approver IN ('ASalama8','hmohamed','Hraslan','MAtef5','MShaarawy3','SNabil2') GROUP BY MONTH(tr.AppDateTime),YEAR(tr.AppDateTime),tr.Approver ORDER BY year_,month_,Approver;";
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		//echo $sql;
		echo '<a href="excel.php?name=TCM_Approvals&query='.$sql_encoded.'">';
	?>
<img width=24px height=24px src="images/excel.bmp" style="border-style: none"/></a>
</td></tr></table>
<?php
	if(isset($_GET['from'])) $getFrom = $_GET['from']; else $getFrom = "1/1/2013";
	
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
		
		$data_Date = array();
		$data_Val = array();
		
		$array_approvers = array('Hraslan','ASalama8','hmohamed','MShaarawy3','SNabil2','MAtef5'); //
		foreach ($array_approvers as &$app) {
			$data_Val[$app] = array();
			$m = $ini_array['NUM_OF_MONTHS_EVAL'] - 1; //4;
			for ($i=0; $i < $ini_array['NUM_OF_MONTHS_EVAL']; $i++) {
				$sql = "SELECT MONTH(tr.AppDateTime) month_, YEAR(tr.AppDateTime) year_, tr.Approver, count(*) CRQnum
				FROM dbo.tbl_Splited_Approval_Audit_Trail tr
				WHERE (tr.Approval_On_Behalf = 'CM_Eval' OR LOWER(tr.Approval_On_Behalf) = 'hraslan')
				AND Approver = '".$app."'
				AND dbo.dateOnly(AppDateTime) BETWEEN dbo.dateOnly(DATEADD(month,-$m,getdate()-(DATEPART(d,getdate()) - 1)))
								AND DATEADD(second,-1,dbo.dateOnly(DATEADD(month,-$m+1,getdate()-(DATEPART(d,getdate()) - 1))))
				GROUP BY MONTH(tr.AppDateTime),YEAR(tr.AppDateTime),tr.Approver
				ORDER BY month_,year_,Approver;";
				$stmt = sqlsrv_query( $conn, $sql );
				//echo $sql;
				if( $stmt === false) {
					die( print_r( sqlsrv_errors(), true) );
				}
				if (sqlsrv_fetch($stmt)=== false){
					die( print_r( sqlsrv_errors(), true));
				}	 
				$year = sqlsrv_get_field( $stmt, 1);
				$month = sqlsrv_get_field( $stmt, 0);
				$numof_CRQs = sqlsrv_get_field( $stmt, 3);
				//$data_month = date("F", mktime(0, 0, 0, $month, 10))." ".$year;
				$data_month = substr(date("F", strtotime("-$m month")),0,3).' '.date("Y", strtotime("-$m month"));
				$data_Val[$app][$data_month] = $numof_CRQs;
				$data_Date[$i] = $data_month;
				sqlsrv_free_stmt( $stmt);
				//echo $app.": ".$data_Date[$i]." ";
				$m = $m -1;
			}
			
			
		}
		sqlsrv_free_stmt( $stmt);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataTable = google.visualization.arrayToDataTable([                       
			['Month',  
			<?php	for($i=0;$i<count($array_approvers); $i++) {             
						echo "'".$array_approvers[$i]."'";
						if ($i<count($array_approvers)-1) echo ",";	//add ',' to all except last element
					}
			?>
			],           
			<?php 
				$i=0;
				foreach ($data_Date as &$month) {             
					echo "['".$month."',"; 
					$j=0;
					foreach ($array_approvers as &$app) {            
						echo $data_Val[$app][$month]; 
						if ($j<count($array_approvers)-1) echo ",";	
						$j=$j+1;
					}
					echo "]";
					if ($i<count($data_Date)-1) echo ",";	//add ',' to all except last element
					$i=$i+1;
				}
			?>
			] ); 
		
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});       
		
		//drawPieChart
		var options = { title: 'TCM Evaluation Approvals'  ,  chartArea:{left:40,top:40,width:"73%",height:"70%"}, //legendTextStyle: {color:'#00FF00'}, //vAxis: {maxValue:3, minValue:1},
						vAxis: { gridlines:{count:10}} , is3D:true, 'isStacked':false , hAxis: {slantedText:true} };          
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(dataTable, options);       
	} 
</script>   
<table >
	<tr><td  class="iframe_td"><div id="chart_div" style="width: 700px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
</table>
<table>
	<tr>	
		<td>	<iframe  width="700px" height="700px" seamless src="Report_Late_CM_Eval.php?from=<?php echo $getFrom; ?>" frameborder="0" ></iframe></td>
		<td>	<iframe  width="700px" height="700px" seamless src="Report_Late_CM_Auth.php?from=<?php echo $getFrom; ?>" frameborder="0" ></iframe></td>
	</tr>
</table>
<?php sqlsrv_close( $conn ); ?>
<?php include ("footer_new.php"); ?>