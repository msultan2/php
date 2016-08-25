<?php session_start();  $pagePrivValue=50; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<table><tr><td width="95%"><div class="body_text">Number of Normal Changes requested per Change Tiers since 12 Aug 2012 </div></td>
<td align=right >
<?php 
		$sql = "SELECT MONTH(Scheduled_Start_Date) 'Month',YEAR(Scheduled_Start_Date) 'Year',CRQ_Type,Product_Categorization_Tier_1,Product_Categorization_Tier_2,Product_Categorization_Tier_3,cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name, count(*) Number_of_CRQs FROM  dbo.vw_Change_Approval_Details cap WHERE cap.Scheduled_Start_Date <= getdate() AND cap.CRQ_Type = 'Normal' GROUP BY MONTH(Scheduled_Start_Date),YEAR(Scheduled_Start_Date),CRQ_Type,Product_Categorization_Tier_1,Product_Categorization_Tier_2,Product_Categorization_Tier_3,cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name ORDER BY YEAR(Scheduled_Start_Date),MONTH(Scheduled_Start_Date) ASC,Number_of_CRQs DESC;";
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		echo '<a href="excel.php?name=Tiers&query='.$sql_encoded.'"> ';
	?>
<img width=24px height=24px src="images/excel.bmp" style="border-style: none"/></a>
</td></tr></table>
	<table>
		<tr>
			<td><iframe src="Report_HU_Tiers.php" frameborder=0 width="650px" height="900px"></iframe></td>
			<td><iframe src="Report_HU_Tiers2.php" frameborder=0 width="650px" height="900px"></iframe></td>
		</tr>
		<tr><td>Number of Standard Changes requested per Change Tiers since 12 Aug 2012 M</td>
		</tr>
		<tr>
			<td><iframe src="Report_HU_Tiers_Standard.php" frameborder=0 width="650px" height="900px"></iframe></td>
			<td><iframe src="Report_HU_Tiers2_Standard.php" frameborder=0 width="650px" height="900px"></iframe></td>
		</tr>
		<tr><td>Number of Changes with no CM requested per Change Tiers since 12 Aug 2012 </td>
		</tr>
		<tr>
			<td><iframe src="Report_HU_Tiers_noCM.php" frameborder=0 width="650px" height="900px"></iframe></td>
			<td><iframe src="Report_HU_Tiers2_noCM.php" frameborder=0 width="650px" height="900px"></iframe></td>
		</tr>
	</table>
<?php include ("footer_new.php"); ?>