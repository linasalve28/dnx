<?php
// lists questions in a section

function show_questions_engage($assessment_id,$section,$preset=""){
    global $db;
    global $dev;
    $s_identikey = $_SESSION['s_identikey'];


    if ($section=="all") {
        $query = "select * from assessment_question where identikey='$s_identikey' and assessment_id='$assessment_id' and item_status <> 'deleted' order by order_id ASC	";
    } else if ($section=="unassigned") {
        $query = "select * from assessment_question where identikey='$s_identikey' and assessment_id='$assessment_id' and item_status <> 'deleted' and section IS NULL order by order_id ASC";
    } else {
        $query = "select * from assessment_question where identikey='$s_identikey' and assessment_id='$assessment_id' and item_status <> 'deleted' and section='$section' order by order_id ASC";
    }

    $question_numeral = "1";
    $statement = $db->prepare($query);
    $statement->bindParam(':oid', $assessment_id);
    $statement->execute();

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        $object_id=$row['object_id'];
        $question_text=stripslashes($row['question_text']);
        $question_type=$row['question_type'];
        $item_status=$row['item_status'];
        $order_id=$row['order_id'];

        if (check_question_has_dependency($object_id)) {

        } else {
            //print_R($preset);
            display_question($object_id,$preset,$question_numeral);
        }
        ++$question_numeral;
    }
}


?>