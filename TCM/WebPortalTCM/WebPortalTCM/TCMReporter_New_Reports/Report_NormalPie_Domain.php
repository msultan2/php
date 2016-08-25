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
		$sql = "SELECT CASE  WHEN Support_Group_Name IN ('Post-Paid Charging','Data & Innovation','Online Enterprise') THEN 'IT' 
										WHEN Support_Group_Name = 'Mobile Internet & Data Support' THEN 'Services' 
										WHEN Support_Group_Name IN ('Fixed Transmission','Fixed Core Configuration') THEN 'Fixed'
										WHEN support_organization IN ('CRM & Sales','Customer Management Systems','Business Intelligence') THEN 'IT' 
										WHEN support_organization IN ('Charging & Mediation','Charging IN & Mediation','Network Information') THEN 'Services'
										WHEN support_organization = 'Mobile Internet & Enterprise' THEN 'Fixed'
										WHEN support_company = 'IT Operations' THEN 'IT'
										WHEN support_company IN ('Network Engineering','Service Management') THEN 'Core'
										WHEN support_company  = 'Regional Operations' THEN 'Radio'
										ELSE 'Services' END Domain,isnull(count(*),0) CRQnum
						   FROM dbo.vw_change_approval_details ch
									WHERE CRQ_Type = 'Normal'
							AND Support_Company IN ('Network Engineering','Service Management','Regional Operations','IT Operations','Products & Services Delivery')
							AND STATUS NOT IN ('Draft','Request For Authorization')
									GROUP BY 
										CASE WHEN Support_Group_Name IN ('Post-Paid Charging','Data & Innovation','Online Enterprise') THEN 'IT' 
										WHEN Support_Group_Name = 'Mobile Internet & Data Support' THEN 'Services' 
										WHEN Support_Group_Name IN ('Fixed Transmission','Fixed Core Configuration') THEN 'Fixed'
										WHEN support_organization IN ('CRM & Sales','Customer Management Systems','Business Intelligence') THEN 'IT' 
										WHEN support_organization IN ('Charging & Mediation','Charging IN & Mediation','Network Information') THEN 'Services'
										WHEN support_organization = 'Mobile Internet & Enterprise' THEN 'Fixed'
										WHEN support_company = 'IT Operations' THEN 'IT'
										WHEN support_company IN ('Network Engineering','Service Management') THEN 'Core'
										WHEN support_company  = 'Regional Operations' THEN 'Radio'
										ELSE 'Services' END
									ORDER BY 1;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['Domain']);
			array_push($data_Val,$row['CRQnum']);
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
			['Domain', 'Number of Normal Changes'],           
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
		var options = {           title: 'Normal Changes Per Domain'  , is3D: true  , chartArea:{left:20,top:20,width:"60%",height:"90%"} };          
		var chart = new google.visualization.PieChart(document.getElementById('chart_div'));         
		chart.draw(data, options);       
	}
</script>   
	<table ><tr>
		<td><div id="chart_div" style="width: 500px; height: 350px;"></div>  </td>
	</tr>
	<tr>
		<td ><div id="table_div" style="width: 330px; height: 150px;" ></div>  </td>
	</tr></table>
<?php sqlsrv_close( $conn ); ?>