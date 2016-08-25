<?php session_start();  $pagePrivValue=30; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<div class="body_text" style="color:darkred;"><b>Network Engineering Teams KPIs</b></div><BR>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>  
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>  
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
<script type="text/javascript">
function hide()
{
    //NW.style.visibility="hidden"; 
	document.getElementById("NW").style.display = "block";
	document.getElementById("IT").style.display = "block";
}
function show()
{
    //NW.style.visibility="visible"; 
	document.getElementById("NW").style.display = "none";
	document.getElementById("IT").style.display = "none";
}
</script>
<script type="text/javascript">
var shown=0;
function hide1()
{
    //NW.style.visibility="hidden"; 
	shown=0;
	//document.getElementById("NW").style.display = "block";
	NW.style.display="block";
}
function show1()
{
    //NW.style.visibility="visible"; 
	if(shown=1)
		hide1();
	else{
		shown=1;
		//document.getElementById("NW").style.display = "none";
		NW.style.display="none";
		}
}
//hide();
</script>
<?php
	$startDate = date('m/d/Y', time() + (60 * 60 * 24 * -90)); //'4/1/2012';
	$endDate = date('m/d/Y', time() + (60 * 60 * 24 * -0));

	if(isset($_POST['from'])) $getFrom = $_POST['from']; else $getFrom = $startDate;
	if(isset($_POST['to'])) $getTo = $_POST['to']; else $getTo = $endDate;
	
	$monthCount = (int)abs((strtotime($getFrom) - strtotime($getTo))/(60*60*24*90)); 
	//echo $getFrom." ".$getTo." mC= ".$monthCount;
?>
<div class="body_text"></div>
<form method=post action='Reporter_TeamKPIs_NE.php'>
	<!--Report of Changes Requests in date interval--><BR>
	<label for="from">From </label><input type="text" id="from" name="from"  value="<?php echo $getFrom;?>" />
	<label for="to">to </label><input type="text" id="to" name="to"  value="<?php echo $getTo;?>" /> 
	<BR><label>Team: &nbsp; </label>
	<select name=team>
		<option value=''>Select Your Team</option>
		<option <?php if($_POST['team']=='Voice Net. Planning & Demand') echo 'selected';?> value='Voice Net. Planning & Demand'>Voice Net. Planning & Demand</option>
		<option <?php if($_POST['team']=='Packet Networks & IMS') echo 'selected';?> value='Packet Networks & IMS'>Packet Networks & IMS</option>
		<option <?php if($_POST['team']=='IP Network Engineering') echo 'selected';?> value='IP Network Engineering'>IP Network Engineering</option>
		<option <?php if($_POST['team']=='Transmission Networks Engineering') echo 'selected';?> value='Transmission Networks Engineering'>Transmission Networks Engineering</option>
	</select>

	<input type=submit name='submit' value='Search'/>
</form>
<?php 
if (isset($_POST['team'])) {
	$team =  $_POST['team'];
	//echo $team;
	}
?>
	<table>	
		<tr colspan=3>
			<td valign=top colspan=3><iframe src="Report_Team_KPI_NE.php?team=<?php echo str_replace(" ","__",$team);?>&from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" frameborder=0 width="1200px" height="<?php echo 400+(30*($monthCount+4)); ?>px"></iframe></td>
		</tr>
		<tr>
			<td valign=top><iframe src="Report_KPIExceptionsTier_NE.php?team=<?php echo str_replace(" ","__",$team);?>&from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" scrolling=no frameborder=0 width="550px" height="400px"></iframe></td>
			<td valign=top><iframe src="Report_KPIFixTier_NE.php?team=<?php echo str_replace(" ","__",$team);?>&from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" scrolling=no frameborder=0 width="450px" height="400px"></iframe></td>
			<td valign=top><iframe src="Report_KPIIDCType_dept.php?dept=NE&team=<?php echo str_replace(" ","__",$team);?>&from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" scrolling=no frameborder=0 width="450px" height="400px"></iframe></td>
		</tr>
	</table>
<?php include ("footer_new.php"); ?>