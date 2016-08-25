<?php session_start();  $pagePrivValue=10; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<div class="body_text">Statistics of Total Change Requests Since 12 Aug 2012</div>
	<table>
		<tr>
			<td><iframe src="Report_ChangeTypes.php" frameborder=0 width="350px" height="400px"></iframe></td>
			<td><iframe src="Report_ChangeFor.php" frameborder=0 width="350px" height="400px"></iframe></td>
			<td><iframe src="Report_ChangeForDept.php" frameborder=0 width="450px" height="400px"></iframe></td>
		</tr>
		<tr>
			<td><iframe src="Report_ChangeForImpl.php" frameborder=0 scrolling=no width="350px" height="400px"></iframe></td>
			<td><iframe src="Report_IncidentPie.php" frameborder=0 scrolling=no width="350px" height="400px"></iframe></td>
			<td><iframe src="Report_EmergencyPie.php" frameborder=0 scrolling=no width="450px" height="400px"></iframe></td>
		</tr>
		<tr>
			<td><iframe src="Report_Risk2.php" frameborder=0 width="350px" height="400px"></iframe></td>
			<td><iframe src="Report_Urgency2.php" frameborder=0 width="350px" height="400px"></iframe></td>
			<td><iframe src="Report_ExecutionTime.php" frameborder=0 width="450px" height="400px"></iframe></td>
		</tr>
		<tr>
			<td><iframe src="Report_Impact2.php" frameborder=0 width="350px" height="400px"></iframe></td>
			<td><iframe src="Report_Impact_Details2.php" frameborder=0 width="350px" height="400px"></iframe></td>
			<td><iframe src="Report_Status_Reason.php" frameborder=0 width="450px" height="400px"></iframe></td>
		</tr>		
	</table>
<?php include ("footer_new.php"); ?>