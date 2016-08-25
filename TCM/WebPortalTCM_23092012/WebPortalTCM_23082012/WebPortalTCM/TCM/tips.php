<?php include ("template.php"); ?>
<div id="content">
	<div class="razd_lr">
		<div id="right">
			<h1>Tips:</h1>
			<div style="height:15px;"></div>
			The change initiator's <b>Manager approval is required</b> to move the change request to the next phase.
			<div class="razd_h"></div>
			
			<h1>Why Remedy Change Management?</h1>
			<div style="height:15px;"></div>
			to provides us with the ability to manage changes by enabling us to assess <b>impact</b>, <b>risk</b>, and resource requirements, and then create plans
			and <b>automate approval</b> functions for implementing changes. <br>It provides <b>scheduling</b> and <b>task assignment</b> functionality,
			and <b>reporting</b> capabilities for reviewing <b>performance</b> and <b>improving processes</b>.
			
			<div class="razd_h"></div>
			<h1>Risk:</h1>
			<div style="height:15px;"></div>
			<table class="blue" width=80% >
				<tr><th>Risk Level</th><th>Impact</th><th>Probability</th></tr>
				<tr>
					<td>Level1</td>
					<td colspan=2>No Service Impact</td>
				</tr>
				<tr>
					<td>Level2</td>
					<td>Low</td>
					<td>Low</td>
				</tr>
				<tr>
					<td>Level3</td>
					<td>Low</td>
					<td>High</td>					
				</tr>
				<tr>
					<td>Level4</td>
					<td><b>High</b></td>
					<td>Low</td>					
				</tr>
				<tr>
					<td>Level5</td>
					<td><b>High</b></td>
					<td><b>High</b></td>
				</tr>
			</table>
			<div style="clear: both;"></div>
		</div>
		<div id="left">
		The change manager is responsible for planning and scheduling the change request. <br>
		This includes assessing the urgency, risks and impact of the change request.
		<div style="height:20px;"></div>
			<h1>Urgency:</h1>
			<div style="height:15px;"></div>
			<table class="blue" >
				<tr><th>Urgency</th><th>Time Frame</th><th>Description</th></tr>
				<tr>
					<td>Critical</td>
					<td><b>quickly</b></td>
					<td class=left><ul>
							<li>recover an <b>available service</b></li>
							<li>deploy a <b>commercial strategic</b> roll out</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>High</td>
					<td><b>quickly</b></td>
					<td class=left><ul>
							<li>recover an <b>affected service</b></li>
						</ul>
					</td>
				</tr>
						<tr>
					<td>Medium</td>
					<td>appropraite</td>
					<td class=left><ul>
							<li>deploy a <b>new service</b></li>
							<li>recover service that is <b>not severly impacted</b></li>
							<li><b>upgrade a system</b> or enhance service feature</li>
						</ul>
					</td>
				</tr>
						<tr>
					<td>Low</td>
					<td>appropraite</td>
					<td class=left><ul>
							<li>recover a service that is degraded but still available</li>
						</ul>
					</td>
				</tr>
			</table>
			<div style="clear: both;"></div>
			<div style="height:20px;"></div>
			<h1>Impact:</h1>
			<div style="height:15px;"></div>
			<table class="blue" >
				<tr><th>Impact</th><th>CAB authorization</th><th>Impacted Subscribers</th><th>Revenue Risk</th></tr>
				<tr>
					<td>Extensive</td>
					<td><b>Required</b></td>
					<td>>25%</td>
					<td>>250K LE</td>
				</tr>
				<tr>
					<td>Significant</td>
					<td><b>Required</b></td>
					<td>>15%</td>
					<td>>51K LE</td>
				</tr>
						<tr>
					<td>Moderate</td>
					<td>Not Required</td>
					<td>>10%</td>
					<td>>1K LE</td>
				</tr>
						<tr>
					<td>Minor</td>
					<td colspan=4>Any impact less than the above</td>
				</tr>
			</table>
			<div style="clear: both;"></div>
			<div style="height:20px;"></div>
			<h1>Priority matrix*:</h1>
			<div style="height:15px;"></div>
			<table class="blue" >
				<tr><th colspan=2 rowspan=2></th><th colspan=4>Impact</th></tr>
				<tr><th>Extensive</th><th>Significant</th><th>Moderate</th><th>Minor</th></tr>
				<tr>
					<th rowspan=4>Urgency</th>
					<th>Critical</th>
					<td><b>Critical</b></td>
					<td><b>Critical</b></td>
					<td>High</td>
					<td>Medium</td>
				</tr>
				<tr>
					<th>High</th>
					<td><b>Critical</b></td>
					<td>High</td>
					<td>Medium</td>
					<td>Medium</td>
				</tr>
				<tr>
					<th>Medium</th>
					<td>High</td>
					<td>Medium</td>
					<td>Medium</td>
					<td>Low</td>
				</tr>
				<tr>
					<th>Low</th>
					<td>Medium</td>
					<td>Medium</td>
					<td>Low</td>
					<td>Low</td>
				</tr>
					
			</table>
			<div style="clear: both;"></div>
			<div style="height:10px;"></div>
			*Priority field is calculated automatically based on the above Matrix. &nbsp;<b> [ Priority = Impact X Urgency ]</b>
			<div style="clear: fix;"></div>
			<div style="height:10px;"></div>
		</div>
		
		<div style="clear: both;"></div>	
	</div>
			
</div>
<?php include ("footer.php"); ?>
				