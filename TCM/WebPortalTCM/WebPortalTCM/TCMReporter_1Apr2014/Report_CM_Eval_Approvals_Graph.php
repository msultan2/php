<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');

/* Specify the server and connection string attributes. */
		$serverName = "egoct-wirws01"; //10.230.95.87
		$connectionInfo = array( "Database"=>"SM_Change_Researching_DB");

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
	
		$data_ASalama8 = array(); 
		$data_MShaarawy3 = array();
		$data_hmohamed = array();
		$data_Hraslan = array();
		$data_SNabil2 = array();
		$j=1;
		for ($i=0; $i < 3; $i++) { 
			$sql = "WITH Temp_CM_Approvals AS (
						SELECT 
							CASE 
								WHEN [First On Behalf of] = 'CM_Eval' THEN [First Approver]
								WHEN [Second On Behalf of] = 'CM_Eval' THEN [Second Approver]
								WHEN [Third On Behalf of] = 'CM_Eval' THEN [Third Approver]
								WHEN [Fourth On Behalf of] = 'CM_Eval' THEN [Fourth Approver]
								WHEN [Fifth On Behalf of] = 'CM_Eval' THEN [Fifth Approver]
								WHEN [Sixth On Behalf of] = 'CM_Eval' THEN [Sixth Approver]
						  ELSE 'xx' 
						END CM_Eval_Approver
						FROM [vw_Change_Approval_Details] 
						WHERE CRQ_Type = 'Normal'
							AND Scheduled_Start_Date >= dateadd(m, datediff(m, 0, GETDATE()) - $i , 0)  
							AND Scheduled_Start_Date <  dateadd(m, datediff(m, 0, GETDATE())+ $j, 0)
						)
					SELECT CM_Eval_Approver,count(*) CRQnum
					FROM Temp_CM_Approvals
					GROUP BY CM_Eval_Approver
					ORDER  BY CM_Eval_Approver;";
					//echo " ss=".$sql;
			$stmt = sqlsrv_query( $conn, $sql );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$value = $row['CRQnum'];
				switch ($row['CM_Eval_Approver']){
						case "ASalama8": array_push($data_ASalama8, $value); break;
						case "MShaarawy3": array_push($data_MShaarawy3, $value); break;
						case "hmohamed": array_push($data_hmohamed, $value); break;
						case "Hraslan": array_push($data_Hraslan, $value); break;
						case "SNabil2": array_push($data_SNabil2, $value); break;
					}
					
					
			}
			sqlsrv_free_stmt( $stmt);
			//$i = $i + 1;
			$j = $j - 1;
		}
		
		
	// Create the graph. These two calls are always required
	$graph = new Graph(550,350,'auto');
	$graph->SetScale("textlin");

	$theme_class=new UniversalTheme;
	$graph->SetTheme($theme_class);

	$graph->yaxis->SetTickPositions(array(0,30,60,90,120,150,180,210,240,270), array(15,45,75,105,135,165,195,225,255,285));
	$graph->SetBox(false);

	$xAxis = array(	date('F y'),
					date('F y', strtotime('-1 month')),
					date('F y', strtotime('-2 month')) );
					
	$graph->ygrid->SetFill(false);
	$graph->xaxis->SetTickLabels($xAxis);
	$graph->yaxis->HideLine(false);
	$graph->yaxis->HideTicks(false,false);

	// Create the bar plots
	$b1plot = new BarPlot($data_ASalama8);
	$b2plot = new BarPlot($data_MShaarawy3);
	$b3plot = new BarPlot($data_SNabil2);
	$b4plot = new BarPlot($data_hmohamed);
	$b5plot = new BarPlot($data_Hraslan);

	// Create the grouped bar plot
	$gbplot = new GroupBarPlot(array($b1plot,$b2plot,$b3plot,$b4plot,$b5plot));
	// ...and add it to the graPH
	$graph->Add($gbplot);


	$b1plot->SetColor("white");
	$b1plot->SetFillColor("#cc1111");

	$b2plot->SetColor("white");
	$b2plot->SetFillColor("#11cccc");

	$b3plot->SetColor("white");
	$b3plot->SetFillColor("#1111cc");

	$graph->title->Set("CM Evaluation Approvals");

	// Display the graph
	$graph->Stroke();
	
sqlsrv_close( $conn );
?>



