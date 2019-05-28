<?php

include("/home/trustbase/servers/gateway.trustbase.com/functions/create.select.functions.php");
include("/home/trustbase/servers/gateway.trustbase.com/inclusive/assessment/functions/functions.php");

function main() {

  global $db;
  global $errorcode;
  global $outcome;
  global $s_identikey;
  global $s_username;

  $qoid=$_GET['qoid'];


  $aoid=$_GET['aoid'];
  
  if ($_GET['object_id']) {
	  
	  $riskid=$_GET['object_id'];
  }
  if ($_GET['function']=="edit") {
$function="edit";
} else if ($_GET['function']=="add") {
	$function="add";
	}




if ($riskid) {
	
	
	
    $statement = $db->prepare("select * from assessment_risk where object_id = :riskid");
    $statement->bindParam(':riskid', $riskid);

     		$statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
	    
    $riskid=$row['object_id'];
    $qoid=$row['question_object_id'];
     $equal_to=$row['equal_to'];
    $risk_level=$row['risk_level'];
	$risk_details=$row['risk_details'];
	$risk_remediation=$row['risk_remediation'];
}

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



    ?>

  <div class="portlet light ">
    <div class="portlet-title">
      <div class="caption">
        <i class="icon-settings font-dark"></i>
        <span class="caption-subject font-dark sbold uppercase">Risk Management</span>
      </div>
      <div class="portlet-body form">


        <form class="form-horizontal" role="form" method="POST" id="modalform" name="modalform" action="/ax/questionriskaction">
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
            <label class="col-md-3 control-label">If answer equals:</label>
            <div class="col-md-9">
           <select name="equal" id="equal">
  <option value="<?php echo $item;?>"><?php echo $item; ?></option>

<?php 
	$option_items=explode(",",$options);
	foreach ($option_items as $item) {
		?>
		<option value="<?php echo $item;?>"<?php if ($item==$equal_to) { echo "selected"; } ?>><?php echo $item; ?></option>
		<?php
	}
?>
</select>
            </div>
          </div>
          
   
         <div class="form-group">
            <label class="col-md-3 control-label">Risk Level</label>
            <div class="col-md-4">           
                <select name="risk_level" id="risk_level" class="form-control">
	                <option value="None" <?php if ($risk_level=="None") { echo "selected"; } ?>>None</option>
                <option value="Low" <?php if ($risk_level=="Low") { echo "selected"; } ?>>Low</option>
                                <option value="Medium" <?php if ($risk_level=="Medium") { echo "selected"; } ?>>Medium</option>
                                                <option value="High" <?php if ($risk_level=="High") { echo "selected"; } ?>>High</option>
                                                                <option value="Very High" <?php if ($risk_level=="Very High") { echo "selected"; } ?>>Very High</option>
                </select>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-md-3 control-label">Risk Details:</label>
            <div class="col-md-9">
				<textarea class="form-control" id="risk_details" name="risk_details"><?php echo stripslashes($risk_details);?></textarea>
			</div>
          </div>
          
          <div class="form-group">
            <label class="col-md-3 control-label">Remediation action:</label>
            <div class="col-md-9">
	                   <input type='hidden' id='qoid' name='qoid' value='<?php echo $qoid;?>'>
	                          <input type='hidden' id='riskid' name='riskid' value='<?php echo $riskid;?>'>
        <input type='hidden' id='function' name='function' value='<?php echo $function; ?>'>
				<textarea class="form-control" id="remediation" name="remediation"><?php echo stripslashes($risk_remediation); ?></textarea>
            </div>
          </div>
          

      </div>
    </div>
    <div class="form-actions">
      <div class="row">
        <div class="col-md-offset-3 col-md-9">
	                 <button class="btn green" id="modalsubmit" name="modalsubmit">Save Risk</button>
        </div>
      </div>
    </div>
       

 
        </form>
  </div>
  





  <?php
   
  }
?>