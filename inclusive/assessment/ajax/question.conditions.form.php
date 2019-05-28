<?php
// This is a blank template that shows how to include the form processing include.
require_once(FS_ROOT_FUNCTIONS."/create.select.functions.php");
require_once(FS_ASSESSMENT_FUNCTIONS."/functions.php");

function main() {
	global $db;
	global $errorcode;
	global $outcome;
	global $s_identikey;
	global $s_username;
	$qoid=$_GET['qoid'];
	$aoid=$_GET['aoid'];
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		include("inclusive/assessment/question.proc.inc.php");
	}
	// pb_check_object_permission("assessment_question",$qoid,"userid","","edit");
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
		$allow_attachment=$row['allow_attachment'];
		$options=$row['options'];
		$displaytype=$row['displaytype'];
		$section=$row['section'];
	}
	// If form submittion has been successful, display message.
	
	echo $question_type;
?>
  <div class="portlet light ">
    <div class="portlet-title">
      <div class="caption">
        <i class="icon-settings font-dark"></i>
        <span class="caption-subject font-dark sbold uppercase">Question Conditions</span>
      </div>
      <div class="portlet-body form">
        <form class="form-horizontal" role="form" method="POST" id="modalform" name="modalform" action="/ax/assessment/questionconditionaction">
          <div class="form-group">
            <div class="col-md-9">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Question:</label>
            <div class="col-md-9">
               <?php echo $question_text;?>
            </div>
          </div>
                 <div class="form-group">
            <label class="col-md-3 control-label">If answer equals</label>
            <div class="col-md-9">
               <select name="equal" id="equal">
                  <option value="<?php echo $item;?>"><?php echo $item; ?></option><?php
                    $option_items=explode(",",$options);
                    foreach ($option_items as $item) {
                    ?>
                        <option value="<?php echo $item;?>"><?php echo $item; ?></option>
                    <?php
                    }
               ?>
               </select>
            </div>
          </div>
         <div class="form-group">
            <label class="col-md-3 control-label">Show question:</label>
            <div class="col-md-4">
                <select name="qoid" id="qoid">
                <option value="">Select a Question</option>
                 <?php
                 $question_data = retrieve_questions($aoid,$qoid);
                 $i=0;
                 $length = count($question_data);
                 for ($i = 0; $i < $length; $i++){
                 ?>
                  <option value="<?php echo $question_data[$i]['object_id']; ?>"><?php echo substr($question_data[$i]['question_text'], 0, 55);?></option>
                  <?php
                   ++$n;
                 }
                 ?>
                </select>
                <input type='hidden' id='function' name='function' value='add'>
                <input type='hidden' id='dependent_on_qoid' name='dependent_on_qoid' value='<?php echo $qoid; ?>'>
            </div>
          </div>
      </div>
    </div>
    <div class="form-actions">
      <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <button class="btn green" id="modalsubmit" name="modalsubmit">Save Conditions</button>
        </div>
      </div>
    </div>
        </form>
  </div>
  <?php
}
?>
