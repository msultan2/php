<?php session_start();  $pagePrivValue=50; require 'approve.php'; ?>
<?php  include ("newtemplate.php"); ?>
<div class="body_text"><b>Monthly Trend of Authorized Changes and Incidents since 12 Aug 2012</b></div>
<table>
	<tr>
		<td>
			<iframe  width="950px" height="1200px" seamless src="Report_CRQType_Monthly.php" frameborder="0" ></iframe>
		</td>
	</tr>
</table>
<?php include ("footer_new.php"); ?>