<?php //session_start();  $pagePrivValue=10; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
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
		$sql = "SELECT DISTINCT  ordr.Team_Order,cab.CRQ,Requester,Support_Company,Support_Organization,Support_Group_Name,Description,Status,Assignee_Company , Assignee_Organization, Assignee_Group,
			CAST(Scheduled_Start_Date AS varchar) Scheduled_Start_Date,CAST(Scheduled_End_Date AS varchar) Scheduled_End_Date,Impact ,Approval_Pending, ChangeFor,CAST(cab.cTimeStamp AS varchar) cTimeStamp,
			Product_Categorization_Tier_1,Product_Categorization_Tier_2,Product_Categorization_Tier_3,auth.Authorized,auth.CM_Comment
			FROM dbo.vw_Change_Daily_CAB cab LEFT OUTER JOIN  dbo.tbl_Change_Daily_CAB_Authorize auth
			ON cab.CRQ = auth.CRQ 
			LEFT OUTER JOIN dbo.tbl_Change_Daily_CAB_Order ordr
			ON cab.Assignee_Organization = ordr.Team_Name
			ORDER BY ordr.Team_Order, cab.Assignee_Group,cab.CRQ;";
					
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Data = array();
		
		$i=0;
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$CRQ = $row['CRQ'];
				$Submitter = $row['Requester'];
				$SupportCompany = $row['Support_Company'];
				$SupportOrganization = $row['Support_Organization'];
				$SupportGroup = $row['Support_Group_Name'];
				$Assignee_Company = $row['Assignee_Company'];
				$Assignee_Organization = $row['Assignee_Organization'];
				$Assignee_Group = $row['Assignee_Group'];
				$Description = $row['Description'];
				$ChangeFor = $row['ChangeFor'];
				$ProductTier1 = $row['Product_Categorization_Tier_1'];
				$ProductTier2 = $row['Product_Categorization_Tier_2'];
				$ProductTier3 = $row['Product_Categorization_Tier_3'];
				$PendingAt = $row['Approval_Pending'];
				$Status = $row['Status'];
				$ScheduledStartDate = $row['Scheduled_Start_Date'];
				$ScheduledEndDate = $row['Scheduled_End_Date'];
				$Authorized = (intval($row['Authorized'])==1)? 'true':'false';
				$CM_Comment = $row['CM_Comment'];
				preg_match('/(?P<x>\d+)-(?P<impact_level>\w+)\/(?P<y>\w+)/', $row['Impact'],$Impact_Exp);
				$Impact = $Impact_Exp['impact_level'];
				$cTimeStam = $row['cTimeStamp'];
				
				$data_Data[$i][CRQ]=$CRQ;
				$data_Data[$i][Submitter]=$Submitter;
				$data_Data[$i][SupportCompany]=$SupportCompany;
				$data_Data[$i][SupportOrganization]=$SupportOrganization;
				$data_Data[$i][SupportGroup]=$SupportGroup;
				$data_Data[$i][Assignee_Company]=$Assignee_Company;
				$data_Data[$i][Assignee_Organization]=$Assignee_Organization;
				$data_Data[$i][Assignee_Group]=$Assignee_Group;
				$data_Data[$i][Description]=str_replace("'","",preg_replace("/[\n\r]/","",$Description));
				$data_Data[$i][ChangeFor]=$ChangeFor;
				$data_Data[$i][ProductTier1]=$ProductTier1;
				$data_Data[$i][ProductTier2]=$ProductTier2;
				$data_Data[$i][ProductTier3]=$ProductTier3;
				$data_Data[$i][PendingAt]=$PendingAt;
				$data_Data[$i][Status]=$Status;
				$data_Data[$i][ScheduledStartDate]=$ScheduledStartDate;
				$data_Data[$i][ScheduledEndDate]=$ScheduledEndDate;
				$data_Data[$i][Authorized]=$Authorized; //$row['Authorized'];
				$data_Data[$i][Impact]=$Impact;
				$data_Data[$i][cTimeStamp]=$cTimeStam;
				
				$i++;
		}
		
		sqlsrv_free_stmt( $stmt);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1.0", {'packages':['controls']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataTable = google.visualization.arrayToDataTable([           
		//	,'SupportCompany','SupportOrganization', 'Assignee_Company','Assignee_Organization',
			['CRQ','Submitter','Requesting Team','Implementing Team','Description','Change For',
			'Change Tiers','Status','Scheduled Date','Impact','Authorized'],                
			<?php 
				for($i=0;$i<count($data_Data); $i++) {             
				//		$data_Data[$i][Assignee_Company]."','".$data_Data[$i][Assignee_Organization]."','".
				//		$data_Data[$i][SupportCompany]."','".$data_Data[$i][SupportOrganization].
						echo "['".$data_Data[$i][CRQ]."','".$data_Data[$i][Submitter]."','".$data_Data[$i][SupportGroup]."','".$data_Data[$i][Assignee_Group].
							 "','".$data_Data[$i][Description]."','".$data_Data[$i][ChangeFor]."','".$data_Data[$i][ProductTier1]." > ".$data_Data[$i][ProductTier2].
							 " > ".$data_Data[$i][ProductTier3]."','".$data_Data[$i][Status]." (".$data_Data[$i][PendingAt].")','".$data_Data[$i][ScheduledStartDate].
							 "','".$data_Data[$i][Impact]."',".$data_Data[$i][Authorized]."]"; 
						if ($i<count($data_Data)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] ); 
		// Create a range slider, passing some options   
		var stringFilter = new google.visualization.ControlWrapper({     
			'controlType': 'StringFilter',     
			'containerId': 'filter_div',     
			'options': {       'filterColumnLabel': 'Implementing Team'     }   
		});
		// Create a pie chart, passing some options   
		var table = new google.visualization.ChartWrapper({     
			'chartType': 'Table',     
			'containerId': 'table_div'  ,
			'options': {       "showRowNumber" : true      } 
			});
		
		//drawTable
		//var table = new google.visualization.Table(document.getElementById('table_div'));         
		//table.draw(dataTable, {showRowNumber: true});       
		
		// Create a dashboard.         
		var dashboard = new google.visualization.Dashboard(document.getElementById('dashboard_div')); 
		
		// Establish dependencies, declaring that 'filter' drives 'pieChart',         
		// so that the pie chart will only display entries that are let through         
		// given the chosen slider range.         
		dashboard.bind(stringFilter, table);          
		
		// Draw the dashboard.         
		dashboard.draw(dataTable);
		  
	} 
