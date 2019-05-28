<?php
// This is a blank template that shows how to include the form processing include.
// IDENTIKEY SQL CONFIRMED

include(FS_ROOT_FUNCTIONS."/create.select.functions.php");

function main() {
    global $db;
    global $errorcode;
    global $outcome;
    global $s_identikey;
    global $s_username;

    $function=$_GET['function'];
    $id=$_GET['aoid'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include(FS_INCLUSIVE_ASSESSMENT."/assessment.proc.inc.php");
    }



    if ($function=='edit' and $_SERVER['REQUEST_METHOD'] !== 'POST') {

        $object_id = $id;

        pb_check_object_permission("assessment",$object_id,"userid",$s_userid,"edit");

        // IF WE ARE EDITING

        $query="select * from assessment_registry where object_id = :id and identikey=:identikey";
        $statement = $db->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->bindParam(':identikey', $s_identikey);
        $statement->execute();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $id=$row['object_id'];
            $title=$row['title'];
            $description=$row['description'];
            $instructions=$row['instructions'];
            $review=$row['reviews_requested'];
        }

    }

    // If form submittion has been successful, display message.

    if ($outcome=="success") {
        if ($function=="edit"){
            echo "<div class=\"alert alert-success\"><strong>Success!</strong> Assessment Edited </div>";
        } else if ($function=="add") {
            echo "<div class=\"alert alert-success\"><strong>Success!</strong> Assessment Created </div>";
        } else if ($function=="del") {
            echo "<div class=\"alert alert-success\"><strong>Success!</strong> Assessment Deleted </div>";
        }
    }

    else if ($function=="del"){
        $aoid = $_GET['aoid'];

        if(isset($aoid)) {
            ?>
            <form class="form-horizontal" role="form" action="/controller/assessment/form" method="POST">

                <!--          <form class="f1" id="create_opp_form" name="create_opp_form" action="/ax/assessment/engageproc" method="post">-->

                <!--        <form id="form" name="form" class="form-horizontal" role="form" action="/ax/assessment/engageproc" ---era assim!!-->
                <!--              method="POST" enctype="multipart/form-data">-->
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Assessment Deletion</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">

                        <div class="col-md-9">

                        </div>
                    </div>

                    <div class="form-group">
                        <h4 class="col-md-12 control-label">Are you sure you want to delete this Assessment?</h4>
                        <p>If you delete this Assessment, you will delete all Sections and Questions linked to it.</p>
                        <?php
                        //get assessment title
                        if (!is_null($aoid)) {

                            $statement = $db->prepare("select * from assessment_registry where object_id = :aoid");
                            $statement->bindParam(':aoid', $aoid);
                            $statement->execute();
                            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                                $id = $row['id'];
                                $object_id = $row['object_id'];
                                $identikey = $row['identikey'];
                                $title = $row['title'];
                            }
                        }


                        echo "<p>Assessment: " . $title . "</p>";


                        $query_response="select * from assessment_response where assessment_id='$aoid' order by id DESC";
                        $statement_response = $db->prepare($query_response);
                        $statement_response->execute();
                        $y = $statement_response->rowCount();
                        if($y > 0){

                            echo "<a>This Assessment has: <strong><a href='". DOMAIN_PATH."/controller/assessment/responselist?aoid=".$aoid."'>" . $y . " </strong>Responses</a>. </p><p>If you delete this Assessment, all Responses will be deleted too.</p>";
                        }

                        $statement_request = $db->prepare("select * from assessment_request where assessment_object_id='$aoid' order by id DESC");
                        $statement_request->execute();
                        $x = $statement_request->rowCount();
                        if($x > 0){
                            echo "<p>Requests:</p>";
                            echo "<ul>";

                            while ($row = $statement_request->fetch(PDO::FETCH_ASSOC)) {
                                $request_code = $row['object_id'];
                                $from_userid = $row['from_userid'];
                                $to_userid = $row['to_userid'];

                                echo "<li>Request code:" . $request_code . "</li>";
                                echo "<li>From userid:" . $from_userid . "</li>";
                                echo "<li>To userid:" . $to_userid . "</li>";
                            }
                            echo "</ul>";
                        }
                        ?>
                    </div>
                </div>

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">

                        </div>
                    </div>
                </div>
                <?php
                echo "<input type='hidden' id='assessment_id' name='aoid' value='" . $aoid . "'>";
                echo "<input type='hidden' id='qoid' name='qoid' value='" . $qoid . "'>";
                echo "<input type='hidden' id='soid' name='soid' value='" . $soid . "'>";
                echo "<input type='hidden' id='function' name='function' value='" . $function . "'>";
                ?>

                <input type='hidden' id='item_status' name='item_status' value='orphan'>

                <div class="modal-footer">
                    <a href="/controller/assessment/list"><button type="button" class="btn default" id="assessmentform_cancel">Cancel</button></a>
                    <!--                  <button type="submit" class="btn btn-default" value="cancel" data-dismiss="modal">No, please Cancel</button>-->
                    <!--                <a href="/ax/assessment/assessm?aoid=--><?php //echo $aoid;?><!--&function=del" class="f4"><button type="button" class="btn btn-success">Yes, Delete this Assessment</button></a>-->

                    <button type="submit" class="btn btn-danger f1" value="delete_assessment" name="submit_button">Yes, Delete this Assessment</button>

                </div>
            </form>
            <?php
        }
        //else { ?>
        <!--          <div class="modal-header">-->
        <!--              <h4 class="modal-title" id="myModalLabel">Assessment Deletion</h4>-->
        <!--              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>-->
        <!--              </button>-->
        <!--          </div>-->
        <!---->
        <!--          <div class="modal-body">-->
        <!--              <div class="form-group">-->
        <!--                  <div class="col-md-9">-->
        <!--                      <h4 class="col-md-12 control-label">Assessment not found.</h4>-->
        <!--                      <p>Please, check the list of existing Assessments.</p>-->
        <!--                      <a href="/controller/assessmentlist">  <button type="button" class="btn green-meadow">View Assessments</button></a>-->
        <!--                  </div>-->
        <!--              </div>-->
        <!--          </div>-->
        <!--          --><?php
