<?php

function pb_alert_link($object_id) {
	global $db;

	$statement = $db->prepare("select * from system_alerts where object_id = :object_id");
	$statement->bindParam(':object_id', $object_id);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

		$scope=$row['scope'];
		$target_type=$row['target_type'];
		$target_id=$row['target_id'];
		$title=$row['title'];

		$read_status=$row['read_status'];

	}

	if ($read_status=="unread") {
		alert_update($object_id);
	}


	switch($target_type) {


	case "assessment_request":
		$url = "";
		break;

	case "certification":
		$url = "";
		break;



	}
	}

	function alert_update($object_id) {
		global $db;

		$statement = $db->prepare("UPDATE system_alerts SET read_status = 'read' WHERE object_id=:object_id");

		$statement->bindParam(':object_id', $object_id);

		$statement->execute();

	}

function alert_create($title,$target_type,$target_id,$target_user="") {
	global $db;
	if (!$target_user) {
		$target_user=$_SESSION['s_userid'];
	}
	$statement = $db->prepare("INSERT INTO system_alerts (object_id,scope,target_type,target_id,title,date,read_status,target_user) VALUES (:object_id,:scope,:target_type,:target_id,:title,NOW(),:read_status,:target_user)");

	$object_id=pb_create_object_id("system_alerts");
	$scope="user";

	$statement->bindParam(':object_id', $object_id);
	$statement->bindParam(':scope', $scope);
	$statement->bindParam(':target_user', $target_user);

	$statement->bindParam(':target_type', $target_type);
	$statement->bindParam(':target_id', $target_id);
	$statement->bindParam(':title', $title);


	$read_status="unread";
	$statement->bindParam(':read_status', $read_status);
	$statement->execute();


	
}
