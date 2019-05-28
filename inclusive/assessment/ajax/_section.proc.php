<?php

$db=db_conn();

// DECLARE ALL VARIABLES

$identikey=$_SESSION['s_identikey'];
if($_SERVER['REQUEST_METHOD']=='POST') {

    $function = $_POST['function'];
    $aoid = $_POST['aoid'];
    $soid = $_POST['soid'];
    $section_name = $_POST['section_name'];
    $section_additional_info = $_POST['section_additional_info'];
    if( $function=='add' ||  $function=='edit'){
        if(pb_validate_required($section_name) == false){

            $arr['outcome'] = "fail";
            $errorcode['section_name'] = "You need to include a section name" ;
        }
    }


} else if ($_SERVER['REQUEST_METHOD']=='GET'){
    $function=$_GET['function'];
    $aoid = $_GET['aoid'];
    $soid = $_GET['soid'];
}
if ($function=="edit") {
    $soid = $_POST['soid'];
}

//pb_check_user_permission("assessment_registry",$assessment_id);
if(!empty($errorcode)){

    $arr['validate'] = $errorcode;
    ///print_R($errorcode);
    $arr['outcome'] = "fail";
    $arr['smessage'] = "Section not created";
    $arr['lmessage'] = "Heres what we see:<p>".$errorcode['section_name']."</p>";
    $arr['refresh-div'] = "activity";
    $arr['refresh-url'] = '';
    $arr['refresh-content'] ='';
    $arr['force—refresh'] = "yes";


}else if ($function=="add") {

    $section_status="active";
    $statement = $db->prepare("SELECT MAX(order_id) as max_order_id FROM assessment_section where parent_assessment_id='$aoid'");
    $statement->execute();
    $max = $statement->fetch(PDO::FETCH_OBJ);
    $order_id=$max->max_order_id+1;

    $object_id = pb_create_object_id("assessment_section");

    $statement = $db->prepare("INSERT INTO assessment_section (id,object_id,title,additional_info,parent_assessment_id,order_id,identikey,section_status) VALUES (:id,:object_id,:title,:additional_info,:parent_assessment_id,:order_id,:identikey,:section_status)");

    $statement->bindParam(':id', $id);
    $statement->bindParam(':object_id', $object_id);
    $statement->bindParam(':title', $section_name);
    $statement->bindParam(':additional_info', $section_additional_info);
    $statement->bindParam(':parent_assessment_id', $aoid);
    $statement->bindParam(':order_id', $order_id);
    $statement->bindParam(':identikey', $identikey);
    $statement->bindParam(':section_status',$section_status);
    $statement->execute();

    $last_item=$db->lastInsertId();
    pb_system_log("Added","Assessment Section",$last_item);

    $item=pb_get_object_id_from_id("assessment_question",$last_item);
    pb_set_object_permission("assessment_section",$item,"userid",$_SESSION['s_userid'],"edit");

    $arr['outcome'] = "success";
    $arr['smessage'] = "Section Created";
    $arr['lmessage'] = "";
    $arr['refresh-div'] = "card-body";
    $arr['refresh-url'] = "/controller/questionlist";
    $arr['url-data'] = 'aoid='.$aoid ;
    $arr['refresh-content'] = '';
    $arr['force-refresh'] = "yes";


} else if ($function=="edit") {

    $statement = $db->prepare("UPDATE assessment_section SET title = :title,additional_info = :additional_info WHERE object_id=:soid");


    $statement->bindParam(':soid', $soid);
    $statement->bindParam(':title', $section_name);
    $statement->bindParam(':additional_info', $section_additional_info);
    $statement->execute();

    $arr['outcome'] = "success";
    $arr['smessage'] = "Section Updated";

} else if ($function=="del"){  //delete Section
    $section_status="deleted";
    $actual_status = "active";
    $item_status="orphan"; //change to 'orphan' questions underneath deleted Section
    //change question item_status = orphan
    $query = "UPDATE assessment_question SET item_status =:item_status WHERE section=:soid and assessment_id=:aoid and item_status=:actual_status";
    $statement = $db->prepare($query);
    $statement->bindParam(':actual_status', $actual_status);
    $statement->bindParam(':item_status', $item_status);
    $statement->bindParam(':soid', $soid);
    $statement->bindParam(':aoid', $aoid);
    $statement->execute();

    //delete section
    $statement = $db->prepare("UPDATE assessment_section SET section_status =:section_status WHERE parent_assessment_id=:parent_assessment_id and object_id=:object_id");
    $statement->bindParam(':object_id', $soid);
    $statement->bindParam(':parent_assessment_id', $aoid);
    $statement->bindParam(':section_status',  $section_status);
    $statement->execute();

    pb_system_log("Deleted","Assessment Section",$soid);


    $arr['outcome'] = "success";
    $arr['smessage'] = "Section Deleted";
    $arr['lmessage'] = "";
    $arr['refresh-url'] = "/controller/questionlist";
    $arr['url-data'] = 'aoid='.$aoid ;
    $arr['refresh-content'] = '';
    $arr['force-refresh'] = "yes";

} else {

    pb_system_log("Error: Function UNDETERMINED","Assessment Question",$id);
    $arr['outcome']="fail";
    $arr['smessage']="Sentinal AI Security: Violation 122 ";

}






?>