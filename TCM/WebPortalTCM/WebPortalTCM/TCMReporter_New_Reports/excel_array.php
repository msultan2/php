<?php
	function cleanData(&$str)
	  {
		if($str == 't') $str = 'TRUE';
		if($str == 'f') $str = 'FALSE';
		if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
		  $str = "'$str";
		}
		if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
	  }

	$report_name=$_GET['name'];
	$data= array();
	$data[0] = array();
	$data[0] = explode(",",$_GET['array']);
	
	 // filename for download
	$filename = "Veto_data_".$report_name."_"	. date('Ymd') . ".csv";

	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: text/csv;");

	$out = fopen("php://output", 'w');

	
	
	for ($row = 0; $row < count($data); $row++)
	{
		//for ($col = 0; $col < 6; $col++)
		//	echo $data[$row][$col]." ";
		array_walk($data[$row], 'cleanData');
		fputcsv($out, array_values($data[$row]), ',', '"');
	}

  fclose($out);
  exit;
?>