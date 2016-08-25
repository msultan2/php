<?php include ("templateTools.php"); ?>
<div id="content">
		<h1>Planned Activities Calendar:</h1>
			<div style="height:15px;"></div>

			<table class="blue" width=80% >
			<?php	  
				$prm= $_REQUEST['prm'];
				$chm= $_REQUEST['chm']; //request 
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
							<td align=center ><font size='3' face='Tahoma'> <a href='Calendar_PA.php?prm=$m&chm=-1'><</a></td>
							<td colspan=5 align=center ><font size='3' face='Tahoma'>$mn $yn </td>
							<td align=center ><font size='3' face='Tahoma'> <a href='Calendar_PA.php?prm=$m&chm=1'>></a></td>
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
				
					$calendar = file('PAcalendar.txt');
					$num_PA = count($calendar);
					for($pa=0; $pa < $num_PA; $pa++){
						//if(strpos($calendar[$pa],$thisDate)){
						list($pa_type,$pa_desc,$date,$pa_impact,$pa_site,$pa_notes,$pa_severity)=split(',',$calendar[$pa],7);
						if($date==$thisDate){
							if($pa_type=='PA'){
								echo "<table class=blue width=90% align=center >";						
								echo "<tr><th width=20%>Activity</th><td>".$pa_desc. "</td></tr>";
								echo "<tr><th>Impact</th><td>".$pa_impact."</td></tr>";
								echo "<tr><th>Site</th><td >".$pa_site."</td></tr>";
								echo "<tr><th>Notes</th><td >".$pa_notes."</td></tr>";
								echo "<tr><th>Severity</th><td class=".$pa_severity." >".$pa_severity."</td></tr>";
								echo "</table><br>";
							}
							if($pa_type=='FR'){
								
								echo "<table class=sara width=90% align=center >";						
								echo "<tr><th width=20%>Event</th><td>".$pa_desc. "</td></tr>";
								echo "<tr><th>Impact</th><td>".$pa_impact."</td></tr>";
								echo "<tr><th>Site</th><td >".$pa_site."</td></tr>";
								echo "<tr><th>Severity</th><td class=".$pa_severity." >".$pa_severity."</td></tr>";
								echo "</table><br>";
							}
						}
					}
				
					echo " </font></td>";
					$adj='';
					$j ++;
					if($j==7){echo "</tr><tr>";
					$j=0;}

				}

				echo "</tr></table></td></tr></table>";
				
			?>
			</table>
</div>
<?php include ("footer.php"); ?>
				