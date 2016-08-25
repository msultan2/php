<?php

include ("/jpgraph-3.5.0b1/src/jpgraph.php");
include ("/jpgraph-3.5.0b1/src/jpgraph_pie.php");
include ("/jpgraph-3.5.0b1/src/jpgraph_pie3d.php");
include ("/jpgraph-3.5.0b1/src/jpgraph_bar.php");
include "/connect_to_db.php";

$date=$_GET['date'];
$chart=$_GET['chart'];

$values=array();
$v2=array();/**/
$title="";
$v1='';

function separator1000($values) {
    return number_format($values);
}
function separator1000_usd($values) {
    return number_format($values/1000).' K';
}


$sql=mysql_query("select Hour,substr(`Desc`,32,7) as `Desc` ,Count from DUAL_2G where  Date='$date' and `Desc` like 'Number of Dual Handsets in the Network%' order by Hour");
while($rows=mysql_fetch_array($sql)):
$sup=$rows['Hour'];
$counts=$rows['Count'];
array_push($values,"$counts");
array_push($v2,"$sup");
endwhile;
//new addition 11:20 pm//////////////////////////////////////////////
$t=count($v2);
for($i = 0; $i < $t ; $i++)
{
if($v2[$i]=="yes")
{
$v2[$i]="Dual";
}
else if($v2[$i]=="No")
{
$v2[$i]="2 SIMs 1 Mobile";
}

}

//end of new addition/////////////////////////////////////////////////
$title="Number of Dual Handsets on $date ";

if($chart=='Bar Chart'){
$graph = new Graph(650,550,'auto');
$graph->SetScale("textlin");
$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);
$graph->SetMargin(70,30,50,30);
$graph->SetBox(false);
$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels($v2);
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->title->SetFont(FF_ARIAL,FS_BOLD); 
// Create the bar plots
$b1plot = new BarPlot($values);
$graph->Add($b1plot);
$b1plot->SetWeight(0);
//"#11cccc","#90EE90"
$graph->yaxis->SetLabelFormatCallback('separator1000');
$b1plot->value->SetFont(FF_ARIAL,FS_BOLD);
$b1plot->value->SetFormat("%d");
$b1plot->value->SetAngle(0);
$b1plot->value->SetFormatCallback('separator1000_usd');
$b1plot->SetFillGradient("#11cccc","midnightblue",GRAD_HOR);
$b1plot->SetWidth(17);
$b1plot->value->Show();
$b1plot->value->SetColor("darkred");
$b1plot->value->SetFont(FF_FONT1,FS_BOLD);
$b1plot->value->SetFormat("%d");
$graph->title->Set("$title");
$graph->Stroke();
}

?>