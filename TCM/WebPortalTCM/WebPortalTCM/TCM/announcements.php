<?php include ("template.php"); ?>
<head>
<link href="templatemo_style_ann.css" rel="stylesheet" type="text/css" />
<link href="css/jquery.ennui.contentslider.css" rel="stylesheet" type="text/css" media="screen,projection" />
</head>

<body>
<div id="templatemo_wrapper_ann">
	<div id="temmplatmeo_header_ann">
		<div id="templatemo_menu_ann">
        
            <ul>
               
                
                <li><a href="Calendar_PA.php">PA Calenadr</a></li>
				<li><a href="announcements.php" class="current">Freeze Calendar</a></li>
                
            </ul>    	
        
        </div> <!-- end of templatemo_menu -->
    
    </div> <!-- end of templatemo_header -->
    
 <div id="templatemo_banner_ann">
   	<div id="banner_left_ann">
        <b><h3>Annual Freeze Calendar:</h3></b>	

<?php
	//This part displays the resualt
	
			//phpinfo();
			error_reporting(-1);$conf['error_level'] = 2;ini_set('display_errors', TRUE);ini_set('display_startup_errors', TRUE);
			
			/* Specify the server and connection string attributes. */
			$serverName = "egzhr-wie2e01"; //10.230.95.87
			$connectionInfo = array( "Database"=>"SM_Change_Researching_DB");

			/* Connect using Windows Authentication. */
			$conn = sqlsrv_connect( $serverName, $connectionInfo);
			if( !$conn ) {
				 echo "Connection could not be established.<br />";
				 die( print_r( sqlsrv_errors(), true));
			}
			$sql = "SELECT Occasion,[Freeze scope] as FScope,[Freeze period] as FPeriod
			FROM dbo.tbl_Freeze_Calendar" ;
			$stmt = sqlsrv_query( $conn, $sql );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			echo "<table class=blue width=90% align=center >
					<tr>
						<th>Occasion/Event</th>
						<th>Freeze scope</th>
						<th>Freeze period</th>
					</tr>";
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$Occasion = $row['Occasion'];
				$Scope = $row['FScope'];
				$Period = $row['FPeriod'];
				
				echo "<tr>
					<td>".$Occasion."</td>
					<td>".$Scope."</td>
					<td>".$Period."</td>
					
				</tr>";
			}

			{echo "</table>";		
				
			sqlsrv_free_stmt( $stmt);
	
			// Close the connection;
			sqlsrv_close( $conn );
			}
			
?>
   	
	</div>
        
      

		<!-- Site JavaScript -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/jquery.ennui.contentslider.js"></script>
	<script type="text/javascript">
			$(function() {
				$('#one').ContentSlider({
					width : '535px',
					height : '233px',
					speed : 800,
					easing : 'easeInOutQuart'
				});
			});
		</script>
	<script src="js/jquery.chili-2.2.js" type="text/javascript"></script>
	<script src="js/chili/recipes.js" type="text/javascript"></script>

        
      </div>   <!-- end of slider --> 
    </div> <!-- end of templatemo_banner -->
    <!-- end of templatemo_content -->
      
 <!-- end of templatemo_wrapper -->

</body>
</html>

<?php include ("footer.php"); ?>