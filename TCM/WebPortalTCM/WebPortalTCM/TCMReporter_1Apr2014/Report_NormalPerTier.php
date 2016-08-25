<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');

$array_teams = array();

/* Specify the server and connection string attributes. */
		$serverName = "egoct-wirws01"; //10.230.95.87
		$connectionInfo = array( "Database"=>"SM_Change_Researching_DB");

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$i = 0;
		
		$sql_tiers="SELECT TOP 9 Product_Categorization_Tier_1 tier, count(*) CRQnum
					FROM  dbo.vw_Change_Approval_Details cap
					WHERE cap.Scheduled_Start_Date <= getdate() AND cap.Scheduled_Start_Date >= '10/1/2012'
					AND cap.Status != 'Draft' 
					AND cap.CRQ_Type = 'Normal'
					GROUP BY Product_Categorization_Tier_1
					ORDER BY CRQnum DESC;";
		$stmt_tiers = sqlsrv_query( $conn, $sql_tiers );
			if( $stmt_tiers === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			while( $row = sqlsrv_fetch_array( $stmt_tiers, SQLSRV_FETCH_ASSOC) ) {
				  array_push($array_tiers, $row['tier']);
			}
			sqlsrv_free_stmt( $stmt_tiers);
			
		foreach ($array_tiers as &$tier) {
			$sql = "SELECT YEAR(cap.Scheduled_Start_Date) Scheduled_year,MONTH(cap.Scheduled_Start_Date) AS Scheduled_month,Product_Categorization_Tier_1, count(*) CRQnum
					FROM  dbo.vw_Change_Approval_Details cap
					WHERE Product_Categorization_Tier_1 = '".$tier."'
					AND cap.Scheduled_Start_Date <= getdate() AND cap.Scheduled_Start_Date >= '10/1/2012'
					AND cap.Status != 'Draft'
					AND cap.CRQ_Type = 'Normal'
					GROUP BY YEAR(cap.Scheduled_Start_Date),MONTH(cap.Scheduled_Start_Date),Product_Categorization_Tier_1
					ORDER BY Scheduled_year,Scheduled_month;";
					//echo $sql;
			$stmt = sqlsrv_query( $conn, $sql );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			$data[$i] = array(); 
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				  array_push($data[$i], $row['CRQnum']);
			}
			sqlsrv_free_stmt( $stmt);
			$i = $i + 1;
		}
		
		//print_r($result);
		//echo $result;
	
$datay1 = $data[0];
$datay2 = $data[1];
$datay3 = $data[2];
$datay4 = $data[3];
$datay5 = $data[4];
$datay6 = $data[5];
$datay7 = $data[6];
$datay8 = $data[7];
$datay9 = $data[8];

// Setup the graph
$graph = new Graph(650,450);
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set('Standard Scheduled Changes Per Implementing Team');
$graph->SetBox(false);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$xAxis = array(	date('F y', strtotime('-4 month')),
				date('F y', strtotime('-3 month')),
				date('F y', strtotime('-2 month')),
				date('F y', strtotime('-1 month')),
				date('F y') );
$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");
$graph->xaxis->SetTickLabels($xAxis);
$graph->xgrid->SetColor('#E3E3E3');

// Create the first line
$p1 = new LinePlot($datay1);
$graph->Add($p1);
$p1->SetColor("#00FFFF");
$p1->SetLegend($array_teams[0]);

// Create the second line
$p2 = new LinePlot($datay2);
$graph->Add($p2);
$p2->SetColor("#FFFF00");
$p2->SetLegend($array_teams[1]);

// Create the third line
$p3 = new LinePlot($datay3);
$graph->Add($p3);
$p3->SetColor("#FF0000");
$p3->SetLegend($array_teams[2]);

// Create the forth line
$p4 = new LinePlot($datay4);
$graph->Add($p4);
$p4->SetColor("#00FF00");
$p4->SetLegend($array_teams[3]);

// Create the fifth line
$p5 = new LinePlot($datay5);
$graph->Add($p5);
$p5->SetColor("#0000FF");
$p5->SetLegend($array_teams[4]);

// Create the sixth line
$p6 = new LinePlot($datay6);
$graph->Add($p6);
$p6->SetColor("#DDDD00");
$p6->SetLegend($array_teams[5]);

// Create the third line
$p7 = new LinePlot($datay7);
$graph->Add($p7);
$p7->SetColor("#DD0000");
$p7->SetLegend($array_teams[6]);

// Create the forth line
$p8 = new LinePlot($datay8);
$graph->Add($p8);
$p8->SetColor("#00DD00");
$p8->SetLegend($array_teams[7]);

// Create the ninth line
$p9 = new LinePlot($datay9);
$graph->Add($p9);
$p9->SetColor("#0000DD");
$p9->SetLegend($array_teams[8]);

$graph->legend->SetFrameWeight(1);

// Output line
$graph->Stroke();

		
	// Close the connection.
	sqlsrv_close( $conn );

?>





