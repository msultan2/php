<?php session_start();  $pagePrivValue=50; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<table><tr><td width="90%"><div class="body_text">Total number of Changes per requesting department per status since 12 Aug 2012 </div></td>
<td align=right >
<?php 
		$sql = "SELECT  cap.Support_Company, cap.Status, count(*) Number_of_CRQs FROM  dbo.vw_Change_Approval_Details cap WHERE cap.CRQ_Type = 'Normal' GROUP BY cap.Support_Company,cap.Status ORDER BY cap.Support_Company,cap.Status;";
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		echo '<a href="excel.php?name=Status&query='.$sql_encoded.'">';
	?>
<img width=24px height=24px src="images/excel.bmp" style="border-style: none"/></a>
</td></tr></table>
	<table>
		<tr>
			<td><iframe src="Report_Status.php" frameborder=0 width="700px" height="700px"></iframe></td>
			<td>
				<table><tr>
						<td><iframe src="Report_ChangeForDept.php" frameborder=0 width="550px" height="370px" scrolling=no></iframe></td>
						</tr>
						<tr>
						<td><iframe src="Report_StatusPie.php" frameborder=0 width="550px" height="370px" scrolling=no></iframe></td>
						</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td><iframe src="Report_StatusAuth_NW.php" frameborder=0 width="700px" height="900px"></iframe></td>
			<td><iframe src="Report_StatusAuth_IT.php" frameborder=0 width="650px" height="900px"></iframe></td>
		</tr>
		<tr>
			<td colspan=2><iframe src="Report_StatusLine.php" frameborder=0 width="650px" height="1100px"></iframe></td>
		</tr>
	</table>
<?php include ("footer_new.php"); ?>