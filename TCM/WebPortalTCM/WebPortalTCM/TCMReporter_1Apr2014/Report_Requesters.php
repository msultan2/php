<link href="style_new.css" rel="stylesheet" type="text/css" />
<table><tr><td width="90%"><div class="body_text">Number of Normal Changes per Requesters </div></td>
<td align=left >
<?php 
		$sql = "SELECT cap.Requester,cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name,count(normal_cap.CRQ) Normal_CRQs,count(standard_cap.CRQ) Standard_CRQs,count(missingF.CRQ) Missing_Fields_CRQs,count(reqForAuth_cap.CRQ) ReqForAuth_CRQs,count(scheduled_cap.CRQ) Scheduled_CRQs, count(completed_cap.CRQ) Completed_CRQs, count(closed_cap.CRQ) Closed_CRQs,count(otherStatus_cap.CRQ) OtherStatus_CRQs, count(*) Total_CRQs FROM  dbo.vw_Change_Approval_Details cap LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Normal') normal_cap ON cap.CRQ = normal_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Standard') standard_cap ON cap.CRQ = standard_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details ch WHERE Missing_Fields = 0) missingF ON cap.CRQ = missingF.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Status = 'Request For Authorization') reqForAuth_cap ON cap.CRQ = reqForAuth_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Status = 'Scheduled') scheduled_cap ON cap.CRQ = scheduled_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Status = 'Completed') completed_cap ON cap.CRQ = completed_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Status = 'Closed') closed_cap ON cap.CRQ = closed_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Status NOT IN ('Request For Authorization','Scheduled','Completed','Closed')) otherStatus_cap ON cap.CRQ = otherStatus_cap.CRQ GROUP BY cap.Requester,cap.Support_Company, cap.Support_Organization,cap.Support_Group_Name ORDER BY cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name,Requester;";
		$sql_new = "SELECT cap.Requester,cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name,count(normal_cap.CRQ) Normal_CRQs,count(standard_cap.CRQ) Standard_CRQs,count(emergency_cap.CRQ) Emergency_CRQs,count(missingF.CRQ) Missing_Fields_CRQs,count(reqForAuth_cap.CRQ) ReqForAuth_CRQs,count(scheduled_cap.CRQ) Scheduled_CRQs,count(completed_cap.CRQ) Completed_CRQs,count(closed_cap.CRQ) Closed_CRQs,count(otherStatus_cap.CRQ) OtherStatus_CRQs,count(*) Total_CRQs FROM  dbo.vw_Change_Approval_Details cap LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Normal') normal_cap ON cap.CRQ = normal_cap.CRQ LEFT OUTER JOIN (SELECT * FROM dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Standard') standard_cap ON cap.CRQ = standard_cap.CRQ LEFT OUTER JOIN (SELECT * FROM dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Normal' AND ((DATEADD(day, -DATEDIFF(day,0,[First Approval Date]), [First Approval Date]) > '2:00:00 PM' AND dbo.DATEONLY( [First Approval Date]) >= (dbo.DATEONLY( Scheduled_Start_Date) -1) ) OR Emergency=0)) emergency_cap ON cap.CRQ = emergency_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details ch WHERE Missing_Fields = 0) missingF ON cap.CRQ = missingF.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Status = 'Request For Authorization') reqForAuth_cap ON cap.CRQ = reqForAuth_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Status = 'Scheduled') scheduled_cap ON cap.CRQ = scheduled_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Status = 'Completed') completed_cap ON cap.CRQ = completed_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Status = 'Closed') closed_cap ON cap.CRQ = closed_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Status NOT IN ('Request For Authorization','Scheduled','Completed','Closed')) otherStatus_cap ON cap.CRQ = otherStatus_cap.CRQ GROUP BY cap.Requester,cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name ORDER BY cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name,Requester;";
		//$sql = "SELECT cap.Requester,cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name,count(normal_cap.CRQ) Normal_CRQs,count(standard_cap.CRQ) Standard_CRQs,count(*) Total_CRQs FROM  dbo.vw_Change_Approval_Details cap LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Normal') normal_cap ON cap.CRQ = normal_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Standard') standard_cap ON cap.CRQ = standard_cap.CRQ WHERE cap.Status != 'Draft' GROUP BY cap.Requester,cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name ORDER BY cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name,Requester;";
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		//echo $sql;
		echo '<a href="excel.php?name=Requesters&query='.$sql_encoded.'">';
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
		$sql = "SELECT TOP 30 cap.Requester, CASE cap.Support_Company
            	WHEN 'Network Engineering' THEN 'NE'
            	WHEN 'Products & Services Delivery' THEN 'PSD'
            	WHEN 'Service Management' THEN 'SM'
            	WHEN 'Regional Operations' THEN 'ROP'
            	WHEN 'IT Operations' THEN 'ITOP'
            	ELSE 'OTHER' 
            END supp_company,cap.Support_Organization,cap.Support_Group_Name, count(*) CRQnum
					FROM  dbo.vw_Change_Approval_Details cap
					WHERE cap.CRQ_Type = 'Normal'
					--AND cap.Scheduled_Start_Date <= getdate() --AND cap.Scheduled_Start_Date >= '10/1/2012' AND cap.Status != 'Draft' 
					GROUP BY Requester , CASE cap.Support_Company
            	WHEN 'Network Engineering' THEN 'NE'
            	WHEN 'Products & Services Delivery' THEN 'PSD'
            	WHEN 'Service Management' THEN 'SM'
            	WHEN 'Regional Operations' THEN 'ROP'
            	WHEN 'IT Operations' THEN 'ITOP'
            	ELSE 'OTHER' 
            END, cap.Support_Organization,cap.Support_Group_Name
					ORDER BY CRQnum DESC;	";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		$data_dept = array();
		$data_requester = array();
		$data_team = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['Requester']." (".$row['supp_company'].": ".$row['Support_Group_Name'].")");
			array_push($data_requester,$row['Requester']);
			array_push($data_dept,$row['supp_company']);
			array_push($data_team,$row['Support_Group_Name']);
			array_push($data_Val,$row['CRQnum']);
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
			['Requester', 'Dept','Team', 'Number of Changes'],           
			<?php 
				//echo "[";
				for($i=0;$i<count($data_requester); $i++) {             
						echo "['".$data_requester[$i]."','".$data_dept[$i]."','".$data_team[$i]."',".$data_Val[$i]."]"; 
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
		var options = { title: 'Top 30 Requesters'  ,  chartArea:{left:40,top:40,width:"65%",height:"80%"}, //legendTextStyle: {color:'#00FF00'}, //vAxis: {maxValue:3, minValue:1},
						vAxis: { gridlines:{count:10}} ,hAxis: { gridlines:{count:0}}   };          
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td  class="iframe_td"><div id="chart_div" style="width: 700px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>