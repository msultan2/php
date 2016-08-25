<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
Design by http://www.AtomicWebsiteTemplates.com
Released for free under a Creative Commons Attribution 3.0 License
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Departments</title>
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

.article {
margin: 0;
padding: 55px 0 0 0;

}

.button {
	-moz-box-shadow:inset 0px 1px 0px 0px #f29c93;
	-webkit-box-shadow:inset 0px 1px 0px 0px #f29c93;
	box-shadow:inset 0px 1px 0px 0px #f29c93;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #fe1a00), color-stop(1, #e60000) );
	background:-moz-linear-gradient( center top, #fe1a00 5%, #e60000 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#fe1a00', endColorstr='#e60000');
	background-color:#fe1a00;
	-webkit-border-top-left-radius:6px;
	-moz-border-radius-topleft:6px;
	border-top-left-radius:6px;
	-webkit-border-top-right-radius:6px;
	-moz-border-radius-topright:6px;
	border-top-right-radius:6px;
	-webkit-border-bottom-right-radius:6px;
	-moz-border-radius-bottomright:6px;
	border-bottom-right-radius:6px;
	-webkit-border-bottom-left-radius:6px;
	-moz-border-radius-bottomleft:6px;
	border-bottom-left-radius:6px;
	text-indent:0;
	border:1px solid #d83526;
	display:inline-block;
	color:#ffffff;
	font-family:Arial;
	font-size:15px;
	font-weight:bold;
	font-style:normal;
	height:39px;
	width:200px;
	text-decoration:none;
	text-align:center;
	text-shadow:1px 1px 0px #b23e35;
	
}
.button:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #e60000), color-stop(1, #fe1a00) );
	background:-moz-linear-gradient( center top, #e60000 5%, #fe1a00 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#e60000', endColorstr='#fe1a00');
	background-color:#e60000;
}.button:active {
	position:relative;
	top:1px;
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
	  
      <div class="clr"></div>
      <div class="header_img">
      <img width="100%" height="50%" src="images/img_top.png" complete="complete"/>
	  </div>
      
      
    </div>
  </div>
  <div class="clr"></div>
  <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
		<h2><span><center>Please choose from the below functions</center></span></h2>
          <br> <br>
		  <?php
				$Dep = $_GET['Department'];
				
				echo "<center>";
				echo "<table>";
				
				echo "<tr>";
				echo "<td>";
				$link = "System_Data_Processing.php" . "?" . "Department=" . $Dep;
				echo "<a href='$link'>";
				echo "<input type='submit' value='View System Data' class='button'>";
				echo "</a>";
				echo "</td>";
				
				echo "<td>";
				$link = "Admin_Data_Processing.php" . "?" . "Department=" . $Dep;
				echo "<a href='$link'>";
				echo "<input type='submit' value='View Admin Data' class='button'>";
				echo "</a>";
				echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
				echo "<td>";
				$link = "Analyza_Data.php" . "?" . "Department=" . $Dep;
				echo "<a href='$link'>";
				echo "<input type='submit' value='Analyze Data' class='button'>";
				echo "</a>";
				echo "</td>";
				
				echo "<td>";
				$link = "Edit_Data.php" . "?" . "Department=" . $Dep . "Type=" . "Add";
				echo "<a href='$link'>";
				echo "<input type='submit' value='Add Data' class='button'>";
				echo "</a>";
				echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
				echo "<td>";
				$link = "Edit_Data.php" . "?" . "Department=" . $Dep . "Type=" . "Edit";
				echo "<a href='$link'>";
				echo "<input type='submit' value='Edit Data' class='button'>";
				echo "</a>";
				echo "</td>";
				
				echo "<td>";
				$link = "Edit_Data.php" . "?" . "Department=" . $Dep . "Type=" . "Delete";
				echo "<a href='$link'>";
				echo "<input type='submit' value='Delete Data' class='button'>";
				echo "</a>";
				echo "</td>";
				echo "</tr>";
				
				
				echo "<tr>";
				echo "<td colspan='2'>";
				echo "<form action='Upload_Data.php' method='post' enctype='multipart/form-data'>";
				echo "<input type='file' name='file' id='file'>";
				echo "<input type='submit' value='Upload Data' name='submit' class='button'>";
				echo "</form>";
				echo "</td>";
				echo "</tr>";
				echo "</table>";
				echo "</center>";
			?>
		</div>
       
      <br> <br> <br>    
      <p class="lr"><font color="#e60000"> Copyright 2014 Vodafone Egypt. Developed by Customer Experience Team.</font></p>
        
      </div>
      <div class="sidebar">
        <div class="gadget">
          <img src="images/2.jpg"  width="100%" height="100%" />
        </div>
       
      </div>
      <div class="clr"></div>
    </div>
  </div>
  </div>
</div>
</body>
</html>