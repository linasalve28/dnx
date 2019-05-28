<?php

require_once(FS_INCLUSIVE_ASSESSMENT."/functions/_assessment.has.sections.php");

// DECLARE ALL VARIABLES
$db = db_conn();
$vars = get_defined_vars();

function check_question_type($qoid) {
    global $db;
    $statement = $db->prepare("select * from assessment_question where object_id = :qoid limit 1");
    $statement->bindParam(':qoid', $qoid);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        $question_type=$row['question_type'];
    }
    return $question_type;
}
function check_required($aoid) {

    global $db;
    // This bypasses field requirements when saving as draft.
    if ($_POST['submit_button']=="draft"){
        return $errorcode;
    }
    $response = $_POST['response'];
    // echo "select * from assessment_registry where unique_access_id = $aoid";
    /*
    BOF Commented by Lina : 14 Dec 17
    Not required as we already have aoid
    $statement = $db->prepare("select * from assessment_registry where object_id = :aoid");
    $statement->bindParam(':aoid', $aoid);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        $aoid=$row['object_id'];
    }
    EOF Commented by Lina : 14 Dec 17
    */
    $statement = $db->prepare("select object_id from assessment_question where assessment_id = :aoid and required='Yes'");
    $statement->bindParam(':aoid', $aoid);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        $qoid = $row['object_id'];
        $response_na=$_POST['response_na'];
        if ($response[$qoid] == "") {
            $errorcode[$qoid] = "REQUIRED";
        }
    }
    return $errorcode;
}

$response = $_POST['response'];
$existing_response = $_POST['existing_response'];
$response_other = $_POST['response_other'];
$response_comment = $_POST['response_comment'];
$response_na = $_POST['response_na'];
$response_code = $_POST['response_code'];
//$response_code = sha1(time());
//$response_code = pb_create_object_id("assessment_response") ;
// This is a unique item that can be given by the original company to help id the person responding. Totally optional.
$unique_person = $_SESSION['u'];
$aoid = $_POST['aoid'];
$assessment_id = $_POST['aoid'];
$friendly_name = $_POST['friendly_name'];

if($_POST['submit_button']=="draft") {
    // This means its a draft submission
   // echo $response.'<br>'.$response_na.'<br>'.$response_other.'<br>'.$response_comment;
}
//foreach(array_keys($response) as $key) {
//    if (is_array($response)) {
//        foreach ($response[$key] as $value){
//            $collective[]=$value;
//        }

foreach(array_keys($response) as $key) {

    if (is_array($_POST['response'][$key])) {
        foreach ($_POST['response'][$key] as $value){
            $collective[] = $value;
        }
        $response[$key] = implode("{{SEP}}",$collective);
        $collective="";
    }
    $question_type = check_question_type($key);
    // If the question is collecting a date, the date will be formatted in a strtotime format
    if ($question_type=="Date") {
        $response[$key]=strtotime($response[$key]);
    }
    //Other responses
    if (is_array($_POST['response_other'][$key])) {
        foreach ($_POST['response_other'][$key] as $value2){
            $collective2[]=$value2;
        }
        $response_other[$key]=implode("{{SEP}}",$collective2);
        $collective2="";
    }
    //Response Comments
    if (is_array($_POST['response_comment'][$key])) {
        foreach ($_POST['response_comment'][$key] as $value3){
            $collective3[]=$value3;
        }
        $response_comment[$key]=implode("{{SEP}}",$collective3);
        $collective3="";
    }
    //Non Applicable button chosen
    if (is_array($_POST['response_na'][$key])) {
        foreach ($_POST['response_na'][$key] as $value4){
            $collective4[]=$value4;
        }
        $response_na[$key] = implode("{{SEP}}",$collective4);
        $collective4="";
    }
}

$s_identikey = $_SESSION['s_identikey'];

