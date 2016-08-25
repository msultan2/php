<?php session_start();  $pagePrivValue=20; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<b>CAB Guidelines:</b>
<p>Please stick to the below guidelines for Daily CAB meeting:
	
	<li>The meeting duration is from 2:30 to 3:30 pm</li>
	<li>Present the CAB report on projector</li>
	<li>Stick to CRQs listed in CAB report only</li>
	<li>Use the 'Daily CAB' Tool and add in the Authorized column (Yes/No) for each change </li>
	<li>Use the 'CAB Attendance' Tool to logg for each team/domain their status (ON TIME or Delay (10,15,20) or NO SHOW)</li>
	<li>Ask attendees to inform their development/engineering parts that the missing CRQs should be subject to exception</li>
	<li>Make sure that testing accountability is well known (who will test and when)</li>
	<li>Stress on closing tasks after implementation</li>
	<li>On Thursday or before any long weekend please make sure that CRQs planned during weekend are discussed during the CAB</li>
	<li>Use the following sequence during the CAB meeting: </li>
	<table width="50%" class=red>
		<TR><TH>Layer</TH><TH>NW/IT</TH><TH>Team</TH></TR>
		<TR><TD>1</TD><TD>NW</TD><TD>Fixed </TD></TR>
		<TR><TD>1</TD><TD>NW</TD><TD>TX</TD></TR>
		<TR><TD>2</TD><TD>NW</TD><TD>Datacom/GSM Security </TD></TR>
		<TR><TD>2</TD><TD>IT</TD><TD>IT Voice & Data </TD></TR>
		<TR><TD>3</TD><TD>NW</TD><TD>Voice CSDB </TD></TR>
		<TR><TD>3</TD><TD>NW</TD><TD>Mobile Internet </TD></TR>
		<TR><TD>3</TD><TD>IT</TD><TD>IT Security </TD></TR>
		<TR><TD>3</TD><TD>IT</TD><TD>DC Systems </TD></TR>
		<TR><TD>4</TD><TD>NW</TD><TD>Services (Charging, Mediation, VAS, Payments) </TD></TR>
		<TR><TD>4</TD><TD>IT</TD><TD>CRM, POS…etc </TD></TR>
		<TR><TD>4</TD><TD>IT</TD><TD>Billing, TIBCO, Provisioning </TD></TR>
	</table>
	
<?php include ("footer_new.php"); ?>