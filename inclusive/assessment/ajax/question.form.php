<?php
// This is a blank template that shows how to include the form processing include.

//include(FS_ASSESSMENT_FUNCTIONS."/create.select.functions.php");
//require(DB_ROOT."/tb.db.conn.php");
include(FS_ASSESSMENT_FUNCTIONS."/functions.php");

function main() {

    global $db;
    global $errorcode;
    global $outcome;
    global $s_identikey;
    global $s_username;

    if(!isset($identikey)){
        $identikey=$_SESSION['s_identikey'];
    }
    $function=$_GET['function'];
    $qoid=$_GET['qoid'];
    $aoid=$_GET['aoid'];
    $soid=$_GET['soid'];


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include(FS_INCLUSIVE_ASSESSMENT."/question.proc.inc.php");
    }

    if ($function!=="edit") {
        pb_check_object_permission("assessment",$aoid,"userid","","edit");
    }

    if ($function=='edit' and $_SERVER['REQUEST_METHOD'] !== 'POST') {

        pb_check_object_permission("assessment_question",$qoid,"userid","","edit");

        $statement = $db->prepare("select * from assessment_question where object_id = :qoid");
        $statement->bindParam(':qoid', $qoid);

        $statement->execute();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $aoid=$row['assessment_id'];
            $question_text=stripslashes($row['question_text']);
            $question_additional_info=stripslashes($row['question_additional_info']);
            $question_type=$row['question_type'];
            $order_id=$row['order_id'];
            $required=$row['required'];
            $allow_comment=$row['allow_comment'];
            $allow_attachment =$row['allow_attachment'];
            $allow_other=$row['allow_other'];
            $allow_non_applicable=$row['allow_non_applicable'];
            $options=$row['options'];
            $displaytype=$row['displaytype'];
            $section = $row['section'];
        }
    }
    // If form submittion has been successful, display message.
    ?>
    <!-- tags eof-->
    <script src="/v2assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
    <link href="/v2assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
    <style>
        .bootstrap-tagsinput {
            width: 100%;
        }
        .bootstrap-tagsinput {
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            display: inline-block;
            padding: 4px 6px;
            color: #555;
            vertical-align: middle;
            border-radius: 4px;
            max-width: 100%;
            line-height: 22px;
            cursor: text;
        }
        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            color: white;
        }
        .label-info {
            background-color: #56B4D3;
        }
        .label {
            display: inline;
            padding: .2em .6em .3em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25em;
        }

    </style>
    <!-- tags bof-->



    <form class="f1" id="create_opp_form" name="create_opp_form" action="/ax/assessment/questionproc" method="post">
        <?php if ($function!="del") { ?>
            <?php if (pb_assessment_has_sections($aoid)) { ?>

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Assessment Question</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">

                        <div class="col-md-9">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Question text</label>
                        <div class="col-md-9">
                        <textarea name="question_text" id="question_text"
                                  class="form-control"><?php echo $question_text; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" id="additional_info">+ Add Additional Info</label>
                        <div class="col-md-9"
                             id="additional_info_box" <?php if (!empty($question_additional_info) && $function == 'edit') { ?> style="display: block" <?php } else { ?> style="display: none" <?php } ?>>
                        <textarea class="form-control error" name="question_additional_info"
                                  id="question_additional_info"
                                  rows='5'><?php echo $question_additional_info; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Question Type</label>

                        <div class="col-md-8">
                            <select class="form-control" name="question_type" id="question_type">
                                <option value="Text" <?php if ($question_type == "Text") {
                                    echo "Selected";
                                } ?>>Small Text
                                </option>
                                <option value="TextArea" <?php if ($question_type == "TextArea") {
                                    echo "Selected";
                                } ?>>Text Area
                                </option>
                                <option value="SelectBox" <?php if ($question_type == "SelectBox") {
                                    echo "Selected";
                                } ?>>Dropdown Box
                                </option>
                                <option value="Radio" <?php if ($question_type == "Radio") {
                                    echo "Selected";
                                } ?>>Multiple Choice (Select One Item)
                                </option>
                                <option value="Checkbox" <?php if ($question_type == "Checkbox") {
                                    echo "Selected";
                                } ?>>Multiple Choice (Select Multiple Items)
                                </option>
                                <option value="Date" <?php if ($question_type == "Date") {
                                    echo "Selected";
                                } ?>>Date
                                </option>
                                <option value="UploadFile" <?php if ($question_type == "UploadFile") {
                                    echo "Selected";
                                } ?>>Upload File
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group"
                         id="options_block" <?php if ((!empty($options) || $question_type == "SelectBox" || $question_type == "Radio" || $question_type == "Checkbox") && $function == 'edit') { ?> style="display: block" <?php } else { ?> style="display: none" <?php } ?> >
                        <label class="col-md-3 control-label">Options</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" value="<?php echo $options; ?>" name="options"
                                   id="options" data-role="tagsinput">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Required</label>
                        <div class="col-md-8">
                            <label class="switch size-sm">
                                <input type="checkbox" name="required" id="required"
                                       value="Yes" <?php if ($required == "Yes") {
                                    echo "checked";
                                } ?>> Yes
                                <span class="slider round success"></span>

                            </label>
                        </div>
                    </div>

                    <script>
                        $(document).ready(function () {
                            // $('#section option[value="<?php echo $soid;?>"]').attr("selected",true);
                            $("#additional_info").click(function () {
                                $("#additional_info_box").toggle();
                            });
                            //If question type ==(SelectBox,Radio,Checkbox)
                            $("#question_type").change(function () {
                                if (this.value == 'SelectBox' || this.value == 'Radio' || this.value == 'Checkbox') {
                                    $('#options_block').show();
                                } else {
                                    $('#options_block').hide();
                                    $('#options').val('');
                                }
                            });

                        });
                    </script>

                    <?php if (pb_assessment_has_sections($aoid)) { ?>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Section</label>
                            <div class="col-md-8">
                                <select name="section" id="section" class="form-control">
                                    <option value=""></option>
                                    <?php
                                    $statement = $db->prepare("select * from assessment_section where parent_assessment_id = :aoid and section_status <> 'deleted'");
                                    $statement->bindParam(':aoid', $aoid);
                                    $statement->execute();
                                    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                                        $object_id = $row['object_id'];
                                        $section_name = $row['title']; ?>
                                        <option value="<?php echo $object_id; ?>" <?php if ($object_id == $section) {
                                            echo "Selected";
                                        } ?>><?php echo $section_name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Allow "Other" as an option</label>
                        <div class="col-md-8">
                            <label class="switch size-sm">
                                <input type="checkbox" name="allow_other" id="allow_other"
                                       value="Yes" <?php if ($allow_other == "Yes") {
                                    echo "checked=''";
                                } ?>>
                                <span class="slider round success"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Allow free text comments</label>
                        <div class="col-md-8">
                            <label class="switch size-sm">
                                <input type="checkbox" name="allow_comment" id="allow_comment"
                                       value="Yes" <?php if ($allow_comment == "Yes") {
                                    echo "checked";
                                } ?>> Yes
                                <span class="slider round success"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Allow file attachments</label>
                        <div class="col-md-8">
                            <label class="switch size-sm">
                                <input type="checkbox" name="allow_attachment" id="allow_attachment"
                                       value="Yes" <?php if ($allow_attachment == "Yes") {
                                    echo "checked";
                                } ?>> Yes
                                <span class="slider round success"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Allow "Non Applicable" as a response</label>
                        <div class="col-md-8">
                            <label class="switch size-sm"><input type="checkbox" name="allow_non_applicable"
                                                                 id="allow_non_applicable"
                                                                 value="Yes" <?php if ($allow_non_applicable == "Yes") {
                                    echo "checked";
                                } ?>> Yes
                                <span class="slider round success"></span>

                            </label>
                        </div>
                    </div>


                </div>

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">

                        </div>
                    </div>
                </div>

                <input type='hidden' id='assessment_id' name='aoid' value='<?php echo $aoid; ?>'>
                <input type='hidden' id='qoid' name='qoid' value='<?php echo strip_tags($_GET['qoid']); ?>'>
                <input type='hidden' id='soid' name='soid' value='<?php echo $section; ?>'>
                <input type='hidden' id='function' name='function' value='<?php echo $function; ?>'>


                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Save Question" class="btn btn-success">

                </div>
                <?php
            } else { ?>

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Assessment Question</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-md-8" style="color: red;">Please create a Section before adding questions.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>

            <?php }
        } else if ($function=="del"){?>
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Question Deletion</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="form-group">

                    <div class="col-md-9">

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 control-label">Are you sure you want to delete this question?</label>
                </div>
            </div>


            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">

                    </div>
                </div>
            </div>
            <?php
            echo "<input type='hidden' id='assessment_id' name='aoid' value='".$aoid."'>";
            echo "<input type='hidden' id='qoid' name='qoid' value='".strip_tags($_GET['qoid'])."'>";
            echo "<input type='hidden' id='soid' name='soid' value='".$section."'>";
            echo "<input type='hidden' id='function' name='function' value='".$function."'>";
            ?>

            <input type='hidden' id='item_status' name='item_status' value='orphan'>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No, please Cancel</button>
                <input type="submit" value="Yes, Delete this Question" class="btn btn-danger">

            </div>
        <?php } ?>
    </form>

    <?php
}
?>