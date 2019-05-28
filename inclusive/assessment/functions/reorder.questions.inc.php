<?php

function reorder_questions($aoid) {
    global $db;


    if (pb_assessment_has_sections($aoid)) {

        $statement_original = $db->prepare("select object_id from assessment_section where parent_assessment_id = '$aoid' and section_status<>'deleted' order by order_id");
        $statement_original->execute();
        $x=1;
        while ($row_original = $statement_original->fetch(PDO::FETCH_ASSOC)){
            $soid=$row_original['object_id'];

            $statement = $db->prepare("select id from assessment_question where assessment_id = '$aoid' and section='$soid' order by order_id");
            $statement->execute();
            $i=1;
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

                $id=$row['id'];
                $statement_update = $db->prepare("UPDATE assessment_question SET order_id ='$i' WHERE id='$id'");
                $statement_update->execute();
                ++$i;
            }
        }





    } else {

        $statement = $db->prepare("select id from assessment_question where assessment_id = '$aoid' and item_status='active' order by order_id");
        $statement->execute();
        $i=1;
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $id=$row['id'];
            $statement_update = $db->prepare("UPDATE assessment_question SET order_id ='$i' WHERE id='$id'");
            $statement_update->execute();
            ++$i;
        }

    }


}
?>