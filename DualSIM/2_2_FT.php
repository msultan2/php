<?php

include ("/jpgraph-3.5.0b1/src/jpgraph.php");
include ("/jpgraph-3.5.0b1/src/jpgraph_pie.php");
include ("/jpgraph-3.5.0b1/src/jpgraph_pie3d.php");
include ("/jpgraph-3.5.0b1/src/jpgraph_bar.php");
include "/connect_to_db.php";

$datef=$_GET['datef'];
$datet=$_GET['datet'];
$chart=$_GET['chart'];

function separator1000($values) {
    return number_format($values);
}
function separator1000_usd($values) {
    return number_format($values/1000).'K';
}

$values=array();
$v2=array();
$new=array();
$other=array();

//////////////////////////////////////////////////////////////start of check on availability
$check="";
$dt=array();
$s2="";
$sql=mysql_query("select distinct(Date) as dates from DUAL2 where Date between'$datef' and '$datet'");
while($rows=mysql_fetch_array($sql)):
$dates=$rows['dates'];
array_push($dt,"$dates");
endwhile;
$r=count($dt);
if($r==0){
header("Content-type: image/png"); 
$im = imagecreatefrompng("picture3s.png"); 

$font_a = 3; 
$xpos_a = 40; 
$ypos_a = 90;
$ypos_b = 106; 
$s1="Please, choose an end date greater ";
$s3="than the start date.";

$white = imagecolorallocate($im, 0, 0, 0); 
imagestring($im, $font_a, $xpos_a, $ypos_a, $s1, $white); 
imagestring($im, $font_a, $xpos_a, $ypos_b, $s3, $white); 

imagepng($im);  

}
//start of check
else{


$sql=mysql_query("select distinct Date as dates from DUAL2 where Date between '$datef' and '$datet' ");
while($rows=mysql_fetch_array($sql)):
$dates=$rows['dates'];

array_push($new,"$dates");

endwhile;

$c=count($new);

for($i = 0; $i < $c ; $i++)
{
$datei=$new[$i];

$sql=mysql_query("select Sum(Count) Count, Date from DUAL2 where Date='$datei' group by Date");
while($rows=mysql_fetch_array($sql)):

$counts=$rows['Count'];
array_push($values,"$counts");
endwhile;
}

if ($datet == $datef){
$title="Subscribers swapping 2 Vodafone SIMs using 2 Mobiles on $datef";}
else {
$title="Subscribers swapping 2 Vodafone SIMs using 2 Mobiles between $datef and $datei";
} 

if($chart=='Bar Chart'){
$graph = new Graph(660,400,'auto');
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);
$graph->SetMargin(70,30,50,70);

$graph->SetBox(false);
$graph->xaxis->SetLabelAngle(45);
$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels($new);
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);
$graph->yaxis->SetLabelFormatCallback('separator1000');
$b1plot = new BarPlot($values);

$graph->Add($b1plot);
$b1plot->value->SetFormatCallback('separator1000_usd');
$b1plot->SetWeight(0);
$b1plot->SetFillGradient("#11cccc","midnightblue",GRAD_HOR);
$graph->title->SetFont(FF_ARIAL,FS_BOLD); 
$b1plot->SetWidth(17);
$b1plot->value->Show();
$b1plot->value->SetColor("darkred");
$b1plot->value->SetFont(FF_FONT1,FS_BOLD);
$b1plot->value->SetFormat("%d");
$graph->title->Set("$title");
$graph->title->SetFont(FF_ARIAL,FS_BOLD); 
$graph->Stroke();

}

}
 ?>