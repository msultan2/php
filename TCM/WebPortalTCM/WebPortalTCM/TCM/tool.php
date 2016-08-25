<?php include ("template.php"); ?>
<?php include ("drop.php"); ?>
<div id="templatemo_content_wrapper">
<div id="templatemo_content">
<div id="main_content">
<div id="templatemo_content_wrapper"><!-- Start of Content -->
<!--end of crq search-->
		<h5><b>Search for Change Requests:<b></h5><br/>
        <div class="box_01_wrapper box_01_bg">
            <div class="box_010">
            <div align=center><h5><b>By CRQ#</b></h5></div>
			<table>
			<form action="CRQ_MSSQL.php" name="myForm" method="post">
				<tr>
					<td align=center><p>Change ID: </p></td>
					<td align=left>
						<input type="text" name="CRQnum" value='<?php echo $_POST['CRQnum'];?>'/>
					</td>
					<td>
						<input type="submit" name="searchCRQ" value="Search" />
					</td>
				</tr>
			</form>		
		</table>
		<div style="height:10px"></div>				
        </div>    
        </div>
<!--end of crq search-->
<!--start of tiers search-->        
        <div class="box_01_wrapper box_01_bg">
            <div class="box_010">
              <div align=center><h5><b>By Product Tiers</b><br>"Coming Soon"</h5></div>
			 <!--<div class="box_01_wrapper">
				<table>
			<form action="CRQ_tiers.php" name="myForm" method="post">
				<tr>
					
					<td align=left><p>tier 1:</p></td>
					<td align=center>
					<div align=center>
					
						<input type="text" name="tier1" value='<?php echo $_POST['tier1'];?>'/>
						
						<input type="text" name="tier2" value='<?php echo $_POST['tier2'];?>'/>
					
					
						<input type="text" name="tier3" value='<?php echo $_POST['tier3'];?>'/>
					
						<br><br>
					</div>
					<input type="submit" name="searchCRQ" value="Search" />
					</td>
					
				</tr>
			</form>		
			</table>
            </div>-->    
            </div>
		<div style="height:10px"></div>
		</div>    
		
 <!--end by tiers search-->
<!--start of by team search--> 
        <div class="box_01_wrapper">
            <div class="box_010">
             <div align=center><h5><b>By Team</b><br>"Coming Soon"<br></h5></div>
			 <!--<html>
				<head>
					<meta charset="utf-8" />
					<script src="ajax_select.js" type="text/javascript"></script>
				</head>
				<body>
					<form action="" method="post">
					Select: <?php echo $re_html; ?>
					</form>
				</body>
			</html>-->            
            </div>    
        </div>
        <div class="cleaner"></div>
</div>
</div>
</div>
</div>		
<!--end of tiers search-->
<!--start of normal and standard search-->
<div id="templatemo_content_wrapper">
	<div id="templatemo_content">
		<div id="main_content">
<html>
<head>
<meta charset="utf-8" />
<script src="ajax_select.js" type="text/javascript"></script>
</head>
<body>
<h5><b>Search for Change Types(Normal or Standard):<b></h5><br/>
<form action="" method="post">

				<?php echo $re_html; ?>
				
</form>
</body>
</html>
</div>
</div>
</div>
<!--end of normal and standard search-->
<!--start of approval cycle search-->
<!--<div id="templatemo_content_wrapper">
	<div id="templatemo_content">
		<div id="main_content">
		<h5><b>Search for Change approval cycle:<b></h5><br/>
	<!--<html>
				<head>
					<meta charset="utf-8" />
					<script src="ajax_select.js" type="text/javascript"></script>
				</head>
				<body>
					<form action="" method="post">
					Select: <?php echo $re_html; ?>
				</form>
				</body>
		</html>-->	
</div>
</div>
</div>	
<!--start of approval cycle search-->
<!-- end of content_wrapper --> 
<?php include ("footer.php"); ?>
