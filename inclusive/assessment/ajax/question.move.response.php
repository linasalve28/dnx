<?php

$data = $_POST['data'];
$aoid = $_POST['aoid'];


$status_check = pb_check_object_permission("assessment",$aoid ,"userid",$_SESSION['s_userid'],"edit",'',1);
if($status_check===true ){
    if(!empty($data)){
        global $db;
        $response = array();
        foreach($data as $key=>$val){
            foreach($val as $k=>$v){
                $order_id = $k +1;
                $object_id = $v ;
                $response[$object_id] = $order_id ;
                $section = substr($key,9);  // To get section_object_id we need to remove word 'sortable_'
                $statement = $db->prepare("UPDATE assessment_question set order_id =:order_id,section =:section where object_id = :object_id AND assessment_id = :aoid");
                $statement->bindParam(':order_id', $order_id);
                $statement->bindParam(':section', $section);
                $statement->bindParam(':object_id', $object_id);
                $statement->bindParam(':aoid', $aoid);
                $statement->execute();
            }
        }
        $data_response = array('response'=>$response,'permission'=>true);
        echo json_encode($data_response);
    }

}else{
    $data_response = array('response'=>$status_check,'permission'=>false);
    echo json_encode($data_response);
}

exit;
?>