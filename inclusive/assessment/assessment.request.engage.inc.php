<?php

function main() {

// First we check to see if a response to this item is already in progress.
	$statement = $db->prepare("select * from assessment_response where request_object_id = :request_object_id and status='draft'");
	$statement->bindParam(':request_object_id', $request_id);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$id=$row['id'];
		$assessment_id=$row['assessment_id'];
		$response_exists="yes";
	}


	if ($response_exists=="yes") {


		$statement = $db->prepare("select * from assessment_response_item where id = :id");
		$statement->bindParam(':id', $id);
		$statement->execute();
		while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
			$id=$row['id'];
			$question_id=$row['question_id'];
			$response_code=$row['response_code'];
			$assessment_id=$row['assessment_id'];
			$response_data=$row['response_data'];
			$response_comment=$row['response_comment'];
			$response_file_attachment=$row['response_file_attachment'];
			$response_other=$row['response_other'];
			$response_na=$row['response_na'];

			$question_data[$question_id]=$response_data;
			$question_comment[$question_id]=$response_comment;

		}


		// $question_data is now an array containing all saved responses.
		// $question_comment is now an array containing all saved comments


	}
	
	
	
	// Not we render the questions, and use the two arrays above to set default values.
	// Comment is not currently used
	

}
?>	