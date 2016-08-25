<?php
	//phpinfo();
	error_reporting(-1);

		
	// content="text/plain; charset=utf-8"
	require_once ('jpgraph/jpgraph.php');
	require_once ('jpgraph/jpgraph_pie.php');
	require_once ('jpgraph/jpgraph_pie3d.php');

	
	
	/* Specify the server and connection string attributes. */
		$serverName = "egoct-wirws01"; //10.230.95.87
		$connectionInfo = array( "Database"=>"SM_Change_Researching_DB");

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$result = array(); 
		$sql = "WITH Temp_Impacts AS ( SELECT CASE 
					WHEN [External Customer] IS NULL AND [Internal Customer] IS NULL AND [Nodes/Systems] IS NULL AND [Reporting] IS NULL 
					  THEN 'No Impacts'
					WHEN [External Customer] IS NOT NULL  
					  THEN 'Service Impact'
					WHEN [Internal Customer] IS NOT NULL 
					  THEN 'Business Impact'
					WHEN [Nodes/Systems]  IS NOT NULL 
					  THEN 'Technical Impact'
					WHEN [Internal Customer] IS NOT NULL 
					  THEN 'Reporting'  
					ELSE
					  'N/A'
					  END Impact_Detail
				FROM [vw_Change_Approval_Details]
				WHERE CRQ_Type = 'Normal')
				SELECT Impact_Detail,count(*) CRQnum
				FROM Temp_Impacts
				WHERE Impact_Detail <> 'N/A'
				GROUP BY Impact_Detail
				ORDER BY Impact_Detail";

		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) { die( print_r( sqlsrv_errors(), true) ); 	}
		$result_count = array(); 
		$result_Impacts = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			  array_push($result_Impacts, $row['Impact_Detail']);
			  array_push($result_count, $row['CRQnum']);
		}
		sqlsrv_free_stmt( $stmt);
		
		//print_r($result);
		//echo $result;

	// Some data
	$data = array();
	$data = $result_count; //array(40,21,17,14,23);
	//print_r($data);
	
	// Create the Pie Graph. 
	$graph = new PieGraph(350,250);

	//$theme_class="DefaultTheme";
	//$graph->SetTheme(new $theme_class());

	$theme_class=new VividTheme; 
	$graph->SetTheme($theme_class);
	
	// Set A title for the plot
	$graph->title->Set("Impact Details");
	$graph->SetBox(true);

	// Create
	$p1 = new PiePlot3D($data);
	$graph->Add($p1);

	$p1->ShowBorder();
	$p1->SetColor('black');
	$p1->ExplodeSlice(1);
	//$p1->SetSliceColors(array('#FF0000','#00FF00','#0000FF','#FFFF00','#00FFFF'));
	$graph->Stroke();

		
	// Close the connection.
	sqlsrv_close( $conn );
?>