</script>   
<?php 	$DB_last_update = date("D, j F Y, g:i a",strtotime($data_Data[0][cTimeStamp]));
				if($DB_last_update == 'Thu, 1 January 1970, 2:00 am'){
					$still_fetching = true;
					echo 'Please wait a few moments while DB is fetching the hourly data..';
				}else {?>
<table width="100%"><tr>
	<td>
		<table><tr><td><div class="body_text"><b>Today's CAB Meeting Report</b></div></td>
		<td align=right >
		<?php 
			$sql = "SELECT DISTINCT ordr.Team_Order,cab.CRQ,Requester,Support_Company,Support_Organization,Support_Group_Name,Description,Status,Assignee_Company , Assignee_Organization, Assignee_Group,CAST(Scheduled_Start_Date AS varchar) Scheduled_Start_Date,CAST(Scheduled_End_Date AS varchar) Scheduled_End_Date,Impact,Approval_Pending,ChangeFor,Product_Categorization_Tier_1,Product_Categorization_Tier_2,Product_Categorization_Tier_3,auth.Authorized,auth.CM_Comment FROM dbo.vw_Change_Daily_CAB cab LEFT OUTER JOIN  dbo.tbl_Change_Daily_CAB_Authorize auth ON cab.CRQ = auth.CRQ LEFT OUTER JOIN dbo.tbl_Change_Daily_CAB_Order ordr ON cab.Assignee_Organization = ordr.Team_Name ORDER BY ordr.Team_Order,cab.Assignee_Group;";
			$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
			//echo $sql;
			echo '<a href="excel.php?name=CAB_Report&query='.$sql_encoded.'">';
		?>
		<img width=24px height=24px src="images/excel.bmp" style="border-style: none"/></a>
		</td></tr></table>
	</td>
	<td  align=right>
		<?php 		echo 'Last Updated: '.$DB_last_update;//$cTimeStamp; 
				}
		?>   
	</td></tr></table>
<table >
	<!--Div that will hold the dashboard-->     
	<div id="dashboard_div">       
		<!--Divs that will hold each control and chart-->       
		<div id="filter_div"></div>       
		<div id="table_div"></div>     
	</div>
	<!--tr><td ><div id="table_div" ></div></td></tr-->
</table>
<?php if(!$still_fetching){ ?>
<!-- kokiiii -->

<?php } ?>
<?php sqlsrv_close( $conn ); ?>
<?php include ("footer_new.php"); ?>