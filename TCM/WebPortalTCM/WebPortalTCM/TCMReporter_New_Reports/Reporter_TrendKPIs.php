<?php session_start();  $pagePrivValue=50; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<div class="body_text" style="color:darkred;"><b>TCM Monthly Review</b></div><BR>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>  
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>  
<link rel="stylesheet" href="/resources/demos/style.css" />  
<script>  
$(function() {    
	$( "#from" ).datepicker({      defaultDate: "+0w",      changeMonth: true,      numberOfMonths: 1,      
			onClose: function( selectedDate ) {        
				$( "#to" ).datepicker( "option", "minDate", selectedDate );    
				}    ,
			showOn: "button",      buttonImage: "images/calendar.png",      buttonImageOnly: true 
	});    
	
	$( "#to" ).datepicker({      defaultDate: "+1d",      changeMonth: true,      numberOfMonths: 1,      
			onClose: function( selectedDate ) {        
				$( "#from" ).datepicker( "option", "maxDate", selectedDate );      
				}    ,
			showOn: "button",      buttonImage: "images/calendar.png",      buttonImageOnly: true 
	});  
	
});  
</script>
<script type="text/javascript">
function hide()
{
    //NW.style.visibility="hidden"; 
	document.getElementById("NW").style.display = "block";
	document.getElementById("IT").style.display = "block";
}
function show()
{
    //NW.style.visibility="visible"; 
	document.getElementById("NW").style.display = "none";
	document.getElementById("IT").style.display = "none";
}
</script>
<script type="text/javascript">
var shown=0;
function hide1()
{
    //NW.style.visibility="hidden"; 
	shown=0;
	//document.getElementById("NW").style.display = "block";
	NW.style.display="block";
}
function show1()
{
    //NW.style.visibility="visible"; 
	if(shown=1)
		hide1();
	else{
		shown=1;
		//document.getElementById("NW").style.display = "none";
		NW.style.display="none";
		}
}
//hide();
</script>
<?php
	$startDate = '12/1/2013'; //date('m/d/Y', time() + (60 * 60 * 24 * -7));
	$endDate = date('m/d/Y', time() + (60 * 60 * 24 * -1));

	if(isset($_POST['from'])) $getFrom = $_POST['from']; else $getFrom = $startDate;
	if(isset($_POST['to'])) $getTo = $_POST['to']; else $getTo = $endDate;
	
	$monthCount = (int)abs((strtotime($getFrom) - strtotime($getTo))/(60*60*24*30)); 
	//echo $getFrom." ".$getTo." mC= ".$monthCount;
?>
<div class="body_text"></div>
<form method=post action='Reporter_MonthlyKPIs.php'>
	Report of Changes Requests in date interval
	<label for="from">From </label><input type="text" id="from" name="from"  value="<?php echo $getFrom;?>" />
	<label for="to">to </label><input type="text" id="to" name="to"  value="<?php echo $getTo;?>" />  
	<input type=submit name='submit' value='Search'/>
</form>
	<table>	
		<tr>
			<td valign=top colspan=3><iframe src="Report_KPI_Trend.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" frameborder=0 width="1400px" height="<?php echo 30*($monthCount+4); ?>px"></iframe></td>
		</tr>
		<tr>
			<td valign=top><iframe src="Report_KPIExceptionsTeam.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" scrolling=no frameborder=0 width="450px" height="400px"></iframe></td>
			<td valign=top><iframe src="Report_KPIFixTeam.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" scrolling=no frameborder=0 width="450px" height="400px"></iframe></td>
			<td valign=top><iframe src="Report_KPIoffPCMTeam.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" scrolling=no frameborder=0 width="450px" height="400px"></iframe></td>
		</tr>
		<tr>
			<td valign=top><iframe src="Report_KPIAdhocNRTeam.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" scrolling=no frameborder=0 width="450px" height="400px"></iframe></td>
			<td valign=top><iframe src="Report_KPIAdhocSTTeam.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" scrolling=no frameborder=0 width="450px" height="400px"></iframe></td>
			<td valign=top><iframe src="Report_KPIAdhocOffTeam.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" scrolling=no frameborder=0 width="450px" height="400px"></iframe></td>
		</tr>
		<tr>
		<p><a href="#" onmouseover="show()" onmouseout="hide()">Show NW/IT Details</a></p>
		</tr>
		<tr>
			<td valign=top colspan=3><div id="NW" ><iframe src="Report_KPI_Trend_NW.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" frameborder=0 width="1350px" height="<?php echo 25*($monthCount+4); ?>px"></iframe></div></td>
		</tr>
		<tr>
			<td valign=top colspan=3><div id="IT" ><iframe src="Report_KPI_Trend_IT.php?from=<?php echo $getFrom;?>&to=<?php echo $getTo;?>" frameborder=0 width="1350px" height="<?php echo 25*($monthCount+4); ?>px"></iframe></div></td>
		</tr>
	</table>
<?php include ("footer_new.php"); ?>