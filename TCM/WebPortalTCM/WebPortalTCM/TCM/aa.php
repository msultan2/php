<?php include ("template.php"); ?>
<?php
$calendar = file('PAcalendar.txt');
					$num_PA = count($calendar);
					for($pa=0; $pa < $num_PA; $pa++)
					{for($vertical=0; $vertical<$pa, $vertical) 
						{list($pa_type,$pa_desc,$date,$pa_impact,$pa_site,$pa_severity)=split(',',$calendar[$pa],6);
						
								echo "<table class=blue width=90% align=center >";						
								echo "<tr><th width=20%>Activity</th><td>".$pa_desc. "</td></tr>";
								echo "<tr><th>Impact</th><td>".$pa_impact."</td></tr>";
								echo "<tr><th>Site</th><td >".$pa_site."</td></tr>";
								echo "<tr><th>Severity</th><td class=".$pa_severity." >".$pa_severity."</td></tr>";
								echo "</table><br>";
						}
				    }
					echo " </font></td>";
					echo "</tr></table></td></tr></table>";
?>				