<!DOCTYPE html>
<html lang="en">
<head>
    <title> Home </title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css" media="screen">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
    <link rel="stylesheet" href="css/grid.css" type="text/css" media="screen"> 
	<link rel="stylesheet" type="text/css" href="engine1/style.css" />
	<script type="text/javascript" src="engine1/jquery.js"></script>	
    <script src="js/jquery-1.6.3.min.js" type="text/javascript"></script>
    <script src="js/cufon-yui.js" type="text/javascript"></script>
    <script src="js/cufon-replace.js" type="text/javascript"></script>
    <script src="js/NewsGoth_400.font.js" type="text/javascript"></script>
	<script src="js/NewsGoth_700.font.js" type="text/javascript"></script>
    <script src="js/NewsGoth_Lt_BT_italic_400.font.js" type="text/javascript"></script>
    <script src="js/Vegur_400.font.js" type="text/javascript"></script> 
    <script src="js/FF-cash.js" type="text/javascript"></script>
    <script src="js/jquery.featureCarousel.js" type="text/javascript"></script>     
    <script type="text/javascript">
      $(document).ready(function() {
        $("#carousel").featureCarousel({
			autoPlay:7000,
			trackerIndividual:false,
			trackerSummation:false,
			topPadding:50,
			smallFeatureWidth:.9,
			smallFeatureHeight:.9,
			sidePadding:0,
			smallFeatureOffset:0
		});
      });
    </script>
	<!--[if lt IE 7]>
    <div style=' clear: both; text-align:center; position: relative;'>
        <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
        	<img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
        </a>
    </div>
	<![endif]-->
    <!--[if lt IE 9]>
   		<script type="text/javascript" src="js/html5.js"></script>
        <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen">
	<![endif]-->
<style>
	h1 a
	{
		width: 350px !important;
		height: 65px !important;
	}
	
	.menu-row {
		width: 100%;
		background: url(../images/menu-row-tail.gif) center top repeat-x #e60000 !important;
	}
	
	.menu {
		padding: 0 0 0 0;
		background: url(../images/menu-spacer.gif) left top no-repeat #e60000 !important;
}

.menu li {
float: left;
position: relative;
background: url(../images/menu-spacer.gif) right top no-repeat #e60000 !important;
padding-right: 2px;
}

#page1 .center-shadow {
background: url(../images/center-shadow.png) center top no-repeat #222121 !important;
}

footer {
height: 40px !important;
}

.main {
width: 1555px !important;
}


.menu li a {
font-size: 18px !important; 
width: 218px !important;
text-transform: capitalize !important;
}

footer .padding {
padding: 13px 0 0 !important;
}

.row-top {
width: 100%;
height: 55px !important;
background-color: #FFFFFF !important;
overflow: hidden;
}

#wowslider-container1 {
zoom: 1;
position: relative;
max-width: 550px;
margin: 0px auto 0px;
z-index: 90;
border: 1px solid #1D1B1B !important;
text-align: left;
}

.container_12 .grid_4 {
width: 324px !important;
}


</style>	
</head>
<body id="page1">
	<div class="extra">
    	<!--==============================header=================================-->
        <header>
        	<div class="row-top">
            	<div class="main">
                	<div class="wrapper">
                    	<br>
						<a href="index.html"> <img src="images/Header.png" /> </a>
                    </div>
                </div>
            </div>
            <div class="menu-row">
            	<div class="menu-bg">
                    <div class="main">
                        <nav class="indent-left">
                            <ul class="menu wrapper">
                                <li><a href="index.html">Home page</a></li>
                                <li><a href="About.html">About Us</a></li>
								<li><a href="contact.html">Contact Us</a></li>
								<li><a href="Login.html">Login</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
			<div class="center-shadow">
			</div>
        </header>
        
        <!--==============================content================================-->

	
	<!--==============================footer=================================-->
     <footer>
        <div class="padding">
            <div class="main">
                <div class="container_12">
                    <div class="wrapper">
                        <article class="grid_4">
                            <p class="p1">Vodafone Egypt &copy; 2013 - Customer Experience Dep.</p>
                           
                            <!-- {%FOOTER_LINK} -->
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </footer>
	<script type="text/javascript"> Cufon.now(); </script>
</body>
</html>
