<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');


$array_approvers = array("ASalama8","MShaarawy3","hmohamed");//,"Hraslan","MBaky11","SNabil2");

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
		/*
		$i = 0;
			$sql = "Select 
			 Count(*) Num_of_Emergncy, CAST(Month(Scheduled_Start_Date) AS VARCHAR)+' '+CAST(Year(Scheduled_Start_Date) AS VARCHAR)Sara
			From 
			 dbo.tbl_Change_Approval_Details
			Where
			 Emergency=0 and Year(Scheduled_Start_Date) = 2012
			Group by 
			Month(Scheduled_Start_Date),Year(Scheduled_Start_Date)
			Order by Year(Scheduled_Start_Date),Month(Scheduled_Start_Date) Asc;";
			$stmt = sqlsrv_query( $conn, $sql );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			$data[$i] = array(); 
			$result = array();
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				  array_push($data[$i], $row['Num_of_Emergncy']);
			}
			sqlsrv_free_stmt( $stmt);
			$i = $i + 1;
		*/
		
		//print_r($result);
		//echo $result;

		$data1y = array();
//$data1y = $data[0];
//$data2y = $data[1];
//$data3y = $data[2];
//$data4y = $data[3];
//$data5y = $data[4];
//$data6y = $data[5];
$data1y=array(47,80,40,116);
$data2y=array(61,30,82,105);
$data3y=array(115,50,70,93);


// Create the graph. These two calls are always required
$graph = new Graph(550,350,'auto');
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);

$graph->yaxis->SetTickPositions(array(0,30,60,90,120,150,180,210,240,270), array(15,45,75,105,135,165,195,225,255,285));
$graph->SetBox(false);

$xAxis = array(	date('F y', strtotime('-4 month')),
				date('F y', strtotime('-3 month')),
				date('F y', strtotime('-2 month')),
				date('F y', strtotime('-1 month')),
				date('F y') );
				
$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels($xAxis);
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

// Create the bar plots
$b1plot = new BarPlot($data1y);
$b2plot = new BarPlot($data2y);
$b3plot = new BarPlot($data3y);



// Create the grouped bar plot
$gbplot = new GroupBarPlot(array($b1plot,$b2plot,$b3plot));
// ...and add it to the graPH
$graph->Add($gbplot);


$b1plot->SetColor("white");
$b1plot->SetFillColor("#cc1111");

$b2plot->SetColor("white");
$b2plot->SetFillColor("#11cccc");

$b3plot->SetColor("white");
$b3plot->SetFillColor("#1111cc");

$b1plot->value->HideZero(); 
$b2plot->value->HideZero(); 
$b3plot->value->HideZero(); 
$b1plot->value->SetFormat('%01.0f'); 
$b2plot->value->SetFormat('%01.0f'); 
$b3plot->value->SetFormat('%01.0f'); 
$b1plot->value->Show(); 
$b2plot->value->Show(); 
$b3plot->value->Show(); 



$graph->title->Set("Bar Plots");

// Display the graph
$graph->Stroke();

// Close the connection.
sqlsrv_close( $conn );
?>



