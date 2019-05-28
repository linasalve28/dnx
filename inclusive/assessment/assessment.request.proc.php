<?php
// This proc file is included into the form page calling it.

//require("/home/trustbase/dbn/tb.db.conn.php");
require_once(DB_ROOT."/tb.db.conn.php");

// DECLARE ALL VARIABLES
echo $title=$_POST['title'];

 $assessment_object_id=$_POST['aoid'];
 $to=$_POST['to'];
 $status="Open";


$error_prefix="<span class=\"label label-danger\">";
$error_suffix="</span>";


//Santize Date: To do

// Begin Validation

// Validation Items


if (pb_validate_required($to)== false){
	$errorcode['to']=$error_prefix."You need to enter a valid email address to send the Assessment Request to".$error_suffix;
}


if ($errorcode) {
	
	$outcome="error";

} else {


$statement = $db->prepare("select userid from access_users where email = :email");
 		$statement->bindParam(':email', $to);
 		$statement->execute();
 		while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

		 $userid=$row['userid'];
		 $existing_user="yes";


}


$object_id=pb_create_object_id("assessment_request");

$statement = $db->prepare("INSERT INTO assessment_request (object_id,from_userid,to_email,to_userid,assessment_object_id,date_created,status,identikey) VALUES (:object_id,:from_userid,:to_email,:to_userid,:assessment_object_id,NOW(),:status,:identikey)");

$from=$_SESSION['s_userid'];

$identikey=$_SESSION['s_identikey'];

$statement->bindParam(':object_id', $object_id);
$statement->bindParam(':from_userid', $from_userid);
$statement->bindParam(':to_email', $to_email);
$statement->bindParam(':to_userid', $to_userid);
$statement->bindParam(':identikey', $identikey);
$statement->bindParam(':assessment_object_id', $assessment_object_id);
$statement->bindParam(':status', $status);

$statement->execute();
$outcome="success";

pb_set_object_permission("assessment_request",$object_id,"userid","","author");
pb_set_object_permission("assessment_request",$object_id,"identikey","","");

//

if ($existing_user=="yes") {
alert_create("$_SESSION[s_user_fullname] has sent you an assessment to complete","assessment_request","1001",$userid); 
}


 		setcookie("notification", "An assessment request sent to $to", time() + (15), "/"); // 86400 = 1 day
 		header("Location:".WS_CONTROLLER."/controller/assessment/list");

		


}


?>