<?php //session_start();  $pagePrivValue=100; //require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<script type="text/javascript" src="jquery-1.2.1.min.js"></script>

		<table>
			<form action="CRQ_Auth.php" name="myForm" method="post">
				<tr>
					<td align=center valign=top><b>Search CRQ: </b></td>
					<td align=left>
						<textarea wrap="hard" rows="05" cols="13" name="CRQnums"><?php echo $_POST['CRQnums'];?></textarea>
					</td>
					<td valign=top>
						<input type="submit" name="searchCRQ" value="Search" />
					</td>
				</tr>
				<tr style="height:10px"></tr>
			</form>		
		</table>		
<?php
	//This part displays the Search CRQ result
	if (isset($_POST['CRQnums'])) {
	
		$CRQnums = preg_split('/\n/',$_POST['CRQnums']);

		echo "<table class=red width=90% >
				<tr>
					<th>CRQ</th>
					<th>Submitter</th>
					<th>Requesting Team</th>
					<th>Implementing Team</th>
					<th>Scheduled Date</th>
					<th>Description</th>
					<th>Impact</th>
					<th>Pending At</th>
					<th>Change Type</th>
					<th>Status</th>
					
					<th>CM Comment</th>
				</tr>";
		for ($i=0; $i<sizeof($CRQnums); $i++){
		
			$CRQnum=chop($CRQnums[$i]);
			if(strlen($CRQnum) >6 OR strlen($CRQnum) <5 OR !is_numeric($CRQnum)){
				echo "<tr><td>".$CRQnum."</td><td colspan=11>Not a valid number, please enter the last 5 digits in the CRQ Number</td></tr>";
			}
			else{ 
					
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
				if(strlen($CRQnum) == 6) $CRQnumber="CRQ000000".$CRQnum;
				if(strlen($CRQnum) == 5) $CRQnumber="CRQ0000000".$CRQnum;
				$sql = "SELECT DISTINCT cab.CRQ,Requester,Support_Company,Support_Organization,Support_Group_Name,Assignee_Company , Assignee_Organization, Assignee_Group,
				Description,Status, CAST(Scheduled_Start_Date AS varchar) Scheduled_Start_Date,CAST(Scheduled_End_Date AS varchar) Scheduled_End_Date,Impact ,Approval_Pending, ChangeFor,
				Product_Categorization_Tier_1,Product_Categorization_Tier_2,Product_Categorization_Tier_3,auth.Authorized,auth.CM_Comment
				FROM dbo.vw_Change_Daily_CAB_ODS cab LEFT OUTER JOIN  dbo.tbl_Change_Daily_CAB_Authorize auth
				ON cab.CRQ = auth.CRQ 
				WHERE cab.CRQ = '".$CRQnumber."';";
				$stmt = sqlsrv_query( $conn, $sql );
				if( $stmt === false) {
					die( print_r( sqlsrv_errors(), true) );
				}
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
					$PendingAt = $row['Approval_Pending'];
					$Status = $row['Status'];
					$ScheduledStartDate = $row['Scheduled_Start_Date'];
					$ScheduledEndDate = $row['Scheduled_End_Date'];
					$Authorized = $row['Authorized'];
					$CM_Comment = $row['CM_Comment'];
					preg_match('/(?P<x>\d+)-(?P<impact_level>\w+)\/(?P<y>\w+)/', $row['Impact'],$Impact_Exp);
					$Impact = $Impact_Exp['impact_level'];
					$is_Auth=($Authorized == 1)? 'checked':'';
					
					echo "<tr>
						<td>".substr($CRQ, -6)."</td>
						<td>".$Submitter."</td>
						<td width=140px><table><tr><td>".$SupportCompany."</td></tr><tr><td>".$SupportOrganization."</td></tr><tr><td>".$SupportGroup."</td></tr></table></td>";
					echo ($Assignee_Company == null)?"<td></td>":"<td width=140px><table><tr><td>".$Assignee_Company."</td></tr><tr><td>".$Assignee_Organization."</td></tr><tr><td>".$Assignee_Group."</td></tr></table></td>";
					echo	"<td width=200px>".$ScheduledStartDate."<br> to <br>".$ScheduledEndDate."</td>
						<td>".$Description."</td>
						<td class=".$Impact.">".$Impact."</td>
						<td>". ( ($Status==="Scheduled")? '--':$PendingAt ) . "</td>
						<td>".$ChangeFor."<table width=100%><tr><td>".$ProductTier1."</td></tr><tr><td>".$ProductTier2."</td></tr><tr><td>".$ProductTier3."</td></tr></table></td>
						<td>".$Status."</td>
						
						<td><textarea name='new_comment' rows=4 cols=20>".$CM_Comment."</textarea> </td>";
						//echo "nmnm: ".$new_comment;
					echo "</tr>";
				}
				if(!$found)
					echo "<tr><td>".$CRQnum."</td><td colspan=11>Not found in the Database</td></tr>";
				
			}
		}
		echo "</table>";
	}
