<link href="css/style.css" rel="stylesheet" type="text/css" />

<?php	  

		if (isset($_GET['region'])) {
			
			if ($_GET['region'] === 'Cairo') {
				$RegionCondition = " QR.Region ='Cairo'";
				$tableRegion = 'Cairo';
			}
			else if ($_GET['region'] === 'Giza') {
				$RegionCondition = " QR.Region ='Giza'";
				$tableRegion = 'Giza';
			}
			else if ($_GET['region'] === 'Alex and North Coast') {
				$RegionCondition = " QR.Region ='Alex and North Coast' ";
				$tableRegion = 'Alex and North Coast';
			}
			else if ($_GET['region'] === 'Delta') {
				$RegionCondition = " QR.Region ='Delta' ";
				$tableRegion = 'Delta';
			}
			else if ($_GET['region'] === 'Canal, Red Sea and Sinai') {
				$RegionCondition = " QR.Region ='Canal, Red Sea and Sinai' ";
				$tableRegion = 'Canal, Red Sea and Sinai';
			}
			else if ($_GET['region'] === 'Upper Egypt') {
				$RegionCondition = " QR.Region ='Upper Egypt' ";
				$tableRegion = 'Upper Egypt';
			}
			else {
				$tableRegion = $_GET['region'];
				$RegionCondition = " QR.Region like '$tableRegion%' ";
			}
		}	
		$data_Qism_Name = array();
		$data_2G_Val_DownSites = array();
		$data_2G_Per_DownSites = array();
		$data_3G_Val_DownSites = array();
		$data_3G_Per_DownSites = array();
		
		/* Parse configuration file */
		$ini_array = parse_ini_file("config.ini");
	
		/* Specify the server and connection string attributes. */

		$serverName = $ini_array['SERVER_NAME']; 
		$connectionInfo = array( "UID"=>$ini_array['DB_USER'], "PWD"=>$ini_array['DB_PASS'], "Database"=>$ini_array['DB_NAME']);

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		//Down Scattered Sites WHERE SS.Region = 'Cairo'
		$sql = "SELECT SS.Site_Type,QR.[Qism NAME] Qism_Name,QR.SUBREGION,COUNT(DS.Site_ID) Down,COUNT(SS.Site_ID) AllSites
				  FROM  dbo.tbl_SS_LK_SubRegions_Sites SS
				  LEFT OUTER JOIN dbo.tbl_SS_DownSites DS
				  ON  SS.Site_ID = (Select case WHEN DS.[Site_ID] LIKE '%[a-z]%' THEN DS.[Site_ID]
													ELSE cast(CAST(DS.[Site_ID] as int) as nvarchar(50))
													END ) 
					LEFT OUTER JOIN  [dbo].[tbl.Qism_Regions] QR
					ON QR.BTS_ID = SS.Site_ID
				  WHERE $RegionCondition
				  GROUP BY SS.Site_Type,QR.[Qism NAME],QR.SUBREGION
				  ORDER BY 2 DESC;
";
				  
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$Qism_Name = $row['Qism_Name'];
			array_push($data_Qism_Name,$Qism_Name);
			$type = $row['Site_Type'];
			
			if($type === '2G') {
				$data_2G_Val_DownSites[$Qism_Name] = $row['Down'];
				$data_2G_Per_DownSites[$Qism_Name] = 100 - round(( $row['Down'] / $row['AllSites'] )*100 , 0);
			}
			else if($type === '3G') {
				$data_3G_Val_DownSites[$Qism_Name] = $row['Down'];
				$data_3G_Per_DownSites[$Qism_Name] = 100 - round(( $row['Down'] / $row['AllSites'] )*100 , 0);
			}
		}
		//echo "area: ".$Qism_Name." type: ".$type."3G: ".$data_3G_Per_DownSites[$Qism_Name]."2G: ".$data_2G_Per_DownSites[$Qism_Name];
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn ); 
		
		$data_Qism_Name = array_unique($data_Qism_Name);
		$aggr_SS = count($data_Qism_Name);
			
		echo "<table class=SStable align=center >";	
		
		echo "<td align=center colspan=5><B><a href=\"../SLA/".$tableRegion."/index_".$tableRegion.".php\" target=\"_blank\">".$tableRegion."</B></td>";
		
		echo "<tr><th width=100px>Qism</th><th colspan=2 width=30px>2G</th><th colspan=2 width=30px>3G</th></tr>";
		
		//for($index=0; $index < $aggr_SS; $index++){
		foreach ($data_Qism_Name as $Qism_Name) {
			//if($date==$thisDate){            
					//$Qism_Name = $data_area[$index];
					$strQism_Name = str_replace(" ","__",$Qism_Name);
					echo "<tr><td><a class=area_link href='Report_Qism.php?Qism_Name=$strQism_Name' target='_blank'>".substr($Qism_Name,0,13)."</a></td>";
					if (isset($data_2G_Per_DownSites[$Qism_Name])) {
						if($data_2G_Per_DownSites[$Qism_Name] <= 100 && $data_2G_Per_DownSites[$Qism_Name] >= 97) $severity = "green";
						if($data_2G_Per_DownSites[$Qism_Name] <= 96 && $data_2G_Per_DownSites[$Qism_Name] >= 94 ) $severity = "yellow";
						if($data_2G_Per_DownSites[$Qism_Name] <= 93 && $data_2G_Per_DownSites[$Qism_Name] >= 87 ) $severity = "orange";
						if($data_2G_Per_DownSites[$Qism_Name] <= 86 && $data_2G_Per_DownSites[$Qism_Name] >= 75 ) $severity = "red";
						if($data_2G_Per_DownSites[$Qism_Name] <= 74 ) $severity = "black";
						echo "<td class=SSS_".$severity.">".$data_2G_Per_DownSites[$Qism_Name]."%</td>";
					}
					else echo "<td></td>";
					
					echo "<td>".$data_2G_Val_DownSites[$Qism_Name]."</td>";
					
					if (isset($data_3G_Per_DownSites[$Qism_Name])) {
						if($data_3G_Per_DownSites[$Qism_Name] <= 100 && $data_3G_Per_DownSites[$Qism_Name] >= 97) $severity = "green";
						if($data_3G_Per_DownSites[$Qism_Name] <= 96 && $data_3G_Per_DownSites[$Qism_Name] >= 94 ) $severity = "yellow";
						if($data_3G_Per_DownSites[$Qism_Name] <= 93 && $data_3G_Per_DownSites[$Qism_Name] >= 87 ) $severity = "orange";
						if($data_3G_Per_DownSites[$Qism_Name] <= 86 && $data_3G_Per_DownSites[$Qism_Name] >= 75 ) $severity = "red";
						if($data_3G_Per_DownSites[$Qism_Name] <= 74 ) $severity = "black";
						echo "<td class=SSS_".$severity.">".$data_3G_Per_DownSites[$Qism_Name]."%</td>";
					}
					else echo "<td></td>";
					
					echo "<td>".$data_3G_Val_DownSites[$Qism_Name]."</td>";
					
					echo "</tr>";
			//	}
			
		}
		echo "</table><br>";
?>					