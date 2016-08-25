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

function separator1000($values) {
    return number_format($values);
}
function separator1000_usd($values) {
    return number_format($values/1000).' K';
}

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
$sql=mysql_query("SELECT substr(`Desc`,11,4) as `Desc`,  sum(Count) counts FROM (SELECT `Desc`, Count FROM DUAL_2G WHERE Date = '$date'  and Hour=$hour and (`Desc` like  'Number of Dual Handsets in the Network' or `Desc` like '%Number of Normal Handsets') UNION ALL SELECT `Desc`, Count FROM DUAL_3G WHERE Date = '$date' and Hour=$hour and (`Desc` like  'Number of Dual Handsets in the Network' or `Desc` like '%Number of Normal Handsets') ) X GROUP BY `Desc`");
while($rows=mysql_fetch_array($sql)):
$sup=$rows['Desc'];
$counts=$rows['counts'];
array_push($values,"$counts");
array_push($v2,"$sup");
endwhile;

//new addition 11:20 pm//////////////////////////////////////////////
$t=count($v2);
for($i = 0; $i < $t ; $i++)
{
if($v2[$i]=="Norm")
{
$v2[$i]="Normal Mobile";
}
}

//end of new addition/////////////////////////////////////////////////

$title="Number of Handsets across the Network on $date at hour=$hour";

if($chart=='Pie Chart'){

$graph = new PieGraph(650,350,'auto');

$title="Ratio of Handsets at $date on hour= $hour";
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

if($chart=='Bar Chart'){
$graph = new Graph(650,350,'auto');
$graph->SetScale("textlin");
$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);
$graph->SetMargin(70,30,50,30);
$graph->SetBox(false);
$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels($v2);
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);
// Create the bar plots
$b1plot = new BarPlot($values);
$graph->title->SetFont(FF_ARIAL,FS_BOLD); 
$graph->Add($b1plot);
$b1plot->SetWeight(0);
//"#11cccc","#90EE90"
$graph->yaxis->SetLabelFormatCallback('separator1000');
$b1plot->SetFillGradient("#11cccc","midnightblue",GRAD_HOR);
$b1plot->SetWidth(17);
$b1plot->value->Show();
$b1plot->value->SetColor("darkred");
$b1plot->value->SetFont(FF_FONT1,FS_BOLD);
$b1plot->value->SetFormat("%d");
$graph->title->Set("$title");
$graph->Stroke();
}
}
//Reyesve if u reyesve check
?>


