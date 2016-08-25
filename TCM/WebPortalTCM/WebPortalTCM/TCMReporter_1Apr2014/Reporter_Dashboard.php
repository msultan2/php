<?php session_start();  $pagePrivValue=50; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<div class="body_text" style="color:darkred;"><b>Change Management Dashboard</b></div>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>  
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>  
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
	$startDate = date('m/d/Y', time() + (60 * 60 * 24 * -30));
	$endDate = date('m/d/Y', time() + (60 * 60 * 24 * -1));
	//echo $startDate." ".$endDate;

	if(isset($_POST['from'])) $getFrom = $_POST['from']; else $getFrom = $startDate;
	if(isset($_POST['to'])) $getTo = $_POST['to']; else $getTo = $endDate;
?>
<form method=post action='Reporter_DashBoard.php'>
	Report of Changes Requests in date interval &nbsp;<label for="from">from &nbsp;</label><input type="text" id="from" name="from"  value="<?php echo $getFrom;?>" />
	<label for="to">to &nbsp;</label><input type="text" id="to" name="to"  value="<?php echo $getTo;?>" />  
	<input type=submit name='submit' value='Search'/>
</form>
	<table>	
		<tr><td valign=top><iframe scrolling=no src="Report_ChangeFor_DashBoard.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" frameborder=0 width="400px" height="350px"></iframe></td>
			<td align=left valign=top><iframe scrolling=no src="Report_Auth_NW_DashBoard.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" frameborder=0 width="400px" height="350px"></iframe></td>
			<td align=left valign=top><iframe scrolling=no src="Report_Auth_IT_DashBoard.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" frameborder=0 width="400px" height="350px"></iframe></td>
		</tr>
		<tr>
			<td colspan=2 align=left valign=top><iframe scrolling=no src="Report_Weekly_DashBoard.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" frameborder=0 width="820px" height="350px"></iframe></td>
			<td align=left valign=top><iframe scrolling=no src="Report_DeptPie_Dashboard.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" frameborder=0 width="400px" height="350px"></iframe></td>
		</tr>
		<tr>
			<td align=left valign=top><iframe scrolling=no src="Report_Emergency_NW_DashBoard2.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" frameborder=0 width="400px" height="350px"></iframe></td>
			<td align=left valign=top><iframe scrolling=no src="Report_Emergency_IT_DashBoard2.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" frameborder=0 width="400px" height="350px"></iframe></td>
			<td align=left valign=top><iframe scrolling=no src="Report_ChangeForPie_DashBoard.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" frameborder=0 width="400px" height="350px"></iframe></td>
		</tr>
		<tr>
			<td colspan=3><iframe scrolling=no src="Report_Totals_Dashboard.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" frameborder=0 width="1000px" height="70px"></iframe></td>
		</tr>
		<tr>
			<td colspan=3><iframe src="Report_MajorActivity_DashBoard.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" frameborder=0 width="1300px" height="2000px"></iframe></td>
		</tr>
	</table>
<?php include ("footer_new.php"); ?>