<?php
	// Incomplete
	// Designed to only make available certain modules and actions
	
function pb_module_security($module,$outcome="abort") {
	$s_username=$_SESSION['s_username'];
		
		
	$query="select * from module_permissions where module='module' and $user='$s_username'";
		
		
		if ($num==0 and $outcome=="abort") {
		// abort the command and do not process
		exit;
			
		} if ($num==0 and $outcome=="hide") {
			// Do nothing. 
			return false;
			
		}  else if ($num > 0) {
			return true;
		}
		
	}
	
?>