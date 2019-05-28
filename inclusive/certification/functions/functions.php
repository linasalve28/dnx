<?php
/*
	function certification_record_status_agg($dta_object_id) {
		// This function will loop through and check the status of all certification records for a particular dta. If any are out of compliance it will return a failure

		select * from dta_certification_dependency
		select * from certification_record where parent_system_certification_registry_object_id=
		$dta_compliance_status="Out of Compliance";
		return $dta_compliance_status;


	}
	*/

function certification_record_status($identikey,$certification_object_id) {
	global $db;
	$query="select * from certification_record where parent_system_certification_registry_object_id='$certification_object_id' and identikey='$identikey'";
	$statement = $db->prepare($query);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

		$status_verified=$row['status_verified'];

		if ($status_verified=="valid") {
			return "valid";
		} else {
			return "invalid";
		}

	}

		return "invalid";


}


function certification_list($category="") {
	global $db;
	// This returns an array with the certification objectid as the key, and the certification name as the list item.
	if ($category) {
		$query="select * from system_certification_registry where certification_category = '$category' order by certification_name asc";
	} else {
		$query="select * from system_certification_registry order by certification_name asc";
	}

	$statement = $db->prepare($query);
	$statement->execute();

	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$id=$row['id'];
		$object_id=$row['object_id'];
		$certification_name=$row['certification_name'];
		$var[$object_id]=$certification_name;
	}

	return $var;

}


function certification_name($object_id) {
	global $db;
	// This returns the certification name from the object id
    $query="select certification_name from system_certification_registry where object_id = '$object_id' limit 1";
	$statement = $db->prepare($query);
	$statement->execute();

	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		return $certification_name=$row['certification_name'];
	}



}
?>