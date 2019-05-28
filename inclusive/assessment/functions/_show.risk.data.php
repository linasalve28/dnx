<?php
	function show_risk_data($qoid,$equal_to) {

	global $db;
	$query="select risk_level,risk_details,risk_remediation from assessment_risk where question_object_id='$qoid' and equal_to='$equal_to'";
	$statement = $db->prepare($query);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
$risk_data['risk_level']=$row['risk_level'];
$risk_data['risk_details']=$row['risk_details'];
$risk_data['risk_remediation']=$row['risk_remediation'];
	 

	}

return $risk_data;

}

?>