<?php

require_once(FS_INCLUSIVE_ASSESSMENT."/functions/_assessment.has.sections.php");

// DECLARE ALL VARIABLES
$db = db_conn();
$vars = get_defined_vars();
$identikey = $_SESSION['s_identikey'];
if($_SERVER['REQUEST_METHOD']=='POST') {
    $aoid = $_POST['aoid'];
    $qoid = $_POST['qoid'];
    $soid = $_POST['soid']; //section deleted
    $question_text = $_POST['question_text'];
    $question_additional_info = $_POST['question_additional_info'];
    $question_type = $_POST['question_type'];
    $required = $_POST['required'];
    $section = $_POST['section']; //new section
    $displaytype = $_POST['displaytype'];
    $allow_other = $_POST['allow_other'];
    $allow_comment = $_POST['allow_comment'];
    $allow_attachment = $_POST['allow_attachment'];
    $allow_non_applicable = $_POST['allow_non_applicable'];
    $options=$_POST['options'];
    $function=$_POST['function'];

} else if ($_SERVER['REQUEST_METHOD']=='GET') {
    $function = $_GET['function'];
    $aoid = $_GET['aoid'];
    $qoid = $_GET['qoid'];
    $soid = $_GET['soid'];

}

if ($displaytype=="") {
    $displaytype="normal";
}

if ($function=="edit") {
    $id=$_POST['id'];
}

pb_check_user_permission("assessment_registry",$aoid);

if($_SERVER['REQUEST_METHOD']=='POST' && ($function=="add" || $function=="edit")) {
        // Validation Items

    if (pb_validate_required($question_text)== false){
        $errorcode['question_text']=$error_prefix."You need to include a question text".$error_suffix;
        $message['question_text'] = $errorcode['question_text'];
    }

    if (pb_validate_required($question_type)== false){
        $errorcode['question_type']=$error_prefix."You need to select the question type".$error_suffix;
        $message['question_type'] = $errorcode['question_type'];

    }
    if (pb_validate_required($section)== false){
        $errorcode['section']=$error_prefix."You need to select a Section or <a href='/controller/sectionform?aoid=".$aoid."' style='color: lightseagreen;'>add one</a>".$error_suffix;
        $message['section'] = $errorcode['section'];
    }
}

