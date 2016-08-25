<?php  include ("newtemplate.php"); ?>
<style>
	#loadImg{position:absolute;z-index:999;}
	#loadImg2{position:absolute;z-index:999;}
	#loadImgSmall{position:absolute;z-index:999;}
	#loadImgSmall2{position:absolute;z-index:999;}
	#loadImg div{display:table-cell;width:560px;height:360px;background:#fff;text-align:center;vertical-align:middle;}
	#loadImg2 div{display:table-cell;width:560px;height:360px;background:#fff;text-align:center;vertical-align:middle;}
	#loadImgSmall div{display:table-cell;width:260px;height:360px;background:#fff;text-align:center;vertical-align:middle;}
	#loadImgSmall2 div{display:table-cell;width:260px;height:360px;background:#fff;text-align:center;vertical-align:middle;}
</style>
<div class="body_text">Number of CM Approvals for Evaluation & Authorization</div>
     <div class="body_banner_area">
<table>
	<tr>
		<td>
			<div id="loadImg"><div><img src="images/loading.jpg" /></div></div>
			<iframe id="content" width=560 height=360 seamless src="Report_CM_Eval_Approvals.php?content=graph" onload="document.getElementById('loadImg').style.display='none';"></iframe>
		</td>
		<td><div id="loadImgSmall"><div><img src="images/loading.jpg" /></div></div>
			<iframe id="content" width=260 height=360 seamless src="Report_CM_Eval_Approvals.php?content=report" onload="document.getElementById('loadImgSmall').style.display='none';"></iframe>
		</td>
	</tr>
	<tr>
		<td><div id="loadImg2"><div><img src="images/loading.jpg" /></div></div>
			<iframe id="content" width=560 height=360 seamless src="Report_CM_Auth_Approvals.php?content=graph" onload="document.getElementById('loadImg2').style.display='none';"></iframe>
		</td>
		<td><div id="loadImgSmall2"><div><img src="images/loading.jpg" /></div></div>
			<iframe id="content" width=260 height=360 seamless src="Report_CM_Auth_Approvals.php?content=report" onload="document.getElementById('loadImgSmall2').style.display='none';"/>
		</td>
		<td>
		</td>

	</tr>
</table>
<?php include ("footer.php"); ?>