<?php session_start();  $pagePrivValue=100; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<div class="body_text">Status of Today's CAB Changes</div>
	<table>
		<tr>
			<td colspan=3><iframe src="Report_CM_Eval_Gauge.php" frameborder=0 width="1050px" height="250px"></iframe></td>
		</tr>
		<tr>
			<td><iframe src="Report_PendingAt.php" frameborder=0 width="350px" height="400px"></iframe></td>
			<td><iframe src="Report_CAB_ChangeTypes.php" frameborder=0 width="350px" height="400px"></iframe></td>
			<td><iframe src="Report_CAB_ChangeFor.php" frameborder=0 width="350px" height="400px"></iframe></td>
		</tr>
	</table>
	<table width=100%><tr><td width=30%>
	<table><tr>
			<td align=left ><a href="CAB_Remedy_Report.php"><div class="body_text"><b>Remedy Query (All)</b></div></a>
			</td></tr>
			<tr>
			<td align=left ><a href="CAB_Remedy_Report_Auth.php"><div class="body_text"><b>Remedy Query (Authorized)</b></div></a>
			</td></tr>
	</table>
	</td><td>
	<table><tr>
			<tr>
			<td align=left ><a href="CAB_Remedy_Report_NW.php"><div class="body_text"><b>Remedy Query (NW)</b></div></a>
			</td></tr>
			<tr>
			<td align=left ><a href="CAB_Remedy_Report_IT.php"><div class="body_text"><b>Remedy Query (IT)</b></div></a>
			</td></tr>
	</table>
	</td><td>
	<table><tr>
			<tr>
			<td align=left ><a href="CAB_Remedy_Report_Impacting_NW.php"><div class="body_text"><b>Impacting (NW)</b></div></a>
			</td></tr>
			<tr>
			<td align=left ><a href="CAB_Remedy_Report_Impacting_IT.php"><div class="body_text"><b>Impacting (IT)</b></div></a>
			</td></tr>
	</table>
	</td></tr></table>
<?php include ("footer_new.php"); ?>