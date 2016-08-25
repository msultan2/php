<link href="css/style.css" rel="stylesheet" type="text/css" />

<?php	  
	//error_reporting(-1);
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	$fileName = '//vf-eg.internal.vodafone.com/technology/TM/Service Management/GOOGLE/AAAAA/ALLSS.txt';
	$ScatteredSitesFile = file($fileName);
	if(!file_exists($fileName))
		echo "Cannot read OSS file!!";
	echo "AllSS: ".file_get_contents('//vf-eg.internal.vodafone.com/technology/TM/Service Management/GOOGLE/AAAAA/ALLSS.txt');
	@readfile('//vf-eg.internal.vodafone.com/technology/TM/Service Management/GOOGLE/AAAAA/ALLSS.txt');
	
	$ScatteredSitesDown = array();
	$impactedAreas = array();
	
	$num_SS = count($ScatteredSitesFile);
	echo "<U>Number of SDS: </U><B>".$num_SS."</B>";
	
	echo "fopen: ".fopen("//vf-eg.internal.vodafone.com/technology/TM/Service Management/GOOGLE/AAAAA/ALLSS.txt", "r");
	if (file_exists($fileName) && is_readable ($fileName)) {
		$fh = fopen($fileName, "r");
		$num_SS = count($ScatteredSitesFile);
		echo "<U>Number of SDS: </U><B>".$num_SS."</B>";
		fclose($fh);
	}
	
		for($index=0; $index < $num_SS; $index++){
			//if(strpos($ScatteredSitesFile[$index],$thisDate)){
			list($site_ID,$x,$y,$r_BSC_RNC,$r_site_type,$r_down_date,$r_area,$r_region,$r_lastModified_date,$z)=split(',',$ScatteredSitesFile[$index],10);
			$ScatteredSitesDown[$r_area] = $ScatteredSitesDown[$r_area] + 1;
			
			$dataString = str_replace('"',"",$site_ID).",".$x.",".$y.",".str_replace('"',"",$r_BSC_RNC).",".str_replace('"',"",$r_site_type).",".str_replace('"',"",$r_down_date).",".str_replace('"',"",$r_area).",".str_replace('"',"",$r_region).",".str_replace('"',"",$r_lastModified_date).",".str_replace('"',"",$z);
			echo "line $index: ".$dataString;
			
		}
		echo "<BR><U>Last Number of SDS: </U><B> ".$num_SS."</B>";
		list($site_ID,$x,$y,$r_BSC_RNC,$r_site_type,$r_down_date,$r_area,$r_region,$r_lastModified_date,$z)=split(',',$ScatteredSitesFile[0],10);
		echo "<BR>Loading.. Last Modified: ".str_replace('"',"",$r_lastModified_date);
		
		
?>					