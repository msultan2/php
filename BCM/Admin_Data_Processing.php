<?php
				
					$Dep = $_GET['Department'];
					$con=mysqli_connect("172.19.10.221","Reader","Reader","BCP");
					if (mysqli_connect_errno())
					{
						echo "Failed to connect to MySQL: " . mysqli_connect_error();
					}
						
					function cleanData(&$str)
					  {
						if($str == 't') $str = 'TRUE';
						if($str == 'f') $str = 'FALSE';
						if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
						  $str = "'$str";
						}
						if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
					  }	
					$filename = "System_data_" . $Dep . "_" . date('Ymd') . ".csv";

					header("Content-Disposition: attachment; filename=\"$filename\"");
					header("Content-Type: text/csv;");
					$out = fopen("php://output", 'w');
					$flag = false;
					$Tresult = mysqli_query($con,"select * from `Employee Details` where Department like '%$Dep%' order by Employee_ID");
					while($Trow = mysqli_fetch_array($Tresult))
					{
					if(!$flag) {
							// display field/column names as first row
								fputcsv($out, array_keys($Trow), ',', '"');
								$flag = true;
					}
					array_walk($Trow, 'cleanData');
						fputcsv($out, array_values($Trow), ',', '"');
					}

					fclose($out);
					exit;
?>