<?php

include ("/jpgraph-3.5.0b1/src/jpgraph.php");
include ("/jpgraph-3.5.0b1/src/jpgraph_pie.php");
include ("/jpgraph-3.5.0b1/src/jpgraph_pie3d.php");
include ("/jpgraph-3.5.0b1/src/jpgraph_bar.php");
include "/connect_to_db.php";

$datef=$_GET['datef'];
$datet=$_GET['datet'];
$chart=$_GET['chart'];

$values=array();
$v2=array();
$new=array();
$other=array();


function separator1000($values) {
    return number_format($values);
}
function separator1000_usd($values) {
    return number_format($values/1000).' K';
}

//////////////////////////////////////////////////////////////start of check on availability
$check="";
$dt=array();
$s2="";
$sql=mysql_query("select distinct(Date) as dates from DUAL_3G where Date between'$datef' and '$datet'");
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
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////dont forget}at the end

$sql=mysql_query("select distinct Date as dates from TWOSIM_3G where Date between '$datef' and '$datet' ");
while($rows=mysql_fetch_array($sql)):
$dates=$rows['dates'];

array_push($new,"$dates");

endwhile;

$c=count($new);
//print_r($new);
$idk=0;
$two=2;
for($i = 0; $i < $c ; $i++)
{
$datei=$new[$i];
//echo "$new[$i]";
$sql=mysql_query("select substr(`Desc`,1,4) as `Desc` , sum(Count) counts from(select `Desc`, Count  from DUAL_3G  where Date='$datei' and (`Desc` like '2 VF%' or `Desc` like '%Number of Dual Handsets in the Network' )) X group by `Desc`");
while($rows=mysql_fetch_array($sql)):
$sup=$rows['Desc'];
$counts=$rows['counts'];
array_push($v2,"$sup");
array_push($values,"$counts");
endwhile;
$l=count($v2)+$idk;
if($l<$two)
{
array_push($v2,"2 VF");
array_push($values,"0");
array_push($other,"$datei");
array_push($other,"$datei");
$idk=$idk +1 ;
$two=$two +2;
}
else{
$two=$two +2;
array_push($other,"$datei");
array_push($other,"$datei");
}
}
//print_r($values);
$data1y=array();
$data2y=array();
$other1=array();
$other2=array();
$v=count($values);
for($i = 0; $i < $v ; $i++) {
if($i % 2 == 0)
{
array_push($data1y,"$values[$i]");
array_push($other1,"$other[$i]");
}
else
{
array_push($data2y,"$values[$i]");
array_push($other2,"$other[$i]");

}
}
//print_r($data1y);
//print_r($data2y);


if ($datet == $datef){
$title="Subscribers using Mobiles supporting Duality on $datef";}
else {
$title="Subscribers using Mobiles supporting Duality between $datef and $datei";
} 

if($chart=='Bar Chart'){

$graph = new Graph(650,650,'auto');
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);

$graph->xaxis->SetTickLabels($other1);
$graph->xaxis->SetLabelAngle(45);
$graph->SetBox(false);
$graph->SetMargin(70,30,70,0);
$graph->ygrid->SetFill(false);

$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

// Create the bar plots
$b1plot = new BarPlot($data1y);
$b2plot = new BarPlot($data2y);

$graph->title->SetFont(FF_ARIAL,FS_BOLD); 
// Create the grouped bar plot
$gbplot = new GroupBarPlot(array($b1plot,$b2plot));
// ...and add it to the graPH
$graph->Add($gbplot);
$graph->title->Set("$title");
$b1plot->value->Show();
$b1plot->value->SetColor("darkred");
$b1plot->value->SetFont(FF_FONT1,FS_BOLD);
//$b1plot->value->SetFormat("%1.2e");
$b1plot->value->SetFormat("%d");
//$b2plot->value->Show();
$b2plot->value->SetColor("darkred");
$b2plot->value->SetFont(FF_FONT1,FS_BOLD);
//$b2plot->value->SetFormat("%1.2e");

$b2plot->SetLegend('2 VF in Same Mobile');
$b1plot->SetLegend('1 VF 1 Other Operator');
$graph->yaxis->SetLabelFormatCallback('separator1000');
$b1plot->value->SetFormatCallback('separator1000_usd');
$b2plot->value->SetFormatCallback('separator1000_usd');
$b1plot->value->Show();
$b2plot->value->Show();
$b1plot->SetColor("white");
//$b1plot->SetFillColor("#cc1111");
$b1plot->SetFillGradient("#cc1111","white",GRAD_LEFT_REFLECTION);
$b2plot->SetColor("white");
//$b2plot->SetFillColor("#1111cc");
$b2plot->SetFillGradient("#1111cc","white",GRAD_LEFT_REFLECTION);

// Display the graph
$graph->Stroke();
}
//remove } if remove check
}
?>