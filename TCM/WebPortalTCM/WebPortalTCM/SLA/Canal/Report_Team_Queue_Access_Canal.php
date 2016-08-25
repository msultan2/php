<link href="../style_new.css" rel="stylesheet" type="text/css" />
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
		$sql = "SELECT 
						CASE 
						WHEN (TT.Assigned_Group 
						like 'Transport%FO%Tx%' 
						OR TT.Assigned_Group like 'Alex%Delta%Access%Service%FO%' 
						OR TT.Assigned_Group like 'Cairo%Access%Service%FO%' 
						OR TT.Assigned_Group like 'HU%Access%Service%FO' 
						OR TT.Assigned_Group like '%BEP%FO%' 
						OR TT.Assigned_Group like 'PTN%RTN%FO' 
						OR TT.Assigned_Group like 'Transport%FO%Datacom')
						THEN TT.Assigned_Group
						WHEN TT.Assigned_Group like 'NFM%' 
						THEN 'NFM'
						WHEN TT.Assigned_Group like 'Site%Management%' 
						THEN 'Site Management'
						WHEN lower(TT.Assigned_Group) like '%flapping%' 
						THEN 'Flapping Sites'
						WHEN TT.Assigned_Group like 'Site%Restoration%' 
						THEN 'Site Restoration'
						WHEN TT.Assigned_Group like 'External%Affairs%' 
						THEN 'External Affairs'
						ELSE 'Others'	
						END Assigned_Group,
						CASE 
						WHEN (TT.Assigned_Group like 'Transport%FO%Tx%' 
						OR TT.Assigned_Group like 'Alex%Delta%Access%Service%FO%' 
						OR TT.Assigned_Group like 'Cairo%Access%Service%FO%' 
						OR TT.Assigned_Group like 'HU%Access%Service%FO' 
						OR TT.Assigned_Group like '%BEP%FO%' 
						OR TT.Assigned_Group like 'PTN%RTN%FO' 
						OR TT.Assigned_Group like 'Transport%FO%Datacom')
						THEN 1
						WHEN TT.Assigned_Group like 'NFM%' 
						THEN 2
						WHEN TT.Assigned_Group like 'Site%Management%' 
						THEN 3
						WHEN TT.Assigned_Group like 'Site%Restoration%' 
						THEN 4
						WHEN lower(TT.Assigned_Group) like '%flapping%' 
						THEN 5
						WHEN TT.Assigned_Group like 'External%Affairs%' 
						THEN 6
						ELSE 7 
						END Sort_Order,
						COUNT(TT.Incident_ID) Violated_TT
						  FROM dbo.vw_SS_Remedy_TT_SLA_All TT
					   WHERE TT.Assigned_Group IS NOT NULL
					AND TT.Region like '%Canal%'
						  AND TT.Incident_ID IS NOT NULL
						  AND TT.OUTAGE <> 'Yes'
						  AND TT.Status IN ('Assigned','Pending','In Progress')
				  group by 
							CASE 
						WHEN (TT.Assigned_Group 
						like 'Transport%FO%Tx%' 
						OR TT.Assigned_Group like 'Alex%Delta%Access%Service%FO%' 
						OR TT.Assigned_Group like 'Cairo%Access%Service%FO%' 
						OR TT.Assigned_Group like 'HU%Access%Service%FO' 
						OR TT.Assigned_Group like '%BEP%FO%' 
						OR TT.Assigned_Group like 'PTN%RTN%FO' 
						OR TT.Assigned_Group like 'Transport%FO%Datacom')
						THEN TT.Assigned_Group
						WHEN TT.Assigned_Group like 'NFM%' 
						THEN 'NFM'
						WHEN TT.Assigned_Group like 'Site%Management%' 
						THEN 'Site Management'
						WHEN lower(TT.Assigned_Group) like '%flapping%' 
						THEN 'Flapping Sites'
						WHEN TT.Assigned_Group like 'Site%Restoration%' 
						THEN 'Site Restoration'
						WHEN TT.Assigned_Group like 'External%Affairs%' 
						THEN 'External Affairs'
						ELSE 'Others'	
						END,
						CASE 
						WHEN (TT.Assigned_Group like 'Transport%FO%Tx%' 
						OR TT.Assigned_Group like 'Alex%Delta%Access%Service%FO%' 
						OR TT.Assigned_Group like 'Cairo%Access%Service%FO%' 
						OR TT.Assigned_Group like 'HU%Access%Service%FO' 
						OR TT.Assigned_Group like '%BEP%FO%' 
						OR TT.Assigned_Group like 'PTN%RTN%FO' 
						OR TT.Assigned_Group like 'Transport%FO%Datacom')
						THEN 1
						WHEN TT.Assigned_Group like 'NFM%' 
						THEN 2
						WHEN TT.Assigned_Group like 'Site%Management%' 
						THEN 3
						WHEN TT.Assigned_Group like 'Site%Restoration%' 
						THEN 4
						WHEN lower(TT.Assigned_Group) like '%flapping%' 
						THEN 5
						WHEN TT.Assigned_Group like 'External%Affairs%' 
						THEN 6
						ELSE 7 
						END
				  HAVING COUNT(TT.Incident_ID) > 0
				  order by 2,3 DESC;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		//$data_Total = array();
		$data_Val = array();
		$data_dept = array();
		$data_team = array();		
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_team,$row['Assigned_Group']);
			array_push($data_Val,$row['Violated_TT']);
		}
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn );
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataChart = google.visualization.arrayToDataTable([   
			['SOC Access Team', 'TTs'],
			<?php 
               
				for($i=0;$i<count($data_team); $i++) {
					
						echo "['".$data_team[$i]."',". $data_Val[$i] ."]"; 
						if ($i<count($data_team)-1) echo ",";	//add ',' to all except last element
					} 
			?>
			] ); 
		
		var view = new google.visualization.DataView(dataChart);
		view.setColumns([0,
						1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" }]);
		//drawPieChart
		var options = { title: 'Team Queues'  ,  chartArea:{left:200,top:40,bottom:20,width:"75%",height:"80%"}, colors:['#932ab6'], //vAxis: {maxValue:3, minValue:1},
						hAxis: {title: 'SOC Access', titleTextStyle: {color: 'red'}, gridlines:{count:7}, max:100} , focusTarget: 'category', tooltip: {isHtml: true} };          
		
		var chart = new google.visualization.BarChart(document.getElementById('chart_div'));         
		chart.draw(view, options );    
		//chart.draw(view, {allowHtml: true});  		
		//chart.draw(data, {allowHtml: true});
		google.visualization.events.addListener(chart, 'click', function (e) {
		// match the id of the axis label
		chart.draw(data, {allowHtml: true});
		var match = e.targetID.match(/hAxis#0#label#(\d+)/);
		if (match && match.length) {
		var row = parseInt(match[1]);

		// use row to fetch any data you need from the DataTable to construct your hyperlink, eg:
		var label = data.getValue(row, 0);
		// then construct your URL and use it however you want, eg:
		var url = 'http://www.google.com/search?q=' + label;
		window.location = url;
    }
});		
	} 
</script>   
<table >
	<tr><td colspan=2 class="iframe_td"><div id="chart_div" style="width: 500px; height: 250px;"></div>  </td><td width=100px>&nbsp;</td><td ><div id="table_div" style="width: 400px;"></div></td></tr>
</table>
