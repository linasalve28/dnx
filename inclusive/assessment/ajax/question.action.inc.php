<?php
// This script directly manipulates an item. For example deleting it etc.

include(FS_ASSESSMENT_FUNCTIONS."/reorder.questions.inc.php");
include(FS_ASSESSMENT_FUNCTIONS."/functions.php");
function main()
{
    $function = $_GET['function'];
    $oid = $_GET['qoid'];

    $object_id = $oid;

// Begin validation

    global $db;
// Need to check user is allowed to acccess this item
    if($_GET['function'] == "section_orderup"){
        $oid = $_GET['soid'];
        pb_check_user_permission("assessment_section", $oid);

        $statement = $db->prepare("SELECT parent_assessment_id from assessment_section WHERE object_id=:id");
        $statement->bindParam(':id', $oid);
        $statement->execute();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $assessment_id = $row['parent_assessment_id'];
        }
    } else {
        pb_check_user_permission("assessment_question", $oid);

        $statement = $db->prepare("SELECT assessment_id from assessment_question WHERE object_id=:id");
        $statement->bindParam(':id', $oid);
        $statement->execute();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $assessment_id = $row['assessment_id'];
        }
    }



    if ($function == "del") {



        $statement = $db->prepare("UPDATE assessment_question SET item_status = 'deleted' WHERE object_id=:object_id");
        $statement->bindParam(':object_id', $oid);
        $statement->execute();
        //  $item=$db->lastInsertId();
        reorder_questions($assessment_id);
        pb_system_log("Deleted", "Assessment Question", $oid);

        header("Location:" . WS_CONTROLLER . "/assessment/questionlist?aoid=$assessment_id");

    } else if ($function == "hide") {

        $statement = $db->prepare("UPDATE assessment_question SET item_status = 'hidden' WHERE object_id =:object_id");
        $statement->bindParam(':object_id', $object_id);
        $statement->execute();

        pb_system_log("Hidden", "Assessment Question", $oid);

        header("Location:" . WS_CONTROLLER . "/assessment/questionlist?aoid=$assessment_id");

    } else if ($function == "unhide") {

        $statement = $db->prepare("UPDATE assessment_question SET item_status = 'active' WHERE object_id=:object_id");
        $statement->bindParam(':object_id', $object_id);
        $statement->execute();
        pb_system_log("Show", "Assessment Question", $oid);

        header("Location:" . WS_CONTROLLER . "/assessment/questionlist?aoid=$assessment_id");

    } else if ($function == "dupe") {

        //echo "select * from assessment_question where object_id = '$object_id'";

        $statement = $db->prepare("select * from assessment_question where object_id = :object_id");
        $statement->bindParam(':object_id', $object_id);
        $statement->execute();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {

            $oid = $row['id'];
            $assessment_id = $row['assessment_id'];
            $identikey = $row['identikey'];
            $question_text = $row['question_text'];
            $question_type = $row['question_type'];
            $required = $row['required'];
            $allow_comment = $row['allow_comment'];
            $allow_attachment = $row['allow_attachment'];
            $options = $row['options'];
            $displaytype = $row['displaytype'];
            $item_status = $row['item_status'];
            $section = $row['section'];

        }
        //echo "<br /><br />";
        //echo "SELECT MAX(order_id) as max_order_id FROM assessment_question where assessment_id='$assessment_id'";


        if (pb_assessment_has_sections($assessment_id)) {

            $statement = $db->prepare("SELECT MAX(order_id) as max_order_id FROM assessment_question where assessment_id='$assessment_id' and section='$section'");
            $statement->execute();
            $max = $statement->fetch(PDO::FETCH_OBJ);
            $max->max_order_id;
            $order_id = $max->max_order_id + 1;

        } else {

            $statement = $db->prepare("SELECT MAX(order_id) as max_order_id FROM assessment_question where assessment_id='$assessment_id'");
            $statement->execute();
            $max = $statement->fetch(PDO::FETCH_OBJ);
            $max->max_order_id;
            $order_id = $max->max_order_id + 1;
        }

        $object_id = pb_create_object_id("assessment_question");


        $statement = $db->prepare("INSERT INTO assessment_question (assessment_id,object_id,identikey,question_text,question_type,order_id,required,allow_comment,allow_attachment,options,displaytype,item_status,section) VALUES (:assessment_id,:object_id,:identikey,:question_text,:question_type,:order_id,:required,:allow_comment,:allow_attachment,:options,:displaytype,:item_status,:section)");

        $statement->bindParam(':assessment_id', $assessment_id);
        $statement->bindParam(':object_id', $object_id);
        $statement->bindParam(':identikey', $identikey); //era aqui o erro
        $statement->bindParam(':question_text', $question_text);
        $statement->bindParam(':question_type', $question_type);
        $statement->bindParam(':order_id', $order_id);
        $statement->bindParam(':required', $required);
        $statement->bindParam(':allow_comment', $allow_comment);
        $statement->bindParam(':allow_attachment', $allow_attachment);
        $statement->bindParam(':options', $options);
        $statement->bindParam(':displaytype', $displaytype);
        $statement->bindParam(':item_status', $item_status);
        $statement->bindParam(':section', $section);
        $statement->execute();

        reorder_questions($assessment_id);
        pb_system_log("Duplicated", "Assessment Question", $oid);
        pb_set_object_permission("assessment_question", $object_id, "userid", $_SESSION['s_userid'], "edit");


        header("Location:" . WS_CONTROLLER . "/assessment/questionlist?aoid=$assessment_id");

    } else if ($function == "settitle") {
        //echo "<br />";
        //echo "UPDATE assessment_registry SET title_field = '$object_id' WHERE object_id='$assessment_id'";

        $statement = $db->prepare("UPDATE assessment_registry SET title_field = :object_id WHERE object_id=:assessment_id");
        $statement->bindParam(':object_id', $object_id);
        $statement->bindParam(':assessment_id', $assessment_id);
        $statement->execute();

        setcookie("notification", "Question has been set as the title for this assessment", time() + (15), "/"); // 86400 = 1 day


        header("Location:" . WS_CONTROLLER . "/assessment/questionlist?aoid=$assessment_id");
    } else if ($function == "orderup") {

        $query = "SELECT order_id from assessment_question where object_id=:oid and assessment_id=:assessment_id";

        $statement = $db->prepare($query);
        $statement->bindParam(':oid', $oid);
        $statement->bindParam(':assessment_id', $assessment_id);
        $statement->execute();


        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $order_id = $row['order_id'];
        }

        $new_order_id = $order_id - 1;

        $query = "UPDATE assessment_question SET order_id = :order_id WHERE order_id=:new_order_id and assessment_id=:assessment_id";

        $statement = $db->prepare($query);
        $statement->bindParam(':new_order_id', $new_order_id);
        $statement->bindParam(':assessment_id', $assessment_id);
        $statement->bindParam(':order_id', $order_id);
        $statement->execute();

        $query = "UPDATE assessment_question SET order_id = :new_order_id WHERE object_id=:oid and assessment_id=:assessment_id";

        $statement = $db->prepare($query);
        $statement->bindParam(':new_order_id', $new_order_id);
        $statement->bindParam(':assessment_id', $assessment_id);
        $statement->bindParam(':oid', $oid);
        $statement->execute();

        header("location:" . WS_CONTROLLER . "/assessment/questionlist?aoid=$assessment_id");


    } else if ($function == "section_orderup") {

        $query = "SELECT order_id from assessment_section where object_id=:oid and parent_assessment_id=:assessment_id";

        $statement = $db->prepare($query);
        $statement->bindParam(':oid', $oid);
        $statement->bindParam(':assessment_id', $assessment_id);
        $statement->execute();


        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $order_id = $row['order_id'];
        }

        $new_order_id = $order_id - 1;

        $query = "UPDATE assessment_section SET order_id = :order_id WHERE order_id=:new_order_id and parent_assessment_id=:assessment_id";

        $statement = $db->prepare($query);
        $statement->bindParam(':new_order_id', $new_order_id);
        $statement->bindParam(':assessment_id', $assessment_id);
        $statement->bindParam(':order_id', $order_id);
        $statement->execute();

        $query = "UPDATE assessment_section SET order_id = :new_order_id WHERE object_id=:oid and parent_assessment_id=:assessment_id";

        $statement = $db->prepare($query);
        $statement->bindParam(':new_order_id', $new_order_id);
        $statement->bindParam(':assessment_id', $assessment_id);
        $statement->bindParam(':oid', $oid);
        $statement->execute();

        header("location:" . WS_CONTROLLER . "/assessment/questionlist?aoid=$assessment_id");


    } else {

        echo "SECURITY ERROR: SENTINEL AI is now active";

    }
}
?>