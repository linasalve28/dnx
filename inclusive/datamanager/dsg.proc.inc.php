<?php
// IDENTIKEY CONFIRMED
require_once(DB_ROOT."/tb.db.conn.php");

// Declare Variables
$name=$_POST['name'];
$description=$_POST['description'];
$identikey=$s_identikey;

$function=$_POST['function'];
$error_prefix = "<span class=\"label label-danger label-autoenroll\">";
$error_suffix = "</span>";

if (!$function) {
	$function="add";
}

//check Name
if(pb_validate_required($name)== false) {
	$errorcode['name'] = $error_prefix . "You need to include a name" . $error_suffix;
}

//check description
if (pb_validate_required($description)==false) {
	$errorcode['description'] = $error_prefix . "Please include a description" . $error_suffix;
}

if ($errorcode) {
	$outcome="error";
} else {

	if ($function == "add") {

// Execute Database
		$statement = $db->prepare("INSERT INTO datamanager_data_subject_group (object_id,identikey,name,description) VALUES (:object_id,:identikey,:name,:description)");

		$object_id = pb_create_object_id("datamanager_data_subject_group");

		$statement->bindParam(':object_id', $object_id);
		$statement->bindParam(':identikey', $identikey);
		$statement->bindParam(':name', $name);
		$statement->bindParam(':description', $description);
		$statement->execute();

		$outcome = "success";

	}
}
// Set object permissions


// Feedback
//echo "Data Subject Group created";

?>