if ($_POST['submit_button']=="save_changes"){
    $errorcode = check_required($aoid);
}
//$errorcode['question_text']=$error_prefix."You need to include a question".$error_suffix;
if($errorcode){

    $arr['validate'] = $errorcode;
    ///print_R($errorcode);
    $arr['outcome'] = "fail";
    $arr['smessage'] = "Assessment not saved";
    $arr['lmessage'] = "Heres what we see:".$message;
    $arr['refresh-div'] = "activity";
    $arr['refresh-url'] = "/central/diagnostics/ajaxoutput.php";
    $arr['refresh-content'] ='';
    $arr['force—refresh'] = "yes";

    $arr['refresh-div'] = "card-body";
    $arr['refresh-url'] = "/controller/assessment/questionlist";
    $arr['url-data'] = 'aoid='.$aoid ;
    $arr['refresh-content'] = '';
    $arr['force—refresh'] = "yes";
}


if (!$errorcode) {
    //if ($_POST['submit_button']=="save_submit") {
    if ($_POST['submit_button']=="save_changes") {
        $status="submitted";
    } else {
        $status="draft";
    }
    // This section converts any items where multiple selections have been made from arrays, into a text string.
    // Date processing, check question type and then store as time string if date.
    if (!$existing_response) {

        $statement = $db->prepare("INSERT INTO assessment_response (assessment_id,response_code,object_id,created_date,status,ip_address,host_name,other_identifier,friendly_name,identikey) VALUES (:assessment_id,:response_code,:object_id,now(),:status,:ip_address,:host_name,:other_identifier,:friendly_name,:identikey)");

        echo "INSERT INTO assessment_response (assessment_id,response_code,created_date,status,ip_address,host_name,other_identifier,friendly_name,identikey) VALUES ($aoid,:response_code,now(),:status,:ip_address,:host_name,:other_identifier,:friendly_name,:identikey)";

        $ip_address = $_SERVER['REMOTE_ADDR'];
        $host_name=gethostbyaddr($ip_address);
        $statement->bindParam(':assessment_id', $aoid);
        $statement->bindParam(':response_code', $response_code);
        $statement->bindParam(':object_id', $response_code);
        $statement->bindParam(':status', $status);
        $statement->bindParam(':friendly_name', $friendly_name);
        $statement->bindParam(':ip_address', $ip_address);
        $statement->bindParam(':host_name', $host_name);
        $statement->bindParam(':other_identifier', $other_identifier);
        $statement->bindParam(':identikey', $s_identikey);
        //$statement->bindParam(':title', $response[$title_field]);
        $statement->execute();

        foreach(array_keys($response) as $key){

            $statement = $db->prepare("INSERT INTO assessment_response_item (question_id,response_code,assessment_id,response_data,response_comment,response_file_attachment,response_other,response_na) VALUES (:question_id,:response_code,:assessment_id,:response_data,:response_comment,:response_file_attachment,:response_other,:response_na)");
            $statement->bindParam(':question_id', $key);
            $statement->bindParam(':response_code', $response_code);
            $statement->bindParam(':assessment_id', $aoid);
            $statement->bindParam(':response_data', $response[$key]);
            $statement->bindParam(':response_comment', $response_comment[$key]);
            $statement->bindParam(':response_file_attachment', $response_file_attachment);
            $statement->bindParam(':response_other', $response_other[$key]);
            $statement->bindParam(':response_na', $response_na[$key]);
            $statement->execute();
            if($response[$key]=='fileupload'){
                //update status for files as active
                $parent_object_type = 'assessment_response';
                $object_status='active';
                $query="UPDATE file_control SET object_status = :object_status WHERE parent_object_id =:response_code and parent_object_section=:question_id and parent_object_type=:parent_object_type";
                $statement = $db->prepare($query);
                $statement->bindParam(':question_id', $key);
                $statement->bindParam(':response_code', $response_code);
                $statement->bindParam(':parent_object_type',$parent_object_type );
                $statement->bindParam(':object_status', $object_status);
                $statement->execute();

                //Move uploaded files from temp folder to secu/f
                //
                $select_query="select enc_file_name from file_control WHERE parent_object_id =:response_code and parent_object_section=:question_id and parent_object_type=:parent_object_type and object_status = :object_status";
                $statement = $db->prepare($select_query);
                $statement->bindParam(':question_id', $key);
                $statement->bindParam(':response_code', $response_code);
                $statement->bindParam(':parent_object_type',$parent_object_type );
                $statement->bindParam(':object_status', $object_status);
                $statement->execute();

                while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {

                    $enc_file_name = $row['enc_file_name'];
                    //move this file from temp to secu
                    //move_uploaded_file(FILES_ROOT_TEMP . "/" .$enc_file_name, FILES_ROOT . "/" . $enc_file_name);

                    if (copy(FILES_ROOT_TEMP . "/" .$enc_file_name, FILES_ROOT. "/" .$enc_file_name)) {
                        unlink(FILES_ROOT_TEMP . "/" .$enc_file_name);
                    }
                }
                //

            }

        }

        $arr['outcome'] = "success";
        $arr['smessage'] = "Assessment submited";
        $arr['lmessage'] = "Heres what we see:".$message;
        $arr['refresh-div'] = "card-body";
        $arr['refresh-url'] = "/controller/assessment/engage";
        $arr['url-data'] = 'aoid='.$aoid ;
        $arr['refresh-content'] = '';
        $arr['force—refresh'] = "yes";

    } else {

        foreach(array_keys($response) as $key){
            // Lets first check to make sure the question exists
            $query="select * from assessment_response_item where response_code='$existing_response' and question_id='$key'";
            $statement_record_check = $db->prepare($query);
            $statement_record_check->execute();
            $errcheck=$statement_record_check->rowCount();
            if ($errcheck==0){
                // INSERT STATEMENTS
                $statement = $db->prepare("INSERT INTO assessment_response_item (question_id,response_code,assessment_id, response_data,response_comment,response_file_attachment,response_other,response_na) VALUES (:question_id,:response_code,:assessment_id,:response_data,:response_comment,:response_file_attachment,:response_other,:response_na)");
                $statement->bindParam(':question_id', $key);
                $statement->bindParam(':response_code', $response_code);
                $statement->bindParam(':assessment_id', $aoid);
                $statement->bindParam(':response_data', $response[$key]);
                $statement->bindParam(':response_comment', $response_comment[$key]);
                $statement->bindParam(':response_file_attachment', $response_file_attachment);
                $statement->bindParam(':response_other', $response_other[$key]);
                $statement->bindParam(':response_na', $response_na[$key]);
                $statement->execute();

            } else {
                // UPDATE STATEMENTS
                $query="UPDATE assessment_response_item SET response_data = :response_data,assessment_id=:assessment_id,response_comment = :response_comment,response_file_attachment = :response_file_attachment, response_other = :response_other, response_na = :response_na WHERE response_code=:existing_response and question_id=:question_id";

                /*
                echo "<br/>";
                    "UPDATE assessment_response_item SET response_data = '$response[$key]',assessment_id='$aoid',response_comment = '$response_comment[$key]',response_file_attachment = '$response_file_attachment' WHERE response_code='$existing_response' and question_id='$key'";
                echo "<br/>";
                */
                $statement = $db->prepare($query);
                $statement->bindParam(':question_id', $key);
                $statement->bindParam(':assessment_id', $aoid);
                $statement->bindParam(':existing_response', $existing_response);
                $statement->bindParam(':response_data', $response[$key]);
                $statement->bindParam(':response_comment', $response_comment[$key]);
                $statement->bindParam(':response_file_attachment', $response_file_attachment);
                $statement->bindParam(':response_other', $response_other[$key]);
                $statement->bindParam(':response_na', $response_na[$key]);
                $statement->execute();

            }
        }
    }
    //echo count($response);
    setcookie("notification", "Assessment Saved as Draft", time() + (15), "/"); // 86400 = 1 day
    if ($_POST['submit_button']=="save_submit") {
        //system_response("Assessment Saved ");
        $outcome="success";
    } else if ($_POST['submit_button']=="save_exit") {
        //system_response("Assessment Saved");
    } else if ($_POST['submit_button']=="save_changes") {
        //system_response("Assessment Saved");
        if (!$existing_response) {
            $existing_response=$response_code;
        }
        //header("location:/controller/assessmentengage?aoid=$assessment_id&existing_response=$existing_response&refresh=yes");
    }
}





