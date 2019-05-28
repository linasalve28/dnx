<?php
/* include("/home/trustbase/servers/gateway.trustbase.com/functions/create.select.functions.php");
include("/home/trustbase/servers/gateway.trustbase.com/lib/autoload.php");
include("/home/trustbase/servers/gateway.trustbase.com/inclusive/assessment/functions/functions.php");
 */
include(FS_ROOT_FUNCTIONS."/create.select.functions.php");
include(FS_ROOT_LIB."/autoload.php");
include(FS_ASSESSMENT_FUNCTIONS."/functions.php");


function main() {
	global $db;
	global $errorcode;
	global $outcome;
	global $s_identikey;
	global $s_username;
	global $ext_db;

	$function=$_GET['function'];
	$id=$_GET['id'];
	$response_code=$_GET['id'];
	$a=$_GET['a'];

	$statement = $db->prepare("select * from assessment_registry where object_id = :a");
	$statement->bindParam(':a', $a);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$object_id=$row['object_id'];
	}


	

?>
    <div class="row">
		<div class="col-md-12">
			<!-- BEGIN PORTLET-->
			<div class="portlet light form-fit ">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-pin font-red"></i>
						<span class="caption-subject font-red sbold uppercase">Response : <?php echo $id;?>  <a href="/controller/assessmentengage?aoid=<?php echo $object_id;?>&existing_response=<?php echo $response_code;?>"> [EDIT]</a></span>
					</div>
				</div>
				<div class="portlet-body form">
					<!-- BEGIN FORM-->
					<form action="#" class="form-horizontal form-bordered">
						<div class="form-body">

<?php
	$statement = $db->prepare("select * from assessment_question where assessment_id = :object_id order by order_id");

	$statement->bindParam(':object_id', $object_id);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

		$object_id=$row['object_id'];
		$question_text=$row['question_text'];
		$question_type=$row['question_type'];
		$question_type=$row['question_type'];

?>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3"><?php echo $question_text; ?></label>
                                                    <div class="col-md-7">

<?php
		$response_data=show_response_data($object_id,$response_code);

		if ($response_data['data']) {
			if ($question_type=="Checkbox") {
				$checkbox_items=explode("{{SEP}}",$response_data['data']);
				for ($x = 0; $x <= count($checkbox_items); $x++) {
					echo $checkbox_items[$x];
					echo "<br />";
				}
			} else if ($question_type=="Date") {
					echo date("d F Y",$response_data['data']);
				} else if ($question_type=="TextArea") {
					echo nl2br($response_data['data']);
                    } else if ($question_type=="text") {
                            echo nl2br($response_data['data']);
                        } else {
                        echo $response_data['data'];
                        //    $risk_data=show_risk_data($object_id,$response_data['data']);
                        //print_r($risk_data);
                        //echo "Risk Level: ".$risk_data[''];
			}

			// Senitment analysis. Fully working, however not currently used.
			if ($question_type=="FiveStar") {
				echo " out of 5";
			}
		}

?>
                                                    </div>
                                                </div>

<?php
	}

?>
                                            </div>
                                        </form>

                                        <!-- END FORM-->
                                    </div>
                                </div>
                                <!-- END PORTLET-->
                            </div>
                        </div>




<?php
}

function show_question($id) {

	global $db;
	$statement = $db->prepare("select question_text from assessment_question where id = :id");
	$statement->bindParam(':id', $id);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		return $question_text=$row['question_text'];
	}
}

function show_response_data($question_id,$response_code) {
	global $db;
	//echo "select * from assessment_response_item where question_id = '$question_id' and response_code= '$response_code'";

	// echo "select * from assessment_response_item where question_id = $question_id and response_code= $response_code";

	$statement = $db->prepare("select * from assessment_response_item where question_id = :question_id and response_code= :response_code");
	$statement->bindParam(':question_id', $question_id);
	$statement->bindParam(':response_code', $response_code);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$id=$row['id'];
		$question_id=$row['question_id'];
		$response_code=$row['response_code'];
		$assessment_id=$row['assessment_id'];
		$response_data_x['data']=stripslashes($row['response_data']);
		$response_data_x['other_field']=$row['response_other']; //show other field Aline
		$response_data_x['comment']=$row['response_comment'];
		$response_data_x['file']=$row['response_file_attachment'];
		$response_data_x['other']=$row['response_other'];
		$response_data_x['na']=$row['response_na'];
		return $response_data_x;
	}
}

?>