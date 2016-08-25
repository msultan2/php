<?php include ("newtemplate.php"); ?>
<div class="body_text">Statistics of Total Change Requests Since 12 Aug 2012</div>
	<table>
		<tr>
			<td><iframe src="Report_WeekDays.php" frameborder=0 width="350px" height="400px"></iframe></td>
			<td><iframe src="Report_WeekDays_IT.php" frameborder=0 width="350px" height="400px"></iframe></td>
			<td><iframe src="Report_Hours_Radar.php" scrolling=no frameborder=0 width="350px" height="400px"></iframe></td>
		</tr>
		<tr>
			<td><iframe src="Report_ChangeTypes.php" frameborder=0 width="350px" height="400px"></iframe></td>
			<td><iframe src="Report_ChangeFor.php" frameborder=0 width="350px" height="400px"></iframe></td>
			<td><iframe src="Report_Status_Reason.php" frameborder=0 width="350px" height="400px"></iframe></td>
		</tr>
		<tr>
			<td><iframe src="Report_Urgency2.php" frameborder=0 width="350px" height="400px"></iframe></td>
			<td><iframe src="Report_Impact2.php" frameborder=0 width="350px" height="400px"></iframe></td>
			<td><iframe src="Report_Impact_Details2.php" frameborder=0 width="350px" height="400px"></iframe></td>
		</tr>		
	</table>
<?php include ("footer_new.php"); ?>