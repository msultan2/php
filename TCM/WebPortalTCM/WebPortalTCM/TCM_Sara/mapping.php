<?php include ("templateTools.php"); ?>
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
		
		$arr_Companys = (array_unique($arr_Companys));
		$arr_Organs = (array_unique($arr_Organs));
		$arr_Groups = (array_unique($arr_Groups));
?>
<div id="content">
	<h1>Re-Org Remedy Teams Mapping:</h1>
	<div style="height:20px;"></div>							
	<table>
		<form action="mapping.php" name="myForm" method="post">
		<tr><th align=left>Old Team Name</th></tr>
		<tr>
			<td width=50%>Old Support Company</td>
			<td>
				<select id="Scompany" name="Scompany"  value='<?php echo $_POST["Scompany"];?>' >
					<option value="">Select</option>
					<?php
						foreach($arr_Companys as $support_company){
							echo '<option value="'.$support_company.'"';
							if ($_POST["Scompany"]==$support_company)
								echo ' SELECTED ';
							echo '>'.$support_company.'</option>';
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Old Support Organization</td>
			<td>
				<select name="Sorg" value='<?php echo $_POST["Sorg"];?>'>
					<option value="" >Select</option>
					<?php
						foreach($arr_Organs as $support_org){
							echo '<option value="'.$support_org.'"';
						if ($_POST["Sorg"]==$support_org)
								echo ' SELECTED ';
							echo '>'.$support_org.'</option>';
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Old Support Group</td>
			<td>
				<select id="Sgroup" name="Sgroup" value='<?php echo $_POST["Sgroup"];?>'>
					<option value="">Select</option>
					<?php
						foreach($arr_Groups as $support_group){
							echo '<option value="'.$support_group.'"';
						if ($_POST["Sgroup"]==$support_group)
								echo ' SELECTED ';
							echo '>'.$support_group.'</option>';
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
