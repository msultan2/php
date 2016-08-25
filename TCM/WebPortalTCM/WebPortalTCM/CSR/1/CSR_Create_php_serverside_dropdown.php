<?php include ("template.php"); ?>
<SCRIPT language=JavaScript>
function reload(form)
{
var val=form.vendor.options[form.vendor.options.selectedIndex].value;
self.location='CSR_Create.php?page=CSR_new&ven=' + val ;
}

</script>
<?php
@$cat=$_GET['ven']; // Use this line or below line if register_global is off
//if(strlen($cat) > 0 and !is_numeric($cat)){ // to check if $cat is numeric data or not. 
//echo "Data Error";
//exit;
//}
?>
<div id="menu-4" class="contact content">
                        <div class="row">
                        	
                            <div class="col-md-12">
                                <div class="toggle-content text-center spacing">
                                    <h3>New CSR</h3>
                                    <p>Create <strong>New CSR</strong> for your vendor to track your current problem or support needed.</p>
                                </div>
                            </div> <!-- /.col-md-12 -->
                            
                            <div class="col-md-12">
                                <div class="contact-form">
                                    <div class="row">
                                    	<form action="CSR_Create.php" method="POST">
                                            <fieldset class="col-md-12">
                                                <input id="name" type="text" name="name" placeholder="Problem Title" value="<?php echo $_POST['name']; ?>">
                                            </fieldset>
                                            <fieldset class="col-md-8">
                                                <input type="name" name="type" id="name" placeholder="Problem Type" value="<?php echo $_POST['type']; ?>">
                                            </fieldset>
                                            
											<fieldset class="col-md-4">
											<label style="color:white;">CSR Type
												<select name="CSR_type">
												  <option <?php if ($_POST['CSR_type']==="Problem") echo "selected";?> value="Problem">Problem</option>
												  <option <?php if ($_POST['CSR_type']==="Other") echo "selected";?> value="Other">Other</option>
												</select>
												</label>
                                            </fieldset>							
											<fieldset class="col-md-5">
                                                <label style="color:white;" for="startDate"/>Start Date<input id="startDate" type="date" name="startDate"  value="<?php echo $_POST['startDate']; ?>" placeholder="Start Date ">
                                            </fieldset>
                                            <fieldset class="col-md-4">
                                                <label style="color:white;">End Date<input type="date" name="endDate" id="endDate" value="<?php echo $_POST['endDate']; ?>" placeholder="End Date"></label>
                                            </fieldset>
											<fieldset class="col-md-3">
											<label style="color:white;">Traffic Impact
												<select name="Impact">
												  <option <?php if ($_POST['Impact']==="Yes") echo "selected";?> value="Yes">Yes</option>
												  <option <?php if ($_POST['Impact']==="No") echo "selected";?> value="No">No</option>
												</select>
												</label>
                                            </fieldset>	
											<fieldset class="col-md-3">
											<label style="color:white;">CSR Severity
												<select name="Severity">
												  <option <?php if ($_POST['Severity']==="Low") echo "selected";?>  value="Low">Low</option>
												  <option <?php if ($_POST['Severity']==="Medium") echo "selected";?>  value="Medium">Med</option>
												  <option <?php if ($_POST['Severity']==="High") echo "selected";?>  value="High">High</option>
												</select>
												</label>
                                            </fieldset>
											<fieldset class="col-md-3">
											<label style="color:white;">CSR Vendor
												<select name="vendor" onchange="reload(this.form)">
												  <option <?php if ($cat==="Ericsson" OR $_POST['vendor']==="Ericsson") echo "selected";?> value="Ericsson">Ericsson</option>
												  <option <?php if ($cat==="Huawei" OR $_POST['vendor']==="Huawei") echo "selected";?> value="Huawei">Huawei</option>
												  <option <?php if ($cat==="Alcatel" OR $_POST['vendor']==="Alcatel") echo "selected";?> value="Alcatel">Alcatel</option>
												  <option <?php if ($cat==="SIAE" OR $_POST['vendor']==="SIAE") echo "selected";?> value="SIAE">SIAE</option>
												  <option <?php if ($cat==="Cisco" OR $_POST['vendor']==="Cisco") echo "selected";?> value="Cisco">Cisco</option>
												</select>
												</label>
											<label style="color:white;">Product Type
												<select name="productType">
													 <?php if ($cat==="Ericsson" OR $_POST['vendor']==="Ericsson") { ?>
												  <option <?php if ($_POST['productType']==="Tellabs 8100") echo "selected";?> value="Tellabs 8100">Tellabs 8100</option>
												  <option <?php if ($_POST['productType']==="Tellabs 8600") echo "selected";?> value="Tellabs 8600">Tellabs 8600</option>
												  <option <?php if ($_POST['productType']==="Tellabs 6300") echo "selected";?> value="Tellabs 6300">Tellabs 6300</option>
												  <option <?php if ($_POST['productType']==="E// MW (Legacy)") echo "selected";?> value="E// MW (Legacy)">E// MW (Legacy)</option>
												  <option <?php if ($_POST['productType']==="E// BEP 2.0") echo "selected";?> value="E// BEP 2.0">E// BEP 2.0</option>
														<?php } else if ($cat==="Huawei" OR $_POST['vendor']==="Huawei") { ?>
												  <option <?php if ($_POST['productType']==="Huawei RTN") echo "selected";?> value="Huawei RTN">Huawei RTN</option>
												  <option <?php if ($_POST['productType']==="Huawei OSN") echo "selected";?> value="Huawei OSN">Huawei OSN</option>
												  <option <?php if ($_POST['productType']==="Huawei PTN") echo "selected";?> value="Huawei PTN">Huawei PTN</option>
														<?php } else if ($cat==="Alcatel" OR $_POST['vendor']==="Alcatel") { ?>
												  <option <?php if ($_POST['productType']==="Alcatel") echo "selected";?> value="Alcatel">Alcatel</option>
														<?php } else if ($cat==="SIAE" OR $_POST['vendor']==="SIAE") { ?>
												  <option <?php if ($_POST['productType']==="SIAE") echo "selected";?> value="SIAE">SIAE</option>
														<?php } else if ($cat==="Cisco" OR $_POST['vendor']==="Cisco") { ?>
												  <option <?php if ($_POST['productType']==="Cisco") echo "selected";?> value="Cisco">Cisco</option>
														<?php } else {?>
														<option value="">Select Vendor</option>
														<?php } ?>

												</select>
												</label>
                                            </fieldset>
											<!--fieldset class="col-md-4">
											<label style="color:white;">Status
												<select name="CSR_Status">
												  <option value="Analysis">Analysis</option>
												  <option value="Waiting">Analysis, Waiting Customer</option>
												  <option value="Answer">Formal answer provided</option>
												</select>
												</label>
                                            </fieldset-->		
                                            <fieldset class="col-md-12">
                                                <textarea name="comment" id="message" placeholder="Description"><?php echo $_POST['comment']; ?></textarea>
                                            </fieldset>
                                            <fieldset class="col-md-12">
                                                <input type="submit" name="submit" value="Save & Send" id="submit" class="button">
                                            </fieldset>
                                        </form>
                                    </div> <!-- /.row -->
                                </div> <!-- /.contact-form -->
                            </div> <!-- /.col-md-12 -->
                        </div> <!-- /.row -->
                    </div> <!-- /.contact -->
