<?php //session_start();  $pagePrivValue=10; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<?php error_reporting(-1);$conf['error_level'] = 2;ini_set('display_errors', TRUE);ini_set('display_startup_errors', TRUE); ?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>  
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>  
<link rel="stylesheet" href="/resources/demos/style.css" />  
<script>  
$(function() {    
	$( "#from" ).datepicker({      defaultDate: "+1w",      changeMonth: true,      numberOfMonths: 1,      
			onClose: function( selectedDate ) {        
				$( "#to" ).datepicker( "option", "minDate", selectedDate );    
				}    ,
			showOn: "button",      buttonImage: "images/calendar.png",      buttonImageOnly: true 
	});    
	
	$( "#to" ).datepicker({      defaultDate: "+1w",      changeMonth: true,      numberOfMonths: 1,      
			onClose: function( selectedDate ) {        
				$( "#from" ).datepicker( "option", "maxDate", selectedDate );      
				}    ,
			showOn: "button",      buttonImage: "images/calendar.png",      buttonImageOnly: true 
	});  
	
});  
</script>
<div class="body_text">Report of Changes Requests in date interval</div>
<form method=post action='CAB_Report_Interval.php'>
	<label for="from">From </label><input type="text" id="from" name="from"   />
	<label for="to">to </label><input type="text" id="to" name="to"   />  
	<input type=submit name='submit' value='Search'/>
