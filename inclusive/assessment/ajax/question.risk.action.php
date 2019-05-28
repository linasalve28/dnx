<?php
include(FS_ROOT_FUNCTIONS."/base.functions.php");
function main() {
global $db;

$riskid=$_POST['riskid'];
$qoid=$_POST['qoid'];
$equal_to=$_POST['equal'];
$risk_level=$_POST['risk_level'];
$risk_details=$_POST['risk_details'];
$risk_remediation=$_POST['remediation'];

$function=$_POST['function'];

	if ($function=="add") {
		$object_id=pb_create_object_id("assessment_risk");
		$statement = $db->prepare("INSERT INTO assessment_risk (object_id,question_object_id,equal_to,risk_level,risk_details,risk_remediation) VALUES (:object_id,
		:question_object_id,:equal_to,:risk_level,:risk_details,:risk_remediation)");

		$statement->bindParam(':object_id', $object_id);
		$statement->bindParam(':question_object_id', $qoid);
		$statement->bindParam(':equal_to', $equal_to);
		$statement->bindParam(':risk_level', $risk_level);
		$statement->bindParam(':risk_details', $risk_details);
		$statement->bindParam(':risk_remediation', $risk_remediation);
		$statement->execute();


		echo "Risk has been created";

	} else if ($function=="edit") {
		
		$statement = $db->prepare("UPDATE assessment_risk SET equal_to = :equal_to, risk_level = :risk_level, risk_details = :risk_details, risk_remediation = :risk_remediation WHERE object_id=:riskid");
		$statement->bindParam(':riskid', $riskid);
		$statement->bindParam(':equal_to', $equal_to);
		$statement->bindParam(':risk_level', $risk_level);
		$statement->bindParam(':risk_details', $risk_details);
		$statement->bindParam(':risk_remediation', $risk_remediation);
		$statement->execute();
			
	}



}

	
?>