<?php include("template.php"); ?>

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-7 connectedSortable">     
                            <!-- Custom tabs (Charts with tabs)-->
                            <div class="nav-tabs-custom">
                                <!-- Tabs within a box -->
                                <ul class="nav nav-tabs pull-right">
                                    <li class="active"><a href="#severity-chart" data-toggle="tab">Customer Value</a></li>
                                    <li><a href="#team-chart" data-toggle="tab">Team</a></li>
                                    <li class="pull-left header"><i class="fa fa-inbox"></i>Services SLA</li>
                                </ul>
                                <div class="tab-content no-padding">
                                    <!-- Morris chart - Sales -->
                                    <div class="chart tab-pane active" id="severity-chart" style="position: relative; height: 370px; width=700px">
										<table><tr align=center><td colspan=2><iframe src="Report_SLA_Services_Guage.php" height=180px width=700px frameborder=0 scrolling=no></iframe></td></tr>
												<!--tr><td colspan=2><iframe src="Report_SLA_Access_Outage.php" height=200px width=700px frameborder=0 scrolling=no></iframe></td></tr-->
												<!--tr><td width=150px>&nbsp;</td>
													<td><iframe src="Report_SLA_Access_Scattered_bkp.php"  height=200px width=550px frameborder=0 scrolling=no></iframe></td></tr-->
											<tr><td width=1px></td>	<td><iframe src="Report_SLA_Services_Warning_bars.php"  height=580px width=700px frameborder=0 scrolling=no></iframe></td></tr>
										</table>
									</div>
                                    <div class="chart tab-pane" id="team-chart" style="position: relative; height: 400px; width=700px;">
										<!--table><tr><td><iframe src="Report_OutagePie_drilldown.php" height=400px width=380px frameborder=0 scrolling=no></iframe></td>
													<td><iframe src="Report_ScatteredPie_drilldown.php" height=400px width=380px frameborder=0 scrolling=no></iframe></td>
										</tr></table-->
										<iframe src="Report_Services_TeamPie_drilldown.php" height=400px width=700px frameborder=0 scrolling=no></iframe>
									</div>
                                </div>
                            </div><!-- /.nav-tabs-custom -->

                            <!-- Chat box -->

                            <!-- TO DO List -->

                            <!-- quick email widget -->
  

                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-5 connectedSortable"> 

                            <!-- Map box -->
							<div class="nav-tabs-custom">
                                <!-- Tabs within a box -->
                                <ul class="nav nav-tabs pull-right">
                                    <li class="active"><a href="#outage-vio" data-toggle="tab">P&P SRs</a></li>
                                    <li><a href="#scatt-vio" data-toggle="tab">Normal SRs</a></li>
                                    <li class="pull-left header"><i class="fa fa-inbox"></i>Team Compliance</li>
                                </ul>
                                <div class="tab-content no-padding">
                                    <!-- Morris chart - Sales -->
                                    <div class="chart tab-pane active" id="outage-vio" style="position: relative; height: 400px;">
										<div><?php include("Report_SLA_Team_Compliance_P&P.php"); ?></div>
									</div>
									<div class="chart tab-pane" id="scatt-vio" style="position: relative; height: 400px;">
										<div><?php include("Report_SLA_Team_Compliance_Services.php"); ?></div>
									</div>
								</div>
                            </div><!-- /.nav-tabs-custom -->
                            <!-- /.box -->
							<!--div class="panel box box-success">
								<div class="box-header">
									<h4 class="box-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
											Outage Details
										</a>
									</h4>
								</div>
								<div id="collapseThree" class="panel-collapse collapse">
									<div class="box-body">
										<?php //$Severity = 'Blue'; echo "<p class=text-$Severity>".$Severity.": ".$data_Val[$Severity]."/".$data_Val_Total[$Severity]."</p>"; ?>
									</div>
								</div>
							</div-->
                            <!-- solid sales graph -->                            

                            <!-- Calendar -->                        
							
                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


<?php include ("footer.php");?>