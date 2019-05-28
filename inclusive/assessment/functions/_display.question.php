<?php
function display_question($qoid,$preset_value,$question_numeral="") {
    global $db;
    global $errorcode;
    $existing_response=$_GET['existing_response'];
    $response=$_POST['response'];
    $response_na=$_POST['response_na'];
    if ($existing_response) {
        //echo "select * from assessment_response_item where response_code = $existing_response and question_id=:$qoid" ;
        $statement = $db->prepare("select * from assessment_response_item where response_code = :existing_response and question_id=:qoid");
        $statement->bindParam(':existing_response', $existing_response);
        $statement->bindParam(':qoid', $qoid);
        $statement->execute();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $question_id=$row['question_id'];
            $response_data = $row['response_data'];
            $response_comment=$row['response_comment'];
            $response_file_attachment=$row['response_file_attachment'];
            $response_other=$row['response_other'];
            $response_na=$row['response_na'];
        }
    } else {
        $response_data = $response[$qoid];
    }
    $statement = $db->prepare("select * from assessment_question where object_id=:object_id");
    $statement->bindParam(':object_id', $qoid);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        $id=$row['id'];
        $qoid=$row['object_id'];
        $question_object_id=$row['object_id'];
        $question_text=stripslashes($row['question_text']);
        $question_type=$row['question_type'];
        $question_required=$row['required'];
        $question_additional_info=$row['question_additional_info'];
        $question_allow_null=$row['allow_null'];
        $question_allow_comment=$row['allow_comment'];
        $question_allow_non_applicable=$row['allow_non_applicable'];
        $question_allow_attachment=$row['allow_attachment'];
        $question_allow_other=$row['allow_other'];
        $options=stripslashes($row['options']);
    }
    ?>

    <div class="form-group">
        <label class="control-label col-md-1"></label>
        <div class="col-md-11">
            <h4><?php if ($_GET['function']=="view") { ?><strong><?php } ?>
                    <?php echo $question_numeral; ?>. <?php echo $question_text; ?>
                    <?php if ($_GET['function']=="view") { ?></strong><?php } ?>
                <?php if ($question_required=="Yes") { echo "*"; } ?></h4>
            <?php echo $question_additional_info; ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-1"></label>
        <div class="col-md-11">
            <h4>
                <?php
                if ($_GET['function']=="view") {

                    if ($question_type=="Date"){
                        if ($response_data) {
                            echo date("d F Y",$response_data);
                        }
                    }elseif($question_type=="UploadFile"){
                        //echo "<br />uploadfile ".$qoid."  ".$existing_response ;
                        //code needs to write to download the uploaded files
                        //echo  $sql = "select * from file_control where parent_object_id = :parent_object_id AND parent_object_section = :qoid";
                       // echo "select object_id,access_key from file_control where parent_object_id = $existing_response AND parent_object_section = $qoid" ;
                        $statement = $db->prepare("select object_id,access_key from file_control where parent_object_id = :parent_object_id AND parent_object_section = :qoid");
                        $statement->bindParam(':qoid', $qoid);
                        $statement->bindParam(':parent_object_id', $existing_response);
                        $statement->execute();
                        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
                            $object_id = $row['object_id'];
                            $access_key = $row['access_key'];
                            echo "<a href='".DOMAIN_PATH."/component/filecontrol/download.php?object_id=".$object_id."&access_key=".$access_key."'>download file</a>" ;
                            echo "<br/>";
                        }

                    } else {
                        echo $response_data;
                        if (isset($response_other)) {
                            echo "<br />";
                            echo "<strong>Other details:</strong> $response_other";
                        }
                        if (isset($response_comment)) {
                            echo "<br />";
                            echo "<strong>Additional Details:</strong> $response_comment";
                        }
                    }
                } else {
                    question_field_display($question_type,$qoid,$response_data,$options,$question_allow_other);
                    if($question_type=="UploadFile") {
                        $statement = $db->prepare("select object_id,access_key from file_control where parent_object_id = :parent_object_id AND parent_object_section = :qoid");
                        $statement->bindParam(':qoid', $qoid);
                        $statement->bindParam(':parent_object_id', $existing_response);
                        $statement->execute();
                        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
                            $object_id = $row['object_id'];
                            $access_key = $row['access_key'];
                            echo "<a href='" . DOMAIN_PATH . "/component/filecontrol/download.php?object_id=" . $object_id . "&access_key=" . $access_key . "'>download file</a>";
                            echo "<br/>";
                        }
                    }
                }

                if ($_GET['function']!=="view")  {
                    if ($question_allow_non_applicable=="Yes") {
                        if(($_POST['response'][$qoid] == "Non applicable")){
                            ?>
                            <br>
                            <input type="button" class="na-button" id="na-btn" data-id="<?php echo $question_object_id;?>" value="Non applicable" name="btn_response_na[<?php echo $question_object_id;?>]" style="background-color: rgb(254, 0, 0);">
                            <input type="hidden" id="na_applicable_<?php echo $question_object_id;?>" data-id="<?php echo $question_object_id;?>" name="response_na[<?php echo $question_object_id;?>]" value="true">
                            <div id="div_for_non_applicable_<?php echo $question_object_id;?>">
                                <input type="hidden" id="na_applicable2_<?php echo $question_object_id;?>" data-id="<?php echo $question_object_id;?>" name="response[<?php echo $question_object_id;?>]" value="Non applicable">
                            </div>
                            <?php
                        } else { ?>
                            <br>
                            <input type="button" class="na-button" id="na-btn" data-id="<?php echo $question_object_id;?>" value="Non applicable" name="btn_response_na[<?php echo $question_object_id;?>]" style="background-color: rgb(53, 152, 220);">
                            <input type="hidden" id="na_applicable_<?php echo $question_object_id;?>" data-id="<?php echo $question_object_id;?>" name="response_na[<?php echo $question_object_id;?>]" value="false">
                            <div id="div_for_non_applicable_<?php echo $question_object_id;?>"></div>
                            <?php
                        }
                    }
                    if ($question_allow_comment=="Yes") {
                        //create_textbox($question_object_id,$preset_value,$option_data)
                        ?>
                        <!-- <span class="show_q_comment btn blue" id="show_comment" data-id="--> <?php //echo $question_object_id;?> <!--">[Add Details]</span> -->
                        <input type="button" class="btn show_q_comment btn btn-details" id="show_comment" data-id="<?php echo $question_object_id;?>" value="Add Details">
                        <span id="q_comment_<?php echo $question_object_id;?>"> </span>
                        <?php
                        if(isset($response_comment)){

                        }
                    }
                    if ($question_allow_delegation=="Yes") {
                    ?>
                        <span class="show_q_comment" data-id="<?php echo $question_object_id;?>">[Delegate to someone else to answer]</span>
                        Who would you like to send this question to for answering?:
                        <span id="q_delegate_<?php echo $question_object_id;?>"></span>
                        <?php
                    }
                }
                if (isset($errorcode[$qoid])) { ?>
                    <span class="label label-danger">
                    <?php echo $errorcode[$qoid]; ?>
                </span>
                <?php } ?>
            </h4>
        </div></div>

    <div id="new_<?php echo $qoid;?>"></div>
    <?php
}
?>