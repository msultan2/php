<?php include ("template.php"); ?>
<?php 
	$Scompany=$_POST['Scompany'];
	$Sorg=$_POST['Sorg'];
	$Sgroup=$_POST['Sgroup'];
?>
<div id="content">
	<h1>Teams Mapping:</h1>
	<div style="height:20px;"></div>							
	<table>
		<form action="mappingOld.php" method="post">
		<tr><th align=left>Old Team Name</th></tr>
		<tr>
			<td width=50%>Old Support Company</td>
			<td><input type="text" name="Scompany" value='<?php echo $_POST["Scompany"];?>'/>
			</td>
		</tr>
		<tr>
			<td>Old Support Organization</td>
			<td><input type="text" name="Sorg" value='<?php echo $_POST["Sorg"];?>'/></td>
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
