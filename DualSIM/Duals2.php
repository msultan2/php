<?php include "/template.php";?>
<?php header('Refresh: 900'); ?>


<table border="0" align="center">
<div id="main" >
<div id="left">
<tr>
<td align="center">
<h2>Duals Statistics </h2>
<p>&nbsp;</p>
<?php
include "/connect_to_db.php";
$options="";
$options2="";
$options3="";
$options4="";
$dt=array();
global $date;
global $hour;
global $chart;
global $datef;
global $datet;
$sql=mysql_query("select DISTINCT Date as Date from DUAL2 order by Date "); //where Hour=$hour and Date='$date'
while($rows=mysql_fetch_array($sql)):
$date1=$rows['Date'];
$options.="<OPTION VALUE=\"$date1\">".$date1.'</option>';
endwhile;
?>

<form method="post">
Date
<SELECT name="date1">
<?php if(isset($_POST['date1'])) { $date=$_POST["date1"]; } else { $date='Date';} ?>  
<OPTION VALUE=<?php echo $date?>><?echo $date ;?>
<?php echo $options?>
<? $date=$_POST["date1"]; ?> 
</SELECT>


<?php 
$r1="Bar Chart";
$r2="Pie Chart";
?>
<input type="submit" name="submit" />
<!--</form>-->

</td>
</tr>


    

<tr>
<td align="center">
<br><br>
<?php
if ($date!="" and  $date!='Date' ){
$chart=$r1;
Print '<img src="2_2_Total.php?date=' . $date . '&chart='. $chart .'" id="imggg">';}
//print '<a href="duals.php?date=' . $date . '&hour=' . $hour . '">lolo</a>';}
else
{
//echo "Please choose a date ";}
$date=$date1;
$chart=$r1;
Print '<img src="2_2_Total.php?date=' . $date . '&chart='. $chart .'" id="imggg">';}
?>

</td>
</tr>


   

<tr>
<td align="center">
<br><br>
<?php
if ($date!="" and  $date!='Date' ){
$chart=$r1;
Print '<img src="2_2_Total2.php?date=' . $date . '&chart='. $chart .'" id="imggg">';}
//print '<a href="duals.php?date=' . $date . '&hour=' . $hour . '">lolo</a>';}
else
{
//echo "Please choose a date ";}
$date=$date1;
$chart=$r1;
Print '<img src="2_2_Total2.php?date=' . $date . '&chart='. $chart .'" id="imggg">';}
?>

</td>
</tr>


<tr>
<td>

<?php 
$sql=mysql_query("select DISTINCT Date as Date from DUAL2 order by Date "); //where Hour=$hour and Date='$date'
while($rows=mysql_fetch_array($sql)):
$date2=$rows['Date'];
$date3=$rows['Date'];
$options3.="<OPTION VALUE=\"$date2\">".$date2.'</option>';
$options4.="<OPTION VALUE=\"$date3\">".$date3.'</option>';
endwhile; 
?>
<br>
<!--<form method="post">-->
From
<SELECT name="date2">
<?php if(isset($_POST['date2'])) { $datef=$_POST["date2"]; } else { $datef='From Date';} ?> 
<OPTION VALUE=<?php echo $datef?>><? echo $datef ;?>
<?php echo $options3?>
<?$datef=$_POST["date2"]; ?> 
</SELECT>

To
<SELECT name="date3"> 
<?php if(isset($_POST['date3'])) { $datet=$_POST["date3"]; } else { $datet='To Date';} ?>
<OPTION VALUE=<?php echo $datet?>><? echo $datet ;?>
<?php echo $options4?>
<? $datet=$_POST["date3"]; ?> 
</SELECT>


<input type="submit"/>
</form>

</td>
</tr>


<tr>

<td colspan="2" >
<br><br>
<?php 
if ($datef!="" and $datet!="" and $datef!='From' and $datet!='To' ){
$chart=$r1;
Print '<img src="2_2_FT.php?datef=' . $datef . '&datet=' . $datet . '&chart='. $chart .'" id="imggg">';  }
//print '<a href="dualss.php?datef=' . $datef . '&datet=' . $datet . '&chart='. $chart .'">lolo</a>';}
else
{
$sql=mysql_query("select DISTINCT Date as Date from DUAL2 order by Date "); //where Hour=$hour and Date='$date'
while($rows=mysql_fetch_array($sql)):
$date2=$rows['Date'];
array_push($dt,"$date2");
endwhile; 
$r=count($dt);
$datef=$dt[$r-7];
$datet=$dt[$r-1];
$chart=$r1;
Print '<img src="2_2_FT.php?datef=' . $datef . '&datet=' . $datet . '&chart='. $chart .'" id="imggg">';  }

//echo "Please choose a date ,hour and an option"; }
?>

</td>


</tr>
</div>
</div>
</table>

<?php include "/footer.php";?>	