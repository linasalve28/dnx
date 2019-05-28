<?php
// This function is to check the unique
// NOT IMPLEMENTED
// Depreciated 
/*
	function pb_assessment_collision_check($value) {

  $statement = $db->prepare("select COUNT(*) from assessment_registry where unique_access_id = :unique_access_id");
    $statement->bindParam(':unique_access_id', $value);
   	$statement->execute();

	if ($statement->fetchColumn() > 0) {
	  return false;
	} else {
	  return true;

	}
 

}
/*
?>