//********************************************************************************

/*
if ($displaytype=="") {
	$displaytype="normal";
}
$options=$_POST['options'];

$function=$_POST['function'];


if ($function=="edit") {
	$id=$_POST['id'];
}



//Santize Date: To do

// Begin Validation

// Validation Items


//pb_check_user_permission("assessment_registry",$assessment_id);

if (pb_validate_required($question_text)== false){
	$errorcode['question_text']=$error_prefix."You need to include a question".$error_suffix;
}

if (pb_validate_required($question_type)== false){
	$errorcode['question_type']=$error_prefix."You need to select the question type".$error_suffix;
}
if (pb_validate_required($section)== false){
	$errorcode['section']=$error_prefix."You need to select a Section or <a href='/controller/sectionform?aoid=".$aoid."'>add one</a>".$error_suffix;
}

    if(!empty($errorcode)){

        $arr['validate'] = $errorcode;
        ///print_R($errorcode);
        $arr['outcome'] = "fail";
        $arr['smessage'] = "Question not created";
        $arr['lmessage'] = "Heres what we see:".$message;
        $arr['refresh-div'] = "activity";
        $arr['refresh-url'] = "/central/diagnostics/ajaxoutput.php";
        $arr['refresh-content'] ='';
        $arr['force—refresh'] = "yes";


    }
//print_R($errorcode);

	if ($function=="add" && empty($errorcode)) {



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

		$query = "INSERT INTO assessment_question (assessment_id,object_id,identikey,question_text,question_additional_info,question_type,order_id,required,options,displaytype,item_status,section,allow_comment,allow_attachment,allow_other,allow_non_applicable) VALUES (:assessment_id,:object_id,:identikey,:question_text,:question_additional_info,:question_type,:order_id,:required,:options,:displaytype,'active',:section,:allow_comment,:allow_attachment,:allow_other,:allow_non_applicable)";
		$statement = $db->prepare($query);

		$statement->bindParam(':assessment_id', $aoid);
		$statement->bindParam(':identikey', $s_identikey);
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
        $arr['force—refresh'] = "yes";


	} else if ($function=="edit" && empty($errorcode)) {

			// Change in section detected
			if ($soid !== $section) {

				$statement = $db->prepare("SELECT MAX(order_id) as max_order_id FROM assessment_question where assessment_id='$aoid' and section='$section'");
				$statement->execute();
				$max = $statement->fetch(PDO::FETCH_OBJ);
				$order_id=$max->max_order_id+1;


				//   echo "UPDATE assessment_question SET question_text = '$question_text', question_additional_info= '$question_additional_info',question_type = '$question_type',required = '$required',options = '$options',displaytype = '$displaytype', order_id='$order_id',section='$section' WHERE object_id='$qoid'";

				$query="UPDATE assessment_question SET question_text = :question_text, question_additional_info= :question_additional_info,question_type = :question_type,required = :required,options = :options,allow_comment = :allow_comment,allow_attachment = :allow_attachment,allow_other=:allow_other,allow_non_applicable=:allow_non_applicable,order_id='$order_id',section='$section' WHERE object_id=:qoid";

                //"UPDATE assessment_question SET question_text = '$question_text', question_additional_info= '$question_additional_info',question_type = '$question_type',required = '$required',options = '$options',allow_comment = '$allow_comment',allow_other='$allow_other',allow_non_applicable='$allow_non_applicable',order_id='$order_id',section='$section' WHERE object_id='$qoid'";

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
                $statement->execute();

			} else {

				//echo "UPDATE assessment_question SET question_text = '$question_text', question_additional_info= '$question_additional_info',question_type = '$question_type',required = '$required',options = '$options',displaytype = '$displaytype' WHERE object_id='$qoid'";
				$query="UPDATE assessment_question SET question_text = :question_text, question_additional_info= :question_additional_info,question_type = :question_type,required = :required,options = :options,allow_comment=:allow_comment, allow_other= :allow_other, allow_non_applicable= :allow_non_applicable WHERE object_id=:qoid";
				
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
                $statement->execute();
				
				
			}

			pb_system_log("Edited","Assessment Question",$id);
            //$query;
			$arr['outcome']="success";
			$arr['smessage']="Question Edited";
			$arr['force—refresh']="yes";


	} else {
			
		    //echo "Sentinal AI Security: Violation 122 ";
		    pb_system_log("Error: Function UNDETERMINED","Assessment Question",$id);
		    $outcome="failed";

	}
*/
//header("location:/controller/questionlist?aoid=$aoid");
//exit;
?>