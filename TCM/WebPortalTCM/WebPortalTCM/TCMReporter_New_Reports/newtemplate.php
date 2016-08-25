<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TCM Reporter</title>
<link href="style_new.css" rel="stylesheet" type="text/css" />  
<link href="TableCSSCode0.css" rel="stylesheet" type="text/css" />  
<link rel="shortcut icon" type="image/x-icon" href="images/VFicon.ico">
</head>
<body>
<!--style="background-image:url(images/vf-bkg.bmp);padding:5px;width:100%;height:100%;background-position: 50% 50%; background-repeat: no-repeat; filter:alpha(opacity=40);"-->
<div id="maincontainer">

<?php //date_default_timezone_set("Africa/Cairo"); ?>
<div id="topsection">
	<div class="innerToptube">
	<table width="100%" height="80px">
		<tr>
			<td rowspan=3 align=left width='80px' ><div width='80px' align=left ><img src="images/vfBrand4.png" width="80px" height="115px" /></div></td>
			<td colspan=2  align=right><b><span style="color:#222222"><?php echo date("D, j F Y, g:i a");//,strtotime ("-1 hour"));?></b></td>
		</tr>
		<tr>
			<!--td align=left width='245px'><h1><span style="color:#B40404"><I>VETO</I></span><BR><U style="color:darkgray"><span style="color:darkgray">TCM </span><span style="color:#B40404">Reporter</span></U></h1></td-->
			<td align=left width='245px'><h1><U style="color:darkgray"><span style="color:darkgray">TCM </span><span style="color:#B40404">Reporter</span></U></h1></td>
			<td width='1250px'></td>
		</tr>
		<tr><td colspan=3  align=right>Welcome <?php echo $_COOKIE["user"]; ?></td></tr>
	</table>
	</div>
</div>
<!-- start of top menu -->
<div class="ubercolortabs">
<ul>
<?php if ($_SESSION['priv'] == 20){ //ITuser ?>

	<li><a href="CAB_Report_IT.php" style="margin-left: 200px"><span>Home</span></a></li>

<?php } elseif ($_SESSION['priv'] == 10) {//TECHIM{ ?>

<?php if($_SERVER['PHP_SELF']=="/TCMReporter/CAB_Yesterday_Report.php") echo "<li class=selected>"; else echo "<li>"; ?>
	<a href="CAB_Yesterday_Report.php" style="margin-left: 200px"><span>Home</span></a></li>
	
<?php } elseif ($_SESSION['priv'] == 25) {//HGabbas{ ?>

<?php if($_SERVER['PHP_SELF']=="/TCMReporter/home.php") echo "<li class=selected>"; else echo "<li>"; ?>
	<a href="home.php" style="margin-left: 200px"><span>Home</span></a></li>
<?php if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_MonthlyKPIs.php") echo "<li class=selected>"; else echo "<li>"; ?>
	<a href="Reporter_MonthlyKPIs.php"><span>KPI Trend</span></a></li>
	
	
<?php } elseif ($_SESSION['priv'] == 30) {//SMuser{ ?>

<?php if($_SERVER['PHP_SELF']=="/TCMReporter/home.php") echo "<li class=selected>"; else echo "<li>"; ?>
	<a href="home.php" style="margin-left: 200px"><span>Home</span></a></li>
<?php if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_SupportTeamKPIs.php") echo "<li class=selected>"; else echo "<li>"; ?>
	<a href="Reporter_SupportTeamKPIs.php"><span>Team KPIs</span></a></li>	

<?php } elseif ($_SESSION['priv'] == 50) {//VIPuser{ ?>

<?php if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_home.php") echo "<li class=selected>"; else echo "<li>"; ?>
	<a href="Reporter_home.php" style="margin-left: 200px"><span>Home</span></a></li>
	<?php if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_DashBoard.php") echo "<li class=selected>"; else echo "<li>"; ?>
	<a href="Reporter_DashBoard.php"><span>Dashboard</span></a></li>
<?php if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_Daily.php") echo "<li class=selected>"; else echo "<li>"; ?>
	<a href="Reporter_Daily.php"><span>Daily Trends</span></a></li>
<?php if($_SERVER['PHP_SELF']=="/TCMReporter/Report_Normal_Week.php") echo "<li class=selected>"; else echo "<li>"; ?>
	<a href="Report_Normal_Week.php"><span>Weekly Trends</span></a></li>
<?php if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_Normal_Standard_Depts.php") echo "<li class=selected>"; else echo "<li>"; ?>
	<a href="Reporter_Normal_Standard_Depts.php"><span>Monthly Trends</span></a></li>
<?php if($_SERVER['PHP_SELF']=="/TCMReporter/Report_Motion_Status.php") echo "<li class=selected>"; else echo "<li>"; ?>
	<a href="Report_Motion_Status.php"><span>Moving Statistics</span></a></li>
<?php if($_SERVER['PHP_SELF']=="/TCMReporter/Did_u_know.php") echo "<li class=selected>"; else echo "<li>"; ?>
	<a href="Did_u_know.php"><span>Did you know?</span></a></li>

<?php } elseif ($_SESSION['priv'] == 100) {//TCMuser{ ?>

<?php if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_home.php") echo "<li class=selected>"; else echo "<li>"; ?>
	<a href="Reporter_home.php" style="margin-left: 200px"><span>Home</span></a></li>
<?php if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_DashBoard.php") echo "<li class=selected>"; else echo "<li>"; ?>
	<a href="Reporter_DashBoard.php"><span>Dashboard</span></a></li>
<?php if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_Daily.php") echo "<li class=selected>"; else echo "<li>"; ?>
	<a href="Reporter_Daily.php"><span>Daily Trends</span></a></li>
<?php if($_SERVER['PHP_SELF']=="/TCMReporter/Report_Normal_Week.php") echo "<li class=selected>"; else echo "<li>"; ?>
	<a href="Report_Normal_Week.php"><span>Weekly Trends</span></a></li>
<?php if($_SERVER['PHP_SELF']=="/TCMReporter/Reporter_Normal_Standard_Depts.php") echo "<li class=selected>"; else echo "<li>"; ?>
	<a href="Reporter_Normal_Standard_Depts.php"><span>Monthly Trends</span></a></li>
<?php //if($_SERVER['PHP_SELF']=="/TCMReporter/Report_Incidents_Month.php") echo "<li class=selected>"; else echo "<li>"; ?>
	<!--a href="Report_Incidents_Month.php"><span>Incidents Trends</span></a></li-->
<?php if($_SERVER['PHP_SELF']=="/TCMReporter/Report_Motion_Status.php") echo "<li class=selected>"; else echo "<li>"; ?>
	<a href="Report_Motion_Status.php"><span>Moving Statistics</span></a></li>
<?php if($_SERVER['PHP_SELF']=="/TCMReporter/Did_u_know.php") echo "<li class=selected>"; else echo "<li>"; ?>
	<a href="Did_u_know.php"><span>Did you know?</span></a></li>
<?php } ?>

</ul>
</div>


<div class="ubercolordivider"> </div>
<!-- end of top menu -->

<div id="contentwrapper">
<div id="contentcolumn">
<div class="innertube">
<div style="height:15px;"></div>
<b><!--write here--><em><!--write here--></em></b> 
<!--content goes here-->

<!--content ends here-->
<!--footer goes here-->

