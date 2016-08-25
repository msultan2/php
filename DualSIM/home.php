
<?php include("template.php");?>  <!--//its a php command and must got a space between include and php then directory and template file-->

<?php header('Refresh: 900'); ?>

 <h2><u><i>Project Description</i></u></h2>
 <br>
<p>The main project objective was finding the number of dual users and the number of real active users, in order   
<br/>to present the Customer Behaviour. Below are a Number of statistics we preformed given the data we had.</p>
<br> 
<table>
	<tr>
		<td valign=top>
			<a href="Dual_Page.php"><h3><i>Duals</i></h3></a>
			<p>Gives you Statistics about:<ul>
			<li>Dual Customers swapping 2 VF SIMs in One Mobile (2/1).<br></li>
			<li>Customers using Handsets that support Duality.<br></li>
			<li>Customers using 2 Diff SIMs in 2 Diff Mobiles (2/2).<br></li></ul>
			<br>
			There are results for <a herf="main_duals3G.php">3G</a> and <a herf="main_duals2G.php">2G</a></p><br>						
		</td>
		<td><img src="images/dual5.png" >
		</td>
	</tr>

	<tr>
		<td valign=top>
			<a href="Trans_Page.php"><h3><i>Transactions</i></h3></a>
			<p>Gives you statistics about the number of transactions or calls Occurring per date specified in each hour available for that date.</p>
			<br>
			<a href="Subs_Page.php"><h3><i>Subscribers</i></h3></a>
			<p>Gives you statistics about the number of Subscribers using the Network even they are Duals or Normal Users per date specified in each hour available for that date.</p>
			<br>
			<a href="Hand_Page.php"><h3><i>Handsets Counts</i></h3></a>
			<p>Gives you statistics about the number of Handsets used per Dual and Normal Users Occurring per date specified in each hour available for that date.</p>
			<br><br>
		</td>
		<td><img src="images/dual41.png" >
		</td>
	</tr>
	
	<tr>
		<td valign=top>
			<a href="Reg_Page.php"><h3><i>Regional Analysis</i></h3></a>
			<p>Gives you statistics about the all the items given in this site but with Regional Analysis showing Sub-Region in a given Region given per hour in a chosen Date.</p>
			<br>
			<a href="Mob_Page.php"><h3><i>Mobile Brands Analysis</i></h3></a>
			<p>Gives you statistics about the all the items given in this site but with Mobile Brands and series Analysis in a given Region given per hour in a chosen Date.</p>
			<br><br>
		</td>
		<td><img src="images/roam.jpg" >
		</td>
	</tr>
	<tr>
		<td valign=top>
			<br><br><br><br><br><br><br>
			<i><h4><u>Hint:</u></h4></i>
			<p>All data collected can be presented in <i>Bar</i> & <i>Pie</i> charts for <i>2G,3G</i> or <i>Both</i>.
			<br>
			All graphs represented in the given variables [<i>Date</i> ,<i>hour</i>, <i>Period</i> or <i>Region</i>].</p>
		
			
		</td>
		<td><img src="images/jo.jpg" >
		</td>
	</tr>
</table>

<?php include "/footer.php";?>	
