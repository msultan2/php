<?php
$errors = $_FILES["images"]["error"];
//print_r($_FILES["images"]);
foreach ($_FILES["images"]["error"] as $key => $error) {
if ($error == UPLOAD_ERR_OK) {
    $name = $_FILES["images"]["name"][$key];
    //$ext = pathinfo($name, PATHINFO_EXTENSION);
    $name = explode("_", $name);
    $imagename='';
    foreach($name as $letter){
        $imagename .= $letter;
    }
 //print_r ($_FILES["images"]["tmp_name"]) ;
    move_uploaded_file( $_FILES["images"]["tmp_name"][$key], "data/" .  $imagename.".png");

}
}
echo "<h2>Successfully Uploaded Images</h2>";

