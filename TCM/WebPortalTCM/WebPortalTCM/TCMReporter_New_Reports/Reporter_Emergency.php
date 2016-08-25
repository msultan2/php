<?php session_start();  $pagePrivValue=50; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<table><tr><td width="90%"><div class="body_text"><b>Number of Emergency Changes</b></div></td>
<td align=right >
<?php 
		$sql = "SELECT Support_Company,Support_Organization,Support_Group_Name,count(*) CRQnum FROM dbo.vw_Change_Approval_Details cap WHERE CRQ_Type = 'Normal' AND STATUS NOT IN ('Draft','Request For Authorization') AND ( (DATEADD(day, -DATEDIFF(day, 0, [First Approval Date]), [First Approval Date]) > '2:00:00 PM' AND dbo.DATEONLY( [First Approval Date]) >= (dbo.DATEONLY( Scheduled_Start_Date) -1) ) OR Emergency = 0) GROUP BY Support_Company,Support_Organization,Support_Group_Name ORDER BY CRQnum DESC;";
		//echo $sql;
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		echo '<a href="excel.php?name=Emergency&query='.$sql_encoded.'">';
		//echo $sql_encoded;
	?>
<img width=24px height=24px src="images/excel.bmp" style="border-style: none"/></a>
</td></tr></table>
	<table>
		<tr>
			<td><iframe src="Report_EmergencyLineAll.php" frameborder=0 width="650px" height="900px"></iframe></td>
			<td><iframe src="Report_Emergency.php" frameborder=0 width="650px" height="900px"></iframe></td>
		</tr>
		<tr>
			<td colspan=2><iframe src="Report_EmergencyLine.php" frameborder=0 width="1050px" height="900px"></iframe></td>
		</tr>	
	</table>
<?php include ("footer_new.php"); ?>