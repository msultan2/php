<?php include ("template.php"); ?>
<?php 
	$Scompany=$_POST['Scompany'];
	$Sorg=$_POST['Sorg'];
	$Sgroup=$_POST['Sgroup'];
	$arr_Company= array("Prepaid Charging","Products & Services Delivery", 'Network Engineering', 'Service Management','IT Operations','Regional Operations','Customer Experience');
	//var_dump($arr_Company);
?>

<script type="text/javascript">
//	function handlefile(){
//		var myFile = document.getElementById('txtF');
//		var fileContents = System.IO.File.ReadAllLines(myFile);
//		document.myForm.textfield.value=fileContents;
//	}
	function setOptions(chosen){

		var selbox = document.myForm.Sorg;
		selbox.options.length = 0;
		//alert(chosen);
		if (chosen == " ") {
			selbox.options[selbox.options.length] = new Option('No database selected',' ');
			}
		else{
			//selbox.options[selbox.options.length] = new Option(chosen);
			document.getElementById("hiddenCompany").value = chosen;
			document.myForm.hiddenCompany.value = chosen;
			alert(document.myForm.hiddenCompany.value);
			
			<?php
					$i=0;
					$mapping = file('txt/mapping.txt');
					$num_teams = count($mapping);
					//echo "alert(chosen);";
					//$chosen =  "<script language='javascript'>document.write(chosen);</script>"; 
					$chosen=$_GET['hiddenCompany'];
					
					for($team_index=0; $team_index< $num_teams; $team_index++)
					{
						list($team_support_company,$team_support_org,$team_support_group,$dummy1,$dummy2,$dummy3)=split(',',$mapping[$team_index]);
						//echo $team_support_company ." kk ". $Scompany;	
						//$arr_org[bar]='sara';
				
					if ($team_support_company==$chosen ){
							//echo $team_support_company ." kk ". $Scompany;						
							$arr_org[$i++]=$team_support_org;
						}
						
						
					}
					//var_dump($arr_org);
					//foreach($arr_org as $support_org){
					//	echo "<option value=".$support_org.">".$support_org."</option>";
					//} 
				?>
				 
				var org = "<?php echo $chosen; ?>" ;

				//alert(org);
				selbox.options[selbox.options.length] = new Option(org);
		}
	}

</script>
<div id="content">
	<h1>Teams Mapping:</h1>
	<div style="height:20px;"></div>							
	<table>
		<form action="mappingNew.php" name="myForm" method="post">
		<tr><th align=left>Old Team Name</th></tr>
		<tr>
			<td width=50%>Old Support Company</td>
			<td>
				<select id="Scompany" name="Scompany"  onchange="setOptions(document.myForm.Scompany.options[document.myForm.Scompany.selectedIndex].value);">
					<option selected value="">Select Department</option>
					<?php

						foreach($arr_Company as $support_company){
							echo '<option value="'.$support_company.'">'.$support_company.'</option>';
						} 
					?>
				</select>
				<input type="hidden" name="hiddenCompany" id="hiddenCompany"  /> 
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
			<td></td>
			<td align=center><input type="submit" value="Check" /></td>									
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
								</table>';
							
						}
					}
?>
</div>

<?php include ("footer.php"); ?>
