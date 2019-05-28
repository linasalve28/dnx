<?php
require_once("include.php");

$name=$_POST['name'];
$description=$_POST['description'];
$type=$_POST['type'];
if ($type=="purpose"){
		$dsg_id=$_POST['dsg_id'];
		$purpose_object_id=pb_create_object_id("datamanager_purpose");
		
} else if ($type=="activity") {
	
		$activity_object_id=pb_create_object_id("datamanager_activity");
		$purpose_id=$_POST['purpose_id'];
}




// First we insert into the Purpose Database
if ($type=="purpose") {
	$statement = $db->prepare("INSERT INTO datamanager_purpose (object_id,name,description,identikey) VALUES (:object_id,:name,:description,:identikey)");
	$statement->bindParam(':object_id', $purpose_object_id);
$statement->bindParam(':name', $name);
$statement->bindParam(':description', $description);
$statement->bindParam(':identikey', $identikey);
$statement->execute();


	
} else if ($type=="activity") {
		$statement = $db->prepare("INSERT INTO datamanager_activity (object_id,name,description,identikey) VALUES (:object_id,:name,:description,:identikey)");
$statement->bindParam(':object_id', $activity_object_id);
$statement->bindParam(':name', $name);
$statement->bindParam(':description', $description);
$statement->bindParam(':identikey', $identikey);
$statement->execute();
	}




// Then we create a link in the Puporse Link database

if ($type=="purpose") {

	$statement = $db->prepare("INSERT INTO datamanager_purpose_link (object_id,dsg_id,purpose_id,identikey) VALUES (:object_id,:dsg_id,:purpose_id,:identikey)");
	$object_id=pb_create_object_id("datamanager_purpose_link");
	$statement->bindParam(':object_id', $object_id);
	$statement->bindParam(':dsg_id', $dsg_id);
	$statement->bindParam(':purpose_id', $purpose_object_id);
	$statement->bindParam(':identikey', $identikey);
	$statement->execute();
	
} else if ($type=="activity") {

		$statement = $db->prepare("INSERT INTO datamanager_activity_link (object_id,purpose_id,activity_id,identikey) VALUES (:object_id,:purpose_id,:activity_id,:identikey)");
	$object_id=pb_create_object_id("datamanager_activity_link");
		$statement->bindParam(':object_id', $object_id);
		$statement->bindParam(':purpose_id', $purpose_id);
		$statement->bindParam(':activity_id', $activity_id);
		$statement->bindParam(':identikey', $identikey);
		$statement->execute();

	}


if ($type=="purpose") {
	$arr['outcome']="success";
	$arr['smessage']="Purpose Created";
	$arr['lmessage']="A purpose has been created. Remember you can always use this purpose with more than one Data Subject Group";
	$arr['force—refresh']="yes";
} else if ($type=="activity") {
		$arr['outcome']="success";
		$arr['smessage']="Activity Created";
		$arr['lmessage']="An activity has been created. Remember you can always use this activity with more than one purpose and multiple Data Subject Groups";
		$arr['force—refresh']="yes";
	}
	
	
echo json_encode($arr);






?>