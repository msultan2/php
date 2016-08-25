<?php include ("template.php"); ?>
<br>
<div id="templatemo_content_wrapper">

	<div id="templatemo_content">
	
		<div id="main_content">
        
		<h5><b>Q:How to open a CRQ?</b></h5>
		<p>A:Please Check the Tutorials page for issues related to remedy.</p>
			<br>
		<h5><b>Q:What does the "CAB" meeting Stand for and why do we have to attend it?</b></h5>
		<p>A:The CAB meeting stands for "Change Advisory Board" and it's imporatant as this meeting is held daily to align with all technology operations the daily changes that they will handle to prevent any conflicts that may cause incidnets and affect our network.</p>
			<br>
		<h5><b>Q:How Can i use remedy through my mobile?</b></h5>
		<p>A:You can send SMS to 5200 with letter "H" and you will recieve the following help page:<p>
			<li>Approve : A CRQ123.</li>
			<li>Reject: R CRQ123.</li>
			<li>Approve on behalf : APOBO Alias CRQ123.</li>
			<li>Reject on behalf : RJOBO Alias CRQ123.</li>
			<li>Status: S 123.</li>
			<li>Summary: SM 123.</li>
			<li>Delegate : D staffID Days.</li>
			<br>
			<br>
		<h5><b>Q:Why do we approve twice?</b></h5>
		<p>A:The 1st approval for evaluating the remedy contents to check all the 14 mandatory fields in Remedy (CM_Eval), the 2nd approval is for Authorizing the change after the daily CAB (CM_Authorized)<p>
			<br>
		<h5><b>Q:Why the change should be submitted and approved before 2:00 PM from development side?</b></h5>
		<p>A:Because the daily CAB meeting is held at 2:30 PM where all the changes are discussed to avoid conflict.<p>
			<br>
		<h5><b>Q:When do I need to proceed with the exception process?</b></h5>
		<p>A:<li>When the CRQ is submitted or approved by the requester manager after 2:00 PM of the last working day before the change scheduled night. [when excluded from CAB meeting]</li>
		     <li>When the CRQ is required outside the maintenance window, or in a Freeze night.</li>
		     <li>When the CRQ is scheduled ASAP to deploy a fix or a commercially urgent request. [emergency change] </li>
			<br>
			<br>
		<h5><b>Q: What is the exception process?</b></h5>
		<p>A:The requester should call the Change Management oncall who by his turn make a conference call with all involved parties, the requester should then send a mail to the technology change management copying the implementer & his (N-2) stating the reason and justification of the delay.<p>
		<br>
		<h5><b>Q:Why the daily CAB meeting include both IT & Network teams?</b></h5>
		<p>A:There is a lot of common areas between the IT & Network and they could be impacted by the changes of each both.<p>
		<br>
		<h5><b>Q:When do I have to take Change Management approval on my Standard Change?</b></h5>
		<p>A:When the Standard Change is scheduled to be implemented outside maintenance window, or in the week end, it needs Change Management Approval.<p>

	</div>
  <!--    <div id="sidebar">
        
        
        <div id="sidebar_featured_project">
        	
            <h3>Submit a Question</h3>
            <div id="contact_form">
            
                <form action="send_mail.php"  method="post" >
                
                    <table>
					<tr>
					<td>Email Adress:</td>
					<td>
					<input type="text" name="email_address" value="" maxlength="100" />
					</td>
					</tr>
					<tr>
					<td>Comments:</td>
					<td>
					<textarea rows="10" cols="50" name="comments"></textarea>
					</td>
					</tr>
					<tr><td>&nbsp;</td>
					<td>
					<input type="submit" value="Submit" />
					</td>
					</tr>
					</table> 
                </form>
            </div>
        </div> <!-- end of sidebar -->

		<div class="cleaner"></div>
	</div> <!-- end of content -->
</div>
</div>

<?php include ("footer.php"); ?>