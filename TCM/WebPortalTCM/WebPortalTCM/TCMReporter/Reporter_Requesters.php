<?php session_start();  $pagePrivValue=50; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<div class="body_text"><b>Number of Normal Changes Requested since 12 Aug 2012</b></div>
	<table>
		<tr>
			<td><iframe src="Report_Requesters.php" frameborder=0 width="750px" height="1200px"></iframe></td>
			<td valign=top><iframe src="Report_RequesterTeam.php" frameborder=0 width="650px" height="800px"></iframe></td>
		</tr>	
	</table>
<?php include ("footer_new.php"); ?>