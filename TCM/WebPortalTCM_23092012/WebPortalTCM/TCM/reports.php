<?php include ("template.php"); ?>
<div id="content_gal">
	<div class="row">
		<div class="box_img2">
			<h4>Create CR:</h4>
			<a href="#" class="preview" title="Create Change Request"><img src="images/img33.jpg" alt="" /></a>
			<div style="height:15px;"></div>
			How to initiate a new change request
		</div>
		<div class="box_razd"></div>
		<div class="box_img2">
			<h4>Close CR:</h4>
			<a href="#" class="preview" title="Close Change Request"><img src="images/img35.jpg" alt="" /></a>
			<div style="height:15px;"></div>
			How to close a change request
		</div>
		<div class="box_razd"></div>
		<div class="box_img2">
			<h4>Approve CR:</h4>
			<a href="#" class="preview" title="Approve Change Request"><img src="images/img34.jpg" alt="" /></a>
			<div style="height:15px;"></div>
			How to approve a change request
		</div>
	</div>
	<div style="height:20px;"></div>
	<div style="clear: both"></div>
</div>
<?php
	#$serverName = "serverName\sqlexpress";
	$connectionInfo = array("Database"=>"dbName","UID"=>"userName","PWD"=>"password","ReturnDatesAsStrings"=>true);
	$conn = sqlsrv_connect("10.0.0.1",$connectionInfo);
	###########################################
	if(!$conn){
		$errors=sqlsrv_errors();
		die(var_dump(($errors));
	}
	
	/* Get products by querying against the product name.*/  
	$tsql = "SELECT ProductID, Name, Color, Size, ListPrice FROM Production.Product"; 

	/* Execute the query. */  
	$getProducts = sqlsrv_query( $conn, $tsql ); 

	/* Loop thru recordset and display each record. */  
	while( $row = sqlsrv_fetch_array( $getProducts, SQLSRV_FETCH_ASSOC ) )  
	{	  
		print_r( $row );  
	} 

  /* Free the statement and connection resource. */ 
  sqlsrv_free_stmt( $getProducts ); 
  sqlsrv_close( $conn ); 

	die('connected');
	###########################################
	if(function_exists('sqlsrv_connect')){
		echo "connection functions are available";
	}else{
		echo "connection functions are not available";
	}
	###########################################
	if($conn === FALSE) {    
		echo 'Could not connect';    
		die('Could not connect: ' . sqlsrv_errors(SQLSRV_ERR_ALL));
	}
	echo 'Successful connection';
	sqlsrv_close($link);
	###########################################
?>
<?php include ("footer.php"); ?>
				