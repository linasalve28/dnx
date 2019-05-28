<?php
// This proc file is included into the form page calling it.

require_once(DB_ROOT."/tb.db.conn.php");

// DECLARE ALL VARIABLES
$title=$_POST['title'];


$function=$_POST['function'];

if ($function=="edit") {
	$id=$_POST['id'];
}

$error_prefix="<span class=\"label label-danger\">";
$error_suffix="</span>";

//Santize Date: To do

// Begin Validation

// Validation Items


if (pb_validate_required($title)== false){
	$errorcode['title']=$error_prefix."You need to include a title for this assessment".$error_suffix;
}


if ($errorcode) {
	$outcome="error";

} else {

	if ($function=="add") {


		// REPLACE WITH SQL INSERT COMMANDS
		
// GET LAST INSERTED ID

// GET LAST INSERTED OBJECT_ID

// SET OBJECT PERMISSIONS		

		// PASTE INSERT SQL HERE


		$outcome="success";


	} else if ($function=="edit") {

			// Uncomment for debugging SQL statement



			// PASTE UPDATE SQL HERE


			$outcome="success";





		} else {
		echo "Sentinal AI Security: Violation Detected: Function Restricted";
		$outcome="failed";

	}


}


?>