<?php session_start();  $pagePrivValue=50; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<div class="body_text"><b>Number of Normal Changes Requested since 12 Aug 2012</b></div>
	<table>
		<tr>
			<td><iframe src="Report_MissingField.php" frameborder=0 width="1000px" height="900px"></iframe></td>
		</tr>
		<tr>
			<td valign=top><iframe src="Report_EmergencyField.php" frameborder=0 width="1000px" height="1300px"></iframe></td>
		</tr>	
	</table>
<?php include ("footer_new.php"); ?>