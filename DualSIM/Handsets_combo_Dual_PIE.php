<?php

include ("/jpgraph-3.5.0b1/src/jpgraph.php");
include ("/jpgraph-3.5.0b1/src/jpgraph_pie.php");
include ("/jpgraph-3.5.0b1/src/jpgraph_pie3d.php");
include ("/jpgraph-3.5.0b1/src/jpgraph_bar.php");
include "/connect_to_db.php";

$date=$_GET['date'];
$hour=$_GET['hour'];
$chart=$_GET['chart'];

$values=array();
$v2=array();/**/
$title="";

$check="";
$hr=array();
$s2="";
$sql=mysql_query("select distinct(Hour) from DUAL_2G where Date='$date' order by Hour");
while($rows=mysql_fetch_array($sql)):
$hours=$rows['Hour'];
array_push($hr,"$hours");
endwhile;
$r=count($hr);
for($i = 0; $i < $r ; $i++)
{
if($hr[$i]==$hour)
{
$check=1;
break;
}
}
if($check=="")
{
$s1= "This hour isn't available  at $date, ";
$s3="Hours currently available are : ";
header("Content-type: image/png"); 
if($r<8){
$im = imagecreatefrompng("picture3s.png"); }
else {$im = imagecreatefrompng("picture3.png"); }
//$im = imagecreate(100,100);
$font_a = 3; 
$xpos_a = 15; 
$ypos_a = 25; 

$font_b = 2; 
$xpos_b = 25; 
$ypos_b = 42; 
 
$ypos_c = 58; 

$white = imagecolorallocate($im, 0, 0, 0); 
imagestring($im, $font_a, $xpos_a, $ypos_a, $s1, $white); 
imagestring($im, $font_a, $xpos_a, $ypos_b, $s3, $white); 
for($i = 0; $i < $r ; $i++)
{
$s2="* $hr[$i]";
imagestring($im, $font_b, $xpos_b, $ypos_c, $s2, $white); 
$ypos_c=$ypos_c+16;
}

imagepng($im);  }

else{
$sql=mysql_query("select trim(substr(`Desc`,28,12)) as `Desc` ,sum(Count) counts FROM (SELECT `Desc`, Count FROM DUAL_2G WHERE Date = '$date' and Hour=$hour and `Desc` like 'Number of Dual Handsets in%' and `Desc` not like '%in the Network' and `Desc` not like '%NULL%'  union All select `Desc`, Count FROM DUAL_3G WHERE Date = '$date' and Hour=$hour and `Desc` like 'Number of Dual Handsets in%' and `Desc` not like '%in the Network' and `Desc` not like '%NULL%' ) X GROUP BY `Desc`");
while($rows=mysql_fetch_array($sql)):
$sup=$rows['Desc'];
$counts=$rows['counts'];
array_push($values,"$counts");
array_push($v2,"$sup");
endwhile;

$title="Regional Analysis for Dual Handsets counts on $date at hour=$hour";
if($chart=='Pie Chart'){

$graph = new PieGraph(650,350,'auto');
$title="Regional Analysis for Dual Handsets counts on $date at hour=$hour";
$theme_class= new VividTheme;
$graph->SetTheme($theme_class);
$graph->title->Set($title);
$graph->title->SetFont(FF_ARIAL,FS_BOLD); 
$p1 = new PiePlot3D($values);
$graph->Add($p1);
$p1->SetLegends($v2);
$graph->legend->SetPos(0.5,0.999999,'center','bottom');
$p1->ShowBorder();
$p1->SetColor('black');
$p1->ExplodeSlice(1);
$graph->Stroke();
}

}
//Reyesve if u reyesve check
?>


