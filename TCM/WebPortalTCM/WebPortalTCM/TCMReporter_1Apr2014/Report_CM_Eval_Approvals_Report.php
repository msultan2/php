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
			echo "<table><tr><th>Evaluater</th><th>Number of Eval Approvals</th><tr>";
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				echo "<tr><td>".$row['CM_Eval_Approver']."</td><td>".$row['CRQnum']."</td></tr>";
			}
			echo "</table>";
			sqlsrv_free_stmt( $stmt);
			//$i = $i + 1;
			$j = $j - 1;
		}


sqlsrv_close( $conn );
?>



