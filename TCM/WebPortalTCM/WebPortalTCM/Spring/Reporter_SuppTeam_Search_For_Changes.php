<?php include ("newtemplate.php"); ?>
<div class="body_text" style="color:darkred;"><b>Support Team Search For Changes</b></div><BR>
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
<div class="body_text" style="color:darkred;"><b>Support Team Changes</b></div><BR>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>  
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script> 
<?php
	$startDate = date('m/d/Y', time() + (60 * 60 * 24 * -0)); //'4/1/2012';
	$endDate = date('m/d/Y', time() + (60 * 60 * 24 * -0));

	if(isset($_POST['from'])) $getFrom = $_POST['from']; else $getFrom = $startDate;
	if(isset($_POST['to'])) $getTo = $_POST['to']; else $getTo = $endDate;
	
	$monthCount = (int)abs((strtotime($getFrom) - strtotime($getTo))/(60*60*24*90)); 
	//echo $getFrom." ".$getTo." mC= ".$monthCount;
?>   
<div class="body_text"></div>
<form method=post action='Reporter_SuppTeam_Search_For_Changes.php'>
	<!--Report of Changes Requests in date interval--><BR> 
	<label for="from">From </label><input type="text" id="from" name="from"  value="<?php echo $getFrom;?>" />
	<label for="to">to </label><input type="text" id="to" name="to"  value="<?php echo $getTo;?>" />
	<BR><label>Team: &nbsp; </label>
	<select name=team>
		<option value=''>Select Your Team</option>
		<option <?php if($_POST['team']=='Solution Support') echo 'selected';?> value='Solution Support'>Solution Support</option>
		<option <?php if($_POST['team']=='VAS Support') echo 'selected';?> value='VAS Support'>VAS Support</option>
		<option <?php if($_POST['team']=='Messaging Support') echo 'selected';?> value='Messaging Support'>Messaging Support</option>
		<option <?php if($_POST['team']=='Payments & Money Transfer Support') echo 'selected';?> value='Payments & Money Transfer Support'>Payments & Money Transfer Support</option>
		<option <?php if($_POST['team']=='Charging Support') echo 'selected';?> value='Charging Support'>Charging Support</option>
		<option <?php if($_POST['team']=='Mediation Support') echo 'selected';?> value='Mediation Support'>Mediation Support</option>
		<option <?php if($_POST['team']=='Datacom/IP switch SM') echo 'selected';?> value='Datacom/IP switch SM'>Datacom/IP switch SM</option>
		<option <?php if($_POST['team']=='Mobile Internet & Data Support') echo 'selected';?> value='Mobile Internet & Data Support'>Mobile Internet & Data Support</option>
		<option <?php if($_POST['team']=='Voice Core Support') echo 'selected';?> value='Voice Core Support'>Voice Core Support</option>
		<option <?php if($_POST['team']=='Voice Access Support') echo 'selected';?> value='Voice Access Support'>Voice Access Support</option>
		<option <?php if($_POST['team']=='Voice Huawei Support') echo 'selected';?> value='Voice Huawei Support'>Voice Huawei Support</option>
		<option <?php if($_POST['team']=='Voice CSDB Support') echo 'selected';?> value='Voice CSDB Support'>Voice CSDB Support</option>
		<option <?php if($_POST['team']=='Backbone & Tx services SM- NW Support') echo 'selected';?> value='Backbone'>Backbone & Tx services SM- NW Support</option>
		<option <?php if($_POST['team']=='Access & Backhaul SM Support') echo 'selected';?> value='Backhaul'>Access & Backhaul SM Support</option>
		<option <?php if($_POST['team']=='Tx & Access NW Cutover changes') echo 'selected';?> value='Cutover'>Tx & Access NW Cutover changes</option>
		<option <?php if($_POST['team']=='TX & Access NW- BSC/RNC cutover') echo 'selected';?> value='NW- BSC/RNC'>TX & Access NW- BSC/RNC cutover</option>
		<option <?php if($_POST['team']=='TX & Access NW- Transmission change') echo 'selected';?> value='Transmission'>TX & Access NW- Transmission change</option>
		<option <?php if($_POST['team']=='NSM') echo 'selected';?> value='NSM'>NSM</option>
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
			<td valign=top colspan=3><iframe src="Report_SuppTeam_Search_Changes.php?team=<?php echo str_replace(" ","__",$team);?>&from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" frameborder=0 width="3000px" height="<?php echo 400+(30*($monthCount+4)); ?>px"></iframe></td>
		</tr>
</table>
<?php include ("footer_new.php"); ?>