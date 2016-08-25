<?php session_start();  $pagePrivValue=50; require 'approve.php'; ?>
<?php  include ("newtemplate.php"); ?>
<div class="body_text"><b>Monthly Trend of Authorized Changes Requested & Implemented</b></div>
<table>
	<tr>
		<td width="700px" height="850px">
			<iframe  width="700px" height="900px" seamless src="Report_NormalPerDept2.php" frameborder="0" ></iframe>
		</td>
		<td><iframe width="700px" height="900px"  seamless src="Report_StandardPerDept.php" frameborder="0"></iframe>
		</td>
	</tr>
	<tr>
		<td><iframe id="content" width="700px" height="900px" seamless src="Report_NormalPerImpTeam2.php" frameborder="0"></iframe>
		</td>
		<td><iframe id="content" width="700px" height="900px" seamless src="Report_StandardPerImpTeam2.php" frameborder="0"></iframe>
		</td>

	</tr>
</table>
<?php include ("footer_new.php"); ?>