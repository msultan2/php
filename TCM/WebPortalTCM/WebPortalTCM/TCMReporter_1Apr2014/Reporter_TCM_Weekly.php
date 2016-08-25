<?php session_start();  $pagePrivValue=50; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<div class="body_text" style="color:darkred;"><b>Service Management Weekly Note</b></div><BR>
<div class="body_text"><b>Technology Change Management</b></div>
	<table>
		<tr>
			<td><iframe src="Report_Hany_ChangeFor.php" frameborder=0 width="450px" height="350px"></iframe></td>
			<td valign=top><iframe src="Report_Hany_Status.php" frameborder=0 width="550px" height="350px"></iframe></td>
		</tr>	
		<tr>
			<td colspan=2><iframe src="Report_Hany_CRQsTotal.php" frameborder=0 width="1000px" height="100px"></iframe></td>
		</tr>
	</table>
<?php include ("footer_new.php"); ?>