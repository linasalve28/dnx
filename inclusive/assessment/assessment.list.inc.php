<style>
    input[type=text] {        /*background-image: url('searchicon.png');*/
        display: inline-block;
        width: 80%;
        box-sizing: border-box;
        border: 2px solid #ccc;
        border-radius: 4px;
        font-size: 12px;
        background-color: white;
        background-position: 5px 5px;
        background-repeat: no-repeat;
        padding: 5px;
    }
    .btn-success.btn-search{
        padding: 0.5rem !important;
        margin-left: 5px;
    }
</style>
<?php
// SQL IDENTIKEY CONFIRMED
function main() {
    global $db;
    global $errorcode;
    global $outcome;
    global $s_identikey;
    global $s_username;
    global $dev;
?>
<style>
.pb-header-app {
    position: relative;
    padding: 2rem;
    color: #fff;
    border-radius: 6px;
    margin-bottom: 15px;

}
.pb-basic-gradient {
    background: #328dff;

/*
	    background: -webkit-linear-gradient(135deg, #3d74f1, #9986ee);
    background: linear-gradient(-45deg, #3d74f1, #9986ee);
    */
    background: rgb(4,144,152);
background: linear-gradient(90deg, rgba(4,144,152,1) 0%, rgba(9,83,121,1) 42%, rgba(23,76,140,1) 100%);
}
	</style>
             <div class="pb-header-app pb-basic-gradient">
                <h3>Assessments</h3>
                <p>Assessments allow you to check your companies progress against a number of standards. They also allow you to capture information from clients and suppliers.
                </p>
            </div>
            
            <form action="<?php echo DOMAIN_PATH ;?>/controller/assessment/list?function=search" method="get">
            <div class="table">
            <div class="portlet-body" style="display: block;">
            <table class="table table-striped table-bordered table-advance table-hover">
            <thead>
            <tr>
                <th colspan="2">
                    Assessment Name
                </th>
               
            </tr>
            <tr>
                <th colspan="2"><input type="text" name="search" placeholder="Search.." class="form-control"/><input type="submit" value="Search" class="btn btn-success btn-search"/>
                </th>
                
            </tr>
            </thead>
            <tbody>
            <?php
               /*========***** Search *****=====*/

    if(isset($_GET['search'])){
	        $search = $_GET['search'];
        if(pb_validate_ultrasafe($search)) {
                /* Paginator for Results on Search */
                $limit = 10;
                $start = 0;
                $query_total = "select count(*) from assessment_registry where title LIKE '%$search%' AND status <> 'deleted' ORDER BY id DESC LIMIT $start,$limit";
                $total_count = $db->query($query_total)->fetchColumn();
                if (isset($_GET['pid'])) {
                    $pid = $_GET['pid'];
                    if ($pid < 1) {
                        $pid = "1";
                    } else {
                        $start = ($pid - 1) * $limit;
                    }
                } else {
                    $pid = "1";
                }


            $query = $db->prepare("select * from assessment_registry where title LIKE '%$search%' AND status <> 'deleted' order by id DESC LIMIT $start, $limit");
            //$query->bindValue(1, "%$search%", PDO::PARAM_STR);
            $query->bindParam(PDO::PARAM_STR,$search);
            $query->execute();
            // Display search result
            if ($query->rowCount() > 0) { // if one or more rows are returned do following

                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    $id = $row['object_id'];
                    $identikey = $row['identikey'];
                    $title = $row['title'];
                    $created_date = $row['created_date'];
                    $assess_id = $row['assess_id'];
                    $description = $row['description'];
                    $instructions = $row['instructions'];
                    $unique_access_id = $row['unique_access_id'];
                    ?>

                    <tr>
                        <td>
                            <?php echo $title; ?>
                        </td>
                        <td>
                            
                                
                                <div class="btn-group">
                                    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Options</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="<?php echo DOMAIN_PATH ;?>/controller/assessment/engage?aoid=<?php echo $id;?>">Use this Assessment</a>
                                        <a class="dropdown-item" href="<?php echo DOMAIN_PATH ;?>/controller/assessment/form?aoid=<?php echo $id;?>&function=del">Delete this Assessment</a>
                                        <a class="dropdown-item" href="<?php echo DOMAIN_PATH ;?>/controller/assessmentresponselist?aoid=<?php echo $id;?>">View Responses</a>
                                        <a class="dropdown-item"  href="<?php echo DOMAIN_PATH ;?>/controller/assessment/form?aoid=<?php echo $id;?>&function=edit">Edit Assessment</a>
                                        <a class="dropdown-item"  href="<?php echo DOMAIN_PATH ;?>/controller/assessmentrequestform?aoid=<?php echo $id;?>&function=edit">Send Assessment Request</a>
                                        
                                        <div class="dropdown-divider"> </div>
                                        <a class="dropdown-item"  href="<?php echo DOMAIN_PATH ;?>/controller/assessmentpreview?aoid=<?php echo $id;?>&function=add">Preview</a>
                                        <a class="dropdown-item"  href="<?php echo DOMAIN_PATH ;?>/controller/questionform?aoid=<?php echo $id;?>&function=add">Add Question</a>
                                        <a class="dropdown-item"  href="<?php echo DOMAIN_PATH ;?>/controller/questionlist?aoid=<?php echo $id;?>">List Questions</a>

                                        <div class="dropdown-divider"> </div>
                                        <a class="dropdown-item"  href="<?php echo DOMAIN_PATH ;?>/controller/externalrequestform?aoid=<?php echo $id; ?>">Send to Client</a>
                                        <a class="dropdown-item"  href="javascript:;"> Suspend Assessment</a>
                                        
                                        <div class="divider"> </div>
                                        
                                        <a class="dropdown-item"  href="https://www.trustbase.com/v/v.php?id=<?php echo $unique_access_id;?>" target="_blank"> View Live on site</a>
                                   </div>
                                </div>
                                
                                
                                
                                
                            </div>
                        </td>
                    </tr>
                <?php } //while $row
                ?>
                </tbody>
                </table>
                </div>
                </div>

               <?php
                if ($total_count > 15) {
                    pb_resultsPagination($query_total, $limit, $start, $pid, $mode = "");
                }
?>
                </form>
<?php
            } else { // if there is no matching rows do following
                 ?>
                    <tr>
                        <td>
                            <?php echo '<b>No results</b> for the search:"'.$search.'"'; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</form>
                <?php
           }
        }
    } else {
     /* ============== End Search ========= */

                    $limit=10;
                    $start=0;
                    $query_total = "select count(*) from assessment_registry where identikey='$s_identikey' AND status <> 'deleted' or status IS NULL";
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

                    $statement = $db->prepare("select id,object_id,identikey,title,created_date,assess_id,description,instructions,unique_access_id,status from assessment_registry where identikey='$s_identikey' AND status <> 'deleted' or status IS NULL order by id DESC LIMIT $start,$limit");
                    $statement->execute();
                    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
                        $id=$row['object_id'];
                        $identikey=$row['identikey'];
                        $title=$row['title'];
                        $created_date=$row['created_date'];
                        $assess_id=$row['assess_id'];
                        $description=$row['description'];
                        $instructions=$row['instructions'];
                        $unique_access_id=$row['unique_access_id'];
                        ?>
                        <tr>
                            <td>
                                <?php echo $title;?>
                            </td>
                            <td>
	                            
	                            
		                            
                                <div class="btn-group">
                                    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Options</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="<?php echo DOMAIN_PATH ;?>/controller/assessment/engage?aoid=<?php echo $id;?>">Use this Assessment</a>
                                        <a class="dropdown-item" href="<?php echo DOMAIN_PATH ;?>/controller/assessment/form?aoid=<?php echo $id;?>&function=del">Delete this Assessment</a>
                                        <a class="dropdown-item" href="<?php echo DOMAIN_PATH ;?>/controller/assessment/responselist?aoid=<?php echo $id;?>">View Responses</a>
                                        <a class="dropdown-item"  href="<?php echo DOMAIN_PATH ;?>/controller/assessment/form?aoid=<?php echo $id;?>&function=edit">Edit Assessment</a>
                                        <a class="dropdown-item"  href="<?php echo DOMAIN_PATH ;?>/controller/assessment/requestform?aoid=<?php echo $id;?>&function=edit">Send Assessment Request</a>
                                        
                                        <div class="dropdown-divider"> </div>
                                        <a class="dropdown-item"  href="<?php echo DOMAIN_PATH ;?>/controller/assessment/preview?aoid=<?php echo $id;?>&function=add">Preview</a>
                                        <a class="dropdown-item"  href="<?php echo DOMAIN_PATH ;?>/controller/assessment/questionform?aoid=<?php echo $id;?>&function=add">Add Question</a>
                                        <a class="dropdown-item"  href="<?php echo DOMAIN_PATH ;?>/controller/assessment/questionlist?aoid=<?php echo $id;?>">List Questions</a>

                                        <div class="dropdown-divider"> </div>
                                        <a class="dropdown-item"  href="<?php echo DOMAIN_PATH ;?>/controller/assessment/externalrequestform?aoid=<?php echo $id; ?>">Send to Client</a>
                                        <a class="dropdown-item"  href="javascript:;"> Suspend Assessment</a>
                                        
                                        <div class="divider"> </div>
                                        
                                        <a class="dropdown-item"  href="https://www.trustbase.com/v/v.php?id=<?php echo $unique_access_id;?>" target="_blank"> View Live on site</a>
                                   </div>
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
    </form>

<?php
}
?>