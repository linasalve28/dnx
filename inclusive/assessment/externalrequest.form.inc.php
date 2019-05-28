<?php

include(FS_ROOT_FUNCTIONS."/create.select.functions.php");

function main() {
	global $db;
	global $errorcode;
	global $outcome;
	global $s_identikey;
	global $s_username;
	$function=$_GET['function'];
	$id=$_GET['id'];
	$oid=$_GET['oid'];
	
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		include(FS_INCLUSIVE_ASSESSMENT."/externalrequest.proc.inc.php");
		$object_id=$request_object_id;
	}

	// If form submittion has been successful, display message.
	if ($outcome=="success") {

		pb_success_message("An assessment request has been sent to $email");

	} else {

		if (!$_GET['oid'] and !$_POST['oid']) {
			echo "You need to select a valid assessment";
			exit;
		} else {
			pb_check_object_permission("assessment",$oid,"userid","","view");
		}
?>

    <div class="portlet light ">
      <div class="portlet-title">
        <div class="caption">
          <i class="icon-settings font-dark"></i>
          <span class="caption-subject font-dark sbold uppercase">External Request </span>
        </div>
        <div class="portlet-body form">
          <form class="form-horizontal" role="form" action="/controller/externalrequestform" method="POST">
            <div class="form-group">
              <div class="col-md-9">
              </div>
            </div>
			<div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-9">
                </div>
            </div>
			
			<div class="form-group">
                  <label class="col-md-3 control-label">Name</label>
                  <div class="col-md-9">
                    <?php echo $errorcode["name"]; ?>
                   <input type="text" class="form-control" value="<?php echo $name;?>" name="name" id="name">
                  </div>
                </div>
                
        <div class="form-group">
                  <label class="col-md-3 control-label">Company</label>
                  <div class="col-md-9">
                    <?php echo $errorcode["company"]; ?>
                     <input type="text" class="form-control" value="<?php echo $company;?>" name="company" id="company">
                  </div>
                </div>
                
        <div class="form-group">
                  <label class="col-md-3 control-label">Email Address</label>
                  <div class="col-md-9">
                    <?php echo $errorcode["email"]; ?>
                      <input type="text" class="form-control" value="<?php echo $email;?>" name="email" id="email">
					  <input type="hidden" name="oid" id="oid" value="<?php echo $oid;?>">
                  </div>
                </div>
        </div>
      </div>

    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn green">Submit</button> <button type="button" class="btn default">Cancel</button>
            </div>
        </div>
    </div>


  <?php
	}
}
?>
