<?php
// This include creates / edits a data transfer agreement
require_once(DB_ROOT."/tb.db.conn.php");
// Change to final location
//require_once(FS_COMPONENT_FILECONTROL."/process.php");

$id=$_POST['id'];
$function=$_POST['function'];
$data_transfer_id=$_POST['data_transfer_id'];
$company_id=$_POST['company_id'];
$date_started=$_POST['date_started'];
$date_ended=$_POST['date_ended'];
$details=$_POST['details'];
$transfer_status=$_POST['transfer_status'];
$other_information=$_POST['other_information'];
$certification_dependant=$_POST['certification_dependant'];
$certification_dependant_status=$_POST['certification_dependant_status'];
$cross_border_transfer=$_POST['cross_border_transfer'];
$transfer_to_country=$_POST['transfer_to_country'];
$transfer_from_country=$_POST['transfer_from_country'];
$transfer_type=$_POST['transfer_type'];
$certification_dependency=$_POST['certification_dependency'];
$company_name=$_POST['companies'];
if ($transfer_type=="FROM"){
	$transfer_to_id=$s_identikey;
	$transfer_from_id=$company_id;
} else if ($transfer_type=="TO") {
	$transfer_from_id=$s_identikey;
	$transfer_to_id=$company_id;
}


$error_prefix="<span class=\"label label-danger\">";
$error_suffix="</span>";


//Santize Date: To do

if ($date_started) {
	$date_started_trans=date('Y-m-d', strtotime($date_started));
} else {
    //$errorcode['date_started']=$error_prefix."Please enter a date started".$error_suffix;
}
if ($date_ended) {
	$date_ended_trans=date('Y-m-d', strtotime($date_ended));
}

// Validation Items
$error_prefix = "<span class=\"label label-danger label-autoenroll\">";
$error_suffix = "</span>";

//check valid details
if (pb_validate_required($details)== false){
	$errorcode['details']=$error_prefix."You need to include details about this data transfer".$error_suffix;
}

//check valid company_name
if (pb_validate_required($company_name)== false){
	$errorcode['company_name']=$error_prefix."You need to specify the company name where the data is being transferred from".$error_suffix;
}

//check valid company_id
if (pb_validate_required($company_id)==false) {
	$errorcode['companies'] = $error_prefix . "You need to specify the company where the data is being transferred from" . $error_suffix;
}

if (pb_validate_required($transfer_to_id)== false){
	$errorcode['transfer_to_id']=$error_prefix."You need to specify the company the data is being transferred to".$error_suffix;
}


if ($cross_border_transfer=="yes"){

	if (!$transfer_from_country) {
		$errorcode['transfer_from_country']=$error_prefix."You need to specify the country the data is being transferred from".$error_suffix;
	}

	if (!$transfer_to_country) {
		$errorcode['transfer_to_country']=$error_prefix."You need to specify the country the data is being transferred to".$error_suffix;
	}

	if ($transfer_to_country==$transfer_from_country) {
		$errorcode['transfer_to_country']=$error_prefix."A cross border transfer can only occurr between two DIFFERENT countries".$error_suffix;
		$errorcode['transfer_from_country']=$error_prefix."A cross border transfer can only occurr between two DIFFERENT countries".$error_suffix;
	}

}

if ($errorcode) {
	$outcome="error";

} else {

	if ($function=="add") {

		$query="INSERT INTO dta_registry (id,object_id,identikey,creator,data_transfer_id,transfer_from_id,transfer_to_id,date_started,date_ended,details,transfer_status,other_information,certification_dependant,certification_dependant_status,cross_border_transfer,transfer_from_country,transfer_to_country,transfer_type,object_status,integrity_status) VALUES (:id,:object_id,:identikey,:creator,:data_transfer_id,:transfer_from_id,:transfer_to_id,:date_started,:date_ended,:details,:transfer_status,:other_information,:certification_dependant,:certification_dependant_status,:cross_border_transfer,:transfer_from_country,:transfer_to_country,:transfer_type,:object_status,:integrity_status)";


		$object_id=pb_create_object_id("dta_registry");
		$object_status="active";
		$integrity_status="pending";
		
		$statement = $db->prepare($query);

		$statement->bindParam(':id', $id);
		$statement->bindParam(':object_id', $object_id);
		$statement->bindParam(':identikey', $s_identikey);
		$statement->bindParam(':creator', $s_username);
		$statement->bindParam(':data_transfer_id', $data_transfer_id);
		$statement->bindParam(':transfer_from_id', $transfer_from_id);
		$statement->bindParam(':transfer_to_id', $transfer_to_id);
		$statement->bindParam(':transfer_to_country', $transfer_to_country);
		$statement->bindParam(':transfer_from_country', $transfer_from_country);
		$statement->bindParam(':cross_border_transfer', $cross_border_transfer);
		$statement->bindParam(':date_started', $date_started_trans);
		$statement->bindParam(':date_ended', $date_ended_trans);
		$statement->bindParam(':details', $details);
		$statement->bindParam(':transfer_status', $transfer_status);
		$statement->bindParam(':other_information', $other_information);
		$statement->bindParam(':certification_dependant', $certification_dependant);
		$statement->bindParam(':certification_dependant_status', $certification_dependant_status);
		$statement->bindParam(':transfer_type', $transfer_type);
		$statement->bindParam(':object_status', $object_status);
		$statement->bindParam(':integrity_status', $integrity_status);
		$statement->execute();
		$item=pb_get_object_id_from_id("dta_registry",$db->lastInsertId());

        $outcome='success';
		file_control_upload("policy","dta",$item,"policy");
		file_control_upload("contract","dta",$item,"contract");

		pb_set_object_permission("dta",$item,"userid",$_SESSION['s_userid'],"edit");
		pb_set_object_permission("dta",$item,"identikey",$s_identikey,"edit");



	if ($certification_dependency) {
		foreach ($certification_dependency as &$cert) {
			$query = "INSERT INTO dta_certification_dependency (id,parent_dta_object_id,certification) VALUES ('',:object_id,:certification)";
			$statement = $db->prepare($query);
			$statement->bindParam(':object_id', $object_id);
			$statement->bindParam(':certification', $cert);
			$statement->execute();
		}
	}





		$outcome="success";
		
 		setcookie("notification", "Data Transfer Agreement created", time() + (15), "/"); // 86400 = 1 day
 		header("location:".WS_CONTROLLER."/dtalist");

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

            $outcome="success";

			file_control_upload("policy","dta",$id,"policy");
			file_control_upload("contract","dta",$id,"contract");
			
			flush_certification_dependency($id);

		foreach ($certification_dependency as &$cert) {
			$query="INSERT INTO dta_certification_dependency (id,parent_dta_object_id,certification) VALUES ('',:object_id,:certification)";
			$statement = $db->prepare($query);
			$statement->bindParam(':object_id', $id);
			$statement->bindParam(':certification', $cert);
			$statement->execute();
		}

			//$outcome="success";
 		setcookie("notification", "Data Transfer Agreement updated", time() + (15), "/"); // 86400 = 1 day
 		header("location:".WS_CONTROLLER."/dtalist");

		} else {
		echo "Sub Controller PHILADELPHIA detected an illegal operation";
		$outcome="failed";

	}


}
?>