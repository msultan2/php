<link href="style_new.css" rel="stylesheet" type="text/css" />
<div class="body_text">Changes per Scheduled Start Hour </div>
<?php
		/* Parse configuration file */
		$ini_array = parse_ini_file("config.ini");
		
		/* Specify the server and connection string attributes. */

		$serverName = $ini_array['SERVER_NAME']; 
		$connectionInfo = array( "Database"=>$ini_array['DB_NAME']);

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$sql = "SELECT DATEPART(hour,ap.Scheduled_Start_Date) sc_hour,count(*) CRQnum
				FROM dbo.vw_Change_Approval_Details ap
				WHERE ap.CRQ_Type = 'Normal'
				GROUP BY DATEPART(hour,ap.Scheduled_Start_Date)
				ORDER BY DATEPART(hour,ap.Scheduled_Start_Date);";
					
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_hour = array();
		$data_Val = array();
		
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_hour,$row['sc_hour']);
			array_push($data_Val,$row['CRQnum']);
		}
		
		sqlsrv_free_stmt( $stmt);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1.0", {packages:["imagechart"]});
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataTable = google.visualization.arrayToDataTable([           
			['Day','Changes'],                
			<?php 
				for($i=0;$i<count($data_hour); $i++) {             
						echo "['".$data_hour[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_hour)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] ); 
		}
      function drawChart() {
        var dataTable = new google.visualization.DataTable();
        dataTable.addColumn('number');
        dataTable.addColumn('number');
        dataTable.addRows([
          [100,10],
          [80,20],
          [60,30],
          [30,40],
          [25,50],
          [20,60],
          [10,70],
        ]);

        var chart = new google.visualization.ImageChart(document.getElementById('radar_div'));

        var options = {cht: 'rs', chco: '00FF00,FF00FF', chg: '25.0,25.0,4.0,4.0', chm: 'B,FF000080,0,1.0,5.0|B,FF990080,1,1.0,5.0',};
        chart.draw(dataTable, options);
      }
    </script>
  
<?php
	$data_hour_string = implode(",",$data_hour);
	$data_Val_string = implode(",",$data_Val);
	//$labels = "12:00AM|1:00AM|2:00AM|3:00AM|4:00AM|5:00AM|6:00AM|7:00AM|8:00AM|9:00AM|10:00AM|11:00AM|12Noon|1:00PM|2:00PM|3:00PM|4:00PM|5:00PM|6:00PM|7:00PM|8:00PM|9:00PM|10:00PM|11:00PM";
	$labels = "12AM|1AM|2AM|3AM|4AM|5AM|6AM|7AM|8AM|9AM|10AM|11AM|12Noon|1PM|2PM|3PM|4PM|5PM|6PM|7PM|8PM|9PM|10PM|11PM";
	//$labels = "12:00AM|3:00AM|6:00AM|9:00AM|12Noon|3:00PM|6:00PM|9:00PM";
		//	&chxp=0,0,20,40,60,80,100
		//	&chd=t:".$data_Val_string."
		//&chd=t:11524,945,1316,284,913,137,82,332,494,693,853,1273,922,918,929,868,794,492,278,155,72,61,64,64&chf=a,s,0000FF55&chg=25.0,25.0,4.0,4.0
	$radar_chart_url = "http://chart.apis.google.com/chart?
				cht=r
				&chxt=y,x
				&chls=3
				&chd=t:".$data_Val_string."
				&chxr=0,500,3000,500
				&chds=0,200
				&chs=350x300
				&chl=".$labels."
				&chm=B,FF990080,0,1.0,5.0";
?>
<table >
	<tr><iframe src="<?php echo $radar_chart_url;?>" frameborder=0 scrolling=no width="350px" height="350px"></iframe> </td></tr>
	<td><div id="radar_div" style="width: 700px; height: 200px;"></div>  </td>
</table>
<?php sqlsrv_close( $conn ); ?>