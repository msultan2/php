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
		$sql = "WITH Temp_Late_Approvals AS (
				  SELECT CASE ch.[First Approver]
								  WHEN 'AR_ESCALATOR' THEN ch.[First On Behalf of]
								  ELSE ch.[First Approver]
								END Approver
				FROM dbo.vw_Change_Approval_Details ch
				WHERE DATEADD(day, -DATEDIFF(day, 0, ch.[Fifth Approval Date]), ch.[Fifth Approval Date]) > '2:00:00 PM'
				AND [First Approver] NOT IN ('ASalama8','MShaarawy3','hmohamed','Hraslan','MBaky11','SNabil2')
				) 
				SELECT TOP 15 Approver, count(*) CRQnum
				FROM Temp_Late_Approvals
				GROUP BY  Approver
				ORDER BY  CRQnum DESC;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$result = array(); 
		$approvers = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			  array_push($result, $row['CRQnum']);
			  array_push($approvers, $row['Approver']);
		}
		
//$data1y=array(47,80,40,116);
//$data2y=array(61,30,82,105);
//$data3y=array(115,50,70,93);


// Create the graph. These two calls are always required
$graph = new Graph(750,350,'auto');
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);

$graph->yaxis->SetTickPositions(array(0,30,60,90,120,150), array(15,45,75,105,135));
$graph->SetBox(false);

$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels($approvers);
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

// Create the bar plots
$b1plot = new BarPlot($result);
//$b2plot = new BarPlot($data2y);
//$b3plot = new BarPlot($data3y);

// Create the grouped bar plot
$gbplot = new GroupBarPlot(array($b1plot));//,$b2plot,$b3plot));
// ...and add it to the graPH
$graph->Add($gbplot);


$b1plot->SetColor("white");
$b1plot->SetFillColor("#cc1111");

//$b2plot->SetColor("white");
//$b2plot->SetFillColor("#11cccc");

//$b3plot->SetColor("white");
//$b3plot->SetFillColor("#1111cc");

$graph->title->Set("Bar Plots");

// Display the graph
$graph->Stroke();
?>
<?php
	sqlsrv_free_stmt( $stmt);
	// Close the connection.
	sqlsrv_close( $conn );
?>


