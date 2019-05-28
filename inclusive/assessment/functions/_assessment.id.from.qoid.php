<?php
	
function assessment_id_from_qoid($qoid) {
	global $db;

	$query="select assessment_id from assessment_question where object_id='$qoid' limit 1";
	$statement = $db->prepare($query);
	$statement->execute();
	
	$n=0;
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
	 $assessment_id=$row['assessment_id'];
	}
	return $assessment_id;
	
}

?>