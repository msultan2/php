<?php include ("template.php"); ?>
<SCRIPT language=JavaScript>

function SelectProductType(){
// ON selection of category this function will work

//alert('hello'+document.CSR_form.vendor.value);
removeAllOptions(document.CSR_form.productType);
//addOption(document.CSR_form.productType, "", "productType", "");

if(document.CSR_form.vendor.value == 'Ericsson'){
addOption(document.CSR_form.productType,"Tellabs 8100", "Tellabs 8100");
addOption(document.CSR_form.productType,"Tellabs 8600", "Tellabs 8600");
addOption(document.CSR_form.productType,"Tellabs 6300", "Tellabs 6300");
addOption(document.CSR_form.productType,"E// MW (Legacy)","E// MW (Legacy)");
addOption(document.CSR_form.productType,"E// BEP 2.0","E// BEP 2.0");
}
if(document.CSR_form.vendor.value == 'Huawei'){
addOption(document.CSR_form.productType,"Huawei RTN", "Huawei RTN");
addOption(document.CSR_form.productType,"Huawei OSN", "Huawei OSN");
addOption(document.CSR_form.productType,"Huawei PTN", "Huawei PTN");
}
if(document.CSR_form.vendor.value == 'Alcatel'){
addOption(document.CSR_form.productType,"Alcatel", "Alcatel");
}
if(document.CSR_form.vendor.value == 'SIAE'){
addOption(document.CSR_form.productType,"SIAE", "SIAE");
}
if(document.CSR_form.vendor.value == 'Cisco'){
addOption(document.CSR_form.productType,"Cisco", "Cisco");
}
}
function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		//selectbox.options.remove(i);
		selectbox.remove(i);
	}
}


function addOption(selectbox, value, text )
{
	var optn = document.createElement("OPTION");
	optn.text = text;
	optn.value = value;

	selectbox.options.add(optn);
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
                                    	<form name="CSR_form" action="CSR_Create.php" method="POST">
                                            <fieldset class="col-md-12">
                                                <input id="name" type="text" name="name" placeholder="Problem Title" value="<?php echo $_POST['name']; ?>">
                                            </fieldset>
                                            <fieldset class="col-md-5">
                                                <input type="name" name="type" id="name" placeholder="Problem Type" value="<?php echo $_POST['type']; ?>">
                                            </fieldset>
                                            <fieldset class="col-md-4">
                                                <input type="name" name="CSR_ID" id="name" placeholder="CSR ID" value="<?php echo $_POST['CSR_ID']; ?>">
                                            </fieldset>
											<fieldset class="col-md-3">
											<label style="color:white;">CSR Type
												<select name="CSR_type">
												  <option <?php if ($_POST['CSR_type']==="Problem") echo "selected";?> value="Problem">Problem</option>
												  <option <?php if ($_POST['CSR_type']==="Project") echo "selected";?> value="Project">Project</option>
												  <option <?php if ($_POST['CSR_type']==="Incident") echo "selected";?> value="Incident">Incident</option>
												  <option <?php if ($_POST['CSR_type']==="Other") echo "selected";?> value="Other">Other</option>
												</select>
												</label>
                                            </fieldset>	
											<fieldset class="col-md-5">
                                                <input type="name" name="RMDY_PRB_ID" id="name" placeholder="Related Problem ID" value="<?php echo $_POST['RMDY_PRB_ID']; ?>">
                                            </fieldset>
											<fieldset class="col-md-4">
                                                <input type="name" name="RMDY_INC_ID" id="name" placeholder="Related Incident ID" value="<?php echo $_POST['RMDY_INC_ID']; ?>">
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
												<select name="vendor" onChange="SelectProductType();" >
												  <option value="">Select Vendor</option>
												  <option <?php if ($_POST['vendor']==="Ericsson") echo "selected";?> value="Ericsson">Ericsson</option>
												  <option <?php if ($_POST['vendor']==="Huawei") echo "selected";?> value="Huawei">Huawei</option>
												  <option <?php if ($_POST['vendor']==="Alcatel") echo "selected";?> value="Alcatel">Alcatel</option>
												  <option <?php if ($_POST['vendor']==="SIAE") echo "selected";?> value="SIAE">SIAE</option>
												  <option <?php if ($_POST['vendor']==="Cisco") echo "selected";?> value="Cisco">Cisco</option>
												</select>
												</label>
											<label style="color:white;">Product Type
												<select name="productType" id="productType" onChange="SelectRedirect();">
														<option value="">Select Vendor</option>
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
											  ,[Traffic_Impact]
											  ,[RMDY_PRB_ID]
											  ,[RMDY_INC_ID])
			 VALUES ('".$problemID_str."','".$_POST['CSR_ID']."','".$_POST['name']."','".$_POST['comment']."','".$_POST['CSR_Status']."','".$_POST['vendor']."','".$_POST['productType']."','".$_POST['Severity']."','".$_POST['CSR_type']."','not me','teamy','".date('m/d/Y H:i:s')."','".$_POST['startDate']."','".$_POST['endDate']."','".$_POST['Impact']."','".$_POST['RMDY_PRB_ID']."','".$_POST['RMDY_INC_ID']."');";
		
		sqlsrv_query( $conn, $sql);
		
		echo "inserted";
		
		sqlsrv_free_stmt( $sql);
		// Close the connection.
		sqlsrv_close( $conn );
	}
?>
<?php include("footer.php"); ?>