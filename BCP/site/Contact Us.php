<h2>Feedback Form</h2>
<?php
  if (isset($_POST["p1"]) && isset($_POST["p2"]) && isset($_POST["p3"]))
    {
		$from = $_POST["p1"]; // sender
		$Email = $_POST["p2"];
		$message = $_POST["p3"];
		// message lines should not exceed 70 characters (PHP rule), so wrap it
		$message = wordwrap($message, 40);
		// send mail
		mail("BCP@vodafone.com","Feedback",$message,"From: $Email\n");
		echo "Thank you for sending us feedback";
    }
	else
	{
	
	}
 
?>