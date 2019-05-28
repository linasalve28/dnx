<?php
	
	
	function main() {
		global $db;
		
$to = "s.fortes@kenexus.com";
$subject = "PrivacyBase Assessment Reminder";
$txt = "Hello! This is a reminder that you have an assessment pending.";
$headers = "From: webmaster@trustbase.com";

mail($to,$subject,$txt,$headers);
		
	}
	
			setcookie("notification", "A reminder has been sent to $to", time() + (15), "/"); // 86400 = 1 day
 		header("location:".WS_CONTROLLER."/assessmentrequestlist");
?>