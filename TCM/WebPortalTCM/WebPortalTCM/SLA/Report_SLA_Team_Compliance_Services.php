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

<?php
		/* Parse configuration file */
		$ini_array = parse_ini_file("config.ini");
		
		/* Specify the server and connection string attributes. */

		$serverName = $ini_array['SERVER_NAME']; 
		$connectionInfo = array( "UID"=>$ini_array['DB_USER'],
								"PWD"=>$ini_array['DB_PASS'],
								"Database"=>$ini_array['DB_NAME']);

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$sql = "  SELECT TT.Assigned_Group,
						CASE WHEN TT.Assigned_Group IN ('Alex & Delta Access Service FO','Cairo Access Service FO','HU Access Service FO','BEP FO','PTN-RTN FO','Transport FO Datacom','Transport FO Tx')
									THEN 1
								ELSE 2
						END Sort_Order,COUNT(vio.Incident_ID) Violated_TT,COUNT(*) Total_TT
				  FROM dbo.[vw_SS_Remedy_TT_SLA_Assigned_Services] TT
				  LEFT OUTER JOIN dbo.[vw_SS_Remedy_TT_SLA_Assigned_Services_Violated] vio
				  ON TT.Incident_ID = vio.Incident_ID
				  WHERE TT.Assigned_Group IS NOT NULL
				  AND CAST(TT.[Customer Value] AS VARCHAR) NOT IN ('Premium','Platinum')
				  group by TT.Assigned_Group,
						CASE WHEN TT.Assigned_Group IN ('Alex & Delta Access Service FO','Cairo Access Service FO','HU Access Service FO','BEP FO','PTN-RTN FO','Transport FO Datacom','Transport FO Tx')
									THEN 1
								ELSE 2
						END
				  HAVING COUNT(vio.Incident_ID) > 0
				  order by 2,3 DESC;";
		$stmt = sqlsrv_query( $conn, $sql );
		
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		$data_Val_Total = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['Assigned_Group']);
			array_push($data_Val,$row['Violated_TT']);
			array_push($data_Val_Total,$row['Total_TT']);
		}	
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn );
?>

                        <div class="row">
							<div class="col-md-12">
                            <div class="box">
								<div><?php //include("Report_SLA_Team_Compliance.php"); ?></div>
								<div class="box-header">
                                    <h3 class="box-title">Normal Assigned SRs</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 20px">Team</th>
											<th style="width: 20px">Violated SRs</th>
                                            <th style="width: 40px">SLA Compliance</th>
											<th style="width: 15px">Compliance %</th>
                                        </tr>
										<?php for($i=0;$i<count($data_Desc); $i++) {  ?>
                                        <tr>
                                            <td><?php echo $data_Desc[$i]; ?></td>
											<td><?php echo $data_Val[$i]." / ".$data_Val_Total[$i]; ?></td>
											<?php 
													$percent = 100 - round((($data_Val[$i] / $data_Val_Total[$i]) *100),0);
													if($percent >= 75){ $SLA_Class = "success";  $SLA_Val_Class = "green"; }
													else if ($percent < 75 && $percent >=50) { $SLA_Class = "primary"; $SLA_Val_Class = "blue"; }
													else if ($percent < 50 && $percent >=25) { $SLA_Class = "yellow"; $SLA_Val_Class = "yellow"; }
													else if ($percent < 25 && $percent >=0) { $SLA_Class = "danger"; $SLA_Val_Class = "red"; }
											?>
                                            <td>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-<?php echo $SLA_Class; ?>" style="width: <?php echo $percent; ?>%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-<?php echo $SLA_Val_Class; ?>"><?php echo $percent; ?>%</span></td>
                                        </tr>
										<?php } ?>
                                    </table>
                                </div>
							<div class="box-footer no-border">
                                    <div class="row">
                                        <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                                            <input type="text" class="knob" data-readonly="false" value="20" data-width="60" data-height="60" data-fgColor="#39CCCC"/>
                                            <div class="knob-label">Assigned</div>
                                        </div><!-- ./col -->
                                        <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                                            <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60" data-fgColor="#39CCCC"/>
                                            <div class="knob-label">Pending</div>
                                        </div><!-- ./col -->
                                        <div class="col-xs-4 text-center">
                                            <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60" data-fgColor="#39CCCC"/>
                                            <div class="knob-label">Resolved</div>
                                        </div><!-- ./col -->
                                    </div><!-- /.row -->
                                </div><!-- /.box-footer -->
							</div>
							</div>
							</div>
							<!-- /.box-body -->
                                <!--div class="box-footer clearfix">
                                    <ul class="pagination pagination-sm no-margin pull-right">
                                        <li><a href="#">&laquo;</a></li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">&raquo;</a></li>
                                    </ul>
                                </div-->
                            