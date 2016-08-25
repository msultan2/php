<?php //session_start(); $pagePrivValue=30; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<div class="body_text" style="color:darkred;"><b>Support Team KPIs</b></div><BR>
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
<form method=post action='Reporter_SupportTeamKPIs.php'>
	<!--Report of Changes Requests in date interval--><BR>
	<label for="from">From </label><input type="text" id="from" name="from"  value="<?php echo $getFrom;?>" />
	<label for="to">to </label><input type="text" id="to" name="to"  value="<?php echo $getTo;?>" /> 
	<BR><label>Team: &nbsp; </label>
	<select name=team>
		<option value=''>Select Your Team</option>
		<option <?php if($_POST['team']=='VAS Support') echo 'selected';?> value='VAS Support'>VAS Support</option>
		<option <?php if($_POST['team']=='Messaging Support') echo 'selected';?> value='Messaging Support'>Messaging Support</option>
		<option <?php if($_POST['team']=='Charging Support') echo 'selected';?> value='Charging Support'>Charging Support</option>
		<option <?php if($_POST['team']=='Mediation Support') echo 'selected';?> value='Mediation Support'>Mediation Support</option>
		<option <?php if($_POST['team']=='Payments & Money Transfer Support') echo 'selected';?> value='Payments & Money Transfer Support'>Payments & Money Transfer Support</option>
		<option <?php if($_POST['team']=='Datacom/IP switch SM') echo 'selected';?> value='Datacom/IP switch SM'>Datacom/IP switch SM</option>
		<option <?php if($_POST['team']=='Mobile Internet & Data Support') echo 'selected';?> value='Mobile Internet & Data Support'>Mobile Internet & Data Support</option>
		<option <?php if($_POST['team']=='Voice Core Support') echo 'selected';?> value='Voice Core Support'>Voice Core Support</option>
		<option <?php if($_POST['team']=='Voice Access Support') echo 'selected';?> value='Voice Access Support'>Voice Access Support</option>
		<option <?php if($_POST['team']=='Voice Huawei Support') echo 'selected';?> value='Voice Huawei Support'>Voice Huawei Support</option>
		<option <?php if($_POST['team']=='Voice CSDB Support') echo 'selected';?> value='Voice CSDB Support'>Voice CSDB Support</option>
		<option <?php if($_POST['team']=='Backbone & Tx services SM- NW Support') echo 'selected';?> value='Backbone & Tx services SM- NW Support'>Backbone & Tx services SM- NW Support</option>
		<option <?php if($_POST['team']=='Access & Backhaul SM Support') echo 'selected';?> value='Access & Backhaul SM Support'>Access & Backhaul SM Support</option>
		<option <?php if($_POST['team']=='Tx & Access NW Cutover changes') echo 'selected';?> value='Tx & Access NW Cutover changes'>Tx & Access NW Cutover changes</option>
		<option <?php if($_POST['team']=='TX & Access NW- BSC/RNC cutover') echo 'selected';?> value='TX & Access NW- BSC/RNC cutover'>TX & Access NW- BSC/RNC cutover</option>
		<option <?php if($_POST['team']=='TX & Access NW- Transmission change') echo 'selected';?> value='TX & Access NW- Transmission change'>TX & Access NW- Transmission change</option>
		<option <?php if($_POST['team']=='NSM') echo 'selected';?> value='NSM'>NSM</option>
		<option <?php if($_POST['team']=='RF transmission changes support') echo 'selected';?> value='RF transmission changes support'>RF transmission changes support</option>
		<option <?php if($_POST['team']=='Fixed Network_Network Deployment') echo 'selected';?> value='Fixed Network_Network Deployment'>Fixed Network_Network Deployment</option>
		<option <?php if($_POST['team']=='Fixed Network_Field Network support') echo 'selected';?> value='Fixed Network_Field Network support'>Fixed Network_Field Network support</option>
		<option <?php if($_POST['team']=='Fixed Network_Customer Deployment') echo 'selected';?> value='Fixed Network_Customer Deployment'>Fixed Network_Customer Deployment</option>
		<option <?php if($_POST['team']=='Fixed Network_Infrastructure Deployment & support') echo 'selected';?> value='Fixed Network_Infrastructure Deployment & support'>Fixed Network_Infrastructure Deployment & support</option>
		<option <?php if($_POST['team']=='Fixed Network Config & Service Support') echo 'selected';?> value='Fixed Network Config & Service Support'>Fixed Network Config & Service Support</option>
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
			<td valign=top colspan=3><iframe src="Report_SuppTeam_KPI.php?team=<?php echo str_replace(" ","__",$team);?>&from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" frameborder=0 width="1200px" height="<?php echo 400+(30*($monthCount+4)); ?>px"></iframe></td>
		</tr>
		<tr>
			<td valign=top><iframe src="Report_SuppKPIExceptionsTier.php?team=<?php echo str_replace(" ","__",$team);?>&from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" scrolling=no frameborder=0 width="550px" height="400px"></iframe></td>
			<td valign=top><iframe src="Report_SuppKPIFixTier.php?team=<?php echo str_replace(" ","__",$team);?>&from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" scrolling=no frameborder=0 width="450px" height="400px"></iframe></td>
			<td valign=top><iframe src="Report_SuppKPIIDCType.php?team=<?php echo str_replace(" ","__",$team);?>&from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" scrolling=no frameborder=0 width="450px" height="400px"></iframe></td>
		</tr>
	</table>
<?php include ("footer_new.php"); ?>