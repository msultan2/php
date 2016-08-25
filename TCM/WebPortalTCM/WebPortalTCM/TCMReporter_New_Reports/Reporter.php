<?php include ("templateReporter.php"); ?>
<div class="body_text">Number of Normal Change Requests in each level of Impact, Urgency and Risk</div>
     <div class="body_banner_area">
<?php
/* Specify the server and connection string attributes. */
		$serverName = "egoct-wirws01"; //10.230.95.87
		$connectionInfo = array( "Database"=>"SM_Change_Researching_DB");

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
?>
<table align=center>
	<tr>
		<td><iframe id="content" width=360 height=260 seamless
			src="Reporter1.php">
		  <p>Your browser does not support iframes. Please upgrade to
			 <a href="http://getfirefox.com">a modern browser</a>.</p>
			</iframe>
		</td>
		<td>
			<iframe id="content" width=360 height=260 seamless
				src="Report_Urgency.php">
		  <p>Your browser does not support iframes. Please upgrade to
			 <a href="http://getfirefox.com">a modern browser</a>.</p>
			</iframe>
		</td>
	</tr>
	<tr>
		<td valign=top width=100%>
			<?php
				$sql = "SELECT CRQ_TYPE,count(*) CRQnum FROM dbo.vw_Change_Approval_Details GROUP BY CRQ_TYPE ORDER BY CRQnum DESC;";
				$stmt = sqlsrv_query( $conn, $sql );
				if( $stmt === false) {
					die( print_r( sqlsrv_errors(), true) );
				}
				echo "<table class=mytable border=1 width=100%>
						<tr><th>Change Type</th><th width=50%>Number of CRQs</th></tr>";
				while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
					echo "<tr><td>".$row['CRQ_TYPE']."</td><td>".$row['CRQnum']."</td></tr>";
				}
				echo "</table>";
				sqlsrv_free_stmt( $stmt);
			?>
		</td>
		<td width=100%>
			<?php
				$sql = "SELECT Urgency,count(*) CRQnum FROM dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Normal' GROUP BY Urgency ORDER BY Urgency;";
				$stmt = sqlsrv_query( $conn, $sql );
				if( $stmt === false) {
					die( print_r( sqlsrv_errors(), true) );
				}
				echo "<table class=mytable border=1 width=100%>
						<tr><th>Urgency Level</th><th width=50%>Number of CRQs</th></tr>";
				while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
					echo "<tr><td width=100>".$row['Urgency']."</td><td>".$row['CRQnum']."</td></tr>";
				}
				echo "</table>";
				sqlsrv_free_stmt( $stmt);
			?>
		</td>
	</tr>
	<tr>
		<td>
		<iframe id="content" width=360 height=260 seamless src="Report_Impact.php">
		  <p>Your browser does not support iframes. Please upgrade to
			 <a href="http://getfirefox.com">a modern browser</a>.</p>
		</iframe>
		</td>
		<td>
		<iframe id="content" width=360 height=260 seamless src="Report_Impact_Details.php">
		  <p>Your browser does not support iframes. Please upgrade to
			 <a href="http://getfirefox.com">a modern browser</a>.</p>
		</iframe>
		</td>
	</tr>
	<tr>
		<td valign=top>
			<?php
				$sql = "SELECT Impact,count(*) CRQnum FROM dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Normal' GROUP BY Impact ORDER BY Impact;";
				$stmt = sqlsrv_query( $conn, $sql );
				if( $stmt === false) {
					die( print_r( sqlsrv_errors(), true) );
				}
				echo "<table class=mytable border=1 width=100%>
						<tr><th>Impact Level </th><th width=50%>Number of CRQs</th></tr>";
				while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
					echo "<tr><td width=80>".$row['Impact']."</td><td>".$row['CRQnum']."</td></tr>";
				}
				echo "</table>";
				sqlsrv_free_stmt( $stmt);
			?>
		</td>
		<td width=100%>
			<?php
				$sql = "WITH Temp_Impacts AS ( SELECT CASE 
					WHEN [External Customer] IS NULL AND [Internal Customer] IS NULL AND [Nodes/Systems] IS NULL AND [Reporting] IS NULL 
					  THEN 'No Impacts'
					WHEN [External Customer] IS NOT NULL  
					  THEN 'Service Impact'
					WHEN [Internal Customer] IS NOT NULL 
					  THEN 'Business Impact'
					WHEN [Nodes/Systems]  IS NOT NULL 
					  THEN 'Technical Impact'
					WHEN [Internal Customer] IS NOT NULL 
					  THEN 'Reporting'  
					ELSE
					  'N/A'
					  END Impact_Detail
				FROM [vw_Change_Approval_Details]
				WHERE CRQ_Type = 'Normal')
				SELECT Impact_Detail,count(*) CRQnum
				FROM Temp_Impacts
				WHERE Impact_Detail <> 'N/A'
				GROUP BY Impact_Detail
				ORDER BY Impact_Detail";
				$stmt = sqlsrv_query( $conn, $sql );
				if( $stmt === false) {
					die( print_r( sqlsrv_errors(), true) );
				}
				echo "<table class=mytable border=1 width=100%>
						<tr><th>Impact Details </th><th width=50%>Number of CRQs</th></tr>";
				while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
					echo "<tr><td width=80>".$row['Impact_Detail']."</td><td>".$row['CRQnum']."</td></tr>";
				}
				echo "</table>";
				sqlsrv_free_stmt( $stmt);
			?>
		</td>
	</tr>
</table>
<?php
	sqlsrv_free_stmt( $stmt);
	// Close the connection.
	sqlsrv_close( $conn );
?>
<?php //include ("footer.php"); ?>