<style>
#na-button div label input {
    margin-right:100px;
}

.na-button {
    margin:0px 4px;
    /*background-color:#EFEFEF;*/
    background-color:#3598dc;
    border-radius:4px;
    /*border:1px solid #D0D0D0;*/
    border:1px solid #3598dc;
    overflow:auto;
    float:left;
    padding: 6px 12px;/**/
    font-size: 14px; /**/
    line-height: 1.44;
    color: #FFF;
    font-weight: 400;
    margin-bottom: 0;
}

.na-button:hover {
    background-color:red;
}

#na-button label {
    float:left;
    width:8.0em;
}

#na-button label span {
    text-align:center;
    padding:3px 0px;
    display:block;
}

#na-button label input {
    position:absolute;
    top:-20px;
}

#na-button input:checked + span {
    background-color:#911;
    color:#fff;
}
.floatinterface {
    position: fixed; 
    bottom: 25px;
    right: 25px;
    height: 50px;
    z-index: 2;
   
}
</style>
<!-- Updated upstream-->
<link href="<?php echo DOMAIN_PATH ;?>/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo DOMAIN_PATH ;?>/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />


<?php

// SQL IDENTIKEY CONFIRMED
function main()
{

	$db=db_conn();
    global $errorcode;
    // include("/home/trustbase/servers/gateway.trustbase.com/inclusive/assessment/functions/v2.form.functions.php");
    include(FS_ASSESSMENT_FUNCTIONS . "/form.functions.php");
    include(FS_ASSESSMENT_FUNCTIONS . "/functions.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include(FS_INCLUSIVE_ASSESSMENT . "/assessment.processor.inc.php");
    } else {
        $assessment_id = $_GET['aoid'];
        $response_code=pb_create_object_id("assessment_response");
    }

if ($outcome == "success") { ?>
    <div class="alert alert-success" style="display: flex; align-items: center;">
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"></circle>
            <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"></path>
        </svg>
        <div>
            <?php if ($_POST['submit_button'] == "draft") {
                echo " Assessment Saved as Draft";
            } else {
                echo "Thank you. Your response to this assessment has been submitted";
            } ?>
        </div>
    </div>
    <?php
} else {


    $existing_response = isset($_GET["existing_response"]) ? $_GET["existing_response"] : (isset($_POST["existing_response"]) ? $_POST["existing_response"] : '');
    if ($existing_response) {
        $statement = $db->prepare("select * from assessment_response_item where response_code = :existing_response");
        $statement->bindParam(':existing_response', $existing_response);
        $statement->execute();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $question_id = $row['question_id'];
            $response_data[$question_id] = $row['response_data'];
            $response_comment = $row['response_comment'];
            $response_file_attachment = $row['response_file_attachment'];
            $response_other = $row['response_other'];
            $response_na = $row['response_na'];
        }
    }
    $aoid = $assessment_id;
    if (!is_null($aoid)) {

        $statement = $db->prepare("select * from assessment_registry where object_id = :aoid");
        $statement->bindParam(':aoid', $assessment_id);
        $statement->execute();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $object_id = $row['object_id'];
            $identikey = $row['identikey'];
            $title = $row['title'];
            $created_date = $row['created_date'];
            $assess_id = $row['assess_id'];
            $description = $row['description'];
            $instructions = $row['instructions'];
            $unique_access_id = $row['unique_access_id'];
            $title_field = $row['title_field'];
            $reviews_requested = $row['reviews_requested'];
            $reviews_approved = $row['reviews_approved'];
            $tagline = $row['tagline'];
            $assessment_type = $row['assessment_type'];
            $created_userid = $row['created_userid'];

        }
    }
    ?>
    <script>
        $(document).ready(function () {

            //create input for more details on other radio item
            $(".other").click(function () {
                var tn = $(this).data("id");
                var btn_na = "btn_response_na[" + tn + "]";
                if ($(this).is(':checked')) {
                    $('#other_field_' + tn).html("<input name=\"response_other[" + tn + "]\" type=\"text\" style=\"width:50%\" placeholder=\"Please enter more details\">");

                //Non applicable
                $('#na_applicable_' + tn).val(false);
                $('#div_for_non_applicable_'+tn).html("");
                //$('#na_applicable2_'+tn).val("");

                    $("input[name^='" + btn_na + "']").css('background-color', 'rgb(53, 152, 220)');
                }
            });

            // [Add details]
            $(".show_q_comment").click(function () {
                var tn = $(this).data("id");
                if ($('#q_comment_' + tn).html() == "") {
                    $('#q_comment_' + tn).html("<textarea name=\"response_comment[" + tn + "]\" id=\"response_comment[" + tn + "]\" style=\"width:100%\" class=\"form-control\" placeholder=\"Please provide additional details\"></textarea>");
                } else {
                    $('#q_comment_' + tn).html("");
                }
            });

            // Other radio: wipe the input text
            $(".radio_item").click(function () {
                var tn = $(this).data("id");
                var btn_na = "btn_response_na[" + tn + "]";
                $('#other_field_' + tn).html("");
                ///$('#q_comment_'+tn).html("");

                $('#na_applicable_' + tn).val(false);
            $('#div_for_non_applicable_'+tn).html("");
            //$('#na_applicable2_'+tn).val("");

                $("input[name^='" + btn_na + "']").css('background-color', 'rgb(53, 152, 220)');
            });
            // Checkbox: wipe the Non-applicable button when clicked

            $('.checkbox-form').click(function () {
                var tn = $(this).data("id");
                var btn_na = "btn_response_na[" + tn + "]";

                $('#na_applicable_' + tn).val(false);
            $('#div_for_non_applicable_'+tn).html("");
            //$('#na_applicable2_'+tn).val("");

                $("input[name^='" + btn_na + "']").css('background-color', 'rgb(53, 152, 220)');
            });

            // Textarea, text and date fields: wipe the Non-applicable button and enable textarea/text/date
            $('.form-control').click(function () {
                var tn = $(this).data("id");
                var btn_na = "btn_response_na[" + tn + "]";
                var n = "response[" + tn + "]";
                $("textarea[id^='" + n + ".textarea']").prop("readonly", false); //enable textarea
                $("input[id^='" + n + ".text']").prop("readonly", false); //enable text

                $('#na_applicable_' + tn).val(false);
                $('#div_for_non_applicable_'+tn).html("");
                //$('#na_applicable2_'+tn).val("");

                $("input[name^='" + btn_na + "']").css('background-color', 'rgb(53, 152, 220)');

            });

            // Select box: wipe the Non-applicable button and enable select box
            $('.select_box').click(function () {
                var tn = $(this).data("id");
                var btn_na = "btn_response_na[" + tn + "]";

                $('#na_applicable_' + tn).val(false);
            //$('#na_applicable2_'+tn).val("");
            $('#div_for_non_applicable_'+tn).html("");

                $("input[name^='" + btn_na + "']").css('background-color', 'rgb(53, 152, 220)');
            });

            //Non-applicable button
            $('.na-button').click(function () {
                var tn = $(this).data("id");
                var n = "response[" + tn + "]";
                if ($(this).css('background-color') == 'rgb(254, 0, 0)') {
                    $(this).css('background-color', 'rgb(53, 152, 220)');
                    $('#na_applicable_' + tn).val(false);
                //$('#na_applicable2_'+tn).val("");
                $('#div_for_non_applicable_'+tn).html("");

                    $("input[id^='" + n + "']").prop("readonly", "");
                } else {
                    $(this).css('background-color', 'rgb(254, 0, 0)');
                    $("#na_applicable_" + tn).val(true);
                //$("#na_applicable2_"+tn).val("Non applicable");
                $('#div_for_non_applicable_'+tn).html("<input type=\"hidden\" id=\"na_applicable2_"+tn+"\" data-id=\""+tn+"\" name=\"response["+tn+"]\" value=\"Non applicable\">");
                    $("input[name^='" + n + "']").prop("checked", false); //disable radio items (yes, no, other) when clicked 'non applicable'
                    $("#other_field_" + tn).html(""); //disable other text box
                    $("input[id^='" + n + ".text']").prop("readonly", true); //disable text field and checkbox
                    $("input[id^='" + n + ".text']").val(""); //wipe the content of textfield
                    $("textarea[id^='" + n + ".textarea']").prop("readonly", true); //disable textarea
                    $("textarea[id^='" + n + ".textarea']").val(""); //wipe the content of textarea
                    $("input[id='" + n + ".date']").val("");
                    $("select[id^='" + n + ".select']").val(""); //disable select box
                }
            });
        });
    </script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption">
                <?php if ($existing_response) { ?>
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase"><?php echo $title; ?></span>
                    <a href="<? echo DOMAIN_PATH;?>/controller/assessmentengage?aoid=<?php echo $object_id; ?>&existing_response=<?php echo $existing_response; ?>">[Edit
                        Response]</a>
                <?php } ?>

                <?php
                if (pb_assessment_has_sections($assessment_id)) { ?>
                    <script>
                        $(function () {
                            // bind change event to select
                            $('#section').on('change', function () {
                                var url = $(this).val(); // get selected value
                                if (url) { // require a URL
                                    window.location = url; // redirect
                                }
                                return false;
                            });
                        });
                    </script>
                    <style>
                        a.anchor {
                            display: block;
                            position: relative;
                            top: -250px;
                            visibility: hidden;
                        }
                    </style>
                    <select name="section" id="section" class="form-control">
                        <option value=""></option>
                        <?php
                        $statement = $db->prepare("select * from assessment_section where parent_assessment_id = :aoid");
                        $statement->bindParam(':aoid', $aoid);
                        $statement->execute();
                        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                            $object_id = $row['object_id'];
                            $section_name = $row['title'];
                            ?>
                            <option value="#<?php echo str_replace(" ", "_", $section_name); ?>"><?php echo $section_name; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                <?php } ?>
            </div>
        </div>
        <div class="portlet-body form">

            <script type="text/javascript">
                $(document).ready(function () {

                    $("#form").on("change", "select, input[type=radio]", function () {

                        strIDChosen = $(this).attr('id');
                        strValueChosen = $(this).val();
                        $.ajax({
                            type: "POST",
                            url: "/ax/assessmentquestioncheck",
                            data: {qoid: strIDChosen, val: strValueChosen},
                            success: function (message) {
                                strIDChosen = strIDChosen.replace("response[", "");
                                strIDChosen = strIDChosen.replace("]", "");
                                strIDChosen = strIDChosen.split(".");
                                $("#new_" + strIDChosen[0]).html(message);
                            },
                            error: function () {
                                alert("An error has occurred processing this question");
                            }
                        });
                    });
                });
            </script>

            <style>

                #dropBox{

                }

                #dropBox p{

                }
                #fileInput{
                    display: none;
                }
                #status{
                    font-family: arial;
                }
            </style>

            <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>-->
            <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
                    crossorigin="anonymous"></script>
            <script>
                var parent_object_type="";
                var parent_object_id="";

                $( document ).ready(function() {
                    $(function(){
                        //file input field trigger when the drop box is clicked
                        $(".filecontrol").click(function(){
                            q_id = $(this).attr("id");
                            alert("The qid:"+q_id);

                            /*parent_object_type=$(this).data("parent-object-type");
                            parent_object_type=$(this).data("parent-object-type");
                            alert("The parent object id:"+parent_object_id);
                            alert("The parent object type:"+parent_object_type);
                            */

                            $("#fileInput").val("");
                            $("#fileInput").click();
                        });

                        //prevent browsers from opening the file when its dragged and dropped
                        $(document).on('drop dragover', function (e) {
                            e.preventDefault();
                        });

                        //call a function to handle file upload on select file
                        $('input[type=file]').on('change', fileUpload);
                    });

                    function fileUpload(event){
                        //notify user about the file upload status

                        alert("The qid2:"+q_id);
                        $("#status"+q_id).html(" Uploading...<img src='/icons/rotate.svg' width='24px' height='24px' />");
                        //get selected file
                        files = event.target.files;
                        //form data check the above bullet for what it is
                        var data = new FormData();

                        //file data is presented as an array
                        for (var i = 0; i < files.length; i++) {
                            var file = files[i];
                            if(file.size > 11762150 ){
                                //check file size (in bytes)
                                $("#status"+q_id).html("Sorry, your file is too large (>11 MB)");
                            }else{
                                //append the uploadable file to FormData object
                                var aoid = $("#aoid").val();
                                var response_code = $("#response_code").val();

                                data.append('file', file, file.name);
                                data.append('aoid', aoid);
                                data.append('objid',q_id);
                                data.append('parent_object_id', response_code);
                                //data.append('parent_object_type', parent_object_type);

                                //create a new XMLHttpRequest
                                var xhr = new XMLHttpRequest();
                                //post file data for upload
                                //xhr.open('POST', 'upload.php', true);
                                xhr.open('POST', "<?php echo DOMAIN_PATH ;?>/ax/dropzoneupload", true);
                                xhr.send(data);
                                xhr.onload = function () {
                                    alert(xhr.responseText);
                                    alert(xhr.responseText);

                                    var response = JSON.parse(xhr.responseText);
                                   // var response = xhr.responseText;

                                    if(xhr.status === 200){
                                        //if(xhr.status === 200 && response.status == 'ok'){
                                        if(response.status == 'success'){
                                            $("#status"+q_id).append(response.filename+"File uploaded");
                                            //response.status
                                           // $( "#result" ).load( "list.php" );

                                        }else if(response.status == 'file_err'){

                                            $("#status"+q_id).append("You cannot upload this file type to this workspace.");

                                        }else{
                                            $("#status"+q_id).append("A problem occured, please try again.");
                                        }

                                    }
                                };
                            }
                        }
                    }
                });
            </script>
            <input type="file" name="fileInput" id="fileInput" />
                            
            <form id="form" name="form" class="form-horizontal" role="form" action="<?php echo DOMAIN_PATH ;?>/controller/assessmentengage"
                  method="POST" enctype="multipart/form-data">





                <?php
                if ($_SESSION['s_userid'] == $created_userid) {
                    ?>
                    <div class="form-group"><label class="control-label col-md-1"></label>
                        <div class="col-md-11">Since you created this assessment, you can give the response a friendly
                            name to help track it.
                        </div>
                    </div>
                    <div class="form-group"><label class="control-label col-md-1">Friendly Name</label>
                        <div class="col-md-11"><h4><input name="friendly_name" type="text" size="80" value=""
                                                          style="width:95%" class="form-control"></h4>
                        </div>
                    </div>

                <?php } ?>
                <input type="hidden" id="unique_access_id" name="unique_access_id"
                       value="<?php echo $unique_access_id; ?>">
                <input type="hidden" id="response_code" name="response_code"
                       value="<?php echo $response_code; ?>">
                <input type="hidden" id="aoid" name="aoid"
                       value="<?php echo $aoid; ?>">


                <?php

                if (pb_assessment_has_sections($aoid)) {
                    $s_identikey = $_SESSION['s_identikey'];
                    $section_numeral = "1";
                    $statement = $db->prepare("select * from assessment_section where identikey='$s_identikey' and parent_assessment_id=:aoid order by order_id ASC");
                    $statement->bindParam(':aoid', $aoid);
                    $statement->execute();
                    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                        $object_id = $row['object_id'];
                        $title = $row['title'];
                        ?>
                        <div class="form-group">
                            <label class="control-label col-md-1"></label>
                            <div class="col-md-11">
                                <h3><strong><?php echo $section_numeral; ?>. <?php echo $title; ?>
                                        <a class="anchor" name="<?php echo str_replace(" ", "_", $title); ?>"></a>
                                    </strong></h3>
                            </div>
                        </div>
                        <?php

                        show_questions_engage($aoid, $object_id);
                        ++$section_numeral;
                    }
                    ?>

                    <?php

                }
                /*	if (check_question_has_dependency($qoid)) { } else {
                        display_question($qoid,$response[$qoid]);
                    }*/

}

                ?>

                <?php

                if ($existing_response) {
                    ?>
                    <input type="hidden" id="existing_response" name="existing_response"
                           value="<?php echo $existing_response; ?>">
                    <?php
                }
                if ($_GET['function'] != 'view') {
                    ?>
                    <div class="floatinterface">
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success" value="save_changes" name="submit_button">
                                        Save Changes
                                    </button>
                                    <!-- <button type="submit" class="btn green" value="save_exit" name="submit_button">Save and Exit
                                     </button> -->
                                    <button type="button" class="btn btn-secondary">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }


                ?>

            </form>

    <?php
}
?>