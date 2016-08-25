<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <title>Rego Monitor</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="CSS-only Responsive Layout with Smooth Transitions" />
        <meta name="keywords" content="css3, transitions, animations, css-only, navigation, smooth scrolling, full width, full height, window width, window height" />
        <meta name="author" content="Codrops" />
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
                    <strong>Regions and Sub-Regions </strong>Scattered sites Monitoring & Analysis
                </a>
                <span class="right">
                    <a href="http://tympanus.net/codrops/2012/06/12/css-only-responsive-layout-with-smooth-transitions/">
                        <!--strong>Back to the Codrops Article</strong-->
                    </a>
                </span>
                <div class="clr"></div>
            </div><!--/ Codrops top bar -->
			
			<div class="st-container">
			<!-- bottom menu -->
				<input type="radio" name="radio-set" id="st-control-2"/>
				<a href="#st-panel-2">Sites Map</a>
				<input type="radio" name="radio-set" checked="checked" id="st-control-1"/>
				<a href="#st-panel-1">Scattered Sites</a>
				<input type="radio" name="radio-set" id="st-control-3"/>
				<a href="#st-panel-3">Cairo Map</a>
				<input type="radio" name="radio-set" id="st-control-4"/>
				<a href="#st-panel-4">Giza Map</a>
				<input type="radio" name="radio-set" id="st-control-5"/>
				<a href="#st-panel-5">Delta Map</a>
				
				<div class="st-scroll">
				
					<!-- Placeholder text from http://hipsteripsum.me/ -->
					
					
					
					<section class="st-panel st-color" id="st-panel-1">
						<div class="st-deco" data-icon="7"></div>
						<h2>Scattered Sites</h2>
						<p>Analyze the reqional scattered down sites</p>
					</section>
					<section class="st-panel" id="st-panel-2">
						<div class="st-deco" data-icon="5"></div>
						<!--h2>Sites Map</h2-->
						<!--p>Banksy adipisicing eiusmod banh mi sed. Squid stumptown est odd future nisi, commodo mlkshk pop-up adipisicing retro.</p-->
							<table align=center>
								<tr height=150px width=100%><td></td></tr>
								<tr>
									<td valign=center><iframe src="Rego.php" frameborder=0 scrolling=no width="800px" height="500px"></iframe></td>
								</tr>
							</table>
					</section>
					<section class="st-panel" id="st-panel-3">
						<div class="st-deco" data-icon="5"></div>
						<!--h2>Sites Map</h2-->
						<!--p>Banksy adipisicing eiusmod banh mi sed. Squid stumptown est odd future nisi, commodo mlkshk pop-up adipisicing retro.</p-->
							<table align=left>
								<tr height=150px width=100%><td></td></tr>
								<tr>
									<td valign=left><iframe src="Rego_Cairo.php" frameborder=0 scrolling=no width="3000px" height="700px"></iframe></td>
								</tr>
							</table>
					</section>
					<section class="st-panel" id="st-panel-4">
						<div class="st-deco" data-icon="5"></div>
						<!--h2>Sites Map</h2-->
						<!--p>Banksy adipisicing eiusmod banh mi sed. Squid stumptown est odd future nisi, commodo mlkshk pop-up adipisicing retro.</p-->
							<table align=center>
								<tr height=150px width=100%><td></td></tr>
								<tr>
									<td valign=center><iframe src="Rego_Giza.php" frameborder=0 scrolling=no width="2000px" height="1000px"></iframe></td>
								</tr>
							</table>
					</section>
					<section class="st-panel" id="st-panel-5">
						<div class="st-deco" data-icon="5"></div>
						<!--h2>Sites Map</h2-->
						<!--p>Banksy adipisicing eiusmod banh mi sed. Squid stumptown est odd future nisi, commodo mlkshk pop-up adipisicing retro.</p-->
							<table align=center>
								<tr height=150px width=100%><td></td></tr>
								<tr>
									<td valign=center><iframe src="Rego_Delta.php" frameborder=0 scrolling=no width="2000px" height="1000px"></iframe></td>
								</tr>
							</table>
					</section>
					

				</div><!-- // st-scroll -->
				
			</div><!-- // st-container -->
			
        </div>
	</body>
</html>