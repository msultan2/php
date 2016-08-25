<?php
	/* Libchart - PHP chart library
	 * Copyright (C) 2005-2011 Jean-Marc Trémeaux (jm.tremeaux at gmail.com)
	 * 
	 * This program is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation, either version 3 of the License, or
	 * (at your option) any later version.
	 * 
	 * This program is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 * GNU General Public License for more details.
	 *
	 * You should have received a copy of the GNU General Public License
	 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
	 * 
	 */
	
	/*
	 * Vertical bar chart demonstration
	 *
	 */

	
	/* Parse configuration file */
		$ini_array = parse_ini_file("config.ini");
		include "../libchart/classes/libchart.php";
	
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
		$sql = "SELECT TOP 10  LTRIM(ch.[Third On Behalf of]) Approver,
		CASE
		WHEN month(ch.Scheduled_Start_Date) = 1 then 'January'
		WHEN month(ch.Scheduled_Start_Date) = 2 then 'February'
		WHEN month(ch.Scheduled_Start_Date) = 3 then 'March'
		WHEN month(ch.Scheduled_Start_Date) = 4 then 'April' 
		 WHEN month(ch.Scheduled_Start_Date) = 5 then 'May'
		 WHEN month(ch.Scheduled_Start_Date) = 6 then 'June'
		 WHEN month(ch.Scheduled_Start_Date) = 7 then 'July'
		 WHEN month(ch.Scheduled_Start_Date) = 8 then 'August'
		 WHEN month(ch.Scheduled_Start_Date) = 9 then 'September'
		 WHEN month(ch.Scheduled_Start_Date) = 10 then 'October'
		 WHEN month(ch.Scheduled_Start_Date) = 11 then 'November'
		 WHEN month(ch.Scheduled_Start_Date) = 12 then 'December'
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
		GROUP BY LTRIM(ch.[Third On Behalf of]),
		CASE
		WHEN month(ch.Scheduled_Start_Date) = 1 then 'January'
		WHEN month(ch.Scheduled_Start_Date) = 2 then 'February'
		WHEN month(ch.Scheduled_Start_Date) = 3 then 'March'
		WHEN month(ch.Scheduled_Start_Date) = 4 then 'April' 
		 WHEN month(ch.Scheduled_Start_Date) = 5 then 'May'
		 WHEN month(ch.Scheduled_Start_Date) = 6 then 'June'
		 WHEN month(ch.Scheduled_Start_Date) = 7 then 'July'
		 WHEN month(ch.Scheduled_Start_Date) = 8 then 'August'
		 WHEN month(ch.Scheduled_Start_Date) = 9 then 'September'
		 WHEN month(ch.Scheduled_Start_Date) = 10 then 'October'
		 WHEN month(ch.Scheduled_Start_Date) = 11 then 'November'
		 WHEN month(ch.Scheduled_Start_Date) = 12 then 'December'
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

	$chart = new VerticalBarChart(500,350);
	$dataSet = new XYDataSet();		
		//while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			//array_push($data_Desc,$row['Approver']);
			//array_push($data_Month,$row['Month']);
			//array_push($data_Val,$row['CRQnum']);
		//}
	
		 while($row = mysql_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
		 {
			$dataSet->addPoint(new Point($row['Approver'],$row['CRQnum'] ));
		 
                  }	
			
	$chart->setDataSet($dataSet);
	$chart->setTitle("Monthly usage for www.example.com");
	$chart->render("generated/demo1.png");
		
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Libchart vertical bars demonstration</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
	<img alt="Vertical bars chart" src="generated/demo1.png" style="border: 1px solid gray;"/>
</body>
</html>