</form>
<?php 
	//if(!isset($_POST['from']))
	if(isset($_POST['submit'])) {
		$ts1 = strtotime($_POST['from']);
		$ts2 = strtotime($_POST['to']);
		$seconds_diff = $ts2 - $ts1;
		$days =  floor($seconds_diff/3600/24);
		if($days >= 15) echo "This interval is $days days. No more than 15 Days ya Ammooor..";
		else{
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
		
		$sql = "SELECT ch.CRQ,Requester,ch.Support_Company,ch.Support_Organization,ch.Support_Group_Name,tsk.Assignee_Company , tsk.Assignee_Organization, tsk.Assignee_Group,
						Description,Status, CAST(ch.Scheduled_Start_Date AS varchar) Scheduled_Start_Date_,CAST(ch.Scheduled_End_Date AS varchar) Scheduled_End_Date,Impact ,APApprovers, ChangeFor,
						Product_Categorization_Tier_1,Product_Categorization_Tier_2,Product_Categorization_Tier_3, 
						CAST(ch.[First Approval Date] AS varchar) First_Approval_Date,ch.[First Approver] First_Approver,ch.[First On Behalf of] FOBO,
						ch.[Second Approver] Approver2,ch.[Second On Behalf of] OBO2, ch.[Third Approver] Approver3,ch.[Third On Behalf of] OBO3, ch.[Fourth Approver] Approver4,ch.[Fourth On Behalf of] OBO4,
						ch.[Fifth Approver] Approver5,ch.[Fifth On Behalf of] OBO5, ch.[Sixth Approver] Approver6,ch.[Sixth On Behalf of] OBO6
					FROM dbo.vw_Change_Approval_Details ch LEFT OUTER JOIN  dbo.vw_Change_Task_Merged_New tsk
					ON ch.CRQ = tsk.Request_ID";
		if (isset($_POST['to']) AND isset($_POST['from'])) {
		$sql = $sql. " WHERE dbo.dateOnly(ch.Scheduled_Start_Date) BETWEEN '".$_POST['from']."' AND '".$_POST['to']."' ";//'4/1/2013' AND '4/12/2013';";
			}
		else
			$sql = $sql. " WHERE dbo.dateOnly(ch.Scheduled_Start_Date) = dbo.dateOnly(getdate()) ";
		$sql = $sql . " ORDER BY ch.Scheduled_Start_Date;"; //sort any way
		//echo $sql;
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Data = array();
		
		$i=0;
			$found = false;
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$found = true;
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
				$PendingAt = $row['APApprovers'];
				$Status = $row['Status'];
				$ScheduledStartDate = $row['Scheduled_Start_Date_'];
				$ScheduledEndDate = $row['Scheduled_End_Date'];
				preg_match('/(?P<x>\d+)-(?P<impact_level>\w+)\/(?P<y>\w+)/', $row['Impact'],$Impact_Exp);
				$Impact = $Impact_Exp['impact_level'];
				$First_Approval_Date = $row['First_Approval_Date'];
				$First_Approver = $row['First_Approver'];
				$FOBO = $row['FOBO'];
				$Approver2 = $row['Approver2'];
				$OBO2 =$row['OBO2'];
				$Approver3 = $row['Approver3'];
				$OBO3 =$row['OBO3'];
				$Approver4 = $row['Approver4'];
				$OBO4 =$row['OBO4'];
				$Approver5 = $row['Approver5'];
				$OBO5 =$row['OBO5'];
				$Approver6 = $row['Approver6'];
				$OBO6 =$row['OBO6'];
				
				$data_Data[$i] = array();
				$data_Data[$i]['CRQ']=$CRQ;
				$data_Data[$i]['Submitter']=$Submitter;
				$data_Data[$i]['SupportCompany']=$SupportCompany;
				$data_Data[$i]['SupportOrganization']=$SupportOrganization;
				$data_Data[$i]['SupportGroup']=$SupportGroup;
				$data_Data[$i]['Assignee_Company']=$Assignee_Company;
				$data_Data[$i]['Assignee_Organization']=$Assignee_Organization;
				$data_Data[$i]['Assignee_Group']=$Assignee_Group;
				$data_Data[$i]['Description']=str_replace("'","",preg_replace("/[\n\r]/","",$Description));
				$data_Data[$i]['ChangeFor']=$ChangeFor;
				$data_Data[$i]['ProductTier1']=str_replace("'","",$ProductTier1);
				$data_Data[$i]['ProductTier2']=$ProductTier2;
				$data_Data[$i]['ProductTier3']=$ProductTier3;
				$data_Data[$i]['Status']=$Status;
				$data_Data[$i]['ScheduledStartDate']=$ScheduledStartDate;
				$data_Data[$i]['ScheduledEndDate']=$ScheduledEndDate;
				//$data_Data[$i]['Authorized']=$Authorized; //$row['Authorized'];
				$data_Data[$i]['Impact']=$Impact;
				//$data_Data[$i]['cTimeStamp']=$cTimeStam;
				
				$i++;
		}
		
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn );
		} // extract from DB only if interval > 15 days
	}
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1.0", {'packages':['controls']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataTable = google.visualization.arrayToDataTable([           
		//	,'SupportCompany','SupportOrganization', 'Assignee_Company','Assignee_Organization',
			['CRQ','Submitter','Requesting Team','Implementing Team','Description',
			'Change For','Change Tiers','Status','Scheduled Date','Impact'],//,'Authorized'],                
			<?php 
				//if(isset($data_Data)){
					for($i=0;$i<count($data_Data); $i++) {             
				//		$data_Data[$i][Assignee_Company]."','".$data_Data[$i][Assignee_Organization]."','".
				//		$data_Data[$i][SupportCompany]."','".$data_Data[$i][SupportOrganization].
						echo "['".$data_Data[$i]['CRQ']."','".$data_Data[$i]['Submitter']."','".$data_Data[$i]['SupportGroup']."','".$data_Data[$i]['Assignee_Group'].
							 "','".$data_Data[$i]['Description']."','".$data_Data[$i]['ChangeFor']."','".$data_Data[$i]['ProductTier1']." > ".$data_Data[$i]['ProductTier2'].
							 " > ".$data_Data[$i]['ProductTier3']."','".$data_Data[$i]['Status']."','".$data_Data[$i]['ScheduledStartDate'].
							 "','".$data_Data[$i]['Impact']."']"; //,".$data_Data[$i]['Authorized']."]"; 
						if ($i<count($data_Data)-1) echo ",";	//add ',' to all except last element
					}  
				//}
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
<?php if(isset($_POST['submit'])) {   ?>
<table width="100%"><tr>
	<td>
		<table><tr><td><div class="body_text">Interval Changes Report from <?php echo $_POST['from']." to ".$_POST['to']; ?></div></td>
		<td align=right >
		<?php 
			$sql = "SELECT ch.CRQ,Requester,ch.Support_Company,ch.Support_Organization,ch.Support_Group_Name,tsk.Assignee_Company , tsk.Assignee_Organization, tsk.Assignee_Group, Description,Status, CAST(ch.Scheduled_Start_Date AS varchar) Scheduled_Start_Date,CAST(ch.Scheduled_End_Date AS varchar) Scheduled_End_Date,Impact ,APApprovers, ChangeFor, Product_Categorization_Tier_1,Product_Categorization_Tier_2,Product_Categorization_Tier_3, CAST(ch.[First Approval Date] AS varchar) First_Approval_Date,ch.[First Approver] First_Approver,ch.[First On Behalf of] FOBO, ch.[Second Approver] Approver2,ch.[Second On Behalf of] OBO2, ch.[Third Approver] Approver3,ch.[Third On Behalf of] OBO3, ch.[Fourth Approver] Approver4,ch.[Fourth On Behalf of] OBO4, ch.[Fifth Approver] Approver5,ch.[Fifth On Behalf of] OBO5, ch.[Sixth Approver] Approver6,ch.[Sixth On Behalf of] OBO6 FROM dbo.vw_Change_Approval_Details ch LEFT OUTER JOIN dbo.vw_Change_Task_Merged_New tsk ON ch.CRQ = tsk.Request_ID ";
			if (isset($_POST['to']) AND isset($_POST['from'])) {
				$sql = $sql. " WHERE dbo.dateOnly(ch.Scheduled_Start_Date) BETWEEN '".$_POST['from']."' AND '".$_POST['to']."' ";//'4/1/2013' AND '4/12/2013';";
			}
			else
				$sql = $sql. " WHERE dbo.dateOnly(ch.Scheduled_Start_Date) = dbo.dateOnly(getdate()) ";
			$sql = $sql . " ORDER BY ch.Scheduled_Start_Date;"; //sort any way
			$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
			//echo $sql;
			echo '<a href="excel.php?name=Interval_Report&query='.$sql_encoded.'">';
		?>
		<img width=24px height=24px src="images/excel.bmp" style="border-style: none"/></a>
		</td></tr></table>
	</td>
	<td  align=right><?php //echo 'Last Updated: '.date("D, j F Y, g:i a",strtotime($data_Data[0][cTimeStamp]));//$cTimeStamp; ?>   </td><tr>
</table>
<?php } ?>
<table >
	<!--Div that will hold the dashboard-->     
	<div id="dashboard_div">       
		<!--Divs that will hold each control and chart-->       
		<div id="filter_div"></div>       
		<div id="table_div"></div>     
	</div>
	<!--tr><td ><div id="table_div" ></div></td></tr-->
</table>

<?php include ("footer_new.php"); ?>