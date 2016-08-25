<link href="css/style.css" rel="stylesheet" type="text/css" />

<?php	  
	error_reporting(-1);
		
	$ScatteredSitesDown = array();	
	$i = 0;
	$DB_updated = false;
	while ($i <= 10){
		$fileName = '//vf-eg.internal.vodafone.com/technology/TM/Service Management/SDS/ALLSS_'.date('Ymd_Hi',time() - $i * 60).'.txt';
		if(file_exists($fileName)) {
			$DB_updated = true; 
			$ScatteredSitesFile = file($fileName);
			$num_SS = count($ScatteredSitesFile) - 1;
			list($site_ID,$x,$y,$r_BSC_RNC,$r_site_type,$r_down_date,$r_area,$r_region,$r_lastModified_date,$z)=split(',',$ScatteredSitesFile[$num_SS],10);
			echo "File Already loaded on ".date('d-m-Y H:i',time() - $i * 60).".. last update: ".$r_lastModified_date;
			break;
		}
		$i++;
	}
	//echo "DB_updated = $DB_updated";
	echo "<BR><U>Number of SDS: </U><B>".$num_SS."</B>";
	
	
		
?>					