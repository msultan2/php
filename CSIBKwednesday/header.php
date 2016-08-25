<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- saved from url=(0077)file:///C:/Users/mahmoud/Desktop/voda%20take1/ver4/Careers%20main%20page.html -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

</head>
<body cz-shortcut-listen="true">














<link rel="stylesheet" type="text/css" href="./resources/megamenus.css" media="projection, screen, print">
<link href="./resources/custom_jQuery.css" rel="stylesheet" type="text/css" media="projection, screen, print">
<link href="./resources/custom_style.css" rel="stylesheet" type="text/css" media="projection, screen, print">





<!---start charts  -->
    <link class="include" rel="stylesheet" type="text/css" href="./jquery.jqplot.min.css" />
    <link type="text/css" rel="stylesheet" href="syntaxhighlighter/styles/shCoreDefault.min.css" />
    <link type="text/css" rel="stylesheet" href="syntaxhighlighter/styles/shThemejqPlot.min.css" />
  
  
    <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="./excanvas.js"></script><![endif]-->
    <script class="include" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    
<!--end charts-->

<!---start tabs -->
<link href="jquery-ui.css" rel="stylesheet">
<style>
	
	.demoHeaders {
		margin-top: 2em;
	}
	#dialog-link {
		padding: .4em 1em .4em 20px;
		text-decoration: none;
		position: relative;
	}
	#dialog-link span.ui-icon {
		margin: 0 5px 0 0;
		position: absolute;
		left: .2em;
		top: 50%;
		margin-top: -8px;
	}
	#icons {
		margin: 0;
		padding: 0;
	}
	#icons li {
		margin: 2px;
		position: relative;
		padding: 4px 0;
		cursor: pointer;
		float: left;
		list-style: none;
	}
	#icons span.ui-icon {
		float: left;
		margin: 0 4px;
	}
	.fakewindowcontain .ui-widget-overlay {
		position: absolute;
	}
	select {
		width: 200px;
	}
	</style>
<!--end tabs -->









<!--start table -->
 <link href="css/bootstrap.css" rel="stylesheet" />
        <link href="./dist/jquery.bootgrid.css" rel="stylesheet" />
        
        <script src="./js/moderniz.2.8.1.js"></script>
         
                          
        <style>
            @-webkit-viewport { width: device-width; }
            @-moz-viewport { width: device-width; }
            @-ms-viewport { width: device-width; }
            @-o-viewport { width: device-width; }
            @viewport { width: device-width; }

            /*body { padding-top: 70px;*/ }
            
            .column .text { color: #f00 !important; }
            .cell { font-weight: bold; }
        </style>
<!--end table -->




<!-- here you can stsrt -->





<title><?php echo $pageTitle ; ?></title>
<link rel="image_src" href="./resources/logo.png">
<div id="header" class="clearfix">
	<div id="global-nav-wrap" class="clearfix" style="width:950px;">
	<ul id="top-globalnav" style="margin: 0 0 0 0px;width: 100%;">
	<li id="aboutus_bookmenu" class="my-world active">
	<a href="index.php" style="padding-left: 0px;    padding-left: 0px;
    font-size: 17px!important;
   
    font-weight: bold;    padding-top: 8px;">IMatrix Analyzer</a>
	</li>
	
	
	
	<?php if(isset($_SESSION["Username"])==true) { ?>
	<li id="" class="my-world active" style="float: right;">
	<a href="logout.php">
	<span>Logout</span></a></li> <?php  } ?>
	
	<li id="aboutus_bookmenu3" class="my-world active" style="float: right; ">
	<a href="index.php" style="padding-left: 0px; color:#E01337;"><span><?php if(isset($_SESSION["Username"])==true) echo "Welcome :".$_SESSION["Username"]; ?> </span></a>
	</li >
	</ul>
	
	</div>


	<!-- Second Level -->
	<div id="top-nav">
<ul id="menulogo">
	<li class="logo">
<a href="#" title="Back to home page"><img src="./resources/logo.png" alt="Vodafone logo - home page"></a>
	</li>
</ul>

<ul id="menu" style="width: 100% !important;" >
  	      	
            	      	<!-- Set book url to its default page url -->
		             
		             		
		             
                   <li id="corporateResponsibility_bookmenu" class="menuItem">
            		<a class="phones" href="controller.php" title="">
            		<span></span>
            		
	            		
			            
			            	<span class="blinespan">
			            
		            
            		Impact Analysis</span></a>
					<ul class="submenu2" id="megamenu2"><li>
            		
                    </li></ul>
            	      	<!-- Set book url to its default page url -->
		             
		             		
		             
                    </li>
				


				<?php  if (isset($activityLogAllowed)==true&&$activityLogAllowed==true){?>				
				<li id="company_bookmenu" class="menuItem">
            		<a class="phones active" href="./ActivityLogOutput.php" title="">
            		<span></span>
            		
	            		
			            	<span>
			            
			            
		            
            		Activity Log </span></a>
					<ul class="submenu3" id="megamenu3"><li>
            		
                    </li></ul>
                    
               
 	
      
	</li>
	                <?php }?>
			
<?php  if (isset($mismatchReportActivityAllowed)==true&&$mismatchReportActivityAllowed==true){?>
			<li id="company_bookmenu" class="menuItem">
            		<a class="phones active" href="./MismatchOutput.php" title="">
            		<span></span>
            		
	            		
			            	<span>
			            
			            
		            
            		Conflicts </span></a>
					<ul class="submenu3" id="megamenu3"><li>
            		
                    </li></ul>
                    
               
 	
      
	</li>
	<?php }?>
	
	<?php  if (isset($cMStatisticsAllowed)==true&&$cMStatisticsAllowed==true){?>
					<li id="company_bookmenu" class="menuItem">
            		<a class="phones active" href="./CMStatistics.php" title="">
            		<span></span>
            		
	            		
			            	<span>
			            
			            
		            Change Statistics
            		 </span></a>
					<ul class="submenu3" id="megamenu3">
					<li>
            		
                    </li></ul>
                    
               
 	
      
	</li>
	<?php }?>
	
	
		<?php  if (isset($downSitesPerActivityAllowed)==true&&$downSitesPerActivityAllowed==true){?>
					<li id="company_bookmenu" class="menuItem">
            		<a class="phones active" href="./downSitesPerActivity.php" title="">
            		<span></span>
            		
	            		
			            	<span>
			            
			            
		            downSites-Activity
            		 </span></a>
					<ul class="submenu3" id="megamenu3">
					<li>
            		
                    </li></ul>
                    
               
 	
      
	</li>
	<?php }?>
	
	
	</ul>


	</div>
</div>
