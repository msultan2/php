<!DOCTYPE html>
<?php 	//include ("Rego_Table_file.php"); 
		//include ("Rego_Remedy_file.php"); 
		$page = "index.php?default=".$_GET['default']; //$_SERVER['PHP_SELF'];
		$sec = 10*60;	// 10 minutes
		
		$browser = $_SERVER['HTTP_USER_AGENT'];
		$chrome = '/Chrome/'; 	//$ie = '/MSIE/';
		if (preg_match($chrome, $browser)){
			//echo "Chrome/Opera";
		//date_default_timezone_set('Africa/Cairo');
		date_default_timezone_set('Africa/Egypt');

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
                <a href="">
                    <!--strong>Regions and Sub-Regions </strong>Scattered sites Monitoring & Analysis-->
					<strong><?php echo date("D, j F Y, g:i a");?></strong>
					<BR><img src="images/SDS_logo1.png" width="270px" height="130px" /><!--h2>Scattered Sites</h2-->
                </a>
				
                <div class="clr"></div>
            </div><!--/ Codrops top bar -->
			<?php //include ("Rego_Menu1.php");  ?>
						<div class="st-container">
			<!-- bottom menu -->
				<input type="radio" name="radio-set"  <?php if($_GET['default'] == 1 OR !isset($_GET['default'])) echo 'checked="checked"';?> id="st-control-1"/>
				<a href="#st-panel-1">Sites Map</a>
				<input type="radio" name="radio-set" <?php if($_GET['default'] == 2) echo 'checked="checked"';?> id="st-control-2"/>
				<a href="#st-panel-2">Sites Table</a>
				<input type="radio" name="radio-set" <?php if($_GET['default'] == 3) echo 'checked="checked"';?> id="st-control-3"/>
				<a href="#st-panel-3">Trend Analysis</a>
				<input type="radio" name="radio-set" <?php if($_GET['default'] == 4) echo 'checked="checked"';?> id="st-control-4"/>
				<a href="#st-panel-4">Cairo & Giza Map</a>
				<input type="radio" name="radio-set" <?php if($_GET['default'] == 5) echo 'checked="checked"';?> id="st-control-5"/>
				<a href="#st-panel-5">Governates Map</a>
				
				<div class="st-scroll">
				
					<!-- Placeholder text from http://hipsteripsum.me/ -->
					
					<section class="st-panel st-color" id="st-panel-1">
						<div class="st-deco" data-icon="7"></div>
						<h2>2G                    3G</h2>
						<!--p>Banksy adipisicing eiusmod banh mi sed. Squid stumptown est odd future nisi, commodo mlkshk pop-up adipisicing retro.</p-->
							<table align=center>
								<tr colspan=2 height=130px width=100%><td></td></tr>
								<tr>
									<td><iframe src="Rego.php?type=2G" frameborder=0 scrolling=no width="800px" height="500px"></iframe></td>
									<td><iframe src="Rego.php?type=3G" frameborder=0 scrolling=no width="800px" height="500px"></iframe></td>
								</tr>

								<tr>
								<td></td>
								<td align=center><a href="../SLA/index.php" target="_blank"><button>SLA Dashboard</button></a></iframe></td>
								</tr>

								<tr>
									<td rowspan=5 valign=top height=110px width=75%><iframe src="Rego_Summary.php" frameborder=0 scrolling=no width="100%" height="120px"></iframe></td>
									<td align=center><a href="SDS_Search.php" target="_blank"><button>Search Sites</button></a></iframe></td>
									
								</tr>
								<tr>
									<td align=center><a href="SDS_Search_By_Node.php" target="_blank"><button>Search By Node</button></a></iframe></td>
									
								</tr>
								<!--tr valign=top>
									<td align=center><a href="SDS_nonTTed.php" target="_blank"><button>View nonTTed Sites</button></a></iframe></td>
								</tr-->
								<tr valign=top>
									<td align=center><a href="SDS_nonTTed_interactive.php" target="_blank"><button>nonTTed Down Sites</button></a></iframe></td>
								</tr>
								<tr valign=top>
									
									<td align=center><a href="SDS_cellTask.php" target="_blank"><button>View Cell Tasks</button></a></td>
								</tr>
								<tr valign=top>
									<td align=center><a href="SDS_Telecom.php" target="_blank"><button>Telecom Down Sites</button></a></iframe></td>
								</tr>
								<tr valign=top>
									
									<td align=center><a href="SDS_Generator.php" target="_blank"><button>Generator Power Down Sites</button></a></td>
								</tr>
							</table>
					</section>
					<section class="st-panel st-color" id="st-panel-2">
						<div class="st-deco" data-icon="5"></div>
						<!--p>Analyze the reqional scattered down sites</p-->
						<table align=center>
							<tr colspan=3 height=150px width=100%><td></td></tr>
							<tr>
								<td valign=top><iframe src="Rego_Table.php?region=Cairo_West" frameborder=0 scrolling=no width="270px" height="800px"></iframe></td>
								<td valign=top><table><tr><td><iframe src="Rego_Table.php?region=Giza" frameborder=0 scrolling=no width="270px" height="380px"></iframe></td></tr>
										<tr><td><iframe src="Rego_Table.php?region=Cairo_East" frameborder=0 scrolling=no width="270px" height="400px"></iframe></td></tr>
								</table></td>
								<td valign=top><table><tr><td><iframe src="Rego_Table.php?region=Alexandria" frameborder=0 scrolling=no width="250px" height="300px"></iframe></td></tr>
										<tr><td><iframe src="Rego_Table.php?region=Canal_Sinai" frameborder=0 scrolling=no width="250px" height="400px"></iframe></td></tr>
								</table></td>
								<td valign=top ><iframe src="Rego_Table.php?region=Canal_Red" frameborder=0 scrolling=no width="270px" height="800px"></iframe></td>
								<td valign=top ><iframe src="Rego_Table.php?region=Delta" frameborder=0 scrolling=no width="260px" height="800px"></iframe></td>
								<td valign=top ><iframe src="Rego_Table.php?region=Upper" frameborder=0 scrolling=no width="250px" height="800px"></iframe></td>
							</tr>
						</table>
					</section>
					<section class="st-panel st-color" id="st-panel-3">
						<div class="st-deco" data-icon="5"></div>
						<!--h2>Sites Map</h2-->
						<!--p>Banksy adipisicing eiusmod banh mi sed. Squid stumptown est odd future nisi, commodo mlkshk pop-up adipisicing retro.</p-->
							<table align=left>
								<tr height=130px width=100%><td></td></tr>
								<tr>
									<!--td colspan=4><iframe src="Rego_Table_file.php" frameborder=0 scrolling=no width="100%" height="50px"></iframe></td-->
								</tr>
								<tr>
									<td colspan=4 valign="bottom"><iframe src="Report_SDScolumn.php" frameborder=0 scrolling=no width="1250px" height="250px"></iframe></td>							
								</tr>
								<tr>
									<!--td><iframe src="Report_RegionPie.php" frameborder=0 scrolling=no width="300px" height="500px"></iframe></td-->
									<td><iframe src="Report_RegionPie_Telecom.php" frameborder=0 scrolling=no width="300px" height="500px"></iframe></td>
									<td><iframe src="Report_PriorityPie.php" frameborder=0 scrolling=no width="300px" height="500px"></iframe></td>
									<td><iframe src="Report_TeamPie.php" frameborder=0 scrolling=no width="350px" height="500px"></iframe></td>
									<td><iframe src="Report_TierPie.php" frameborder=0 scrolling=no width="300px" height="500px"></iframe></td>
									<td><iframe src="Report_DownDaysPie.php?days=30" frameborder=0 width="330px" height="500px"></iframe></td>
								</tr>
							</table>
					</section>
					<section class="st-panel st-color" id="st-panel-4">
						<div class="st-deco" data-icon="5"></div>
						<!--h2>Sites Map</h2-->
						<!--p>Banksy adipisicing eiusmod banh mi sed. Squid stumptown est odd future nisi, commodo mlkshk pop-up adipisicing retro.</p-->
							<table align=center>
								<tr height=100px width=100%><td></td></tr>
								<tr>
									<!--td valign=left><iframe src="Rego_Giza.php?type=2G" frameborder=0 scrolling=no width="2000px" height="1000px"></iframe></td-->
									<!--td valign=right><iframe src="Rego_Giza.php" frameborder=0 scrolling=no width="2000px" height="1000px"></iframe></td-->
									<td valign=center><iframe src="Rego_Giza_Map2.php" frameborder=0 scrolling=no width="1400px" height="1000px"></iframe></td>
								</tr>
							</table>
					</section>
					<section class="st-panel st-color" id="st-panel-5">
						<div class="st-deco" data-icon="5"></div>
						<!--h2>Sites Map</h2-->
						<!--p>Banksy adipisicing eiusmod banh mi sed. Squid stumptown est odd future nisi, commodo mlkshk pop-up adipisicing retro.</p-->
							<h2>2G                    3G</h2>
						<!--p>Banksy adipisicing eiusmod banh mi sed. Squid stumptown est odd future nisi, commodo mlkshk pop-up adipisicing retro.</p-->
							<table align=center>
								<tr colspan=3 height=150px width=100%><td></td></tr>
								<tr>
									<td><iframe src="Rego_Gov.php?type=2G" frameborder=0 scrolling=no width="800px" height="500px"></iframe></td>
									<td><iframe src="Rego_Gov.php?type=3G" frameborder=0 scrolling=no width="800px" height="500px"></iframe></td>
								</tr>
								<tr>
									<td colspan=2>
									<table><tr>
										<td><iframe src="Rego_ShortTable.php?region=Cairo" frameborder=0 scrolling=no width="100%" height="300px"></iframe></td>
										<td><table><tr><td><iframe src="Rego_ShortTable.php?region=Giza" frameborder=0 scrolling=no width="100%" height="200px"></iframe></td></tr>
													<tr><td><iframe src="Rego_ShortTable.php?region=Alex" frameborder=0 scrolling=no width="100%" height="100px"></iframe></td></tr></table>
										</td>
										<td><iframe src="Rego_ShortTable.php?region=Canal_Red" frameborder=0 scrolling=no width="100%" height="300px"></iframe></td>
										<td><iframe src="Rego_ShortTable.php?region=Canal_Sinai" frameborder=0 scrolling=no width="100%" height="300px"></iframe></td>
										<td><iframe src="Rego_ShortTable.php?region=Delta" frameborder=0 scrolling=no width="120%" height="300px"></iframe></td>
										<td><iframe src="Rego_ShortTable.php?region=Upper" frameborder=0 scrolling=no width="100%" height="300px"></iframe></td>
									</tr>
									</table>
									</td>
								</tr>
							</table>
					</section>
					

				</div><!-- // st-scroll -->
				
			</div><!-- // st-container -->
        </div>
	</body>
</html>
<?php
	}
	else echo "<h1>Your Browser Version is not supported, please use <a href='https://www.google.com/intl/en/chrome/'>Google Chrome.</a></h1>";
?>