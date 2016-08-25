<?php
 $img = $_POST['imgBase64'];
                    
$img = str_replace('data:application/vnd.ms-excel;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$fileData = base64_decode($img);
//saving
if($_POST['canvasnum']=="canvas1"){
$fileName = 'data/'.$_POST['crq'].'impactedSitesPerBSC.jpg';
}else if($_POST['canvasnum']=="canvas2"){
$fileName = 'data/'.$_POST['crq'].'impactedareaPercentage.jpg';
}else if($_POST['canvasnum']=="canvas3"){
$fileName = 'data/'.$_POST['crq'].'table1.jpg';
}else if($_POST['canvasnum']=="canvas4"){
$fileName = 'data/'.$_POST['crq'].'table2.jpg';
}else if($_POST['canvasnum']=="canvas5"){
$fileName = 'data/'.$_POST['crq'].'ListOfSites.jpg';
}else if($_POST['canvasnum']=="canvas6"){
$fileName = 'data/'.$_POST['crq'].'Sites.xls';
}
file_put_contents($fileName, $fileData);


?>