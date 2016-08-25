<?php // content="text/plain; charset=utf-8"

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
		$data_ASalama8 = array(); 
		$data_MShaarawy3 = array();
		$data_hmohamed = array();
		$data_Hraslan = array();
		$data_SNabil2 = array();
if($_GET['content']=='graph'){
	
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');

		$j=1;
		for ($i=0; $i < 3; $i++) { 
			$sql = "SELECT CM_Eval_Approver,count(*) CRQnum
					FROM (
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
						) Temp_CM_Approvals
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
			if ($data_ASalama8[$i] == null) array_push($data_ASalama8, 0);
			if ($data_MShaarawy3[$i] == null) array_push($data_MShaarawy3, 0);
			if ($data_hmohamed[$i] == null) array_push($data_hmohamed, 0);
			if ($data_Hraslan[$i] == null) array_push($data_Hraslan, 0);
			if ($data_SNabil2[$i] == null) array_push($data_SNabil2, 0);
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

	$b4plot->SetColor("white");
	//$b4plot->SetFillColor("#11bb11");

	$b5plot->SetColor("white");
	//$b5plot->SetFillColor("#11cc11");

	$graph->title->Set("CM Evaluation Approvals");
	//$graph->subtitle->Set('(March 12, 2008)');
	$graph->xaxis->title->Set('Months');
	//$graph->yaxis->title->Set('Number of CRQs');
	$graph->xaxis->title->SetFont( FF_FONT1 , FS_BOLD );
	//$graph->yaxis->title->SetFont( FF_FONT1 , FS_BOLD );
	//$graph->yaxis->title->SetPos( 'left' ,'top' );
	
	$b1plot->SetLegend('ASalama8');
	$b2plot->SetLegend('MShaarawy3');
	$b3plot->SetLegend('SNabil2');
	$b4plot->SetLegend('hmohamed');
	$b5plot->SetLegend('Hraslan');
	
	// Display the graph
	$graph->Stroke();
}elseif($_GET['content']=='report'){

	echo "<link href='style_table.css' rel='stylesheet' type='text/css' />";
	echo "<table class=blue>";
		$j=1;
		for ($i=0; $i < 3; $i++) { 
			$sql = "WITH Temp_CM_Approvals AS (
						SELECT YEAR(Scheduled_Start_Date) schYear, MONTH(Scheduled_Start_Date) schMonth,
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
					SELECT schYear, schMonth, CM_Eval_Approver,count(*) CRQnum
					FROM Temp_CM_Approvals
					GROUP BY schYear, schMonth,CM_Eval_Approver
					ORDER  BY schYear DESC, schMonth DESC,CM_Eval_Approver;";
					//echo " ss=".$sql;
			$stmt = sqlsrv_query( $conn, $sql );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			$first = 1; 
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$value = $row['CRQnum'];
				$month[$i] = $row['schMonth'];
				$year[$i] = $row['schYear'];
				switch ($row['CM_Eval_Approver']){
						case "ASalama8": array_push($data_ASalama8, $value); break;
						case "MShaarawy3": array_push($data_MShaarawy3, $value); break;
						case "hmohamed": array_push($data_hmohamed, $value); break;
						case "Hraslan": array_push($data_Hraslan, $value); break;
						case "SNabil2": array_push($data_SNabil2, $value); break;
					}		
			}
			if ($data_ASalama8[$i] == null) array_push($data_ASalama8, 0);
			if ($data_MShaarawy3[$i] == null) array_push($data_MShaarawy3, 0);
			if ($data_hmohamed[$i] == null) array_push($data_hmohamed, 0);
			if ($data_Hraslan[$i] == null) array_push($data_Hraslan, 0);
			if ($data_SNabil2[$i] == null) array_push($data_SNabil2, 0);

			
			//	if($first) { echo "<tr><th colspan=2>Month: ".$row['schMonth']." ".$row['schYear']."</th></tr>"; $first=0;}
			//	if($row['CM_Eval_Approver']!='xx') echo "<tr><td>".$row['CM_Eval_Approver']."</td><td>".$row['CRQnum']."</td></tr>";
			//}
			sqlsrv_free_stmt( $stmt);
			//$i = $i + 1;
			$j = $j - 1;
		}
		echo "<tr><td>Month</td><td>".$month[0]." ".$year[0]."</td><td>".$month[1]." ".$year[1]."</td><td>".$month[2]." ".$year[2]."</td></tr>";
		echo "<tr><td>ASalama8</td><td>".$data_ASalama8[0]."</td><td>".$data_ASalama8[1]."</td><td>".$data_ASalama8[2]."</td></tr>";
		echo "<tr><td>MShaarawy3</td><td>".$data_MShaarawy3[0]."</td><td>".$data_MShaarawy3[1]."</td><td>".$data_MShaarawy3[2]."</td></tr>";
		echo "<tr><td>SNabil2</td><td>".$data_SNabil2[0]."</td><td>".$data_SNabil2[1]."</td><td>".$data_SNabil2[2]."</td></tr>";
		echo "<tr><td>hmohamed</td><td>".$data_hmohamed[0]."</td><td>".$data_hmohamed[1]."</td><td>".$data_hmohamed[2]."</td></tr>";
		echo "<tr><td>Hraslan</td><td>".$data_Hraslan[0]."</td><td>".$data_Hraslan[1]."</td><td>".$data_Hraslan[2]."</td></tr>";
		
		echo "</table>";
}

sqlsrv_close( $conn );
?>



