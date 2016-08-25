<?php

include ("/jpgraph-3.5.0b1/src/jpgraph.php");
include ("/jpgraph-3.5.0b1/src/jpgraph_pie.php");
include ("/jpgraph-3.5.0b1/src/jpgraph_pie3d.php");
include ("/jpgraph-3.5.0b1/src/jpgraph_bar.php");
include "/connect_to_db.php";

$date=$_GET['date'];
$hour=$_GET['hour'];
$chart=$_GET['chart'];

function separator1000($values) {
    return number_format($values);
}
function separator1000_usd($values) {
    return number_format($values/1000).' K';
}


$values=array();
$v2=array();/**/
$title="";

//////////////////////////////////////////////////////////////start of check on availability
$check="";
$hr=array();
$s2="";
$sql=mysql_query("select distinct(Hour) from DUAL_3G where Date='$date' order by Hour");
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


//imagestring($im, $font_c, $xpos_c, $ypos_c, $string_c, $white); 
//imagestring($im, $font_d, $xpos_d, $ypos_d, $string_d, $white); 

imagepng($im);  
/*$string="$s1 $s2";
$str=strlen($string);
$im = imagecreate(400, 300);
// White background and blue text
$bg = imagecolorallocate($im, 255, 255, 255);
$textcolor = imagecolorallocate($im, 0, 0, 255);
$string1=chunk_split($string, 20);
// Write the string at the top left
imagestring($im, 5, 0, 0, $string1, $textcolor);
// Output the image
header('Content-type: image/png');
imagepng($im);
imagedestroy($im);*/
}
//start of check
else{
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////dont forget}at the end
$sql=mysql_query(" select substr(`Desc`,1,4) as `Desc` ,Count from DUAL_3G where Hour=$hour and Date='$date' and (`Desc` like '2 VF%' or `Desc` like 'Number of Dual Handsets in the Network') order by `Desc`");
while($rows=mysql_fetch_array($sql)):
$sup=$rows['Desc'];
$counts=$rows['Count'];
array_push($values,"$counts");
array_push($v2,"$sup");
endwhile;

//new addition 11:20 pm//////////////////////////////////////////////
$t=count($v2);
for($i = 0; $i < $t ; $i++)
{
if($v2[$i]=="2 VF")
{
$v2[$i]="2 VF in same Mobile";
}
if($v2[$i]=="Numb")
{
$v2[$i]="1 VF 1 Other Operator";
}
}

//end of new addition/////////////////////////////////////////////////

$title="Number of Duals across the Network in $date at hour=$hour";
if($chart=='Pie Chart'){

$graph = new PieGraph(650,350,'auto');

$title="Ratio of Duals at $date on hour= $hour";
$theme_class= new VividTheme;
$graph->SetTheme($theme_class);
$graph->title->Set($title);
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
$graph->Add($b1plot);
$b1plot->SetWeight(0);
$graph->yaxis->SetLabelFormatCallback('separator1000');
//"#11cccc","#90EE90"
$b1plot->SetFillGradient("#11cccc","midnightblue",GRAD_HOR);
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
//Reyesve if u reyesve check
?>


