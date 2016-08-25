<!DOCTYPE html>
<?php 	//include ("Rego_Table_file.php"); 
		//include ("Rego_Remedy_file.php"); 
		$page = $_SERVER['PHP_SELF'];
		$sec = 10*60;	// 10 minutes
		
		$browser = $_SERVER['HTTP_USER_AGENT'];
		$chrome = '/Chrome/'; 	//$ie = '/MSIE/';
		if (preg_match($chrome, $browser)){
			//echo "Chrome/Opera";
		date_default_timezone_set('Africa/Cairo');

 ?>
<html lang="en">
    <head>
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <title>SDS Regional Monitor</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="CSS-only Responsive Layout with Smooth Transitions" />
        <meta name="keywords" content="css3, transitions, animations, css-only, navigation, smooth scrolling, full width, full height, window width, window height" />
        <meta name="author" content="Codrops" />
		<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
        <link rel="shortcut icon" href="../favicon.ico"> 
		<link href='http://fonts.googleapis.com/css?family=Josefin+Slab:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
		<script type="text/javascript" src="js/modernizr.custom.79639.js"></script> 
		<!--[if lte IE 8]>
			 <link rel="stylesheet" type="text/css" href="css/simple.css" />
		<![endif]-->
    </head>
    <body>
        <div class="container">
		
			<!-- Codrops top bar -->
            <div class="codrops-top">
                <a href="http://tympanus.net/Tutorials/CSS3ImageAccordion/">
                    <!--strong>Regions and Sub-Regions </strong>Scattered sites Monitoring & Analysis-->
					<strong><?php echo date("D, j F Y, g:i a");?></strong>
					<BR><img src="images/SDS_logo1.png" width="270px" height="130px" /><!--h2>Scattered Sites</h2-->
					<h3><?php //echo date("D, j F Y, g:i a");?></h3>
                </a>
                <span class="right">
                    <a href="http://tympanus.net/codrops/2012/06/12/css-only-responsive-layout-with-smooth-transitions/">
                        <!--strong>Back to the Codrops Article</strong-->
                    </a>
                </span>
                <div class="clr"></div>
            </div><!--/ Codrops top bar -->
			<?php include ("Rego_Menu1.php");  ?>
			
        </div>
	</body>
</html>
<?php
	}
	else echo "<h1>Your Browser Version is not supported, please use <a href='https://www.google.com/intl/en/chrome/'>Google Chrome.</a></h1>";
?>