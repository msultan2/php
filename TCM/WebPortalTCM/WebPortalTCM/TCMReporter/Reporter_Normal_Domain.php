<?php session_start();  $pagePrivValue=50; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<div class="body_text"><B>Statistics of Changes Per Domain Since 12 Aug 2012</B></div>
	<table valign=top align=left>
		<tr>
			<td valign=top align=left><iframe src="Report_Normal_Domain.php" frameborder=0 scrolling=no width="950px" height="800px"></iframe></td>
			<td valign=top align=left><iframe src="Report_NormalPie_Domain.php" frameborder=0 scrolling=no width="550px" height="700px"></iframe></td>
		</td>		
		</tr>		
				<tr>
			<td valign=top align=left><iframe src="Report_All_Domain.php" frameborder=0 scrolling=no width="950px" height="800px"></iframe></td>
			<td valign=top align=left><iframe src="Report_AllPie_Domain.php" frameborder=0 scrolling=no width="550px" height="700px"></iframe></td>
		</td>		
		</tr>
	</table>
<?php include ("footer_new.php"); ?>