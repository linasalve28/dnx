<?php

$error_prefix="<span class=\"label label-danger\">";
$error_suffix="</span>";

$id=$_POST['id'];
$object_id=pb_create_object_id("external_request_registry");
$request_type="assessment";
$request_access_id=create_unique_access_id();
$oid=$_POST['oid'];
$email=$_POST['email'];
$name=$_POST['name'];
$company=$_POST['company'];
$request_status="Not Viewed";
$created_by=$_SESSION['s_userid'];
$created_by_identikey=$_SESSION['s_identikey'];


if (pb_validate_required($name)== false){
	$errorcode['name']=$error_prefix."You need to include a name".$error_suffix;
}

if (pb_validate_required($company)== false){
	$errorcode['company']=$error_prefix."You need to include a company name".$error_suffix;
}

if (pb_validate_required($email)== false){
	$errorcode['email']=$error_prefix."You need to include a valid email address".$error_suffix;
}

//pb_check_object_permission("assessment",$oid,"userid","","view");



if ($errorcode) {
	$outcome="error";

} else {




	$statement = $db->prepare("INSERT INTO external_request_registry (id,object_id,request_type,request_object_id,request_access_id,name,email,company,created_date,request_status,created_by,created_by_identikey) VALUES (:id,:object_id,:request_type,:request_object_id,:request_access_id,:name,:email,:company,NOW(),:request_status,:created_by,:created_by_identikey)");


	$statement->bindParam(':id', $id);
	$statement->bindParam(':object_id', $object_id);
	$statement->bindParam(':request_type', $request_type);
	$statement->bindParam(':request_object_id', $oid);
	$statement->bindParam(':request_access_id', $request_access_id);
	$statement->bindParam(':name', $name);
	$statement->bindParam(':email', $email);
	$statement->bindParam(':company', $company);
	$statement->bindParam(':request_status', $request_status);
	$statement->bindParam(':created_by', $created_by);
	$statement->bindParam(':created_by_identikey', $created_by_identikey);
	$statement->execute();

	$outcome="success";
}
?>