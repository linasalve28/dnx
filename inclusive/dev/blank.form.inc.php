<?php
// This is a blank template that shows how to include the form processing include.

include(FS_ROOT_FUNCTIONS."/create.select.functions.php");


function main() {

  global $db;
  global $errorcode;
  global $outcome;
  global $s_identikey;
  global $s_username;



  $function=$_GET['function'];
  $id=$_GET['id'];



  if ($_SERVER['REQUEST_METHOD'] == 'POST') {


//    include("inclusive/dta.proc.inc.php");

  }



  if ($function=='edit' and $_SERVER['REQUEST_METHOD'] !== 'POST') {


// PASTE SQL to retrieve record being edited

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
// FORM

<div class="portlet light ">
  <div class="portlet-title">
    <div class="caption">
      <i class="icon-settings font-dark"></i>
      <span class="caption-subject font-dark sbold uppercase">FORM TITLE</span>
    </div>
    <div class="portlet-body form">

      // CHANGE FORM ACTION
      <form class="form-horizontal" role="form" action="/controller/dtaform" method="POST">

        <div class="form-group">

          <div class="col-md-9">

          </div>
        </div>


// USE DB GEN REPLICATOR  to create the form groups below

    <div class="form-group">
              <label class="col-md-3 control-label"><<replace>></label>
              <div class="col-md-9">
                <?php echo $errorcode["<<replace>>"]; ?>
                  <input type="text" class="form-control" value="<?php echo $<<replace>>;?>" name="<<replace>>" id="<<replace>>">

              </div>
            </div>





    </div>
  </div>
  <div class="form-actions">
    <div class="row">
      <div class="col-md-offset-3 col-md-9">
        <button type="submit" class="btn green">Submit</button>
        <button type="button" class="btn default">Cancel</button>
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