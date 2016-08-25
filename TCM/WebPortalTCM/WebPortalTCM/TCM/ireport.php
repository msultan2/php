<?php include ("template.php"); ?>
<head>
<link href="templatemo_style_ann.css" rel="stylesheet" type="text/css" />
<link href="css/jquery.ennui.contentslider.css" rel="stylesheet" type="text/css" media="screen,projection" />
</head>

<body>
<div id="templatemo_wrapper_ann">
	<div id="temmplatmeo_header_ann">
		<div id="templatemo_menu_ann">
            <ul>	   
                <li><a href="ireport4.php" >Weekly Trends</a></li>
				<li><a href="ireport.php" class="current">Monthly Trends</a></li>
				<li><a href="ireport2.php">Status</a></li>
				<li><a href="ireport3.php">Statistics</a></li>
            </ul>    	    
        </div> <!-- end of templatemo_menu -->
    
    </div> <!-- end of templatemo_header -->
    
 <div id="templatemo_banner_ann">
   	<div id="banner_left_ann">
        <b><h3>Scheduled Changes Trends:</h3></b>			
		<table>
			<tr>
				<td>
					<iframe  class="iframe_td" width="480px" height="450px" seamless src="Report_NormalPerDept.php" frameborder="0" ></iframe>
				</td>
				<td>
					<iframe  class="iframe_td" width="480px" height="450px" seamless src="Report_StandardPerDept.php" frameborder="0" ></iframe>
				</td>
			</tr>
		</table>
	</div>
        
      

		<!-- Site JavaScript -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/jquery.ennui.contentslider.js"></script>
	<script type="text/javascript">
			$(function() {
				$('#one').ContentSlider({
					width : '535px',
					height : '233px',
					speed : 800,
					easing : 'easeInOutQuart'
				});
			});
		</script>
	<script src="js/jquery.chili-2.2.js" type="text/javascript"></script>
	<script src="js/chili/recipes.js" type="text/javascript"></script>

        
      </div>   <!-- end of slider --> 
    </div> <!-- end of templatemo_banner -->
    <!-- end of templatemo_content -->
      
 <!-- end of templatemo_wrapper -->

</body>
</html>

<?php include ("footer.php"); ?>