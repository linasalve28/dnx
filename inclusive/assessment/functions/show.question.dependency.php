<?php
function show_question_dependency($d_qoid) {
	global $db;
	$statement = $db->prepare("select qoid,equal_to,dependent_on_qoid from assessment_question_dependency where dependent_on_qoid = :d_qoid");
	$statement->bindParam(':d_qoid', $d_qoid);
	$statement->execute();

     /*
     * Questions in hierarchy should not be draggable, to do so we add class 'ui-state-disabled'
     	echo "<ul class='q ui-state-disabled' id='sortable'>";
     */

	echo "<ul class='q' id='sortable'>";
	$i_count=1;
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$qoid=$row['qoid'];
		$equal_to=$row['equal_to'];
		$dependent_on_qoid=$row['dependent_on_qoid'];
		show_question_item($qoid,$i_count,$equal_to);
		++$i_count;
	}
	echo "</ul>";
}
?>