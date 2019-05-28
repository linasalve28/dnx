<?php
	
function check_question_has_dependency($qoid) {

	global $db;
	$query="select id from assessment_question_dependency where qoid='$qoid'";
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