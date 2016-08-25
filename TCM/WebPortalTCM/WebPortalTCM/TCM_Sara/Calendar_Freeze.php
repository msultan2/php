<?php include ("templateCal.php"); ?>
<div id="content">
	<div class="razd_lr">
		<h1>Freeze Calendar:</h1>
			<div style="height:15px;"></div>

			<table class="blue" width=80% >
			<?php	  
				$prm= $_REQUEST['prm'];
				$chm= $_REQUEST['chm'];
				if(isset($prm)){
					$m= $prm+$chm;
				}
				else{
					$m= date("m");
				}
				
				$d= date("d");     // Finds today's date
				$y= date("Y");     // Finds today's year

				$no_of_days = date('t',mktime(0,0,0,$m,1,$y)); // This is to calculate number of days in a month

				$mn=date('M',mktime(0,0,0,$m,1,$y)); // Month is calculated to display at the top of the calendar

				$yn=date('Y',mktime(0,0,0,$m,1,$y)); // Year is calculated to display at the top of the calendar

				$j= date('w',mktime(0,0,0,$m,1,$y)); // This will calculate the week day of the first day of the month

				for($k=1; $k<=$j; $k++){ // Adjustment of date starting
				$adj .="<td>&nbsp;</td>";
				}

				/// Starting of top line showing name of the days of the week

				echo "<table cellspacing='0' cellpadding='0' align=center width='100' border='1'>
						<tr>
							<td align=center ><font size='3' face='Tahoma'> <a href='Calendar_Freeze.php?prm=$m&chm=-1'><</a></td>
							<td colspan=5 align=center ><font size='3' face='Tahoma'>$mn $yn </td>
							<td align=center ><font size='3' face='Tahoma'> <a href='Calendar_Freeze.php?prm=$m&chm=1'>></a></td>
						</tr><tr>";

				echo " <table class=blue width=80% >";

				echo "<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr><tr>";

				////// End of the top line showing name of the days of the week//////////

				
				//////// Starting of the days//////////
				for($i=1;$i<=$no_of_days;$i++){
					echo $adj."<td valign=top><font size='2' face='Tahoma'>$i<br>"; // This will display the date inside the calendar cell
					echo "<br>";
				
					$thisDate=$i." ".$mn." ".$yn;
					#echo "today: ".$thisDate;	
				
					$calendar = file('calendars/Freeze.txt');
					$num_PA = count($calendar);
					for($pa=0; $pa < $num_PA; $pa++){
						//if(strpos($calendar[$pa],$thisDate)){
						list($date,$freeze_desc,$freeze_reason,$note,$freeze_duration)=split(',',$calendar[$pa],5);
						if($date==$thisDate){
							echo "<div style='background-color: lightgray;'>";
							echo "<table class=yellow width=90% align=center >";						
							echo "<tr><th width=20%>Description</th><td>".$freeze_desc. "</td></tr>";
							echo "<tr><th>Reason</th><td>".$freeze_reason. "</td></tr>";
							echo "<tr><th>Duration</th><td>".$freeze_duration." day(s)</td></tr>";
							echo "<tr><th>Notes</th><td >".$note."</td></tr>";
							echo "</table></div><br>";
						}
					}				
					echo " </font></td>";
					$adj='';
					$j ++;
					if($j==7){
						echo "</tr><tr>";
						$j=0;
					}

				}

				echo "</tr></table></td></tr></table>";
				
			?>
			</table>
	</div>
	<div style="height:20px;"></div>
	<div style="clear: both"></div>
</div>
<?php include ("footer.php"); ?>
				