<?php
include(FS_ROOT_FUNCTIONS."/create.select.functions.php");
include(FS_ROOT_FUNCTIONS."/base.functions.php");

// pb_check_user_permission($item_type,$item_id);
// pb_system_log($action,$item,$other_data="");

function main() {
  global $db;
  global $errorcode;
  global $outcome;
  global $s_identikey;
  global $s_username;

  echo $outcome;
  $function=$_GET['function'];
  $id=$_GET['id'];



  if ($_SERVER['REQUEST_METHOD'] == 'POST') {


// INSERT INCLUDE TO PROCESSING SCRIPT
//    include("inclusive/dta.proc.inc.php");

  }



  if ($function=='edit' and $_SERVER['REQUEST_METHOD'] !== 'POST') {

// IF WE ARE EDITING
// INSERT SQL CODE TO GET RECORD DATA

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
// INSERT HTML FOR THE FORM HERE




  <?php
    }
  }
  ?>