<link href="style_new.css" rel="stylesheet" type="text/css" />
<table><tr><td><div class="body_text">Normal Changes per Requesting Teams </div></td>
<td align=right >
<?php 
		//$sql = "SELECT cap.Requester,ISNULL(ap.Approver_Name,LTRIM(cap.[First On Behalf of])) Manager,cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name,count(normal_cap.CRQ) Normal_CRQs, count(standard_cap.CRQ) Standard_CRQs, count(reqForAuth_cap.CRQ) ReqForAuth_CRQs,count(scheduled_cap.CRQ) Scheduled_CRQs, count(completed_cap.CRQ) Completed_CRQs, count(closed_cap.CRQ) Closed_CRQs,count(otherStatus_cap.CRQ) OtherStatus_CRQs, count(*) Total_CRQs FROM  dbo.vw_Change_Approval_Details cap LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Normal') normal_cap ON cap.CRQ = normal_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Standard') standard_cap ON cap.CRQ = standard_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Status = 'Request For Authorization') reqForAuth_cap ON cap.CRQ = reqForAuth_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Status = 'Scheduled') scheduled_cap ON cap.CRQ = scheduled_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Status = 'Completed') completed_cap ON cap.CRQ = completed_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Status = 'Closed') closed_cap ON cap.CRQ = closed_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE Status NOT IN ('Request For Authorization','Scheduled','Completed','Closed')) otherStatus_cap ON cap.CRQ = otherStatus_cap.CRQ LEFT OUTER JOIN dbo.tbl_Change_LK_Approvers ap ON LOWER(CASE cap.[First On Behalf of] WHEN 'Approved' THEN cap.[First Approver] WHEN 'Rejected' THEN cap.[First Approver] ELSE LTRIM(cap.[First On Behalf of]) END) = LOWER(ap.Approver_Alias) WHERE cap.Status != 'Draft' GROUP BY cap.Requester , ISNULL(ap.Approver_Name,LTRIM(cap.[First On Behalf of])),cap.Support_Company, cap.Support_Organization,cap.Support_Group_Name ORDER BY cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name,Requester;";
		$sql = "SELECT cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name,count(normal_cap.CRQ) Normal_CRQs,count(standard_cap.CRQ) Standard_CRQs,count(*) Total_CRQs FROM  dbo.vw_Change_Approval_Details cap LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Normal') normal_cap ON cap.CRQ = normal_cap.CRQ LEFT OUTER JOIN (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Standard') standard_cap ON cap.CRQ = standard_cap.CRQ WHERE cap.Status != 'Draft' GROUP BY cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name ORDER BY cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name;";
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		//echo $sql;
		echo '<a href="excel.php?name=RequesterTeam&query='.$sql_encoded.'">';
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
		$sql0 = "SELECT TOP 10  CASE cap.Support_Company
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
					GROUP BY  CASE cap.Support_Company
            	WHEN 'Network Engineering' THEN 'NE'
            	WHEN 'Products & Services Delivery' THEN 'PSD'
            	WHEN 'Service Management' THEN 'SM'
            	WHEN 'Regional Operations' THEN 'ROP'
            	WHEN 'IT Operations' THEN 'ITOP'
            	ELSE 'OTHER' 
            END, cap.Support_Organization,cap.Support_Group_Name
					ORDER BY CRQnum DESC;	";
					
		$sql = "SELECT TOP 10  CASE cap.Support_Company
						WHEN 'Network Engineering' THEN 'NE'
						WHEN 'Products & Services Delivery' THEN 'PSD'
						WHEN 'Service Management' THEN 'SM'
						WHEN 'Regional Operations' THEN 'ROP'
						WHEN 'IT Operations' THEN 'ITOP'
						ELSE 'OTHER' 
					END supp_company,cap.Support_Organization,cap.Support_Group_Name,count(normal_cap.CRQ) Normal_CRQs,count(emergency_cap.CRQ) Emergency_CRQs
				FROM  dbo.vw_Change_Approval_Details cap LEFT OUTER JOIN 
				(SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Normal') normal_cap ON cap.CRQ = normal_cap.CRQ LEFT OUTER JOIN 
				  (SELECT * FROM  dbo.vw_Change_Approval_Details WHERE CRQ_Type = 'Normal'
				  AND STATUS NOT IN ('Draft','Request For Authorization')
								--AND Scheduled_Start_Date >= '10/1/2012'
								AND ( (DATEADD(day, -DATEDIFF(day, 0, [First Approval Date]), [First Approval Date]) > '2:00:00 PM'
								AND dbo.DATEONLY( [First Approval Date]) >= (dbo.DATEONLY( Scheduled_Start_Date) -1) ) 
							OR	Emergency = 0	  )) emergency_cap ON cap.CRQ = emergency_cap.CRQ 
				GROUP BY CASE cap.Support_Company
						WHEN 'Network Engineering' THEN 'NE'
						WHEN 'Products & Services Delivery' THEN 'PSD'
						WHEN 'Service Management' THEN 'SM'
						WHEN 'Regional Operations' THEN 'ROP'
						WHEN 'IT Operations' THEN 'ITOP'
						ELSE 'OTHER' 
					END ,cap.Support_Organization,cap.Support_Group_Name 
				ORDER BY Normal_CRQs DESC;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_comp = array();
		$data_Val = array();
		$data_Val_Emergency = array();
		$data_requester = array();
		$data_team = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_comp,$row['supp_company']);
			//array_push($data_org,$row['Support_Organization']);
			array_push($data_team,$row['Support_Group_Name']);
			array_push($data_Val,$row['Normal_CRQs']);
			array_push($data_Val_Emergency,$row['Emergency_CRQs']);
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
			['Dept','Requesting Team','Normal Changes','Emergency Changes'],                
			<?php 
				for($i=0;$i<count($data_team); $i++) {             
						echo "['".$data_comp[$i]."','".$data_team[$i]."',".$data_Val[$i].",".$data_Val_Emergency[$i]."]"; 
						if ($i<count($data_team)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] ); 
			
		var dataChart = google.visualization.arrayToDataTable([                      
			['Requesting Team', 'Normal Changes','Emergency Changes'],           
			<?php 
				for($i=0;$i<count($data_team); $i++) {             
						echo "['".$data_team[$i]."',".$data_Val[$i].",".$data_Val_Emergency[$i]."]"; 
						if ($i<count($data_team)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] ); 
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});       
		
		//drawPieChart
		var options = { title: 'Top 10 Requesting Teams'  ,  chartArea:{left:40,top:40,width:"70%",height:"70%"}, //legendTextStyle: {color:'#00FF00'}, //vAxis: {maxValue:3, minValue:1},
						vAxis: { gridlines:{count:10}} , is3D:true, 'isStacked':true };          
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td  class="iframe_td"><div id="chart_div" style="width: 600px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>