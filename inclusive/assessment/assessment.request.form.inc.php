<?php
// This is a blank template that shows how to include the form processing include.

include(FS_ROOT_FUNCTIONS. "/create.select.functions.php");


function main() {

  global $db;
  global $errorcode;
  global $outcome;
  global $s_identikey;
  global $s_username;
  global $dev;


  $function=$_GET['function'];
   $aoid=$_GET['aoid'];

if (!$aoid) {
	$aoid=$_POST['aoid'];
}


if (!$aoid) {
	echo "Specify a valid Assessment $aoid";
	exit;
}


  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      include(FS_INCLUSIVE_ASSESSMENT."/assessment.request.proc.php");
  }
  // If form submittion has been successful, display message.
  if ($outcome=="success") {
    if ($function=="edit"){
      echo "<div class=\"alert alert-success\"><strong>Success!</strong> Data Transfer Agreement Edited </div>";
    } else if ($function=="add") {
        echo "<div class=\"alert alert-success\"><strong>Success!</strong> Data Transfer Agreement Created </div>";
    }
  } else {

    ?>


<div class="portlet light ">
  <div class="portlet-title">
    <div class="caption">
      <i class="icon-settings font-dark"></i>
      <span class="caption-subject font-dark sbold uppercase">Send Assessment</span>
       </div>
    <div class="portlet-body form">


      <form class="form-horizontal" role="form" action="/controller/assessment/requestform" method="POST">
    <input type='hidden' id='aoid' name='aoid' value='<?php echo $aoid;?>'>
	      

        <div class="form-group">

          <div class="col-md-9">

          </div>
        </div>


<div class='form-group'>
<label class='col-md-3 control-label'></label>

<div class='col-md-9'>
	<label>Enter the email of the person you are sending the assessment to:</label>
<?php echo $errorcode['to']; ?>
<input type='text' class='form-control' value='' name='to' id='to'>

</div>

    </div>
  </div>
  <div class="form-actions">
    <div class="row">
      <div class="col-md-offset-3 col-md-9">
        <button type="submit" class="btn green">Send Request</button>
        <button type="button" class="btn default">Cancel</button>
      </div>
    </div>
  </div>



      </form>
</div>







  <?php
    }
  }
  ?>