<?php
	include("/home/trustbase/dbn/tb.db.conn.php");
	$object_type=$_GET['otype'];
	$object_id=$_GET['oid'];

if ($object_type=="dta") {
	// Data Transfer agreement
	
	$table="dta_registry";
	$object_name="Data Transfer Agreement";
}

	
if ($object_id) {	
	echo $query="update $table set object_status='deleted' where object_id='$object_id'";
$statement = $db->prepare($query);
//$statement->bindParam(':object_id', $object_id);
$statement->execute();
}


?>