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
		// AND Support_Company IN ('Regional Operations','Network Engineering','Products & Services Delivery','Service Management','IT Operations')
		$sql = "SELECT CASE WHEN ".$ini_array['IT_CONDITION']." THEN 'IT' ELSE 'NETWORK' END ChangeFor,count(*) CRQnum FROM dbo.vw_Change_Approval_Details 
				WHERE CRQ_Type = 'Normal'
				AND Status NOT IN ('Request For Authorization','Pending','Cancelled','Rejected')
				AND dbo.DateOnly(Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(Scheduled_Start_Date) >= '$getFrom'
				GROUP BY CASE WHEN ".$ini_array['IT_CONDITION']." THEN 'IT' ELSE 'NETWORK' END  
				ORDER BY ChangeFor DESC;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val_NR = array();
		$data_Val_ST = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['ChangeFor']);
			array_push($data_Val_NR,$row['CRQnum']);
		}
		
		sqlsrv_free_stmt( $stmt);
		
		// get IT & NW CRQs Standard from today till last week (ex: from yesterday Wednesday till last Thursday) 7 days,'Cancelled')
		$sql = "SELECT CASE WHEN ".$ini_array['IT_CONDITION']." THEN 'IT' ELSE 'NETWORK' END ChangeFor,count(*) CRQnum FROM dbo.vw_Change_Approval_Details 
				WHERE CRQ_Type = 'Standard'
				AND Status NOT IN ('Request For Authorization','Pending','Cancelled','Rejected')
				AND dbo.DateOnly(Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(Scheduled_Start_Date) >= '$getFrom'
				GROUP BY CASE WHEN ".$ini_array['IT_CONDITION']." THEN 'IT' ELSE 'NETWORK' END  
				ORDER BY ChangeFor DESC;";

		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			//array_push($data_Desc,$row['ChangeFor']);
			array_push($data_Val_ST,$row['CRQnum']);
		}
		
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn );
?> 
<script language="javascript" src="http://www.google.com/jsapi"></script>     
<div id="chart"></div>

   <script type="text/javascript">
      var queryString = '';
      var dataUrl = '';

      function onLoadCallback() {
        if (dataUrl.length > 0) {
          var query = new google.visualization.Query(dataUrl);
          query.setQuery(queryString);
          query.send(handleQueryResponse);
        } else {
          var dataTable = new google.visualization.DataTable();
          dataTable.addRows(7);

          dataTable.addColumn('number');
          dataTable.addColumn('number');
          dataTable.setValue(0, 0, 10);
          dataTable.setValue(0, 1, 50);
          dataTable.setValue(1, 0, 50);
          dataTable.setValue(1, 1, 60);
          dataTable.setValue(2, 0, 60);
          dataTable.setValue(2, 1, 100);
          dataTable.setValue(3, 0, 80);
          dataTable.setValue(3, 1, 40);
          dataTable.setValue(4, 0, 40);
          dataTable.setValue(4, 1, 20);
          dataTable.setValue(5, 0, 60);
          dataTable.setValue(5, 1, 40);
          dataTable.setValue(6, 0, 30);
          dataTable.setValue(6, 1, 30);

          draw(dataTable);
        }
      }
	
      function draw(dataTable) {
        var vis = new google.visualization.ImageChart(document.getElementById('chart'));
        var options = {
          chxl: '',
          chxp: '',
          chxr: '',
          chxs: '',
          chxtc: '',
          chxt: 'y',
          chbh: 'a',
          chm:'N,FF0000,0,-1,11|N,000000,1,,12',
		  chs: '650x350',
		  chbh:'20,1,30' ,
          cht: 'bvg',
          chco:'4D89F9,C6D9FD',
          chd: 't:10,50,60,80,40,60,30|50,60,100,40,20,40,30',
          chdl: 'Standard|Normal',
          chtt: 'Vertical bar chart Sara',
		  chxl: 'x:Mar 13|Apr 13|May 13| Jun 13|Jul 13|Aug 13|Sep 13',
		  chem:'y;s=bubble_text_small_withshadow;d=bb,Koki 80 My Best,FF8,000;ds=0;dp=3;py=1'
        };
        vis.draw(dataTable, options);
      }
	
      function handleQueryResponse(response) {
        if (response.isError()) {
          alert('Error in query: ' + response.getMessage() + ' ' + response.getDetailedMessage());
          return;
        }
        draw(response.getDataTable());
      }

      google.load("visualization", "1", {packages:["imagechart"]});
      google.setOnLoadCallback(onLoadCallback);

    
</script>   
