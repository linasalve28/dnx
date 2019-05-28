<?php
	$object_type=$_GET['otype'];
	$object_id=$_GET['oid'];
	
if (!$object_type or !$object_id) {
	echo "Error Code 301e";
	exit;
}

if ($object_type=="dta") {
	// Data Transfer agreement
	$table="dta_registry";
	$object_name="Data Transfer Agreement";
	
	
	} else  if ($object_type=="certification_record") {
	// Data Transfer agreement
	$table="certification_record";
	$object_name="Certification record";
	
} else {
	
	echo "Error 301b";
	exit;
}

	
if ($object_id) {	
	
	
if (pb_check_object_permission($object_type,$object_id,"userid",$_SESSION['s_userid'],"edit","advanced")) {
	
	$query = "update $table set object_status='deleted' where object_id='$object_id'";
	$statement = $db->prepare($query);

	//$statement->bindParam(':object_id', $object_id);
	$statement->execute();
	echo "success";
} else {
	echo "Error 301c";
}


} else {
	echo "Error 301d";
}
?>