<?php 
	if (isset($_POST['submit'])) {
	
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
			 echo "Connection could not be established.<br />";
			 die( print_r( sqlsrv_errors(), true));
		}
		$CRQ = $_POST['updateCRQ'];
		$if_Auth = intval($_POST['updateAuth']);
		//$new_comment = str_replace("-", " ", $_POST['new_comment']);
	
		$sql_init = "SELECT MAX([Problem_ID]) FROM [SM_Change_Researching_DB].[dbo].[tbl_TX_CSR_CSR]";
		$query = sqlsrv_query($conn, $sql_init);
		if (sqlsrv_fetch($query)=== false){
			die( print_r( sqlsrv_errors(), true));
		}

		$problemID = intval(sqlsrv_get_field( $query, 0));
		echo "before: ".$problemID;
		$problemID ++;
		echo "after: ".$problemID;
		sqlsrv_free_stmt( $sql_init);
		
		if(strlen($problemID) == 0) $problemID_str="00001";
			elseif(strlen($problemID) == 1) $problemID_str="0000".$problemID;
			elseif(strlen($problemID) == 2) $problemID_str="000".$problemID;
			elseif(strlen($problemID) == 3) $problemID_str="00".$problemID;
			elseif(strlen($problemID) == 4) $problemID_str="0".$problemID;
			elseif(strlen($problemID) == 5) $problemID_str=$problemID;
		
		$sql = "INSERT INTO dbo.tbl_TX_CSR_CSR ([Problem_ID]
											  ,[CSR_ID]
											  ,[Name]
											  ,[Description]
											  ,[CSR_Status]
											  ,[CSR_Vendor]
											  ,[CSR_ProductType]
											  ,[CSR_Severity]
											  ,[CSR_Type]
											  ,[Submitter]
											  ,[Team]
											  ,[Submit_Date]
											  ,[Start_Date]
											  ,[End_Date]
											  ,[Traffic_Impact])
			 VALUES ('".$problemID_str."',1234665,'".$_POST['name']."','".$_POST['comment']."','".$_POST['CSR_Status']."','".$_POST['vendor']."','".$_POST['productType']."','".$_POST['Severity']."','".$_POST['CSR_type']."','not me','teamy','".date('m/d/Y H:i:s')."','".$_POST['startDate']."','".$_POST['endDate']."','".$_POST['Impact']."');";
		
		sqlsrv_query( $conn, $sql);
		
		echo "inserted";
		
		sqlsrv_free_stmt( $sql);
		// Close the connection.
		sqlsrv_close( $conn );
	}
?>
<?php include("footer.php"); ?>