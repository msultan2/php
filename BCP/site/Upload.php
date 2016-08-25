<?php
if ($_FILES["file"]["error"] > 0) {
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
} 
else 
{
  echo "Upload: " . $_FILES["file"]["name"] . "<br>";
  echo "Type: " . $_FILES["file"]["type"] . "<br>";
  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";

	if (file_exists("C:/wamp/www/BCP/Uploads/" . $_FILES["file"]["name"])) 
	{
      echo $_FILES["file"]["name"] . " already exists. ";
    } 
	else {
      Copy($_FILES["file"]["tmp_name"],
      "C:/wamp/www/BCP/Uploads/" . $_FILES["file"]["name"]);
      echo "File uploaded successfully";
    }
}
?>