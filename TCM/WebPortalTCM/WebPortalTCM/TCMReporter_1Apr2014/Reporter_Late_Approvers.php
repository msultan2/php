<?php session_start();  $pagePrivValue=50; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<table><tr><td width="90%"><div class="body_text"><b>Number of Normal Changes per Late Approver</b></div></td>
<td align=right >
<?php 
		$sql = "SELECT CASE ch.[First Approver] WHEN 'AR_ESCALATOR' THEN ch.[First On Behalf of] ELSE ch.[First Approver] END Approver,ap.Approver_Name,Support_Company,Support_Organization,Support_Group_Name,count(*) CRQnum FROM dbo.vw_Change_Approval_Details ch LEFT OUTER JOIN dbo.tbl_Change_LK_Approvers ap ON (CASE ch.[First Approver] WHEN 'AR_ESCALATOR' THEN ch.[First On Behalf of] ELSE ch.[First Approver] END) = ap.Approver_Alias WHERE CRQ_Type = 'Normal' AND DATEADD(day, -DATEDIFF(day, 0, ch.[First Approval Date]), ch.[First Approval Date]) > '2:00:00 PM' AND dbo.DATEONLY( ch.[First Approval Date]) >= (dbo.DATEONLY( ch.Scheduled_Start_Date) -1) AND [First On Behalf of] NOT IN ('Hraslan','CM_Eval') GROUP BY  CASE ch.[First Approver] WHEN 'AR_ESCALATOR' THEN ch.[First On Behalf of] ELSE ch.[First Approver] END , ap.Approver_Name,Support_Company,Support_Organization,Support_Group_Name ORDER BY  CRQnum DESC;";
		//echo $sql;
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		echo '<a href="excel.php?name=LateApprover&query='.$sql_encoded.'">';
		//echo $sql_encoded;
	?>
<img width=24px height=24px src="images/excel.bmp" style="border-style: none"/></a>
</td></tr></table>
	<table>
		<tr>
			<td><iframe src="Reporter_Late_Approver.php" frameborder=0 width="800px" height="800px"></iframe></td>
			<td><iframe src="Reporter_Late_SupportApprover.php" frameborder=0 width="450px" height="800px"></iframe></td>
			<td valign=top align=left><iframe src="Report_Late_Approvers_Pie2.php" frameborder=0 width="600px" height="800px"></iframe></td>
		</tr>
</table>
<table width="20%"><tr><td><div class="body_text"><b>Trend of Approval Time of Normal Changes</b></div></td>
<td align=right >
<?php 
		$sql = "SELECT appMonth, appYear,[Before 2:00 PM],[2:00 - 3:00],[3:00 - 4:00],[4:00 - 5:00],[After 5:00 PM] FROM ( SELECT datepart(MONTH,ch.[First Approval Date]) appMonth,datepart(YEAR,ch.[First Approval Date]) appYear,CASE WHEN datepart(HOUR,ch.[First Approval Date]) < 14 THEN 'Before 2:00 PM' WHEN datepart(HOUR,ch.[First Approval Date]) = 14 THEN '2:00 - 3:00' WHEN datepart(HOUR,ch.[First Approval Date]) = 15 THEN '3:00 - 4:00' WHEN datepart(HOUR,ch.[First Approval Date]) = 16 THEN '4:00 - 5:00' WHEN datepart(HOUR,ch.[First Approval Date]) >= 17 THEN 'After 5:00 PM' END hourInterval, count(*) CRQnum FROM dbo.vw_Change_Approval_Details ch WHERE CRQ_Type = 'Normal' AND [First Approval Date] IS NOT NULL AND ch.Status <> 'Request For Authorization' GROUP BY datepart(MONTH,ch.[First Approval Date]),datepart(YEAR,ch.[First Approval Date]), CASE WHEN datepart(HOUR,ch.[First Approval Date]) < 14 THEN 'Before 2:00 PM' WHEN datepart(HOUR,ch.[First Approval Date]) = 14 THEN '2:00 - 3:00' WHEN datepart(HOUR,ch.[First Approval Date]) = 15 THEN '3:00 - 4:00' WHEN datepart(HOUR,ch.[First Approval Date]) = 16 THEN '4:00 - 5:00' WHEN datepart(HOUR,ch.[First Approval Date]) >= 17 THEN 'After 5:00 PM' END ) queryA PIVOT ( max(CRQnum) for hourInterval in ([Before 2:00 PM],[2:00 - 3:00],[3:00 - 4:00],[4:00 - 5:00],[After 5:00 PM]) ) queryP;";
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		echo '<a href="excel.php?name=LateApprovalsTrend&query='.$sql_encoded.'">';
	?>
<img width=24px height=24px src="images/excel.bmp" style="border-style: none"/></a>
</td></tr></table>
<table>
		<tr>
			<td><iframe src="Report_Late_Approvers_Trend.php" frameborder=0 width="800px" height="900px"></iframe></td>
			<td><iframe src="Report_Late_Approvers_TrendDaily.php" frameborder=0 width="800px" height="900px"></iframe></td>
		</tr>
	</table>
<?php include ("footer_new.php"); ?>