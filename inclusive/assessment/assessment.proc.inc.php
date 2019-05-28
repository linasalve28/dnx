<?php

// IDENTIKEY CONFIRMED
require_once(DB_ROOT."/tb.db.conn.php");
// DECLARE ALL VARIABLES
$title=$_POST['title'];
$description=$_POST['description'];
$instructions=$_POST['instructions'];
$review=$_POST['review'];

$function=$_POST['function'];

if ($function=="edit") {
	$function="edit";
	$id=$_POST['id'];
} else if ($function=="add") {
		$function="add";
} else if ($function=="del") {
	$function=$_POST['function'];
	$aoid=$_POST['aoid'];
	$qoid=$_POST['qoid'];
	$soid=$_POST['soid'];
} else {
	echo "FC1 Security Violation";
	exit;
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

}
if ($function=="add" && empty($errorcode)) {

	$object_id=pb_create_object_id("assessment_registry");

	$seed = str_split('abcdefghijklmnopqrstuvwxyz'
		.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
		.'0123456789'); // and any other characters
	shuffle($seed); // probably optional since array_is randomized; this may be redundant
	$rand = '';
	foreach (array_rand($seed, 7) as $k) $unique_access_id .= $seed[$k];



	$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	$statement = $db->prepare("INSERT INTO assessment_registry (identikey,object_id,title,created_date,description,instructions,unique_access_id,reviews_requested) VALUES (:identikey,:object_id,:title,now(),:description,:instructions,:unique_access_id,:reviews_requested)");

	$statement->bindParam(':identikey', $s_identikey);
	$statement->bindParam(':object_id', $object_id);
	$statement->bindParam(':title', $title);
	$statement->bindParam(':description', $description);
	$statement->bindParam(':instructions', $instructions);
	$statement->bindParam(':unique_access_id', $unique_access_id);
	$statement->bindParam(':reviews_requested', $review);

	$statement->execute();

	$last_item=$db->lastInsertId();
	pb_system_log("Assessment Created","Assessment Registry",$last_item);

	$item=pb_get_object_id_from_id("assessment_registry",$last_item);

	pb_set_object_permission("assessment",$item,"userid",$_SESSION['s_userid'],"edit");
	pb_set_object_permission("assessment",$item,"identikey",$s_identikey,"edit");

	$outcome="success";

} else if ($function=="edit" && empty($errorcode)) {

		// Uncomment for debugging SQL statement
		//$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );


		// REPLACE WITH SQL INSERT COMMANDS

		// NEED TO CHECK PERMISSION
		pb_check_object_permission("assessment",$id,"userid","","edit");

		$statement = $db->prepare("UPDATE assessment_registry SET title = :title,description = :description,instructions = :instructions,reviews_requested = :reviews_requested WHERE object_id=:id");


		$statement->bindParam(':id', $id);
		$statement->bindParam(':title', $title);
		$statement->bindParam(':description', $description);
		$statement->bindParam(':instructions', $instructions);
		$statement->bindParam(':reviews_requested', $review);
		$statement->execute();

		$outcome="success";

		//print_r($statement->errorInfo());




} else if($function=="del") {
    $status="deleted";
    //update assessment to deleted
    $statement = $db->prepare("UPDATE assessment_registry SET status = 'deleted' WHERE object_id=:object_id");
    $statement->bindParam(':object_id', $aoid);
    $statement->execute();

    //delete section
    $statement = $db->prepare("UPDATE assessment_section SET section_status = 'deleted' WHERE parent_assessment_id=:parent_assessment_id");
    $statement->bindParam(':parent_assessment_id', $aoid);
    $statement->execute();


    //update assessment_question to deleted
    $query = "UPDATE assessment_question SET item_status = 'deleted' WHERE assessment_id=:aoid";
    $statement = $db->prepare($query);
    $statement->bindParam(':aoid', $aoid);
    $statement->execute();

    //update assessment_request to deleted
    $statement = $db->prepare("UPDATE assessment_request SET status = 'deleted' WHERE assessment_object_id=:aoid");
    $statement->bindParam(':aoid', $aoid);
    $statement->execute();

    //update assessment_response to deleted
    $statement = $db->prepare("UPDATE assessment_response SET status = 'deleted' WHERE assessment_id=:aoid");
    $statement->bindParam(':aoid', $aoid);
    $statement->execute();

    //update assessment_response_item to deleted
    $statement = $db->prepare("UPDATE assessment_response_item SET status = 'deleted' WHERE assessment_id=:aoid");
    $statement->bindParam(':aoid', $aoid);
    $statement->execute();

    $arr['outcome'] = "deleted";
    $arr['smessage'] = "Assessment deleted";
    $arr['lmessage'] = "Heres what we see:" . $message;
    $arr['refresh-div'] = "card-body";
    $arr['refresh-url'] = "/controller/assessment/engage";
    $arr['refresh-content'] = '';
    $arr['force-refresh'] = "yes";

    $outcome = "success";

} else {
	echo "Sentinal AI Security: Violation Detected 1";
	$outcome="failed";

}


?>
