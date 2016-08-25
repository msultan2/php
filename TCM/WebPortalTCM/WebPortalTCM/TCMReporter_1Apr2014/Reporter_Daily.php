<?php session_start();  $pagePrivValue=50; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<div class="body_text">Statistics of Total Change Requests Since 12 Aug 2012</div>
	<table>
		<tr>
			<td colspan=2 valign=top><iframe src="Report_Normal_Daily.php" frameborder=0 scrolling=no width="1250px" height="1200px"></iframe></td>
		</tr>
		<tr>
			<td><iframe src="Report_WeekDays.php" frameborder=0 scrolling=no width="500px" height="800px"></iframe></td>
			<td><iframe src="Report_WeekDays_IT.php" frameborder=0 scrolling=no width="500px" height="800px"></iframe></td>
		</tr>

		<!--td valign=top><iframe src="Report_Hours_Radar.php" scrolling=no frameborder=0 width="350px" height="400px"></iframe></td-->
	
	</table>
<?php include ("footer_new.php"); ?>