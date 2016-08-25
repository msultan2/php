<?php //session_start(); $pagePrivValue=30; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<div class="body_text" style="color:darkred;"><b>Support Team Changes</b></div><BR>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>  
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>    
<div class="body_text"></div>
<form method=post action='Reporter_SuppTeam_Changes.php'>
	<!--Report of Changes Requests in date interval--><BR> 
	<BR><label>Team: &nbsp; </label>
	<select name=team>
		<option value=''>Select Your Team</option>
		<option <?php if($_POST['team']=='VAS Support') echo 'selected';?> value='VAS Support'>VAS Support</option>
		<option <?php if($_POST['team']=='Messaging Support') echo 'selected';?> value='Messaging Support'>Messaging Support</option>
		<option <?php if($_POST['team']=='Charging Support') echo 'selected';?> value='Charging Support'>Charging Support</option>
		<option <?php if($_POST['team']=='Mediation Support') echo 'selected';?> value='Mediation Support'>Mediation Support</option>
		<option <?php if($_POST['team']=='Solution Support') echo 'selected';?> value='Solution Support'>Solution Support</option>
		<option <?php if($_POST['team']=='Payments & Money Transfer Support') echo 'selected';?> value='Payments & Money Transfer Support'>Payments & Money Transfer Support</option>
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
			<td valign=top colspan=3><iframe src="Report_SuppTeam_Changes.php?team=<?php echo str_replace(" ","__",$team);?>" frameborder=0 width="1600px" height="2200px"></iframe></td>
		</tr>
</table>
<?php include ("footer_new.php"); ?>