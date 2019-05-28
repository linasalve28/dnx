<?php 
	// This retrieves the Questions for an assessment, while excluding one type. Used in the Conditions form.
	function retrieve_questions($aoid,$exclude="") {
	global $db;
	if ($exclude) {
		
	$query="select * from assessment_question where assessment_id='$aoid' and object_id!='$exclude'";	
	
	} else {
	$query="select * from assessment_question where assessment_id='$aoid'";	
	}
	$statement = $db->prepare($query);
	$statement->execute();
	
	$n=0;
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
	 echo $array[$n]['object_id']=$row['object_id'];
	 echo $array[$n]['question_text']=$row['question_text'];
	 
	 ++$n;
	}

return $array;

	
}

?>