<?php
include_once(FS_ASSESSMENT_FUNCTIONS."/show.question.dependency.php"); 
include_once(FS_ASSESSMENT_FUNCTIONS."/show.button.php"); 
function show_question_item($qoid,$i_count="1",$equal_to){ 
	//This formats and displays a question in a table row   
	global $db;
	$statement = $db->prepare("select assessment_id,object_id,section,question_text,order_id from assessment_question where object_id = :qoid");
	$statement->bindParam(':qoid', $qoid);
	$statement->execute();
	$internal_count=1;
	while($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$id = $row['id'];
		$assessment_id = $row['assessment_id'];		
		$object_id = $row['object_id'];
		$section = $row['section'];
		$question_text = stripslashes($row['question_text']);
		$order_id = $row['order_id'];
		if($equal_to){
			$equal_to = "<span class='badge badge-primary' style='background-color:#46b733;padding:5px'>".$equal_to."</span>"; 
		}
		echo "<li class='q' id='$object_id'><i class='fa fa-bars'></i><span id='seq_$object_id'> $i_count.</span> $equal_to $question_text";
		show_button($object_id,"question",$order_id);
		show_question_dependency($object_id);
		echo "</li>";
	}
}
?>