?>		
	<table width='100%'>	
		<tr><b>Today's CAB Report:</b></tr>
	</table>
<?php
	
			//phpinfo();
			//error_reporting(-1);$conf['error_level'] = 2;ini_set('display_errors', TRUE);ini_set('display_startup_errors', TRUE);
			
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
			$sql = "SELECT DISTINCT  ordr.Team_Order,cab.CRQ,Requester,Support_Company,Support_Organization,Support_Group_Name,Description,Status,Assignee_Company , Assignee_Organization, Assignee_Group,
						CAST(cab.Scheduled_Start_Date AS varchar) Scheduled_Start_Date,CAST(Scheduled_End_Date AS varchar) Scheduled_End_Date,Impact ,Approval_Pending, ChangeFor,
						Product_Categorization_Tier_1,Product_Categorization_Tier_2,Product_Categorization_Tier_3,auth.Authorized,auth.CM_Comment
						,External_Customer,Service_Impact,Internal_Customer,Business_Impact,Nodes_Systems,Technical_Impact,Reporting,DWH_Impact 
					FROM dbo.vw_Change_Daily_CAB cab LEFT OUTER JOIN  dbo.tbl_Change_Daily_CAB_Authorize auth
						ON cab.CRQ = auth.CRQ 
						LEFT OUTER JOIN dbo.tbl_Change_Daily_CAB_Order ordr
						ON cab.Assignee_Organization = ordr.Team_Name
					WHERE Assignee_Company <> 'Regional Operations' AND Assignee_Company <> 'Access Network' 
					--AND Assignee_Group <> 'Fixed Network_Network Deployment'
					ORDER BY ordr.Team_Order, cab.Assignee_Group, cab.CRQ; ";
			$stmt = sqlsrv_query( $conn, $sql );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			//echo "<form method=POST action='CRQ_Auth.php'>";
			echo "<div style='CSSTableGenerator'>";
			echo	"<table class='CSSTableGenerator'  width=90% >
					<tr>
						<td></td>
						<td>Requesting Team</td>
						<td>Implementing Team</td>
						<td>Description</td>
						<td>Change Type</td>
						<td>Scheduled Date</td>
						<td>Status</td>
						<td>CAB</td>
						<td>CM Comment</td>
					</tr>";
			$index = 1;
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
				$Authorized = (intval($row['Authorized']) == 1)? 1:0;
				$CM_Comment = $row['CM_Comment'];
				preg_match('/(?P<x>\d+)-(?P<impact_level>\w+)\/(?P<y>\w+)/', $row['Impact'],$Impact_Exp);
				$Impact = $Impact_Exp['impact_level'];
				$is_Auth=($Authorized == 1)? 'checked':'';
				if($row['External_Customer']!="") $Impact_Service=$row['External_Customer'].": ".$row['Service_Impact'];
				if($row['Internal_Customer']!="") $Impact_Business=$row['Internal_Customer'].": ".$row['Business_Impact'];
				if($row['Nodes_Systems']!="") $Impact_Technical=$row['Nodes_Systems'].": ".$row['Technical_Impact'];
				if($row['Reporting']!="") $Impact_DWH=$row['Reporting'].": ".$row['DWH_Impact'];
				#echo "whyyyyy: ".$row['External_Impact'];

				echo "<tr><td>".$index."</td>
					<td width=120px>".$SupportGroup."<BR>[".$Submitter."]</td>";
				echo ($Assignee_Company == null)?"<td></td>":"<td>".$Assignee_Group."</td>";
				echo "<td class=Major><U>CRQ: ".substr($CRQ, -6)."</U><BR>".$Description."<B>";
				
				if($Impact_Service!="") echo "<BR>Service Impact: ".$Impact_Service;
				if($Impact_Business!="") echo "<BR>Business Impact: ".$Impact_Business;
				if($Impact_Technical!="") echo "<BR>Technical Impact: ".$Impact_Technical;
				if($Impact_DWH!="") echo "<BR>DWH Impact: ".$Impact_DWH;
				
				echo "</B></td>";
					//<td class=".$Impact.">".$Impact."</td>
					//<td>". ( ($Status==="Scheduled")? '--':$PendingAt ) . "</td>
				echo "<td width=190px class='".$ChangeFor."'>".$ChangeFor.": ".$ProductTier1." > ".$ProductTier2." > ".$ProductTier3."</td>";
				echo "<td width=150px>".$ScheduledStartDate."<br> to <br>".$ScheduledEndDate."</td>";
				echo "<td>".$Status .( ($Status==="Scheduled")? '':"<BR>(".$PendingAt.")" )."</td>";
				?>
					<td><input type='checkbox'  <?php echo $is_Auth; ?>  onclick="chkit('<?php echo $CRQ; ?>', this.checked);" /></td>
				<?php
				echo "<td><textarea name='new_comment_".$CRQ."' rows=4 cols=20 onblur=upperCase('".$CRQ."')>".$CM_Comment."</textarea> </td>";
					
					//echo "nmnm: ".$new_comment;
				echo "</tr>";
				
				$Impact_Service="";
				$Impact_Business="";
				$Impact_Technical="";
				$Impact_DWH="";
				$index++;
			}

			echo "</table>";
			echo "</div>";
			//echo "</form>";
			
			sqlsrv_free_stmt( $stmt);
	
			// Close the connection.
			sqlsrv_close( $conn );

