<?php 

		$con=mysqli_connect("172.19.10.221","Reader","Reader","BCP");
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		$filename= "http://egoct-wipsd01/BCP/Uploads/Business.csv";
				
        $file = fopen($filename, "r");
        
		
		$count = 0; 
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {
			  $count++;
			
			if($count>1){  
				mysqli_query($con,"INSERT into Business (ID,Layers,Title,`Rcovery Position`) values ('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]')");
			}
		}
        fclose($file);
        echo 'CSV File has been successfully Imported';
        // header('Location: index.php');

?>