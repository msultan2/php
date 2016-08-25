<!DOCTYPE html>
<?php 	
		$sec = 1*60;	// 10 minutes
		$page = $_SERVER['PHP_SELF'];
		$browser = $_SERVER['HTTP_USER_AGENT'];
		$chrome = '/Chrome/'; 	//$ie = '/MSIE/';
		if (preg_match($chrome, $browser)){
			//echo "Chrome/Opera";
		//date_default_timezone_set('Africa/Cairo');
		date_default_timezone_set('Asia/Riyadh');

 ?>
 <html>
    <head>
        <meta charset="UTF-8">
        <title>SM Dashboard</title>
		<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
		
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
	<body>
			<div class="nav-tabs-custom">
					<!-- Morris chart - Sales -->
						<table><tr><td width=50%>
							<h2><center>SLA Compliance</center></h2>
							<table height=600px>
								<tr align=center><td colspan=3><iframe src="Report_SLA_Guage.php" height=180px width=700px frameborder=0 scrolling=no></iframe></td></tr>
								<tr><td colspan=3>
										<h2><center>Incidents Compliance</center></h2>
										<iframe src="Report_SLA_Access_Outage.php" height=320px width=700px frameborder=0 scrolling=no></iframe></td></tr>
								<tr><td colspan=3><h2><center>Sites Grade Compliance</center></h2></td></tr>
								<tr><td width=20px>&nbsp;</td>
									<td>
										
										<!--iframe src="Report_SLA_Access_Scattered_bkp.php?context=DVD"  height=200px width=720px frameborder=0 scrolling=no></iframe></td></tr-->
										<iframe src="Report_SLA_Access_Scattered_bars.php"  height=280px width=400px frameborder=0 scrolling=no></iframe></td>
									<td><iframe src="Report_SLA_Access_Scattered_columns.php"  height=250px width=300px frameborder=0 scrolling=no></iframe></td></tr>
							</table>
							</td>
								<td width=50%>
								<h2><center>Teams Queue</center></h2>
								<table height=600px>
									<tr align=center><td><iframe src="Report_Team_Queue_Access.php" height=370px width=700px frameborder=0 scrolling=no></iframe></td></tr>
									<tr align=center><td><iframe src="Report_Team_Queue_TX.php" height=400px width=700px frameborder=0 scrolling=no></iframe></td></tr>
								</table>
							</td>
							</tr>
						</table>
			</div><!-- /.nav-tabs-custom -->
	</body>
</HTML>
<?php
	}
	else echo "<h1>Your Browser Version is not supported, please use <a href='https://www.google.com/intl/en/chrome/'>Google Chrome.</a></h1>";
?>							