?>
<script type="text/javascript"> 
function chkit(CRQnum, Authorized) { 
   
   var Authorize=(Authorized==true)?1:0; 
   var comment=document.getElementsByName("new_comment_"+CRQnum)[0].value;
   //alert(comment);
   var new_comment=comment.replace(/ /g,"-");
   var url = "CRQ_Auth_update.php?updateCRQ="+CRQnum+"&updateAuth="+Authorize+"&new_comment="+new_comment+"&t="+Math.random();
   if(window.XMLHttpRequest) { 
	  //alert('1');
	  req = new XMLHttpRequest(); 
   } else if(window.ActiveXObject) { 
      //alert('2');
	  req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
   // Use get instead of post. 
   //alert(url);
   req.open("GET", url, false); 
   req.send(); 
}
function upperCase(CRQnum){
	var comment=document.getElementsByName("new_comment_"+CRQnum)[0].value;
	//alert(comment);
   var new_comment=comment.replace(/ /g,"-");
   var url = "CRQ_Auth_update_comment.php?updateCRQ="+CRQnum+"&new_comment="+new_comment+"&t="+Math.random();
   if(window.XMLHttpRequest) { 
	  //alert('1');
	  req = new XMLHttpRequest(); 
   } else if(window.ActiveXObject) { 
	  //alert('2');
	  req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
   // Use get instead of post. 
   //alert(url);
   req.open("GET", url, false); 
   req.send(); 
}

</script>
<?php include ("footer_new.php"); ?>