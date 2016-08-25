<?php session_start();  $pagePrivValue=20; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<div class="body_text" style="color:darkred;"><b>Service Management Weekly Report</b></div><BR>
<div class="body_text"><b>Technology Change Management</b></div>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>  
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>  
<link rel="stylesheet" href="/resources/demos/style.css" />  
<script>  
$(function() {    
	$( "#from" ).datepicker({      defaultDate: "+0w",      changeMonth: true,      numberOfMonths: 1,      
			onClose: function( selectedDate ) {        
				$( "#to" ).datepicker( "option", "minDate", selectedDate );    
				}    ,
			showOn: "button",      buttonImage: "images/calendar.png",      buttonImageOnly: true 
	});    
	
	$( "#to" ).datepicker({      defaultDate: "+1d",      changeMonth: true,      numberOfMonths: 1,      
			onClose: function( selectedDate ) {        
				$( "#from" ).datepicker( "option", "maxDate", selectedDate );      
				}    ,
			showOn: "button",      buttonImage: "images/calendar.png",      buttonImageOnly: true 
	});  
	
});  
</script>
<?php
	$weekback = date('m/d/Y', time() + (60 * 60 * 24 * -7));
	$yesterday = date('m/d/Y', time() + (60 * 60 * 24 * -1));
	//echo $weekback." ".$yesterday;

	if(isset($_POST['from'])) $getFrom = $_POST['from']; else $getFrom = $weekback;
	if(isset($_POST['to'])) $getTo = $_POST['to']; else $getTo = $yesterday;
?>
<div class="body_text"></div>
<form method=post action='Reporter_TCM_Weekly2.php'>
	Report of Changes Requests in date interval
	<label for="from">From </label><input type="text" id="from" name="from"  value="<?php echo $getFrom;?>" />
	<label for="to">to </label><input type="text" id="to" name="to"  value="<?php echo $getTo;?>" />  
	<input type=submit name='submit' value='Search'/>
</form>
	<table>	
		<tr>
			<td valign=top colspan=2><iframe src="Report_SMweekly_ChangeFor.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" frameborder=0 width="550px" height="550px"></iframe></td>
			<td rowspan=2 align=left valign=top><iframe src="Report_SMweekly_Teams3.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" frameborder=0 width="700px" height="850px"></iframe></td>
		</tr>
		<tr>
			<td><iframe src="Report_noCM.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" scrolling=no frameborder=0 width="250px" height="300px"></iframe></td>
			<td><iframe src="Report_noCM_Teams.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" scrolling=no frameborder=0 width="250px" height="300px"></iframe></td>
		</tr>
		<tr>
			<!--td colspan=2><iframe src="Report_Hany_CRQsTotal.php" frameborder=0 width="1000px" height="100px"></iframe></td-->
		</tr>
		<tr>
			<td colspan=3><iframe src="Report_IDC_Weekly.php" frameborder=0 width="750px" height="600px"></iframe></td>
		</tr>
		<tr>
			<td colspan=3><table><tr>
			<td><iframe src="Report_IDC_Team2.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" scrolling=no frameborder=0 width="450px" height="450px"></iframe></td>
			<td><iframe src="Report_ExceptionsTeam.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" frameborder=0 width="450px" height="450px"></iframe></td>
			<td><iframe src="Report_HW_Team.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" scrolling=no frameborder=0 width="450px" height="450px"></iframe></td>
			</tr></table></td>
		</tr>
	</table>
<?php include ("footer_new.php"); ?>