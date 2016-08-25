<?php

$file = fopen("contacts.csv","w");
$con=mysqli_connect("172.19.10.221","Reader","Reader","BCP");
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"select * from `Authorized_Users`");
while($row = mysqli_fetch_array($result))
{
	fputcsv($file,$row);
}

fclose($file); 
?>