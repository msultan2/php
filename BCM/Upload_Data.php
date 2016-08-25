<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
Design by http://www.AtomicWebsiteTemplates.com
Released for free under a Creative Commons Attribution 3.0 License
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>BCM</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
<!-- CuFon: Enables smooth pretty custom font rendering. 100% SEO friendly. To disable, remove this section -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/arial.js"></script>
<script type="text/javascript" src="js/cuf_run.js"></script>
<script type="text/javascript" src="js/radius.js"></script>
<!-- CuFon ends -->
<style>
a {
color: #e60000 !important;
text-decoration: none;
}

.sidebar .gadget {
margin: 0 0 10px 0;
padding: 10px;
border: 1px solid #ebebeb;
height: 439px !important;
}
</style>

</head>
<body>
<div class="main">
  <div class="header">
    <div class="header_resize">
      <div class="logo">
      <img src="images/logo_img.png" width="10%" height="10%" />
      <h2><a href="index.html">Business Continuity Management</a></h1>
      </div>
      <div class="clr"></div>
      
	  <div class="menu_nav">
        <ul>
          <li class="active"><a href="index.html">Home</a></li>
          <li><a href="contact.html">Contact Us</a></li>
          <li><a href="login.html">Login</a></li>
        </ul>
      </div>
	  
    </div>
  </div>
  <div class="clr"></div>
  <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
		  <?php
			if ($_FILES["file"]["error"] > 0) {
					echo "Error: " . $_FILES["file"]["error"] . "<br>";
			} 
			else 
			{
				  echo "Upload: " . $_FILES["file"]["name"] . "<br>";
				  echo "Type: " . $_FILES["file"]["type"] . "<br>";
				  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";

					if (file_exists("C:/wamp/www/BCP/Uploads/" . $_FILES["file"]["name"])) 
					{
					  echo "<h2>";
					  echo "<span>";	
					  echo $_FILES["file"]["name"] . " already exists. ";
					  echo "</span>";
					  echo "</h2>";
					} 
					else {
					  Copy($_FILES["file"]["tmp_name"],
					  "C:/wamp/www/BCP/Uploads/" . $_FILES["file"]["name"]);
					  echo "<h2>";
					  echo "<span>";
					  echo "File uploaded successfully";
					  echo "</span>";
					  echo "</h2>";
					}
			}
		?>
		
          <div class="clr"></div>
          
		</div>
       
          <p class="lr"><font color="#e60000">© Copyright 2014 Vodafone Egypt. Developed by Customer Experience Team.</font></p>
      
        
      </div>
      <div class="clr"></div>
    </div>
  </div>
  </div>
</div>
</body>
</html>
