<?php
// This allows us to connect to the External Data Core, where Reponses are held.
//include("/home/trustbase/dbn/tb.db.conn.php");
 

// ISOLATE AND PUT INTO CENTRAL FILES
function name_title_data($assessment_id){

  global $db;

  $assessment_id=$_GET['aoid'];
  $s_identikey=$_SESSION['s_identikey'];

  /* BOF Optimised Code Lina 15 Dec 2017 */
  $query = "select assessment_question.question_text from assessment_question LEFT JOIN assessment_registry ON assessment_question.object_id = assessment_registry.title_field where assessment_registry.object_id = :assessment_id and assessment_registry.identikey = :s_identikey order by assessment_registry.id DESC";   
  $statement = $db->prepare($query);
  $statement->bindParam(':assessment_id', $assessment_id);
  $statement->bindParam(':s_identikey', $s_identikey);
  $statement->execute();
  while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
	return $question_text=$row['question_text'];
  }
  
  /* EOF Optimised Code Lina 15 Dec 2017 */   
}

function main() {
    global $db;
    global $errorcode;
    global $outcome;
    global $s_identikey;
    global $s_username;
    global $ext_db;
    ?>
  <div class="m-heading-1 border-green m-bordered">
    <h3>Responses</h3>
    
  </div>



  <div class="portlet-body" style="display: block;">
	  <div class="table">
		  <table class="table table-striped table-bordered table-advance table-hover">
			  <thead>
				<tr>
				  <th>
					  <i class="fa fa-briefcase"></i> <?php echo name_title_data($assessment_id); ?> </th>
				  <th class="hidden-xs">
					  <i class="fa fa-question"></i> To </th>
				  <th>
					  <i class="fa fa-bookmark"></i> Status </th>
				  <th> </th>
				</tr>
			  </thead>

			<tbody>


<?php
if (strlen($_GET['assessment_id']) > 7) {
  echo "String Permission Error";
   strlen($_GET['assessment_id']);
  exit;
}
 $assessment_id=$_GET['aoid'];


//pb_check_user_permission("assessment_registry_uac",$assessment_id);



// First we get the Question ID that is the title
function title_data($assessment_id,$response_code) {

  global $db;

$assessment_id=$_GET['aoid'];
$s_identikey=$_SESSION['s_identikey'];

 $query="select * from assessment_registry where object_id='$assessment_id' and identikey='$s_identikey' order by id DESC";

  $statement = $db->prepare($query);

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






// Next we get the response id for this assessment_id, we need the response code of each item
$query_total = "select count(*) from assessment_response where assessment_id='$assessment_id'";
$total_count = $db->query($query_total)->fetchColumn();
$start=0;
$limit=10;

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


$s_identikey = $_SESSION['s_identikey'];
$query="select * from assessment_response where assessment_id='$assessment_id' order by id DESC LIMIT $start, $limit";
//echo "<pre>$query</pre>";
//$query="select * from assessment_response where identikey='$s_identikey' order by id DESC";

$statement = $db->prepare($query);
$statement->execute();
$y= $statement->rowCount();

while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
	$id=$row['id'];
	$assessment_id=$row['assessment_id'];
	$response_code=$row['response_code'];
	$title=$row['title'];
	$created_date=$row['created_date'];
	$completed_date=$row['completed_date'];
	$status=$row['status'];
	$ip_address=$row['ip_address'];
	$host_name=$row['host_name'];
	$other_identifier=$row['other_identifier'];

                                            ?>
                                                <tr>
                                                    <td>
                                                        <a href="<?php echo DOMAIN_PATH ;?>/controller/assessment/engage?function=view&aoid=<?php echo $assessment_id;?>&existing_response=<?php echo $response_code;?>">
                                                        <?php
                                                        $title_data=title_data($assessment_id,$response_code);

                                                        if (!$title_data) { ?> Response <?php echo $y; $y=$y-1; }  else {
                                                         echo title_data($assessment_id,$response_code);
                                                         }
                                                         $title_data="";
                                                        ?>
                                                        </a>
													</td>
													<td>
                                                       <?php echo date("d M Y h:i",strtotime($created_date));?>
                                                    </td>
                                                    <td>
                                                          <span class="label label-sm label-success label-mini"> <?php echo $certification_dependant_status; ?> </span>
                                                    </td>
                                                    <td>  </td>
                                                </tr>
                                            <?php
                                          }


                                          ?>

                                              </tbody>
                                          </table>

                                         
                                              <div>

                                      </div>
                                  </div>


  <?php
    //echo "<pre>$query</pre>";
    if ($total_count > 15) {
        pb_resultsPagination($query_total, $limit, $start, $pid, $mode = "");
    }
  }
  ?>