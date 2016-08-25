<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Searching Tool</title>
<meta name="keywords" content="contact redox, red, dark brown, free css templates, web design, CSS, HTML" />
<meta name="description" content="Contact Redox - free CSS templates + free website templates" />
<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="templatemo_header_wrapper">
	<div id="templatemo_header">
    
    	<div id="site_title">
            <h1><a href="index.php">
                <img src="images/slider/TCM logo.png" alt="Work 01" />
               <!--<span>free css template for everyone</span>-->
            </a></h1>
        </div>
        
        <div id="templatemo_menu">
    
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="FAQ.php">FAQ</a></li>
                <li><a href="blog.php">Tutorials</a></li>
                <li><a href="templates.php">CAB Report</a></li>
                <li><a href="contact.php" class="current">Contact Us</a></li>
            </ul>    	
    
    	</div> <!-- end of templatemo_menu -->
        
        <div class="cleaner"></div>
	</div> <!-- end of header -->
    
</div> <!-- end of header_wrapper -->
            
<div id="templatemo_content_wrapper">
	<div id="templatemo_content">


<div id="main_content">
		<h2>Search Remedy CRQs:</h2>
		<div style="height:15px;"></div>
		<table>
			<form action="CRQ_MSSQL.php" name="myForm" method="post">
				<tr>
					<td align=center><h4>CRQ ID: </h4></td>
					<td align=left>
						<input type="text" name="CRQnum" value='<?php echo $_POST['CRQnum'];?>'/>
					</td>
					<td>
						<input type="submit" name="searchCRQ" value="Search" />
					</td>
				</tr>
			</form>		
		</table>
		<div style="height:10px"></div>
<?php
	//This part displays the Search CRQ result
	if (isset($_POST['CRQnum'])) {
	
		$CRQnum = $_POST['CRQnum'];
		if(strlen($CRQnum)!=5 OR !is_numeric($CRQnum)){
			echo "Not a valid number, please enter the last 5 digits in the CRQ Number";
		}
		else{
			
			//phpinfo();
			error_reporting(-1);$conf['error_level'] = 2;ini_set('display_errors', TRUE);ini_set('display_startup_errors', TRUE);
			
			/* Specify the server and connection string attributes. */
			$serverName = "egoct-wirws01"; //10.230.95.87
			$connectionInfo = array( "Database"=>"SM_Change_Researching_DB");

			/* Connect using Windows Authentication. */
			$conn = sqlsrv_connect( $serverName, $connectionInfo);
			if( !$conn ) {
				 echo "Connection could not be established.<br />";
				 die( print_r( sqlsrv_errors(), true));
			}
			$sql = "SELECT CRQ,Requester,Support_Company,Support_Organization,Support_Group_Name,Description,Status,
			CAST(Scheduled_Start_Date AS varchar) Scheduled_Start_Date,CAST(Scheduled_End_Date AS varchar) Scheduled_End_Date,Impact 
			FROM dbo.vw_Change_Approval_Details WHERE CRQ = 'CRQ0000000".$CRQnum."';";
			$stmt = sqlsrv_query( $conn, $sql );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			echo "<table class=blue width=90% align=center >
					<tr>
						<th>CRQ</th>
						<th>Submitter</th>
						<th>Initiator Team</th>
						<th>Scheduled Date</th>
						<th>Description</th>
						<th>Impact</th>
						<th>Urgency</th>
						<th>Change Type</th>
						<th>Status</th>
					</tr>";
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$CRQ = $row['CRQ'];
				$Submitter = $row['Requester'];
				$SupportCompany = $row['Support_Company'];
				$SupportOrganization = $row['Support_Organization'];
				$SupportGroup = $row['Support_Group_Name'];
				$Description = $row['Description'];
				$ProductTier1 = "1";
				$ProductTier2 = "2";
				$ProductTier3 = "3";
				$Urgency = "test";
				$Status = $row['Status'];
				$ScheduledStartDate = $row['Scheduled_Start_Date'];
				$ScheduledEndDate = $row['Scheduled_End_Date'];
				//preg_match('/(?P<x>\d+)-(?P<impact_level>\w+)\/(?P<y>\w+)/', $row['Impact'],$Impact_Exp);
				$Impact = $row['Impact']; //$Impact_Exp[impact_level];
				
				
				echo "<tr>
					<td>".$CRQ."</td>
					<td>".$Submitter."</td>
					<td width=140px><table><tr><td>".$SupportCompany."</td></tr><tr><td>".$SupportOrganization."</td></tr><tr><td>".$SupportGroup."</td></tr></table></td>
					<td width=200px>".$ScheduledStartDate."<br> to <br>".$ScheduledEndDate."</td>
					<td>".$Description."</td>
					<td class=".$Impact.">".$Impact."</td>
					<td>".substr($Urgency,2)."</td>
					<td><table width=100%><tr><td>".$ProductTier1."</td></tr><tr><td>".$ProductTier2."</td></tr><tr><td>".$ProductTier3."</td></tr></table></td>
					<td>".$Status."</td>
				</tr>";
			}

			echo "</table>";		
				
			 
			//else{    
				//echo "No Matches Found"; 
			//} 
			sqlsrv_free_stmt( $stmt);
	
			// Close the connection.
			sqlsrv_close( $conn );
		}
	}
?>
<br>
<h2>Search Remedy CRQs:</h2>

</div>

     <div class="cleaner"></div>     
 </div>
        
    
        </div> <!-- end of sidebar -->

		<div class="cleaner"></div>
	</div> <!-- end of content -->
    
</div> <!-- end of content_wrapper --> 

<div id="templatemo_footer_wrapper">

    <div id="templatemo_footer">

        <ul class="footer_menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="web_design.php">Web Design</a></li>
            <li><a href="blog.php">Blog</a></li>
            <li><a href="templates.php">Portfolio</a></li>
            <li class="last_menu"><a href="contacs.php">Contact Us</a></li>
        </ul>
    
        Copyright © 2048 <a href="#">Your Company Name</a> | 
        Designed by <a href="http://www.templatemo.com" target="_parent">Free CSS Templates</a> | 
        Validate <a href="http://validator.w3.org/check?uri=referer">XHTML</a> &amp; 
        <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>
    
    </div> <!-- end of footer -->  
</div> <!-- end of footer_wrapper -->

</body> 
</html>