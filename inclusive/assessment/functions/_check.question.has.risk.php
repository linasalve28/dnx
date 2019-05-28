<?php
function check_question_has_risk($qoid) {

	global $db;
	$query="select id from assessment_risk where question_object_id='$qoid'";
	$statement = $db->prepare($query);
	$statement->execute();
	$errcheck=$statement->rowCount();
	if ($errcheck==0) {
		return false;
	} else {
		return true;
	}



}
?>