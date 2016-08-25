<?php include ("template.php"); ?>
<br>
<br>
<p><b>&nbsp;&nbsp;Today's CAB Meeting Report</b></p>
<?php
		/* Parse configuration file 
		$ini_array = parse_ini_file("config.ini");*/
		
		// Here add your own data for connecting to MySQL database
		$serverName = 'egzhr-wie2e01';
		$connectionInfo = array( "Database"=>"SM_Change_Researching_DB");
		

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$sql = "SELECT DISTINCT  ordr.Team_Order,cab.CRQ,Requester,Support_Company,Support_Organization,Support_Group_Name,Description,Status,Assignee_Company , Assignee_Organization, Assignee_Group,
			CAST(Scheduled_Start_Date AS varchar) Scheduled_Start_Date,CAST(Scheduled_End_Date AS varchar) Scheduled_End_Date,Impact ,Approval_Pending, ChangeFor,
			Product_Categorization_Tier_1,Product_Categorization_Tier_2,Product_Categorization_Tier_3,auth.Authorized,auth.CM_Comment
			FROM dbo.vw_Change_Daily_CAB cab LEFT OUTER JOIN  dbo.tbl_Change_Daily_CAB_Authorize auth
			ON cab.CRQ = auth.CRQ 
			LEFT OUTER JOIN dbo.tbl_Change_Daily_CAB_Order ordr
			ON cab.Assignee_Organization = ordr.Team_Name
			ORDER BY ordr.Team_Order, cab.Support_Group_Name;";
				
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
			
				$data_Data[$i][CRQ]=$CRQ;
				$data_Data[$i][Submitter]=$Submitter;
				$data_Data[$i][SupportCompany]=$SupportCompany;
				$data_Data[$i][SupportOrganization]=$SupportOrganization;
				$data_Data[$i][SupportGroup]=$SupportGroup;
				$data_Data[$i][Assignee_Company]=$Assignee_Company;
				$data_Data[$i][Assignee_Organization]=$Assignee_Organization;
				$data_Data[$i][Assignee_Group]=$Assignee_Group;
				$data_Data[$i][Description]=str_replace("'","",$Description);
				$data_Data[$i][Description]=str_replace("'","",preg_replace("/[\n\r]/","",$Description));
				$data_Data[$i][ChangeFor]=$ChangeFor;
				$data_Data[$i][ProductTier1]=$ProductTier1;
				$data_Data[$i][ProductTier2]=$ProductTier2;
				$data_Data[$i][ProductTier3]=$ProductTier3;
				$data_Data[$i][PendingAt]=$Description;
				$data_Data[$i][Status]=$Status;
				$data_Data[$i][ScheduledStartDate]=$ScheduledStartDate;
				$data_Data[$i][ScheduledEndDate]=$ScheduledEndDate;
				$data_Data[$i][Authorized]=$Authorized; //$row['Authorized'];
				$data_Data[$i][Impact]=$Impact;
				
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
			['CRQ','Submitter','Requesting Team','Implementing Team','Description','ChangeFor',
			'ProductTier1','ProductTier2','ProductTier3','Status','ScheduledStartDate','ScheduledEndDate','Impact','Authorized'],                
			<?php 
				for($i=0;$i<count($data_Data); $i++) {             
				//		$data_Data[$i][Assignee_Company]."','".$data_Data[$i][Assignee_Organization]."','".
				//		$data_Data[$i][SupportCompany]."','".$data_Data[$i][SupportOrganization].
						echo "['".$data_Data[$i][CRQ]."','".$data_Data[$i][Submitter]."','".$data_Data[$i][SupportGroup]."','".$data_Data[$i][Assignee_Group].
							 "','".$data_Data[$i][Description]."','".$data_Data[$i][ChangeFor]."','".$data_Data[$i][ProductTier1]."','".$data_Data[$i][ProductTier2].
							 "','".$data_Data[$i][ProductTier3]."','".$data_Data[$i][Status]."','".$data_Data[$i][ScheduledStartDate]."','".$data_Data[$i][ScheduledEndDate].
							 "','".$data_Data[$i][Impact]."',".$data_Data[$i][Authorized]."]"; 
						if ($i<count($data_Data)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] ); 
		// Create a string filter, passing some options   
		var stringFilter = new google.visualization.ControlWrapper({     
			'controlType': 'StringFilter',     
			'containerId': 'filter_div',     
			'options': {       'filterColumnLabel': 'Implementing Team'     }   
		});
		// Create a table chart, passing some options   
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
<table >
	<!--Div that will hold the dashboard-->     
	<div id="dashboard_div">       
		<!--Divs that will hold each control and chart-->       
<table>
<tr>
<td>		
		<div id="filter_div"></div> 
</td>		
<td align=left >
<?php 
		$sql = "SELECT DISTINCT ordr.Team_Order,cab.CRQ,Requester,Support_Company,Support_Organization,Support_Group_Name,Description,Status,Assignee_Company , Assignee_Organization, Assignee_Group,CAST(Scheduled_Start_Date AS varchar) Scheduled_Start_Date,CAST(Scheduled_End_Date AS varchar) Scheduled_End_Date,Impact,Approval_Pending,ChangeFor,Product_Categorization_Tier_1,Product_Categorization_Tier_2,Product_Categorization_Tier_3,auth.Authorized FROM dbo.vw_Change_Daily_CAB cab LEFT OUTER JOIN  dbo.tbl_Change_Daily_CAB_Authorize auth ON cab.CRQ = auth.CRQ LEFT OUTER JOIN dbo.tbl_Change_Daily_CAB_Order ordr ON cab.Assignee_Organization = ordr.Team_Name ORDER BY ordr.Team_Order,cab.Support_Group_Name;";
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		//echo $sql;
		echo '<a href="excel.php?name=CAB_Report&query='.$sql_encoded.'">';
	?>
<img width=24px height=24px src="images\Save-icon.png" style="border-style: none"/></a>

</td>
</tr>
</table>
     
		<div id="table_div"></div>     
	</div>
	<!--tr><td ><div id="table_div" ></div></td></tr-->
</table>

<?php sqlsrv_close( $conn ); ?>
<?php include ("footer.php"); ?>