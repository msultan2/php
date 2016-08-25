<link href="style_new.css" rel="stylesheet" type="text/css" />
<table><tr><td width="90%"><div class="body_text">Requesters of Emergency Changes</div></td>
<td align=left >
<?php 
		$sql_old = "select ch.Requester,ch.Support_Company,ch.Support_Organization,ch.Support_Group_Name,count(*) CRQnum from dbo.vw_Change_Approval_Details ch where Missing_Fields = 0 group by ch.Requester, ch.Support_Company, ch.Support_Organization, ch.Support_Group_Name order by CRQnum DESC;";
		$sql = "select ch.Requester,ch.Support_Company,ch.Support_Organization,ch.Support_Group_Name,count(mf.CRQ) 'Emergency CRQs',count(ch.CRQ) 'Total Normal Changes' FROM  dbo.vw_Change_Approval_Details ch LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Emergency = 0) mf ON ch.CRQ = mf.CRQ WHERE ch.CRQ_Type = 'Normal' group by ch.Requester, ch.Support_Company, ch.Support_Organization, ch.Support_Group_Name order by 5 DESC;";
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		//echo $sql;
		echo '<a href="excel.php?name=Missing_Fields&query='.$sql_encoded.'">';
	?>
<img width=24px height=24px src="images/excel.bmp" style="border-style: none"/></a>
</td></tr></table>
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
		$sql_old = "SELECT cap.Requester, CASE cap.Support_Company
            	WHEN 'Network Engineering' THEN 'NE'
            	WHEN 'Products & Services Delivery' THEN 'PSD'
            	WHEN 'Service Management' THEN 'SM'
            	WHEN 'Regional Operations' THEN 'ROP'
            	WHEN 'IT Operations' THEN 'ITOP'
            	ELSE 'OTHER' 
            END supp_company,cap.Support_Organization,cap.Support_Group_Name, count(*) CRQnum
					FROM  dbo.vw_Change_Approval_Details cap
					WHERE Emergency = 0 --Yes
					GROUP BY Requester , CASE cap.Support_Company
            	WHEN 'Network Engineering' THEN 'NE'
            	WHEN 'Products & Services Delivery' THEN 'PSD'
            	WHEN 'Service Management' THEN 'SM'
            	WHEN 'Regional Operations' THEN 'ROP'
            	WHEN 'IT Operations' THEN 'ITOP'
            	ELSE 'OTHER' 
            END, cap.Support_Organization,cap.Support_Group_Name
					HAVING count(*) > 3
					ORDER BY CRQnum DESC;	";
		
		$sql = "SELECT cap.Requester, CASE cap.Support_Company
						WHEN 'Network Engineering' THEN 'NE'
						WHEN 'Products & Services Delivery' THEN 'PSD'
						WHEN 'Service Management' THEN 'SM'
						WHEN 'Regional Operations' THEN 'ROP'
						WHEN 'IT Operations' THEN 'ITOP'
						ELSE 'OTHER' 
					END supp_company,cap.Support_Organization,cap.Support_Group_Name, count(emrg.CRQ) CRQnum, count(cap.CRQ) Total
				FROM  dbo.vw_Change_Approval_Details cap LEFT OUTER JOIN 
						(SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Emergency = 0) emrg ON cap.CRQ = emrg.CRQ 					
				WHERE cap.CRQ_Type = 'Normal' AND cap.Status != 'Request For Authorization'
				GROUP BY cap.Requester , CASE cap.Support_Company
						WHEN 'Network Engineering' THEN 'NE'
						WHEN 'Products & Services Delivery' THEN 'PSD'
						WHEN 'Service Management' THEN 'SM'
						WHEN 'Regional Operations' THEN 'ROP'
						WHEN 'IT Operations' THEN 'ITOP'
						ELSE 'OTHER' 
					END, cap.Support_Organization,cap.Support_Group_Name
				HAVING count(emrg.CRQ) > 3
				ORDER BY CRQnum DESC;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		$data_Val_total = array();
		$data_dept = array();
		$data_requester = array();
		$data_team = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['Requester']." (".$row['supp_company'].": ".$row['Support_Group_Name'].")");
			array_push($data_requester,$row['Requester']);
			array_push($data_dept,$row['supp_company']);
			array_push($data_team,$row['Support_Group_Name']);
			array_push($data_Val,$row['CRQnum']);
			array_push($data_Val_total,$row['Total']);
		}
		
		sqlsrv_free_stmt( $stmt);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataTable = google.visualization.arrayToDataTable([           
			['Requester', 'Dept','Team', 'Emergency CRQs','Total Normal CRQs'],           
			<?php 
				//echo "[";
				for($i=0;$i<count($data_requester); $i++) {             
						echo "['".$data_requester[$i]."','".$data_dept[$i]."','".$data_team[$i]."',".$data_Val[$i].",".$data_Val_total[$i]."]"; 
						if ($i<count($data_requester)-1) echo ",";	//add ',' to all except last element
					}  
				//echo "]";
			?>
			] ); 
			
		var dataChart = google.visualization.arrayToDataTable([                      
			<?php 
				echo "['dummy',";
				for($i=0;$i<count($data_Desc); $i++) {             
						echo "'".$data_Desc[$i]."'";
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
				}
				echo "],[2,";
				for($i=0;$i<count($data_Desc); $i++) {             
						echo $data_Val[$i]; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
				}
				echo "]";
			?>
			] ); 
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});       
		
		//drawPieChart
		var options = { title: 'Requesters of Emergency CRQs (more than 3 times)'  ,  chartArea:{left:40,top:40,width:"55%",height:"80%"} //legendTextStyle: {color:'#00FF00'}, //vAxis: {maxValue:3, minValue:1}
						//,vAxis: { gridlines:{count:10}} 
						,hAxis: { gridlines:{count:0}}   };          
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td  class="iframe_td"><div id="chart_div" style="width: 900px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" style="width: 900px;"></div></td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>