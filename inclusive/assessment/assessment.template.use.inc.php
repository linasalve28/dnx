<?php
include(FS_ROOT_FUNCTIONS."/create.select.functions.php");
include(FS_ASSESSMENT_FUNCTIONS."/functions.php");


function main()
{
    global $db;
    // Copies an assessment but sets the owner as the current user, ensures it is not a shared one and also generates a new response key
    $aoid = $_GET['aoid'];
    $statement_assessment = $db->prepare("select * from assessment_registry where object_id = :object_id");
    $statement_assessment->bindParam(':object_id', $aoid);
    $statement_assessment->execute();
    while ($row_assessment = $statement_assessment->fetch(PDO::FETCH_ASSOC)) {
        $id = "";
        // Needs to be replaced
        $object_id_assessment = pb_create_object_id("assessment_registry");
        $identikey = $_SESSION['s_identikey'];
        $title = $row_assessment['title'];
        //$created_date = $row['created_date'];
        // Needs to be replaced
        $assess_id = $row_assessment['assess_id'];
        $description = $row_assessment['description'];
        $instructions = $row_assessment['instructions'];
        $unique_access_id = $row_assessment['unique_access_id'];
        // Needs to be replaced
        $seed = str_split('abcdefghijklmnopqrstuvwxyz' . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . '0123456789'); // and any other characters
        shuffle($seed); // probably optional since array_is randomized; this may be redundant
        $rand = '';
        foreach (array_rand($seed, 7) as $k) $unique_access_id .= $seed[$k];
        $title_field = $row_assessment['title_field'];
        $assessment_type = '';
        $last_item = $db->lastInsertId();
        pb_system_log("Assessment Created", "Assessment Registry", $last_item);
        $item = pb_get_object_id_from_id("assessment_registry", $last_item);


        //inserting copy of assessment
        $statement_assessment = $db->prepare("INSERT INTO assessment_registry (id,object_id,identikey,title,created_date,assess_id,description,instructions,unique_access_id,title_field,reviews_requested,reviews_approved,tagline,assessment_type) VALUES (:id,:object_id,:identikey,:title,NOW(),:assess_id,:description,:instructions,:unique_access_id,:title_field,:reviews_requested,:reviews_approved,:tagline,:assessment_type)");
        $statement_assessment->bindParam(':id', $id);
        $statement_assessment->bindParam(':object_id', $object_id_assessment);
        $statement_assessment->bindParam(':identikey', $identikey);
        $statement_assessment->bindParam(':title', $title);
        //	$statement->bindParam(':created_date', $created_date);
        $statement_assessment->bindParam(':assess_id', $assess_id);
        $statement_assessment->bindParam(':description', $description);
        $statement_assessment->bindParam(':instructions', $instructions);
        $statement_assessment->bindParam(':unique_access_id', $unique_access_id);
        $statement_assessment->bindParam(':title_field', $title_field);
        $statement_assessment->bindParam(':reviews_requested', $reviews_requested);
        $statement_assessment->bindParam(':reviews_approved', $reviews_approved);
        $statement_assessment->bindParam(':tagline', $tagline);
        $statement_assessment->bindParam(':assessment_type', $assessment_type);
        $statement_assessment->execute();

        pb_set_object_permission("assessment", $item, "userid", $_SESSION['s_userid'], "edit");
        pb_set_object_permission("assessment", $item, "identikey", $identikey, "edit");


    };

//Selecting sections from previous assessment (questions will be under a pre-determined section)
    $query_section = "SELECT * FROM assessment_section where parent_assessment_id='$aoid'";
    $statement_section = $db->prepare($query_section);
    $statement_section->execute();
    while ($row_section = $statement_section->fetch(PDO::FETCH_ASSOC)) {
        //echo "<p>loop while section</p>";
        $id = ""; //auto-increment
        $old_soid = $row_section['object_id'];
        $new_soid = pb_create_object_id("assessment_section");
        $title = $row_section['title'];
        $additional_info = $row_section['additional_info'];
        $parent_assessment_id = $row_section['parent_assessment_id'];
        $order_id = $row_section['order_id'];
        $identikey = $_SESSION['s_identikey'];


        //Inserting sections: inside the loop
        $statement_section2 = $db->prepare("INSERT INTO assessment_section (object_id,title,additional_info,parent_assessment_id,order_id,identikey) VALUES (:object_id,:title,:additional_info,:parent_assessment_id,:order_id,:identikey)");
        //$statement_section2->bindParam(':id', $id);
        $statement_section2->bindParam(':object_id', $new_soid);
        $statement_section2->bindParam(':title', $title);
        $statement_section2->bindParam(':additional_info', $additional_info);
        $statement_section2->bindParam(':parent_assessment_id', $object_id_assessment);
        $statement_section2->bindParam(':order_id', $order_id);
        $statement_section2->bindParam(':identikey', $identikey);
        $statement_section2->execute();

        pb_set_object_permission("assessment_section", $item, "userid", $_SESSION['s_userid'], "edit");


        //selecting questions from previous assessment

        $query_question = "select * from assessment_question where section='$old_soid'";
        $statement_question = $db->prepare($query_question);
        $statement_question->execute();
        while ($row_question = $statement_question->fetch(PDO::FETCH_ASSOC)) {

            $assessment_id = $object_id_assessment;
            $new_qoid = pb_create_object_id("assessment_question");
            $identikey = $row_question['s_identikey'];
            $question_text = $row_question['question_text'];
            $question_additional_info = $row_question['question_additional_info'];
            $question_type = $row_question['question_type'];
            $order_id = $row_question['order_id'];
            $required = $row_question['required'];
            $allow_comment = $row_question['allow_comment'];
            $allow_attachment = $row_question['allow_attachment'];
            $reponse_na = $row_question['allow_non_applicable'];
            $options = $row_question['options'];
            $displaytype = $row_question['displaytype'];
            $view_status = $row_question['view_status'];
            $item_status = $row_question['item_status'];
            $weight = $row_question['weight'];

            //insert questions
            $statement = $db->prepare("INSERT INTO assessment_question (assessment_id,object_id,identikey,question_text,question_additional_info,question_type,section,order_id,required,allow_comment,allow_attachment,allow_non_applicable,options,displaytype,view_status,item_status,weight)
											VALUES (:assessment_id,:object_id,:identikey,:question_text,:question_additional_info,:question_type,:section,:order_id,:required,:allow_comment,:allow_attachment,:allow_non_applicable,:options,:displaytype,:view_status,:item_status,:weight)");

            $statement->bindParam(':assessment_id', $assessment_id);
            $statement->bindParam(':object_id', $new_qoid);
            $statement->bindParam(':identikey', $identikey);
            $statement->bindParam(':question_text', $question_text);
            $statement->bindParam(':question_additional_info', $question_additional_info);
            $statement->bindParam(':question_type', $question_type);
            $statement->bindParam(':section', $new_soid);
            $statement->bindParam(':order_id', $order_id);
            $statement->bindParam(':required', $required);
            $statement->bindParam(':allow_comment', $allow_comment);
            $statement->bindParam(':allow_attachment', $allow_attachment);
            $statement->bindParam(':allow_non_applicable',$response_na);
            $statement->bindParam(':options', $options);
            $statement->bindParam(':displaytype', $displaytype);
            $statement->bindParam(':view_status', $view_status);
            $statement->bindParam(':item_status', $item_status);
            $statement->bindParam(':weight', $weight);
            $statement->execute();

            $last_item = $db->lastInsertId();
            pb_system_log("Added", "Assessment Question", $last_item);

            $item = pb_get_object_id_from_id("assessment_question", $last_item);
            pb_set_object_permission("assessment_question", $item, "userid", $_SESSION['s_userid'], "edit");

            //$outcome = "success";
        }
        //end of Question insertion loop
    }
    //	if ($outcome=="success") {
    echo "<div class=\"alert alert-success\"><strong>Success!</strong> Assessment Copied.</div>";
    echo "<div class=\"portlet light\">
            <div class=\"portlet-body\"> 
                <div>
                    <a href='/controller/assessment/form?aoid=".$object_id_assessment."&function=edit'><button type=\"button\" class=\"btn btn-success\">Edit Assessment</button></a>
                    <a href='/controller/assessment/questionlist?aoid=".$object_id_assessment."'><button type=\"button\" class=\"btn btn-success\">List of Questions</button></a>
                </div>
            </div>
          </div>";

//		} else {

//echo "<pre>";
////print_r($old_qoid);
//echo "</pre>";

    // Lets see how we can duplicate the attributes.


    // create an array with question_data[OLD_QOID]=NEWQOID




}

?>