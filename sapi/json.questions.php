<?php
require_once("../config.inc.php");
include( DB_ROOT."/tb.db.conn.php");

$db=db_conn();

$statement = $db->prepare("select object_id,title from assessment_section where parent_assessment_id='CJsWGBk' order by order_id");
 		$statement->bindParam(':id', $id);
 		$statement->execute();
  		$i=0;		
while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

	$section_id=$row['object_id'];
	$arr[$section_id]['object_id']=$section_id;	
	$arr[$row['object_id']]['title']=$row['title'];


$statement_x = $db->prepare("select object_id,question_text,question_additional_info,question_type,options,section,order_id,required from assessment_question where assessment_id='CJsWGBk' and section='$section_id'");
 		$statement_x->bindParam(':id', $id);
 		$statement_x->execute();
  		$x=0;		
while ($row_x = $statement_x->fetch(PDO::FETCH_ASSOC)){

	$arr[$row['object_id']]['question'][$x]=$row_x;
	
++$x;
}


++$i;
}







echo json_encode($arr);


?>