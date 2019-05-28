<?php
// This is a blank template that shows how to include the form processing include.
include_once(FS_ROOT_FUNCTIONS."/core_security_functions_inc.php");
include_once(FS_COMPONENT_FILECONTROL."/process.php");

function main() {
    global $db;
    global $errorcode;
    global $outcome;
    global $s_identikey;
    global $s_username;

    $objid = $_POST['objid']; //que_id
    $aoid = $_POST['aoid']; //assessment_id
    $parent_object_id = $_POST['parent_object_id']; //assessment_id

    //$aoid = $_POST['aoid'];
    //$response_code = sha1(time());

    // $permission = pb_check_object_permission("assessment_question",$qoid,"userid",$_SESSION['s_userid'],"edit",'',1);


    $error_prefix="<span class=\"label label-danger\">";
    $error_suffix="</span>";

    if (isset($_POST['objid']) && !empty($_FILES)) {

        $errorcode = array();
        //Check validations
        /*
        if (pb_validate_required($transfer_to_id)== false){
            $errorcode['transfer_to_id']=$error_prefix."You need to specify the company the data is being transferred to".$error_suffix;
        }*/

        if (!empty($errorcode)) {
            $outcome = "error";
            $result  = array("status"=>"file_err","filename"=>"");
        } else {
            //$parent_object_id = sha1(time());
           $result = file_control_upload_modal("file","assessment_response",$parent_object_id, $objid,true);
        }
        echo json_encode($result);
        //include("inclusive/assessment/question.proc.inc.php");
    }

}
?>