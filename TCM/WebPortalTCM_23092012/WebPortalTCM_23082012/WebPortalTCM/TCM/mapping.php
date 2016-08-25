<?php include ("templateTools.php"); ?>
<?php 
	$Scompany=$_POST['Scompany'];
	$Sorg=$_POST['Sorg'];
	$Sgroup=$_POST['Sgroup'];
	
	$arr_Company= array('Products & Services Delivery', 'Network Engineering', 'Service Management','IT Operations','Regional Operations','Customer Experience');

 
?>
<script type="text/javascript">
	function handlefile(){
		var myFile = document.getElementById('txtF');
		var fileContents = System.IO.File.ReadAllLines(myFile);
		document.myForm.textfield.value=fileContents;
	}
	function setOptions(chosen){

		var selbox = document.myForm.Sorg;
		selbox.options.length = 0;
		if (chosen == " ") {
			selbox.options[selbox.options.length] = new Option('No database selected',' ');
			}
		else{
			//selbox.options[selbox.options.length] = new Option(chosen);
			document.getElementById("chosenOrg").value = chosen;


			<?php
					$i=0;
					$mapping = file('txt/mapping.txt');
					foreach($mapping as $team){
						list($team_support_company,$team_support_org,$team_support_group,$dummy1,$dummy2,$dummy3)=split(',',$team);
						if ($team_support_company==$Scompany){
							echo $team_support_company ." ". $Scompany;						
							$arr_org[$i++]=$team_support_org;
						}
					}
					//foreach($arr_org as $support_org){
					//	echo "<option value=".$support_org.">".$support_org."</option>";
					//} 
				?>
				var org = "<?php echo $arr_org[1]; ?>";
				selbox.options[selbox.options.length] = new Option(org);
		}
	}

</script>

<div id="content">
	<h1>Teams Mapping:</h1>
	<div style="height:20px;"></div>							
	<table>
		<form name="myForm" action="mapping.php" method="post">
		<tr><th align=left>Old Team Name</th></tr>
		<tr>
			<td width=50%>Old Support Company</td>
			<td>
				<select name="Scompany" onchange="setOptions(document.myForm.Scompany.options[document.myForm.Scompany.selectedIndex].value);">
					<option selected value="">Select Department</option>;
					<?php
						foreach($arr_Company as $support_company){
							echo "<option value=".$support_company.">".$support_company."</option>";
						} 
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Old Support Organization</td>
			<td>
				<select name="Sorg">
					<option value=" " selected="selected">No Department selected</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Old Support Group</td>
			<td><input type="text" name="Sgroup" value='<?php echo $_POST["Sgroup"];?>'/></td>				
		</tr>
		<tr>
			<td>k: <?php echo $Scompany;?></td>
			<td align=center>
				<input type="text" id="chosenOrg" />
				<input type="submit" value="Check" />
			</td>									
		</tr>
		</form> 					
	</table>
<?php $mapping = file('txt/mapping.txt');
					$num_teams = count($mapping);
					//echo $num_teams;
					for($team_index=0; $team_index< $num_teams; $team_index++)
					{
						list($New_Support_Company,$New_Support_Organization,$New_Support_Group,$Old_Support_Company,$Old_Support_Organization,$Old_Support_Group)=split(',',trim($mapping[$team_index]));
						//if ((strcmp ($Old_Support_Company ,$Scompany ) ==0) and (strcmp ($Old_Support_Organization,$Sorg ) ==0) and  (strcmp ($Old_Support_Group,$Sgroup ) ==0)) 
						if(($Old_Support_Company==$Scompany)and ($Old_Support_Organization==$Sorg)and ($Old_Support_Group==$Sgroup))
						{
							echo '<table>
								<form action="mapping.php" method="post">
									<tr><th align=left>New Team Name</th></tr>
									<tr><td width=50%>New Support Company</td>
										<td>'.$New_Support_Company.'</td>
									</tr>
									<tr>
										<td>New Support Organization</td>
										<td>'.$New_Support_Organization.'</td>
									</tr>
									<tr>
										<td>New Support Group</td>
										<td>'.$New_Support_Group.'</td>				
									</tr>
								</form> 					
								</table>';
							
						}
					}
?>
</div>

<?php include ("footer.php"); ?>
