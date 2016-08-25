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
		$sql = "SELECT Urgency,count(*) CRQnum FROM dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Normal' GROUP BY Urgency ORDER BY Urgency";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$result = array(); 
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			  $value = $row['CRQnum'];
			  array_push($result, $value);
		}
		//print_r($result);
		//echo $result;

	// Some data
	$data = array();
	$data = $result; //array(40,21,17,14,23);
	//print_r($data);
	
	// Create the Pie Graph. 
	$graph = new PieGraph(350,250);

	//$theme_class="DefaultTheme";
	//$graph->SetTheme(new $theme_class());

	$theme_class=new VividTheme; 
	$graph->SetTheme($theme_class);
	
	// Set A title for the plot
	$graph->title->Set("Urgency Levels");
	$graph->SetBox(true);

	// Create
	$p1 = new PiePlot3D($data);
	$graph->Add($p1);

	$p1->ShowBorder();
	$p1->SetColor('black');
	$p1->ExplodeSlice(1);
	//$p1->SetSliceColors(array('#FF0000','#00FF00','#0000FF','#FFFF00','#00FFFF'));
	$graph->Stroke();

	sqlsrv_free_stmt( $stmt);

		
	// Close the connection.
	sqlsrv_close( $conn );
?>




