<?php
// IDENTIKEY CONFIRMED
require_once(DB_ROOT."/tb.db.conn.php");

$id=$_SESSION['id'];
$identikey=$_SESSION['s_identikey'];
$company_name=$_POST['company_name'];
$contact_name=$_POST['contact_name'];
$contact_email=$_POST['contact_email'];
$contact_phone=$_POST['contact_phone'];
$details=$_POST['details'];

$function=$_POST['function'];


if (!$function) {
    $function="add";
}

if ($function=="add") {

    //echo substr('abcdef', 0, 4);  // abcd

    //validating Company_name, contact name and contact email
    $error_prefix = "<span class=\"label label-danger label-autoenroll\">";
    $error_suffix = "</span>";
}
//check valid company_name
if(pb_validate_required($company_name)== false) {
    $errorcode['company_name'] = $error_prefix . "You need to include a Company name for this enrollment" . $error_suffix;
}

//check valid contact_name
if (pb_validate_required($contact_name)==false) {
    $errorcode['contact_name'] = $error_prefix . "Please include a Contact name for this enrollment" . $error_suffix;
}

//check valid contact_email
if(pb_validate_required($contact_email)==false) {
    $errorcode['contact_email'] = $error_prefix . "Please include an email." . $error_suffix;
}
else if (pb_validate_email($contact_email) == false) {
        $errorcode['contact_email'] = $error_prefix . "Please include a valid email." . $error_suffix;
}



if ($errorcode) {
    $outcome = "error";
} else {

    if ($function == "add") {
        //end Aline

        $object_id_c = substr(strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/', '', $company_name)), 0, 4);
        $object_id_c = $object_id_c . rand(10000, 99999);

        $statement = $db->prepare("INSERT INTO autoenroll_registry (id,object_id,identikey,company_name,contact_name,contact_email,details,status) VALUES (:id,:object_id,:identikey,:company_name,:contact_name,:contact_email,:details,:status)");
        $status = "in progress";
        $statement->bindParam(':id', $id);
        $statement->bindParam(':object_id', $object_id_c);
        $statement->bindParam(':identikey', $identikey);
        $statement->bindParam(':company_name', $company_name);
        $statement->bindParam(':contact_name', $contact_name);
        $statement->bindParam(':contact_email', $contact_email);
        $statement->bindParam(':details', $details);
        $statement->bindParam(':status', $status);
        $statement->execute();

        pb_system_log("Added", "Auto Enroll", $db->lastInsertId());
        $outcome = "success"; // Aline

    } else if ($function == "edit") {

        $statement = $db->prepare("UPDATE autoenroll_registry SET identikey = :identikey,company_name = :company_name,contact_name = :contact_name,contact_email = :contact_email,contact_phone = :contact_phone,details = :details WHERE id=:id");

        $statement->bindParam(':id', $id);
        $statement->bindParam(':identikey', $identikey);
        $statement->bindParam(':company_name', $company_name);
        $statement->bindParam(':contact_name', $contact_name);
        $statement->bindParam(':contact_email', $contact_email);
        $statement->bindParam(':contact_phone', $contact_phone);
        $statement->bindParam(':details', $details);
        pb_system_log("Edited", "Auto Enroll", $id);
        $outcome = "success";

    } else {
        echo "Error Function UNDETERMINED";
        pb_system_log("Error: Function Unknown", "Auto Enroll", "");
        $outcome = "failed";
    }
    header("location:".WS_CONTROLLER."/autoenrolllist");

}
?>