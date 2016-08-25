<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');

$array_depts = array("IT Operations","Network Engineering","Products & Services Delivery","Regional Operations","Service Management");

/* Specify the server and connection string attributes. */
		$serverName = "egoct-wirws01"; //10.230.95.87
		$connectionInfo = array( "Database"=>"SM_Change_Researching_DB");

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$i = 0;
		foreach ($array_depts as &$dept) {
			$sql = "SELECT YEAR(cap.Scheduled_Start_Date) Scheduled_year,MONTH(cap.Scheduled_Start_Date) AS Scheduled_month,cap.Support_Company, count(*) CRQnum
					FROM  dbo.vw_Change_Approval_Details cap
					WHERE cap.Support_Company = '".$dept."'
					AND cap.Scheduled_Start_Date <= getdate() AND cap.Scheduled_Start_Date >= '10/1/2012'
					AND cap.Status NOT IN ('Draft', 'Request For Authorization')
					AND cap.CRQ_Type = 'Normal'
					GROUP BY YEAR(cap.Scheduled_Start_Date),MONTH(cap.Scheduled_Start_Date),cap.Support_Company
					ORDER BY Scheduled_year,Scheduled_month;";
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

	// Some data
	//$data = array();
	//$datay1 = array(); //array(40,21,17,14,23);
	//print_r($data);
	
$datay1 = $data[0];//array(20,15,23,15);
$datay2 = $data[1];
$datay3 = $data[2];
$datay4 = $data[3];
$datay5 = $data[4];

// Setup the graph
$graph = new Graph(550,350);
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set('Normal Scheduled Changes Per Requesting Department');
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
$p1->SetLegend($array_depts[0]);

// Create the second line
$p2 = new LinePlot($datay2);
$graph->Add($p2);
$p2->SetColor("#FFFF00");
$p2->SetLegend($array_depts[1]);

// Create the third line
$p3 = new LinePlot($datay3);
$graph->Add($p3);
$p3->SetColor("#FF0000");
$p3->SetLegend($array_depts[2]);

// Create the forth line
$p4 = new LinePlot($datay4);
$graph->Add($p4);
$p4->SetColor("#00FF00");
$p4->SetLegend($array_depts[3]);

// Create the fifth line
$p5 = new LinePlot($datay5);
$graph->Add($p5);
$p5->SetColor("#0000FF");
$p5->SetLegend($array_depts[4]);

$graph->legend->SetFrameWeight(1);

// Output line
$graph->Stroke();

		
	// Close the connection.
	sqlsrv_close( $conn );

?>