if(!empty($errorcode)){

    $arr['validate'] = $errorcode;
    ///print_R($errorcode);
    $arr['outcome'] = "fail";
    $arr['smessage'] = "Question not created";
    $arr['lmessage'] = "Heres what we see:<p>".$message['question_text']."</p><p>".$message['question_type']."</p><p>".$message['section']."</p>";
    $arr['refresh-div'] = "activity";
    $arr['refresh-url'] = "/central/diagnostics/ajaxoutput.php";
    $arr['refresh-content'] ='';
    $arr['force—refresh'] = "yes";


} else if($function=="add") {

    if (pb_assessment_has_sections($aoid)) {

        $statement = $db->prepare("SELECT MAX(order_id) as max_order_id FROM assessment_question where assessment_id='$aoid' and section='$section'");
        $statement->execute();
        $max = $statement->fetch(PDO::FETCH_OBJ);
        $order_id=$max->max_order_id+1;

    } else {
        $statement = $db->prepare("SELECT MAX(order_id) as max_order_id FROM assessment_question where assessment_id='$aoid'");
        $statement->execute();
        $max = $statement->fetch(PDO::FETCH_OBJ);
        $order_id=$max->max_order_id+1;
    }

    $object_id = pb_create_object_id("assessment_question");

    $query = "INSERT INTO assessment_question (assessment_id,object_id,identikey,question_text,question_additional_info,question_type,order_id,required,options,displaytype,item_status,section,allow_comment,allow_attachment,allow_other,allow_non_applicable,created_by,created_on,object_owner) VALUES (:assessment_id,:object_id,:identikey,:question_text,:question_additional_info,:question_type,:order_id,:required,:options,:displaytype,'active',:section,:allow_comment,:allow_attachment,:allow_other,:allow_non_applicable,:created_by,:created_on,:object_owner)";
    $statement = $db->prepare($query);
    $created_by = $object_owner= $_SESSION['s_userid'];
    $created_on = date('Y-m-d h:i:s');
    $statement->bindParam(':assessment_id', $aoid);
    $statement->bindParam(':identikey', $identikey);
    $statement->bindParam(':object_id', $object_id);
    $statement->bindParam(':question_text', $question_text);
    $statement->bindParam(':question_additional_info', $question_additional_info);
    $statement->bindParam(':question_type', $question_type);
    $statement->bindParam(':order_id', $order_id);
    $statement->bindParam(':required', $required);
    $statement->bindParam(':displaytype', $displaytype);
    $statement->bindParam(':options', $options);
    $statement->bindParam(':section', $section);
    $statement->bindParam(':allow_comment', $allow_comment);
    $statement->bindParam(':allow_attachment', $allow_attachment);
    $statement->bindParam(':allow_other', $allow_other);
    $statement->bindParam(':allow_non_applicable', $allow_non_applicable);
    $statement->bindParam(':created_by', $created_by);
    $statement->bindParam(':created_on', $created_on);
    $statement->bindParam(':object_owner', $object_owner);

    $statement->execute();

    //"Question has been created";

    setcookie("notification", "Question Created", time() + (15), "/"); // 86400 = 1 day



    $last_item=$db->lastInsertId();
    pb_system_log("Added","Assessment Question",$last_item);


    $item=pb_get_object_id_from_id("assessment_question",$last_item);
    pb_set_object_permission("assessment_question",$item,"userid",$_SESSION['s_userid'],"edit");


    $arr['outcome'] = "success";
    $arr['smessage'] = "Question Created";
    $arr['lmessage'] = "Heres what we see:".$message;
    $arr['refresh-div'] = "card-body";
    $arr['refresh-url'] = "/controller/questionlist";
    $arr['url-data'] = 'aoid='.$aoid ;
    $arr['refresh-content'] = '';
    $arr['force-refresh'] = "yes";


} else if ($function=="edit") {

    // Change in section detected
    if ($soid !== $section) {

        $item_status=$_POST['item_status'];

        //orphans changing to a new Section
        if($item_status="orphan") {
            $item_status = "active"; //when changing orphan to new Section, change question from orphan to active
            $last_modified_by = $_SESSION['s_userid'];
            $last_modified_on =  date('Y-m-d h:i:s');

            //$section = new section chosen and item_status = active
            $query = "UPDATE assessment_question SET question_text = :question_text, question_additional_info= :question_additional_info,question_type = :question_type,section=:section,order_id=:order_id,required = :required,allow_comment = :allow_comment,allow_attachment = :allow_attachment,allow_other=:allow_other,allow_non_applicable=:allow_non_applicable,options = :options,item_status=:item_status,last_modified_by=:last_modified_by,last_modified_on=:last_modified_on WHERE object_id=:qoid";

            $statement = $db->prepare($query);
            $statement->bindParam(':qoid', $qoid);
            $statement->bindParam(':question_text', $question_text);
            $statement->bindParam(':question_additional_info', $question_additional_info);
            $statement->bindParam(':question_type', $question_type);
            $statement->bindParam(':section', $section); //new section selected by user on question.form
            $statement->bindParam(':order_id', $order_id);
            $statement->bindParam(':required', $required);
            $statement->bindParam(':allow_comment', $allow_comment);
            $statement->bindParam(':allow_attachment', $allow_attachment);
            $statement->bindParam(':allow_other', $allow_other);
            $statement->bindParam(':allow_non_applicable', $allow_non_applicable);
            $statement->bindParam(':options', $options);
            $statement->bindParam(':item_status', $item_status);
            $statement->bindParam(':last_modified_by', $last_modified_by);
            $statement->bindParam(':last_modified_on', $last_modified_on);


            $statement->execute();

        } else {

            $statement = $db->prepare("SELECT MAX(order_id) as max_order_id FROM assessment_question where assessment_id='$aoid' and section='$section'");
            $statement->execute();
            $max = $statement->fetch(PDO::FETCH_OBJ);
            $order_id=$max->max_order_id+1;
            $last_modified_by = $_SESSION['s_userid'];
            $last_modified_on =  date('Y-m-d h:i:s');
            //   echo "UPDATE assessment_question SET question_text = '$question_text', question_additional_info= '$question_additional_info',question_type = '$question_type',required = '$required',options = '$options',displaytype = '$displaytype', order_id='$order_id',section='$section' WHERE object_id='$qoid'";

            $query="UPDATE assessment_question SET question_text = :question_text, question_additional_info= :question_additional_info,question_type = :question_type,required = :required,options = :options,allow_comment = :allow_comment,allow_attachment = :allow_attachment,allow_other=:allow_other,allow_non_applicable=:allow_non_applicable,order_id=:order_id,section=:section,item_status=:item_status,last_modified_by=:last_modified_by,last_modified_on=:last_modified_on WHERE object_id=:qoid";

            //"UPDATE assessment_question SET question_text = '$question_text', question_additional_info= '$question_additional_info',question_type = '$question_type',required = '$required',options = '$options',allow_comment = '$allow_comment',allow_other='$allow_other',allow_non_applicable='$allow_non_applicable',order_id='$order_id',section='$section' WHERE object_id='$qoid'"; $section $order_id

            $statement = $db->prepare($query);
            $statement->bindParam(':qoid', $qoid);
            $statement->bindParam(':question_text', $question_text);
            $statement->bindParam(':question_additional_info', $question_additional_info);
            $statement->bindParam(':question_type', $question_type);
            $statement->bindParam(':required', $required);
            $statement->bindParam(':options', $options);
            $statement->bindParam(':allow_comment', $allow_comment);
            $statement->bindParam(':allow_attachment', $allow_attachment);
            $statement->bindParam(':allow_other', $allow_other);
            $statement->bindParam(':allow_non_applicable', $allow_non_applicable);
            $statement->bindParam(':order_id', $order_id);
            $statement->bindParam(':section', $section); //new section selected by user on question.form
            $statement->bindParam(':item_status', $item_status);
            $statement->bindParam(':last_modified_by', $last_modified_by);
            $statement->bindParam(':last_modified_on', $last_modified_on);
            $statement->execute();
        }
    }else {

        $last_modified_by = $_SESSION['s_userid'];
        $last_modified_on =  date('Y-m-d h:i:s');

        //echo "UPDATE assessment_question SET question_text = '$question_text', question_additional_info= '$question_additional_info',question_type = '$question_type',required = '$required',options = '$options',displaytype = '$displaytype' WHERE object_id='$qoid'";
        $query="UPDATE assessment_question SET question_text = :question_text, question_additional_info= :question_additional_info,question_type = :question_type,required = :required,options = :options,allow_comment=:allow_comment, allow_other= :allow_other, allow_non_applicable= :allow_non_applicable,last_modified_by=:last_modified_by,last_modified_on=:last_modified_on WHERE object_id=:qoid";

        $statement = $db->prepare($query);

        $statement->bindParam(':qoid', $qoid);
        $statement->bindParam(':question_text', $question_text);
        $statement->bindParam(':question_additional_info', $question_additional_info);
        $statement->bindParam(':question_type', $question_type);
        $statement->bindParam(':required', $required);
        $statement->bindParam(':options', $options);
        $statement->bindParam(':allow_comment', $allow_comment);
        $statement->bindParam(':allow_other', $allow_other);
        $statement->bindParam(':allow_non_applicable', $allow_non_applicable);
        $statement->bindParam(':last_modified_by', $last_modified_by);
        $statement->bindParam(':last_modified_on', $last_modified_on);
        $statement->execute();
    }

    pb_system_log("Edited","Assessment Question",$id);

    $arr['outcome'] = "success";
    $arr['smessage'] = "Question Edited";
    $arr['lmessage'] = "Heres what we see:".$message;
    $arr['refresh-div'] = "card-body";
    $arr['refresh-url'] = "/controller/questionlist";
    $arr['url-data'] = 'aoid='.$aoid ;
    $arr['refresh-content'] = '';
    $arr['force_refresh'] == "yes";


} else if ($function=="del") { //deleting question

    $statement = $db->prepare("UPDATE assessment_question SET item_status = 'deleted' WHERE object_id=:object_id");
    $statement->bindParam(':object_id', $qoid);
    $statement->execute();

    pb_system_log("Deleted","Assessment Question",$id);

    $arr['outcome'] = "success";
    $arr['smessage'] = "Question Deleted";
    $arr['lmessage'] = "Heres what we see:".$message;
    $arr['refresh-div'] = "card-body";
    $arr['refresh-url'] = "/controller/questionlist";
    $arr['url-data'] = 'aoid='.$aoid ;
    $arr['refresh-content'] = '';
    $arr['force_refresh'] == "yes";
} else {

    //echo "Sentinal AI Security: Violation 122 ";
    pb_system_log("Error: Function UNDETERMINED", "Assessment Question", $id);
    $outcome = "failed";

}






//header("location:/controller/questionlist?aoid=$aoid");
//exit;
?>