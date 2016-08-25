<?php

 $img = $_POST['imgBase64'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$fileData = base64_decode($img);
//saving
if($_POST['canvasnum']=="canvas1"){
$fileName = 'data/photo.png';
}else if($_POST['canvasnum']=="canvas2"){$fileName = 'data/photo2.png';}
file_put_contents($fileName, $fileData);


?>