<?php

function pb_set_object_permission($object_type,$object_id,$auth_type,$auth_id="",$permission_type){
    global $db;

    if (!$auth_id) {
        if ($auth_type=="identikey") {
            $auth_id=$_SESSION['s_identikey'];
        } else if ($auth_id=="userid") {
            $auth_id=$_SESSION['s_userid'];
        }
    }

    $statement = $db->prepare("INSERT INTO object_permissions (id,object_type,object_id,auth_type,auth_id,created,permission_type) VALUES (:id,:object_type,:object_id,:auth_type,:auth_id,NOW(),:permission_type)");

    $statement->bindParam(':id', $id);
    $statement->bindParam(':object_type', $object_type);
    $statement->bindParam(':object_id', $object_id);
    $statement->bindParam(':auth_type', $auth_type);
    $statement->bindParam(':auth_id', $auth_id);
    $statement->bindParam(':permission_type', $permission_type);
    $statement->execute();

}
// NEW FUNCTION: WORK IN PROGRESS

function pb_check_object_permission($object_type,$object_id,$auth_type,$auth_id,$permission_type,$mode="simple",$ajx=false) {
    // Disable after testing
    //return true;
    global $db;

    // if user is Data Protection Officer
    if ($_SESSION['s_role']=="DPO") {
        $_SESSION['s_role'];
        if (pb_get_identikey_from_object_id($object_id,$object_type)==$_SESSION['s_identikey']) {
            return true;
        }
    }

    if ($auth_id=="") {
        if ($auth_type=="identikey") {
            $auth_id=$_SESSION['s_identikey'];
        } else if ($auth_type=="userid") {
            $auth_id=$_SESSION['s_userid'];
        }
    }


    if ($permission_type=="owner") {
        $query="select id from object_permissions where object_type='$object_type' and object_id='$object_id' and auth_type='$auth_type' and auth_id='$auth_id' and permission_type='owner'";

    } else if ($permission_type=="edit") {
        $query="select id from object_permissions where object_type='$object_type' and object_id='$object_id' and auth_type='$auth_type' and auth_id='$auth_id'  and (permission_type='edit' or permission_type='owner')";

    } else if ($permission_type=="del") {
        $query="select id from object_permissions where object_type='$object_type' and object_id='$object_id' and auth_type='$auth_type' and auth_id='$auth_id'  and (permission_type='del' or permission_type='owner')";

    } else if ($permission_type=="view") {
        $query="select id from object_permissions where object_type='$object_type' and object_id='$object_id' and auth_type='$auth_type' and auth_id='$auth_id'  and (permission_type='view' or permission_type='edit' or permission_type='owner')";

    } else {
        if($ajx===false){
            echo "Unknown Permission Error";
            exit;
        }else{
            return "Unknown Permission Error";
        }

    }
    //echo $query;
    $statement = $db->prepare($query);
    $statement->execute();
    $errcheck=$statement->rowCount();
    if ($errcheck>0) {

        return true;
    } else {
        if ($mode=="advanced") {
            return false;
        } else {

            if($ajx===false) {

                echo "You do not have permission to execute the requested action. (CON.INT PERM ERROR)";
                exit;

            } else {
                return "You do not have permission to execute the requested action. (AX.INT PERM ERROR)";
            }

        }
    }



}


// This is designed to check if a user has permission to execute an action on an item_status
// No longer used

function pb_check_user_permission($item_type,$item_id){
    global $db;

    $user_identikey=$_SESSION["s_identikey"];
    // error mode
    //$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

    // Set SQL code based on the item we are checking
    if ($item_type=="assessment_question") {
        $query="select identikey from assessment_question where object_id = :id";

    } else if ($item_type=="assessment_section"){
        $query="select identikey from assessment_section where object_id = :id";

    } else if ($item_type=="assessment_registry") {
        $query="select identikey from assessment_registry where object_id = :id";

    } else if ($item_type=="assessment_registry_uac") {
        $query="select identikey from assessment_registry where unique_access_id = :id";

    } else if ($item_type=="assessment_response") {

    }

    $statement = $db->prepare($query);
    $statement->bindParam(':id', $item_id);
    $statement->execute();


    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        $item_identikey=$row['identikey'];
    }


    if ($user_identikey==$item_identikey) {
        return true;
    } else {

        echo "TrustBase SENTINEL AI has detected a security permission issue with your request. Superceeded.";
        echo $item_type;
        exit;

    }
}



?>