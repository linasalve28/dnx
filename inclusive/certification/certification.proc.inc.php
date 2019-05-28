<?php
// This include creates / edits a data transfer agreement
require_once(DB_ROOT."/tb.db.conn.php");
// Change to final location
require_once(FS_COMPONENT_FILECONTROL."/process.php");

$id=$_POST['id'];
$function=$_POST['function'];
$date_started=$_POST['date_started'];
$date_ended=$_POST['date_ended'];
$certification_start_date=$_POST['certification_start_date'];
$certification_expire_date=$_POST['certification_expire_date'];
$certification_other_data=$_POST['certification_other_data'];
$certification_select=$_POST['certification_select'];
$identikey=$_SESSION['s_identikey'];



$error_prefix="<span class=\"label label-danger\">";
$error_suffix="</span>";


//Santize Date: To do

if ($date_started) {
	$date_started_trans=date('Y-m-d', strtotime($date_started));
}
if ($date_ended) {
	$date_ended_trans=date('Y-m-d', strtotime($date_ended));
}

// Validation Items


//if (pb_validate_required($details)== false){
//$errorcode['details']=$error_prefix."You need to include details about this data transfer".$error_suffix;
//}

if ($errorcode) {
	$outcome="error";

} else {

	if ($function=="add") {


		$object_id=pb_reate_object_id("certification_record");
		$status_verified="pending";
		$object_status="active";


		$statement = $db->prepare("INSERT INTO certification_record (id,object_id,certification_details,certification_start_date,certification_expire_date,status_verified,certification_other_data,parent_system_certification_registry_object_id,identikey,object_status) VALUES (:id,:object_id,:certification_details,:certification_start_date,:certification_expire_date,:status_verified,:certification_other_data,:parent_system_certification_registry_object_id,:identikey,:object_status)");

		$statement->bindParam(':id', $id);
		$statement->bindParam(':object_id', $object_id);
		$statement->bindParam(':certification_details', $certification_details);
		$statement->bindParam(':certification_start_date', $date_started_trans);
		$statement->bindParam(':certification_expire_date', $date_ended_trans);
		$statement->bindParam(':status_verified', $status_verified);
		$statement->bindParam(':certification_other_data', $certification_other_data);
		$statement->bindParam(':parent_system_certification_registry_object_id', $certification_select);
		$statement->bindParam(':identikey', $identikey);
		$statement->bindParam(':object_status', $object_status);
		$statement->execute();

		$item=pb_get_object_id_from_id("certification_record",$db->lastInsertId());

		pb_file_control_upload("policy","certification_record",$item,"policy");
		pb_file_control_upload("supporting","certification_record",$item,"supporting");

		pb_set_object_permission("certification_record",$item,"userid",$_SESSION['s_userid'],"edit");
		pb_set_object_permission("certification_record",$item,"identikey",$s_identikey,"edit");


		$outcome="success";
$notification="Certification registered";

	} else if ($function=="edit") {

		pb_check_object_permission("certification_record",$id,"userid","","edit");
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

		$statement = $db->prepare("UPDATE certification_record SET certification_details = :certification_details,certification_start_date = :certification_start_date,certification_expire_date = :certification_expire_date,certification_other_data = :certification_other_data,parent_system_certification_registry_object_id = :parent_system_certification_registry_object_id WHERE object_id=:id");

			$statement->bindParam(':id', $id);
			$statement->bindParam(':certification_details', $certification_details);
			$statement->bindParam(':certification_start_date', $date_started_trans);
			$statement->bindParam(':certification_expire_date', $date_ended_trans);
			$statement->bindParam(':certification_other_data', $certification_other_data);
			$statement->bindParam(':parent_system_certification_registry_object_id', $certification_select);


		$statement->execute();

			pb_file_control_upload("supporting","certification_record",$id,"supporting");
			pb_file_control_upload("policy","certification_record",$id,"policy");

			

	

			$outcome="success";

$notification="Certification updated";

		} else {
		echo "Sentinal AI Security: Violation Detected";
		$outcome="failed";

	}


}

if ($outcome=="success") {
			setcookie("notification", $notification, time() + (15), "/"); // 86400 = 1 day
header("Location:".WS_CONTROLLER."/certlist");
	
}
?>