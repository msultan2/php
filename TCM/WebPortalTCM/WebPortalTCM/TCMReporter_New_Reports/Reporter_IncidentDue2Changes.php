<?php session_start();  $pagePrivValue=50; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<div class="body_text"><B>Statistics of Incidents due to Changes (IDCs) Since 1 Nov 2012</B></div>
	<table valign=top align=left>
		<tr>
			<td id=myLeft width="70%">
			<table>
				<tr><td valign=top align=left><iframe src="Report_Incidents_Monthly.php" frameborder=0 scrolling=no width="950px" height="1300px"></iframe></td></tr>
				<tr><td valign=top align=left><iframe src="Report_IDC_Category_Line.php" frameborder=0 scrolling=no width="950px" height="800px"></iframe></td></tr>
			</table>
			</td>
		<td id=myRight width="30%" valign=top align=left>
			<table>
				<tr><td valign=top align=left><iframe src="Report_IDC_Category.php" frameborder=0 scrolling=no width="350px" height="380px"></iframe></td></tr>
				<tr><td valign=top align=left><iframe src="Report_IDC_Team.php" frameborder=0 scrolling=no width="350px" height="380px"></iframe></td></tr>
				<tr><td valign=top align=left><iframe src="Report_IDC_Priority.php" frameborder=0 scrolling=no width="350px" height="380px"></iframe></td></tr>
				<tr><td valign=top align=left><iframe src="Report_IDC_Severity.php" frameborder=0 scrolling=no width="350px" height="380px"></iframe></td></tr>
				<tr><td valign=top align=left><iframe src="Report_IDC_Type.php" frameborder=0 scrolling=no width="350px" height="380px"></iframe></td></tr>	
			</table>
		</td>		
		</tr>		
	</table>
<?php include ("footer_new.php"); ?>