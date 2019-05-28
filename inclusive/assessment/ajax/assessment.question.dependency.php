<?php
include(FS_ASSESSMENT_FUNCTIONS."/form.functions.php");

// This file is used for displaying a question that is hidden because it has a dependency.
function display_question_ajax($qoid) {
	global $db;
	$statement = $db->prepare("select * from assessment_question where object_id=:object_id");
	$statement->bindParam(':object_id', $qoid);
	$statement->execute();

	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$id=$row['id'];
		$question_text=$row['question_text'];
		$question_type=$row['question_type'];
		$question_additional_info=$row['question_additional_info'];
		$question_allow_null=$row['question_allow_null'];
		$question_allow_comment=$row['question_allow_comment'];
		$question_allow_attachment=$row['question_allow_attachment'];
		$options=$row['options'];

	}

?>
<div class="form-group"> <label class="control-label col-md-1"></label>
<div class="col-md-11"><h3> <?php echo $question_text;?></h3></div></div>

<div class="form-group"><label class="control-label col-md-1"></label>
<div class="col-md-11">
<?php
	question_field_display($question_type,$qoid,$response[$qoid],$options);
	?>
</div></div>
<div id="new_<?php echo $qoid;?>"></div>
<?php
}



function main() {

	global $db;

	$dependent_on=str_replace("response[","",$_POST['qoid']);
	$dependent_on=str_replace("]", "",$dependent_on);
	$dependent_on=explode(".",$dependent_on);
	$dependent_on=$dependent_on[0];

	$val=$_POST['val'];
	$query="select * from assessment_question_dependency where dependent_on_qoid = '$dependent_on' and equal_to='$val'";
	$statement = $db->prepare($query);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$qoid=$row['qoid'];
	    display_question_ajax($qoid);
	}



}


?>