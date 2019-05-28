<?php

// This function will display a list of assessment requests either sent or recieved by the user
// First we get the Question ID that is the title
function show_assessment_title_field($response_code) {
    global $db;
    global $ext_db;
    $assessment_id=$_GET['assessment_id'];
    $s_identikey=$_SESSION['s_identikey'];

    $statement = $db->prepare("select * from assessment_registry where unique_access_id='$assessment_id' and identikey='$s_identikey' order by id DESC");

    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        $title_field=$row['title_field'];
    }

    $statement = $db->prepare("select * from assessment_response_item where response_code='$response_code' and question_id='$title_field' order by id DESC");
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        return   $title_data=$row['response_data'];
    }

}



function display_request_list($request_type) {
    global $db;
    global $errorcode;
    global $outcome;
    global $s_identikey;
    global $s_username;
    global $dev;

    $s_userid=$_SESSION['s_userid'];

    if ($request_type=="sent") {
        $statement = $db->prepare("select * from assessment_request where from_userid=:from_userid");
        $statement->bindParam(':from_userid', $s_userid);

    } else if ($request_type=="received") {
        $statement = $db->prepare("select * from assessment_request where to_userid=:to_id");
        $statement->bindParam(':to_id', $s_userid);

    }


    $statement->execute();

    $errcheck=$statement->rowCount();

    ?>
    <p> The following requests have been <?php echo $request_type;?> </p>

    <div class="portlet-body" style="display: block;">
        <div class="table">
            <table class="table table-striped table-bordered table-advance table-hover">
                <thead>
                <tr>
                    <th> Assessment Name </th>
                    <th> <?php if ($request_type=="sent") { echo "Sent to"; } else if ($request_type=="received") { echo "From"; } ?></th>
                    <th> Date <?php if ($request_type=="sent") { echo "Sent"; } else if ($request_type=="received") { echo "Received"; } ?></th>
                    <th> Current Status</th>
                    <th> Delete </th>
                    <th> Options</th>
                </tr>
                </thead>

                <tbody>
                <?php


                while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

                    $to_userid=$row['to_userid'];
                    $to_email=$row['to_email'];
                    $from_userid=$row['from_userid'];

                    $assessment_object_id=$row['assessment_object_id'];
                    $response_code = $row['response_code'];
                    $date_created = $row['date_created'];
                    $status = $row['status'];

                    if ($request_type=="sent") {
                        $person_id=$to_userid;

                    } else if ($request_type=="received"){
                        $person_id=$from_userid;

                    }

                    ?>
                    <tr>
                        <td>
                            <?php echo pb_uni_check("assessment_registry","title",$assessment_object_id) ?>
                        </td>
                        <td>

                            <?php
                            if ($request_type=="sent") {

                                if ($to_userid) {


                                }


                            } else if ($request_type=="received"){

                                $statement_x = $db->prepare("select first_name,last_name,company_name from access_users where userid = :userid");
                                $statement_x->bindParam(':userid', $person_id);
                                $statement_x->execute();
                                while ($row_x = $statement_x->fetch(PDO::FETCH_ASSOC)){
                                    $company=$row_x['company_name'];
                                    $first_name=$row_x['first_name'];
                                    $last_name=$row_x['last_name'];
                                }



                            } ?>

                            <?php echo $first_name; ?> <?php echo $last_name; ?> <?php if ($company) { echo "($company)"; } ?>



                        </td>
                        <td><?php echo date("d M Y",strtotime($date_created)); ?></td>
                        <td><?php echo $status; ?></td>

                        <td>
                            <?php if ($request_type=="sent") { $action="cancel"; } else if ($request_type=="received") { $action="reject"; } ?>
                            <button class="btn btn-default confirm-click" data-href="/delete.php?id=54" data-toggle="modal" data-target="#confirm-click" data-title="<?php echo ucwords($action); ?> Assessment Request" data-body="Are you certain you wish to <?php echo $action;?> this assessment request?">
                                <?php echo ucwords($action); ?>Delete</button>
                        </td>
                        <td></td>
                        <td>

                            <div class="btn-group">
                                <button class="btn red dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Options</button>
                                <ul class="dropdown-menu">

                                    <li>
                                        <a href="/controller/assessmentsendreminder?aoid=<?php echo $id;?>" class="dropdown-item">Send Email Reminder</a>
                                    </li>
                                    <li>
                                        <a href="#" data-href="/controller/assessmentrequestdelete?oid=23" data-toggle="modal" data-target="#confirm-delete" class="dropdown-item">Delete Request</a>
                                    </li>

                                    <li class="divider"> </li>
                                    <li>
                                        <?php if ($request_type=="sent") { ?>
                                            <a href="/controller/questionform?aoid=<?php echo $id;?>&function=add" class="dropdown-item">View Response</a>
                                        <?php } ?>
                                    </li>

                                </ul>
                            </div>

                        </td>

                    </tr>

                    <?php
                }

                ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php
    if ($total_count > 15) {
        pb_resultsPagination($query_total, $limit, $start, $pid, $mode = "");
    }
}



