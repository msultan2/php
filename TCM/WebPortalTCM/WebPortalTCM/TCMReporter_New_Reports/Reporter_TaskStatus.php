<?php session_start();  $pagePrivValue=50; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<div class="body_text">Statistics of Service Management Tasks on New Web Remedy (Starting Feb 2014)</div>
	<table>
		<tr>
			<td><iframe src="Report_TaskStatus.php" frameborder=0 scrolling=no width="700px" height="800px"></iframe></td>
			<td><iframe src="Report_TaskStatus_Standard.php" frameborder=0 scrolling=no width="700px" height="800px"></iframe></td>
		</tr>
	</table>
<?php include ("footer_new.php"); ?>