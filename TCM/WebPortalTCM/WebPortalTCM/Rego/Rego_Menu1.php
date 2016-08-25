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
								<tr colspan=3 height=130px width=100%><td></td></tr>
								<tr>
									<td><iframe src="Rego.php?type=2G" frameborder=0 scrolling=no width="800px" height="500px"></iframe></td>
									<td><iframe src="Rego.php?type=3G" frameborder=0 scrolling=no width="800px" height="500px"></iframe></td>
								</tr>
								<tr>
									<td valign=top><iframe src="Rego_Table_file.php" frameborder=0 scrolling=no width="100%" height="70px"></iframe></td>
									<td rowspan=2 align=center><a href="SDS_Search.php" target="_blank"><button>Search Site List</button></a></iframe></td>
								</tr>
								<tr valign=top>
									<td colspan=2 valign=top><iframe src="Rego_Remedy_file.php" frameborder=0 scrolling=no width="100%" height="50px"></iframe></td>
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
									<td><iframe src="Report_SDSbar.php" frameborder=0 scrolling=no width="350px" height="250px"></iframe></td>
								</tr>
								<tr>
									<td><iframe src="Report_RegionPie.php" frameborder=0 scrolling=no width="300px" height="500px"></iframe></td>
									<td><iframe src="Report_UrgencyPie.php" frameborder=0 scrolling=no width="300px" height="500px"></iframe></td>
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
									<!--td colspan=2><iframe src="Rego_Table_file.php" frameborder=0 scrolling=no width="100%" height="100px"></iframe></td-->
								</tr>
								<tr>
									<!--td valign=left width=50%><iframe src="Rego_Delta.php?type=2G" frameborder=0 scrolling=no width="700px" height="1000px"></iframe></td-->
									<!--td valign=right><iframe src="Rego_Delta.php?type=3G" frameborder=0 scrolling=no width="2000px" height="1000px"></iframe></td-->
								</tr>
							</table>
					</section>
					

				</div><!-- // st-scroll -->
				
			</div><!-- // st-container -->