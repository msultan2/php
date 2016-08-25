<link href="style_new.css" rel="stylesheet" type="text/css" />
<?php
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
		$sql = "SELECT TOP 20 LTRIM(ch.[Third On Behalf of]) Approver,
		CASE
		WHEN (month(ch.Scheduled_Start_Date) = 1 AND YEAR((ch.Scheduled_Start_Date)) = 2015) then 'January 2015'
		WHEN (month(ch.Scheduled_Start_Date) = 2 AND YEAR((ch.Scheduled_Start_Date)) = 2015)then 'February 2015'
		WHEN (month(ch.Scheduled_Start_Date) = 3 AND YEAR((ch.Scheduled_Start_Date)) = 2015)then 'March 2015'
		WHEN (month(ch.Scheduled_Start_Date) = 4 AND YEAR((ch.Scheduled_Start_Date)) = 2015) then 'April 2015' 
		 WHEN (month(ch.Scheduled_Start_Date) =5 AND YEAR((ch.Scheduled_Start_Date)) = 2015) then 'May 2015'
		 WHEN (month(ch.Scheduled_Start_Date) = 6 AND YEAR((ch.Scheduled_Start_Date)) = 2015) then 'June 2015'
		 WHEN (month(ch.Scheduled_Start_Date) = 7 AND YEAR((ch.Scheduled_Start_Date)) = 2015) then 'July 2015'
		 WHEN (month(ch.Scheduled_Start_Date) = 8 AND YEAR((ch.Scheduled_Start_Date)) = 2015) then 'August 2015'
		 WHEN (month(ch.Scheduled_Start_Date) = 9 AND YEAR((ch.Scheduled_Start_Date)) = 2015) then 'September 2015'
		 WHEN (month(ch.Scheduled_Start_Date) = 10 AND YEAR((ch.Scheduled_Start_Date)) = 2015) then 'October 2015'
		 WHEN (month(ch.Scheduled_Start_Date) = 11 AND YEAR((ch.Scheduled_Start_Date)) = 2015) then 'November 2015'
		 WHEN (month(ch.Scheduled_Start_Date) = 12 AND YEAR((ch.Scheduled_Start_Date)) = 2015) then 'December 2015'
		 WHEN (month(ch.Scheduled_Start_Date) = 10 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'October 2014'
		  WHEN (month(ch.Scheduled_Start_Date) = 11 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'November 2014'
		   WHEN (month(ch.Scheduled_Start_Date) = 12 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'December2014'
		WHEN (month(ch.Scheduled_Start_Date) = 1 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'January 2014'
		WHEN (month(ch.Scheduled_Start_Date) = 2 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'February 2014'
		WHEN (month(ch.Scheduled_Start_Date) = 3 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'March 2014'
		WHEN (month(ch.Scheduled_Start_Date) = 4 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'April 2014'
		WHEN (month(ch.Scheduled_Start_Date) = 5 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'May 2014'
		WHEN (month(ch.Scheduled_Start_Date) = 6 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'June 2014'
		WHEN (month(ch.Scheduled_Start_Date) = 7 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'July 2014'
		WHEN (month(ch.Scheduled_Start_Date) = 8 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'August 2014'	
		WHEN (month(ch.Scheduled_Start_Date) = 9 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'September 2014'			
			END Month, 
               count(*) CRQnum
				FROM dbo.vw_Change_Approval_Details ch
				LEFT OUTER JOIN dbo.tbl_Change_LK_Approvers ap
				ON (CASE ch.[Third On Behalf of]
								  WHEN 'Approved' THEN ch.[Third Approver]
								  ELSE LTRIM(ch.[Third On Behalf of]) 
								END) = ap.Approver_Alias
				WHERE CRQ_Type = 'Normal'
				AND DATEPART(HOUR, ch.[Third Approval Date]) >= 17
				AND YEAR (ch.Scheduled_Start_Date) >= 2014
				AND dbo.DATEONLY( ch.[Third Approval Date]) >= (dbo.DATEONLY( ch.Scheduled_Start_Date) -1)
				AND [Third On Behalf of] NOT IN ('CM_Eval','CM_Authorized','CM_CC','wsaad','GMoustafa')
		GROUP BY LTRIM(ch.[Third On Behalf of]), ap.Approver_Name,
		CASE
		WHEN (month(ch.Scheduled_Start_Date) = 1 AND YEAR((ch.Scheduled_Start_Date)) = 2015) then 'January 2015'
		WHEN (month(ch.Scheduled_Start_Date) = 2 AND YEAR((ch.Scheduled_Start_Date)) = 2015)then 'February 2015'
		WHEN (month(ch.Scheduled_Start_Date) = 3 AND YEAR((ch.Scheduled_Start_Date)) = 2015)then 'March 2015'
		WHEN (month(ch.Scheduled_Start_Date) = 4 AND YEAR((ch.Scheduled_Start_Date)) = 2015) then 'April 2015' 
		 WHEN (month(ch.Scheduled_Start_Date) =5 AND YEAR((ch.Scheduled_Start_Date)) = 2015) then 'May 2015'
		 WHEN (month(ch.Scheduled_Start_Date) = 6 AND YEAR((ch.Scheduled_Start_Date)) = 2015) then 'June 2015'
		 WHEN (month(ch.Scheduled_Start_Date) = 7 AND YEAR((ch.Scheduled_Start_Date)) = 2015) then 'July 2015'
		 WHEN (month(ch.Scheduled_Start_Date) = 8 AND YEAR((ch.Scheduled_Start_Date)) = 2015) then 'August 2015'
		 WHEN (month(ch.Scheduled_Start_Date) = 9 AND YEAR((ch.Scheduled_Start_Date)) = 2015) then 'September 2015'
		 WHEN (month(ch.Scheduled_Start_Date) = 10 AND YEAR((ch.Scheduled_Start_Date)) = 2015) then 'October 2015'
		 WHEN (month(ch.Scheduled_Start_Date) = 11 AND YEAR((ch.Scheduled_Start_Date)) = 2015) then 'November 2015'
		 WHEN (month(ch.Scheduled_Start_Date) = 12 AND YEAR((ch.Scheduled_Start_Date)) = 2015) then 'December 2015'
		 WHEN (month(ch.Scheduled_Start_Date) = 10 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'October 2014'
		  WHEN (month(ch.Scheduled_Start_Date) = 11 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'November 2014'
		   WHEN (month(ch.Scheduled_Start_Date) = 12 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'December2014'
		WHEN (month(ch.Scheduled_Start_Date) = 1 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'January 2014'
		WHEN (month(ch.Scheduled_Start_Date) = 2 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'February 2014'
		WHEN (month(ch.Scheduled_Start_Date) = 3 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'March 2014'
		WHEN (month(ch.Scheduled_Start_Date) = 4 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'April 2014'
		WHEN (month(ch.Scheduled_Start_Date) = 5 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'May 2014'
		WHEN (month(ch.Scheduled_Start_Date) = 6 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'June 2014'
		WHEN (month(ch.Scheduled_Start_Date) = 7 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'July 2014'
		WHEN (month(ch.Scheduled_Start_Date) = 8 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'August 2014'	
		WHEN (month(ch.Scheduled_Start_Date) = 9 AND YEAR((ch.Scheduled_Start_Date)) = 2014) then 'September 2014'			
			END
		ORDER BY  CRQnum DESC;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		$data_dept = array();
		$data_team = array();
		$data_Month = array();		
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['Approver']);
			array_push($data_Month,$row['Month']);
			array_push($data_Val,$row['CRQnum']);
		}
		
		sqlsrv_free_stmt( $stmt);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	//google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataTable = google.visualization.arrayToDataTable([           
			['Approver', 'Month' ,'Number of Changes'],           
			<?php 
				//echo "[";
				for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."','".$data_Month[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  
				//echo "]";
			?>
			] ); 
			
				dataTable.setColumnProperty(0, {allowHtml: true});
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		//table.draw(dataChart, {showRowNumber: true});
		table.draw(dataTable, {allowHtml: true});
			
		
		var view = new google.visualization.DataView(dataTable);
		view.setColumns([0, 
						1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" }]);      
	} 

</script>   
<table  >
	<tr>
	<td ><div id="table_div" style="width: 300px;"></div></td>
	</tr>
</table>
<?php sqlsrv_close( $conn ); ?>