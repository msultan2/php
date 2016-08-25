<?php include ("template.php"); ?>
<?php 
	$Scompany=$_POST['Scompany'];
	$Sorg=$_POST['Sorg'];
	$Sgroup=$_POST['Sgroup'];
	//$arr_Company= array("Prepaid Charging","Products & Services Delivery", 'Network Engineering', 'Service Management','IT Operations','Regional Operations','Customer Experience');
	//var_dump($arr_Company);
	$arr_Companys = array();
	$arr_Organs = array();
	$arr_Groups = array();
?>
<?php
		$mapping = file('txt/mapping.txt');
		$num_teams = count($mapping);
		for($team_index=0; $team_index< $num_teams; $team_index++)
		{
			///////list($team_support_company,$team_support_org,$team_support_group,$dummy1,$dummy2,$dummy3)=split(',',$mapping[$team_index]);
			////////$arr_Company[$team_index]=array($team_support_company,$team_support_org,$team_support_group) ;
			///////$arr_org[$team_index]=$team_support_org;
			
			list($team_support_company,$team_support_org,$team_support_group,$team_support_company_old,$team_support_org_old,$team_support_group_old)=split(',',$mapping[$team_index]);
			
			$team_line[$team_index] = array(         
					'Company_New' => $team_support_company,         
					'Organization_New' => $team_support_org,
					'Group_New' => $team_support_group,
					'Company_Old' => $team_support_company_old,         
					'Organization_Old' => $team_support_org_old,
					'Group_Old' => $team_support_group_old
				) ;
			
			array_push($arr_Companys,$team_line[$team_index]['Company_Old']);
			array_push($arr_Organs,$team_line[$team_index]['Organization_Old']);
			array_push($arr_Groups,$team_line[$team_index]['Group_Old']);
		}
		//for($i=0;$i<$num_teams;$i++){
			//$arr_Companys[$i] = $team_line[$i]['Company_Old'];
		//}
		$arr_Companys = (array_unique($arr_Companys));
		
		//foreach($arr_Companys as $kk){
		//	$hash = $kk['Company_New'];
		//	$unique_comp[$hash] = $kk; 
		//}
		
		//for($team_index=0; $team_index< $num_teams; $team_index++)
		//{
		//	var_dump($team_line);
		//}
		
		//if ($team_support_company==$php_chosen ){
				//echo $team_support_company ." kk ". $Scompany;						
			//	$arr_org[$i++]=$team_support_org;
			//}
			
			
		//}
		//var_dump($arr_org);
		//foreach($arr_org as $support_org){
		//	echo "<option value=".$support_org.">".$support_org."</option>";
		//} 
	?>
<script  type="text/javascript">

	function setOptions(chosen){

		var selbox = document.myForm.Sorg;
		selbox.options.length = 0;
		//alert(chosen);
		if (chosen == " ") {
			selbox.options[selbox.options.length] = new Option('No Company selected',' ');
		}
		else{
			<?php 
				$arr_orgs = array();
				for($i=0;$i<$num_teams;$i++){
			?>
					if (chosen == '<?php echo $team_line[$i]['Company_Old'];?>'){
						<?php array_push($arr_orgs,$team_line[$i]['Organization_Old']); ?>
					}
			<?php }?>
			
			<?php 
				$arr_orgs = (array_unique($arr_orgs));
				foreach($arr_orgs as $support_org){ ?>
						selbox.options[selbox.options.length] = new Option(<?php echo "'".$support_org."'";?>);
					
			<?php
			}?>
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
				<select id="Scompany" name="Scompany"  value='<?php echo $_POST["Scompany"];?>' onchange="setOptions(document.myForm.Scompany.options[document.myForm.Scompany.selectedIndex].value);">
					<option selected value="">Select</option>
					<?php
						foreach($arr_Companys as $support_company){
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
				<select name="Sorg" value='<?php echo $_POST["Sorg"];?>'>
					<option value=" " selected="selected">No Department selected</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Old Support Group</td>
			<td>
				<select id="Sgroup" name="Sgroup" value='<?php echo $_POST["Sgroup"];?>'>
					<option selected value="">Select</option>
					<?php
						foreach($arr_Groups as $support_group){
							echo '<option value="'.$support_group.'">'.$support_group.'</option>';
						}
					?>
				</select>
			</td>				
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
						if(($Old_Support_Company==$Scompany)and ($Old_Support_Organization==$Sorg)and ($Old_Support_Group==trim($Sgroup)))
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
						//else
						//	echo $Old_Support_Company. "|". $Scompany. "||".$Old_Support_Organization. "|".$Sorg. "||".$Old_Support_Group. "|".$Sgroup."-";
					}
?>
</div>

<?php include ("footer.php"); ?>
