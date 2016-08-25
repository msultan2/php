<?php include ("template.php"); ?>
<?php include ("drop.php"); ?>
<div id="templatemo_content_wrapper">
<div id="templatemo_content">
<div id="main_content">
<div id="templatemo_content_wrapper"><!-- Start of Content -->
<!--start of crq search-->
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
            <div align=center><h5><b>By Product Tiers</b></h5></div>
			<div class="box_01_wrapper">
				<html>
				<head>
					<meta charset="utf-8" />
					<script src="ajax_select.js" type="text/javascript"></script>
				</head>
				<body>
					<form action="" method="post">
					Select: <?php echo $re_html; ?>
					</form>
				</body>
				</html>            
            </div>    
        </div>
		<div style="height:10px"></div>
	</div>    	
<!--end by tiers search-->
<!--start of team search-->
	<div class="box_01_wrapper box_01_bg">
        <div class="box_010">
            <div align=center><h5><b>By Product Tiers</b></h5></div>
			<div class="box_01_wrapper">
				<html>
				<head>
					<meta charset="utf-8" />
					<script src="ajax_select.js" type="text/javascript"></script>
				</head>
				<body>
					<form action="" method="post">
					Select: <?php echo $re_html; ?>
					</form>
				</body>
				</html>            
            </div>    
        </div>
		<div style="height:10px"></div>
	</div>
<!--end of team search-->
</div>    
</div>	
</div>    
</div>
<!--start of st. and normal-->
<div id="templatemo_content_wrapper">
<div id="templatemo_content">
<div id="main_content">
<div class="box_01_wrapper box_01_bg">
        <div class="box_010">
            <div align=center><h5><b>By Product Tiers</b></h5></div>
			<div class="box_01_wrapper">
				<html>
				<head>
					<meta charset="utf-8" />
					<script src="ajax_select.js" type="text/javascript"></script>
				</head>
				<body>
					<form action="" method="post">
					Select: <?php echo $re_html; ?>
					</form>
				</body>
				</html>            
            </div>    
        </div>
		<div style="height:10px"></div>
	</div>
</div>    
</div>	
</div>    
</div>
<!--end of st. and normal-->
<!--start of approval cycle-->
<div id="templatemo_content_wrapper">
<div id="templatemo_content">
<div id="main_content">
<div class="box_01_wrapper box_01_bg">
        <div class="box_010">
            <div align=center><h5><b>By Product Tiers</b></h5></div>
			<div class="box_01_wrapper">
				<html>
				<head>
					<meta charset="utf-8" />
					<script src="ajax_select.js" type="text/javascript"></script>
				</head>
				<body>
					<form action="" method="post">
					Select: <?php echo $re_html; ?>
					</form>
				</body>
				</html>            
            </div>    
        </div>
		<div style="height:10px"></div>
	</div>
</div>    
</div>	
</div>
<!--end of approval cycle-->
<?php include ("footer.php"); ?> 