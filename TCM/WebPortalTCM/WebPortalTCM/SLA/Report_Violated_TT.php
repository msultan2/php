<?php include("template.php"); ?>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
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
		$sql = "SELECT  Site_ID,TTnumber,CAST(SA_Time AS VARCHAR(50)) SA_Time,TT.Assigned_Team,TT.Chronic_Site,TT.Outage,TT.Site_Grade,Status
				  FROM dbo.tbl_SS_Remedy_TT TT
				  WHERE Outage = 'Yes';";
		$stmt = sqlsrv_query( $conn, $sql );
		
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$i=1;
?>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Violated Outage TTs Report</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
												<th>TT Number</th>
												<th>Site ID</th>
                                                <th>Team</th>
                                                <th>Assigned Date</th>
												<th>Number of Sites</th>
                                                <th>Status</th>
                                                <th>Grade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
												while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
													echo "<tr>";
													echo "<td>".$i++."</td></td>";
													echo "<td>".$row['TTnumber']."</td></td>";
													echo "<td>".$row['Site_ID']."</td></td>";
													echo "<td>".$row['Assigned_Team']."</td></td>";
													echo "<td>".$row['Assigned_Team']."</td></td>";
													echo "<td>".$row['Status']."</td></td>";
													echo "<td>".$row['Status']."</td></td>";
													echo "<td>".$row['Site_ID']."</td></td>";
													echo "</tr>";
												}
												sqlsrv_free_stmt( $stmt);
												sqlsrv_close( $conn ); 
										?>
                                        </tbody>
                                        <!--tfoot>
                                            <tr>
                                                <th>#</th>
												<th>TT Number</th>
												<th>Site ID</th>
                                                <th>Team</th>
                                                <th>Assigned Date</th>
												<th>Number of Sites</th>
                                                <th>Status</th>
                                                <th>Grade</th>
                                            </tr>
                                        </tfoot-->
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="js/AdminLTE/demo.js" type="text/javascript"></script>
        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
		</script>
	</body>
</html>

<?php //include ("footer.php");?>
