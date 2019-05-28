<?php
ini_set( 'session.cookie_httponly', 1 );
ini_set( 'session.cookie_secure', 1 );
session_start();
// This is for AJAX calls : Controller
if ($_SESSION['s_timeout'] + 60 * 60 < time()) {
    unset($_SESSION['s_username']);
    unset($_SESSION['s_userid']);
    unset($_SESSION['s_identikey']);
    unset($_SESSION['s_user_fullname']);
} else {
    $_SESSION['s_timeout'] = time();
}

if (!$_SESSION['s_userid']){
    unset($_SESSION['s_identikey']);
    unset($_SESSION['s_username']);

    ?>
    <script>
        window.location.reload();
    </script>
    <?php
    exit;
}

require("config.inc.php");

$page = $_GET['page'];
$page= explode("/",$page);


$app=$page[0];
$page=$page[1];


//$base_dir = "/home/trustbase/servers/gateway.trustbase.com/";
$base_dir = DOCUMENT_ROOT ;

require_once(DB_ROOT."/tb.db.conn.php");
require_once(FS_ROOT_FUNCTIONS."/base.functions.php");


$statement = $db->prepare("select * from system_page_registry where pagename=:page and app=:app and display_mode ='ajax'");
$statement->bindParam(':page', $page);
$statement->bindParam(':app', $app);
$statement->execute();

while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
    $app = $row['app'];
    $pagename = $row['pagename'];
    $filename = $row['filename'];
    $directory_path = $row['directory_path'];
}

/*

switch($page) {
  case "unidelete":
    $pageinc = FS_ROOT_AJAX."/uni.delete.php";
  break;

  case "questionrisk":
    $pageinc = FS_ASSESSMENT_AJAX."/question.risk.form.inc.php";
  break;

  case "questionriskaction":
    $pageinc = FS_ASSESSMENT_AJAX."/question.risk.action.inc.php";
  break;  

  case "listrisk":
    $pageinc = FS_ASSESSMENT_AJAX."/risk.list.inc.php";
  break;

  case "assessmentquestioncheck":
    $pageinc = FS_ASSESSMENT_AJAX."/assessment.question.dependency.inc.php";
  break;  

  case "questionconditions":
    $pageinc =FS_ASSESSMENT_AJAX."/question.conditions.form.php";
  break;  

  case "questionconditionaction":
    $pageinc = FS_ASSESSMENT_AJAX."/question.condition.action.php";
  break;

  case "assessmentquestionmoveresponse":
    $pageinc = FS_ASSESSMENT_AJAX."/question.move.response.php";
  break;

  case "dropzoneupload":
    $pageinc = FS_ASSESSMENT_AJAX."/question.dropzone.upload.form.php";
  break;

  default:
    echo "Internal Error";
    exit;
}
*/

include(FS_ROOT_INCLUSIVE.$directory_path.$filename);
if(function_exists(main)){
  main();
}
?>


