<?php


function main() {

    $db=db_conn();

    $s_identikey=$_SESSION['s_identikey'];
    $s_username=$_SESSION['s_username'];
    $s_userid=$_SESSION['s_userid'];

    $function=$_GET['function'];
    $soid = $_GET['soid'];
    $qoid = $_GET['qoid'];

    if ($function!=="edit") {
        $aoid=$_GET['aoid'];
        if(is_null($aoid)) {
            $aoid=$_POST['aoid'];
        }
        pb_check_object_permission("assessment",$aoid,"userid","","edit");
    }

    if ($function=='edit' and $_SERVER['REQUEST_METHOD'] !== 'POST') {

        //  pb_check_object_permission("assessment_question",$id,"userid","","edit");

        $statement = $db->prepare("select title, additional_info from assessment_section where object_id = :soid");
        $statement->bindParam(':soid', $soid);

        $statement->execute();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

            //$object_id=$row['object_id'];
            $section_name=stripslashes($row['title']);
            $section_additional_info=stripslashes($row['additional_info']);

        }

    }
    ?>

    <form class="f1" id="modal_form" name="modal_form" action="/ax/assessment/sectionproc" method="post">
        <?php if ($function!="del"){  ?>
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Assessment Section</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <div class="col-md-9">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Section Name</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" value="<?php echo $section_name;?>" name="section_name" id="section_name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Additional Info</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" value="<?php echo $section_additional_info;?>" name="section_additional_info" id="section_additional_info">
                    </div>
                </div>

            </div>

            <?php //if ($function=="edit") { ?>
                <!--<input type='text' id='soid' name='soid' value='<?php //echo $object_id; ?>'> -->
            <?php // } else { ?>
                <!--<input type='text' id='aoid' name='aoid' value='<?php //echo strip_tags($_GET['aoid']);?>'> -->
            <?php //} ?>
            <input type='hidden' id='function' name='function' value='<?php echo $function; ?>'>
            <input type="hidden" name="aoid" value="<?php echo $aoid;?>"/>
            <input type='hidden' id='soid' name='soid' value='<?php echo $soid; ?>'>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <input type="submit" value="Save" class="btn btn-success">
            </div>

        <?php } else if ($function=="del"){ ?>
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Section Deletion</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-md-9">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 control-label">Are you sure you want to delete this Section?</label>
                    <div class="col-md-9">
                    </div>
                </div>
            </div>
            <input type='hidden' id='aoid' name='aoid' value="<?php echo $aoid;?>">
            <input type='hidden' id='function' name='function' value='<?php echo $function; ?>'>
            <input type="hidden" name="soid" value="<?php echo $soid;?>"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No, please Cancel</button>
                <input type="submit" value="Yes, Delete this Section" class="btn btn-danger">
            </div>
        <?php }?>
    </form>

   <?php
}
?>