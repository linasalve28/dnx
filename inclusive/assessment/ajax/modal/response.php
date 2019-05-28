<?php
	// This outputs AJAX RESPONSE
	$id=$_GET['id'];
	
	
	if ($id=="1") {
		echo "No text field options";
	}elseif($id=="2") {
		echo "Select Box Options";
		include("options.php");
	}
?>