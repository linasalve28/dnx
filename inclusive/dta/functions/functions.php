<?php
	
	
function dta_integrity($object_id) {
	
	global $db;
	$query="select * from dta_certification_dependency where parent_dta_object_id='$object_id'";
	$statement = $db->prepare($query);
	$statement->execute();
	
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$id=$row['id'];
		$parent_dta_object_id=$row['parent_dta_object_id'];
		$certification=$row['certification'];

	}
	
	// get certification records that are dependant
	// check status of all items
	// if any are invalid
	//return "at risk"
	//else
	// return good
	
	
}	
	
function check_certification_dependency($target,$object_id) {
	global $db;
	$query="select id from dta_certification_dependency where parent_dta_object_id='$object_id' and certification='$target'";
	$statement = $db->prepare($query);
	$statement->execute();
	$errcheck=$statement->rowCount();
	if ($errcheck==0) {
		return false;
	} else {
		return true;
	}
}


function flush_certification_dependency($object_id) {
	global $db;
	$query="delete from dta_certification_dependency where parent_dta_object_id='$object_id' limit 10";
	$statement = $db->prepare($query);
	$statement->execute();
}

function show_certification_dependency($object_id) {
	global $db;
	$query="select id from dta_certification_dependency where parent_dta_object_id='$object_id'";
	$statement = $db->prepare($query);
	$statement->execute();
	
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$id=$row['id'];
		$parent_dta_object_id=$row['parent_dta_object_id'];
		$certification=$row['certification'];

	}

}

?>	