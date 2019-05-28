<?php
include_once(FS_ROOT_FUNCTIONS."/base.functions.php");

function main(){

	global $db;
	print_r($_POST);
	$object_id = pb_create_object_id("assessment_question_dependency");
	// This should come from the hidden form field
	$dependent_on_qoid=$_POST['dependent_on_qoid'];
	$equal=$_POST['equal'];
	$qoid=$_POST['qoid'];
	$function=$_POST['function'];

	$query = "INSERT INTO assessment_question_dependency (object_id,qoid,dependent_on_qoid,equal_to) 
	VALUES ('$object_id','$qoid','$dependent_on_qoid','$equal_to')";

	$statement = $db->prepare("INSERT INTO assessment_question_dependency(object_id,
	qoid,dependent_on_qoid,equal_to,created_by,created_on,last_modified_on,last_modified_by) VALUES (:object_id,:qoid,:dependent_on_qoid,:equal_to,:created_by,NOW(),NOW(),:last_modified_by)");

	$object_id = pb_create_object_id(assessment_question_dependency);
	$created_by = $_SESSION['s_userid'];
	$statement->bindParam(':object_id', $object_id);
	$statement->bindParam(':qoid', $qoid);
	$statement->bindParam(':dependent_on_qoid', $dependent_on_qoid);
	$statement->bindParam(':equal_to', $equal);
	$statement->bindParam(':last_modified_by', $created_by);
	$statement->bindParam(':created_by', $created_by);
	$statement->execute();
	echo "Condition has been created $query: ";
}
?>