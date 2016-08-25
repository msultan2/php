<?php include ("index_tools.php");  ?>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
		<table>
			<form action="SDS_Search_By_Node.php" name="myForm" method="post">
				<tr>
					<td align=center valign=top><b>SDS Search: </b></td>
					<td align=left>
						<textarea wrap="hard" rows="10" cols="13" name="SiteIDs"><?php echo $_POST['SiteIDs'];?></textarea>
					</td>
					<td valign=top>
						<input type="submit" name="searchSDS" value="Search" />
					</td>
				</tr>
				<tr style="height:10px"></tr>
			</form>		
		</table>		

<?php
	//This part displays the Search CRQ result
	if (isset($_POST['SiteIDs'])) {
	
		$SiteIDs = preg_split('/\n/',$_POST['SiteIDs']);
		$arrArea = array();
		$sumSites = 0;
		$sumTT = 0;
		$sumAreas = 0;
		
	/************************** Excel ***********************/
	$querySDS = "";
	for ($i=0; $i<sizeof($SiteIDs); $i++){
		$querySDS = $querySDS. "'$SiteIDs[$i]'";
		if($i < sizeof($SiteIDs) - 1)
			$querySDS = $querySDS. ",";
	}
		$sql = "SELECT * FROM  tbl_All_Network_Nodes ANN WHERE ANN.Site IN ($querySDS);";		 
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		//echo $sql_encoded;
		echo '<a href="excel.php?name=SDS_2014&query='.$sql_encoded.'">';
		echo 'Export to Excel: <img width=24px height=24px src="images/excel.bmp" style="border-style: none"/></a>';
	/************************** Excel ***********************/
	
		echo "<div id='main'>
				<table class='features-table'>
				<tr>
					<td class='ol-cell col-cell1 col-cellh'>Site ID</td>
					<td class='ol-cell col-cell1 col-cellh'>Node</td>
				</tr>";
		for ($i=0; $i<sizeof($SiteIDs); $i++){
		
			$siteID=chop($SiteIDs[$i]);
			//if(strlen($siteID) >6 OR strlen($siteID) <5 OR !is_numeric($siteID)){
			//	echo "<tr><td>".$siteID."</td><td colspan=11>Not a valid number, please enter the last 5 digits in the CRQ Number</td></tr>";
			//}
			//else{ 
					
			//phpinfo();
			error_reporting(-1);$conf['error_level'] = 2;ini_set('display_errors', TRUE);ini_set('display_startup_errors', TRUE);
				
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
					 echo "Connection could not be established.<br />";
					 die( print_r( sqlsrv_errors(), true));
				}
				if(strlen($siteID) == 0) continue;
				if(strlen($siteID) == 2) $siteID_4d="00".$siteID;
				else if(strlen($siteID) == 3) $siteID_4d="0".$siteID;
				else $siteID_4d = $siteID;
				
				
				  
				$sql = "SELECT * FROM  tbl_All_Network_Nodes ANN WHERE ANN.Site = '".$siteID_4d."';";
				$stmt = sqlsrv_query( $conn, $sql );
				if( $stmt === false) {
					die( print_r( sqlsrv_errors(), true) );
				}
				$found = false;
				while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				//print_r($row);
					$found = true;
					$Node = $row['Node'];
					$Site = $row['Site'];
					
					echo "<tr>
						<td class='col-cell col-cell1'>".$siteID_4d."</td>
						<td class='col-cell col-cell1'>".$Node."</td>";
					echo "</tr>";
				}
				
				
			sqlsrv_free_stmt( $stmt);
			//}
		}
		//$sumAreas = count(array_unique($arrArea));
		echo "
				
				</table></div>";
	
		// Close the connection.
		sqlsrv_close( $conn );
	}
?>		
<?php //include ("footer_tools.php");  ?>