//      }
        //end of delete assessment
    }




    else {

        ?>

        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">Assessment</span>
                </div>
                <div class="portlet-body form">
                    <form class="form-horizontal" role="form" action="/controller/assessment/form" method="POST">

                        <div class="form-group">

                            <div class="col-md-9">

                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">Title</label>
                            <div class="col-md-9">
                                <?php if(isset($errorcode["title"])){echo $errorcode["title"];} ?>
                                <input type="text" class="form-control" value="<?php echo $title;?>" name="title" id="title">

                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">Description</label>
                            <div class="col-md-9">
                                <?php if(isset($errorcode["description"])){echo $errorcode["description"];} ?>
                                <input type="text" class="form-control" value="<?php echo $description;?>" name="description" id="description">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Instructions</label>
                            <div class="col-md-9">
                                <?php if(isset($errorcode["instructions"])){echo $errorcode["instructions"];} ?>
                                <input type="text" class="form-control" value="<?php echo $instructions;?>" name="instructions" id="instructions">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Review Assessment</label>
                            <div class="col-md-9">
                                <?php if(isset($errorcode["review"])){echo $errorcode["review"];} ?>
                                <p>If this assessment is collecting reviews of your company it will contribute to your Trust Rating.</p>
                                <label><input type="radio" name="review" value="Yes" <?php if ($review=="Yes") { echo "checked";} ?>> Yes</label>
                                <label><input type="radio" name="review" value="No" <?php if ($review=="No"|$review=="") { echo "checked";} ?>> No</label>
                            </div>
                        </div>



                </div>
            </div>
            <div class="form-actions">
                <?php if ($_GET['function']=="edit") { ?>
                    <input type="hidden" name="function" value="edit">
                    <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
                <?php } ?>
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn green">Submit</button>
                        <a href="/controller/assessment/list"><button type="button" class="btn default" id="assessmentform_cancel">Cancel</button></a>
                    </div>
                </div>
            </div>
            <?php if ($function=="edit") { ?>
                <input type='hidden' id='id' name='id' value='<?php echo $id;?>'>
            <?php } ?>
            <input type='hidden' id='function' name='function' value='<?php echo $function; ?>'>
            </form>
        </div>



        <?php
    }
}
?>