function display_inprogress_list($request_type) {

    // This function will display assessments that are in progress, and also those that have been submitted.
    global $db;
    global $errorcode;
    global $outcome;
    global $s_identikey;
    global $s_username;
    global $dev;

    $s_userid=$_SESSION['s_userid'];

    // TO DO: Only responses submitted by user
    if ($request_type=="submitted") {
        $statement = $db->prepare("select * from assessment_response where created_userid=:user_id or identikey=:identikey and status='submitted'");
        $statement->bindParam(':user_id', $s_userid);
        $statement->bindParam(':identikey', $s_identikey);
    } else if ($request_type=="draft") {
        $statement = $db->prepare("select * from assessment_response where created_userid=:user_id or identikey=:identikey and status='draft'");
        $statement->bindParam(':user_id', $s_userid);
        $statement->bindParam(':identikey', $s_identikey);
    }
    $limit = 10;
    $start = 0;
    $query_total = "select count(*) from assessment_registry where identikey='$s_identikey'";
    $total_count = $db->query($query_total)->fetchColumn();
    if(isset($_GET['pid'])) {
        $pid=$_GET['pid'];
        if ($pid < 1) {
            $pid="1";
        } else {
            $start=($pid-1)*$limit;
        }
    } else {
        $pid="1";
    }
    $columnName = $_POST['columnName'];
    $sort = $_POST['sort'];
//    $statement = $db->prepare("select * from assessment_response order by id DESC LIMIT $start, $limit");

//    $statement = $db->prepare("select * from assessment_response order by " .$columnName." ".$sort." LIMIT ".$start,$limit." ");

    $statement->execute();
    $errcheck=$statement->rowCount();
    ?>
    <p> The following requests have been <?php echo $request_type;?> </p>

    <div class="portlet-body" style="display: block;">
        <div class="table">
            <input type='hidden' id='sort' value='asc'>
            <table class="table table-striped table-bordered table-advance table-hover" id="assTable">
                <thead>
                <tr>
                    <th><span onclick='sortTable("ass_name");'> Assessment Name </span></th>
                    <th> <?php if ($request_type=="sent") { echo "Sent to"; } else if ($request_type=="received") { echo "From"; } ?></th>
                    <th><span onclick='sortTable("date");'> Date <?php if ($request_type=="sent") { echo "Sent"; } else if ($request_type=="received") { echo "Received"; } ?></span></th>
                    <th><span onclick='sortTable("current_status");'> Current Status</span></th>
                    <th><span onclick='sortTable("delete");'> Delete </span></th>
                    <th><span onclick='sortTable("options");'> Options </span></th>
                </tr>
                </thead>

                <tbody>
                <?php
                while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

                    $to_userid=$row['to_userid'];
                    $to_email=$row['to_email'];
                    $from_userid=$row['from_userid'];

                    $assessment_object_id=$row['assessment_id'];
                    $response_code =$row['response_code'];
                    $date_created=$row['created_date'];
                    $status=$row['status'];
                    if ($request_type=="sent") {
                        $person_id = $to_userid;
                    } else if ($request_type=="received"){
                        $person_id = $from_userid;
                    }

                    ?>
                    <tr>
                        <td>
                            <?php echo pb_uni_check("assessment_registry","title",$assessment_object_id) ?>
                        </td>
                        <td>
                            <?php
                            if ($request_type=="sent") {

                                if ($to_userid) {


                                }


                            } else if ($request_type=="received"){

                                $statement_x = $db->prepare("select first_name,last_name,company_name from access_users where userid = :userid");
                                $statement_x->bindParam(':userid', $person_id);
                                $statement_x->execute();
                                while ($row_x = $statement_x->fetch(PDO::FETCH_ASSOC)){
                                    $company=$row_x['company_name'];
                                    $first_name=$row_x['first_name'];
                                    $last_name=$row_x['last_name'];
                                }
                            } ?>

                            <?php echo $first_name; ?> <?php echo $last_name; ?> <?php if ($company) { echo "($company)"; } ?>
                        </td>
                        <td><?php echo date("d M Y",strtotime($date_created)); ?></td>
                        <td><?php echo $status; ?></td>
                        <td>
                            <?php if ($request_type=="sent") { $action="cancel"; } else if ($request_type=="received") { $action="reject"; } ?>
                            <button class="btn btn-default confirm-click" data-href="/delete.php?id=54" data-toggle="modal" data-target="#confirm-click" data-title="<?php echo ucwords($action); ?> Assessment Request" data-body="Are you certain you wish to <?php echo $action;?> this assessment request?">
                                <?php echo ucwords($action); ?>Delete</button>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button class="btn red dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Options</button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="/controller/assessmentsendreminder?aoid=<?php echo $id;?>" class="dropdown-item">Send Email Reminder</a>
                                    </li>
                                    <?php
                                    if($status=='draft'){
                                    ?>
                                        <li>
                                            <a href="/controller/assessment/engage?aoid=<?php echo $assessment_object_id;?>&existing_response=<?php echo $response_code; ?>" class="dropdown-item">Edit Response</a>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                    <li>
                                        <a href="#" data-href="/controller/assessmentrequestdelete?oid=23" data-toggle="modal" data-target="#confirm-delete" class="dropdown-item">Delete Request</a>
                                    </li>
                                    <li class="divider"> </li>
                                    <li>
                                        <?php if ($request_type=="sent") { ?>
                                            <a href="/controller/questionform?aoid=<?php echo $id;?>&function=add" class="dropdown-item">View Response</a>
                                        <?php } ?>
                                    </li>

                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php

    if ($total_count > 15) {
        pb_resultsPagination($query_total, $limit, $start, $pid, $mode = "");
    }

}
?>
<script>
    function sortTable(columName){

        var sort = $("#sort").val();
        $.ajax({
            url:'assessment.inprogress.list.inc.php',
            type:'post',
            data:{columnName:columnName,sort:sort},
            success: function(response){

                $("#assTable tr:not(:first)").remove();

                $("#assTable").append(response);
                if(sort == "asc"){
                    $("#sort").val("desc");
                }else{
                    $("#sort").val("asc");
                }

            }
        });
    }
</script>