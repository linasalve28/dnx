<?php
	// Check user has permission to execute actions on this object
	
	
	$action=$_GET['action'];
	
	if ($action=="accept") {
		// This will migrate the DSR from the External Database into the primary directory
		
		$external_identikey=get_external_identkey($s_username);
	
	
		
		
	} else if ($action=="delete") {
		
		
		
	}
	
?>