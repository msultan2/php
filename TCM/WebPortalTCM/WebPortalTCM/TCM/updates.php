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
                <li><a href="updates.php" class="current">Updates</a></li>
               
                <li><a href="Calendar_PA.php">PA Calenadr</a></li>
				<li><a href="announcements.php">Freeze Calendar</a></li>
                
            </ul>    	
        
        </div> <!-- end of templatemo_menu -->
    
    </div> <!-- end of templatemo_header -->
    
 <div id="templatemo_banner_ann">
   	<div id="banner_left_ann">
        
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