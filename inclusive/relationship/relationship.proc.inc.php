<?php
// This include creates / edits a data transfer agreement
require_once(DB_ROOT."/tb.db.conn.php");
// Change to final location
require_once(FS_COMPONENT_FILECONTROL."/process.php");

$id=$_POST['id'];
$function=$_POST['function'];


$object_id=$_POST['object_id'];
$identikey=$_SESSION['s_identikey'];
$creator=$_SESSION['s_userid'];
$company_id=$_POST['company_id'];
$details=$_POST['details'];
$object_status="active";
$integrity_status="Establishing";


$error_prefix="<span class=\"label label-danger\">";
$error_suffix="</span>";


//Santize Date: To do


// Validation Items




if (pb_validate_required($company_id)== false){
	$errorcode['companies']=$error_prefix."You need to specify the company the relationship is being formed with".$error_suffix;
}



if ($errorcode) {
	$outcome="error";

} else {

	if ($function=="add") {

$statement = $db->prepare("INSERT INTO relationship_registry (id,
object_id,
identikey,
creator,
target_company_id,
details,
object_status,
integrity_status) VALUES (:id,
:object_id,
:identikey,
:creator,
:target_company_id,
:details,
:object_status,
:integrity_status)");

$statement->bindParam(':id', $id);
$statement->bindParam(':object_id', $object_id);
$statement->bindParam(':identikey', $identikey);
$statement->bindParam(':creator', $creator);
$statement->bindParam(':target_company_id', $company_id);
$statement->bindParam(':details', $details);
$statement->bindParam(':object_status', $object_status);
$statement->bindParam(':integrity_status', $integrity_status);
$statement->execute();







		
		pb_set_object_permission("relationship",$item,"userid",$_SESSION['s_userid'],"edit");
		pb_set_object_permission("relationship",$item,"identikey",$s_identikey,"edit");



if ($certification_dependency) {
		foreach ($certification_dependency as &$cert) {
			$query="INSERT INTO certification_dependency_registry (id,parent_dta_object_id,certification) VALUES ('',:object_id,:certification)";
			$statement = $db->prepare($query);
			$statement->bindParam(':object_id', $object_id);
			$statement->bindParam(':certification', $cert);
			$statement->execute();
		}
		}





		$outcome="success";


	} else if ($function=="edit") {

pb_check_object_permission("dta",$id,"userid","","edit");
			$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );


			$query="UPDATE dta_registry SET
      transfer_type = :transfer_type,
   transfer_from_id = :transfer_from_id,
   transfer_to_id = :transfer_to_id,
   date_started = :date_started,
   date_ended = :date_ended,
   details = :details,
   cross_border_transfer = :cross_border_transfer,
   transfer_from_country = :transfer_from_country,
   transfer_to_country = :transfer_to_country
   WHERE object_id=:id";



			$statement = $db->prepare($query);



			$statement->bindParam(':id', $id);
			$statement->bindParam(':transfer_type', $transfer_type);
			$statement->bindParam(':transfer_from_id', $transfer_from_id);
			$statement->bindParam(':transfer_to_id', $transfer_to_id);
			$statement->bindParam(':date_started', $date_started_trans);
			$statement->bindParam(':date_ended', $date_ended_trans);
			$statement->bindParam(':transfer_to_country', $transfer_to_country);
			$statement->bindParam(':transfer_from_country', $transfer_from_country);
			$statement->bindParam(':cross_border_transfer', $cross_border_transfer);
			$statement->bindParam(':details', $details);



			$statement->execute();



			file_control_upload("contract","dta",$id,"contract");
			
flush_certification_dependency($id);

		foreach ($certification_dependency as &$cert) {
			$query="INSERT INTO dta_certification_dependency (id,parent_dta_object_id,certification) VALUES ('',:object_id,:certification)";
			$statement = $db->prepare($query);
			$statement->bindParam(':object_id', $id);
			$statement->bindParam(':certification', $cert);
			$statement->execute();
		}

			$outcome="success";


		} else {
		echo "Sentinal AI Security: Violation Detected";
		$outcome="failed";

	}


}


?>