<?php
require_once("config.inc.php");
include( DB_ROOT."/tb.db.conn.php");
include( FS_ROOT_FUNCTIONS ."/base.functions.php");

// This needs to be replaced with user ID variable. Here.
//$module=getUserModules("sf27621");
$page = $_GET['page'];
$page = explode("/",$page);

$app = $page[0];
$page = $page[1];

$base_dir = FS_ROOT_INCLUSIVE;

//$base_dir="/home/trustbase/servers/gateway.trustbase.com/inclusive/";
//echo "select * from system_page_registry where pagename=$page and app=$app" ;

$statement = $db->prepare("select * from system_page_registry where pagename=:page and app=:app");
$statement->bindParam(':page', $page);
$statement->bindParam(':app', $app);
$statement->execute();

while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
    $section = $row['app'];
    $pagename = $row['pagename'];
    $filename = $row['filename'];
    $directory_path = $row['directory_path'];
    $includes = $row['toolbar'];
    $toolbarinc = DOCUMENT_ROOT.'/'.$includes;

    if(!empty($includes)){
       /* $filearr = explode(',',$includes);
        foreach ($filearr as $includefile){
            require($includefile);
        } */
    }
    $pageinc = FS_ROOT_INCLUSIVE. $directory_path.$filename;
}


/*
switch($page) {

	case "ctest":
	$pageinc = "/home/trustbase/servers/gateway.trustbase.com/dev/animatedcheckmark/index.php";
	$section = "assessment";
	break;

	case "databasescan":
	$pageinc ="/home/trustbase/servers/gateway.trustbase.com/dev/dbscan/scan.php";
	$section ="datamanager";
	break;

	case "mtest":
	$pageinc ="/home/trustbase/servers/gateway.trustbase.com/dev/editoptions/index.php";
	$section ="assessment";
	break;

	case "welcome":
	//$pageinc = $base_dir."welcome/welcome.inc.php";
	$pageinc = FS_INCLUSIVE_WELCOME."/welcome.inc.php";
	$section = "";
	$breadcrumbs = array("Welcome" => "/controller/welcome");
	break;

	case "alertlist":
	//$pageinc = $base_dir."system/alert.list.inc.php";
	$pageinc = FS_INCLUSIVE_SYSTEM."/alert.list.inc.php";
	$section = "";
	$breadcrumbs = array("Home" => "/controller/welcome","Alerts" => "/controller/alertlist");
	break;

	case "alertlink":
	//$pageinc = $base_dir."system/alert.action.link.php";
	$pageinc = FS_INCLUSIVE_SYSTEM ."/alert.action.link.php";
	$section = "";
	break;

	case "databreach": //done
	//$pageinc=$base_dir."databreach/databreach.list.inc.php";
	$pageinc = FS_INCLUSIVE_DATABREACH."/databreach.list.inc.php";
	$section = "breach";
	$breadcrumbs = array("Welcome" => "/controller/welcome","Data Breach" => "/controller/databreach");
	break;

	case "dsrexternal": //done
	//$pageinc = $base_dir."subjectrequest/external.form.php";
	$pageinc = FS_INCLUSIVE_SUBJECTREQUEST ."/external.form.php";
	$section = "datamanager";
	$breadcrumbs = array("Welcome" => "/controller/welcome","Data Subject Requests" => "/controller/dsrlist");
	break;

	case "dsrlist": //done
	//$pageinc=$base_dir."subjectrequest/dsr.list.inc.php";
	$pageinc = FS_INCLUSIVE_SUBJECTREQUEST."/dsr.list.inc.php";
	$section = "dsr";
	$breadcrumbs = array("Welcome" => "/controller/welcome","Data Subject Requests" => "/controller/dsrlist");
	break;

	case "dsrview":
	//$pageinc=$base_dir."subjectrequest/dsr.view.inc.php";
	$pageinc= FS_INCLUSIVE_SUBJECTREQUEST."/dsr.view.inc.php";
	$section="dsr";
	$breadcrumbs = array("Welcome" => "/controller/welcome","Data Subject Requests" => "/controller/dsrlist");
	break;

	case "datamanager": //done
	//$pageinc = $base_dir."datamanager/welcome.inc.php";
	$pageinc = FS_INCLUSIVE_DATAMANAGER."/welcome.inc.php";
	$section = "datamanager";
	$breadcrumbs = array("Data Manager" => "/controller/datamanager");
	break;
	case "dsglist": //done
	//$pageinc=$base_dir."datamanager/dsg.list.inc.php";
	$pageinc = FS_INCLUSIVE_DATAMANAGER."/dsg.list.inc.php";
	$section = "datamanager";
	$breadcrumbs = array("Data Manager" => "/controller/datamanager","List Data Subject Groups" => "/controller/dsglist");
	break;
	case "dsgform": //done
	//$pageinc=$base_dir."datamanager/dsg.form.inc.php";
	$pageinc= FS_INCLUSIVE_DATAMANAGER."/dsg.form.inc.php";
	$section = "datamanager";
	$breadcrumbs = array("Data Manager" => "/controller/datamanager","Data Subject Form" => "/controller/dsgform");
	break;
	// Data Transfers
	case "dtalist":
	//$pageinc = $base_dir."dta/dta.list.inc.php";
	$pageinc = FS_INCLUSIVE_DTA."/dta.list.inc.php";
	$section="dta";
	$breadcrumbs = array("Data Transfer Agreements" => "/controller/dtalist");
	break;
case "dtaform"://done
	//$pageinc = $base_dir."dta/dta.form.inc.php";
	$pageinc = FS_INCLUSIVE_DTA."/dta.form.inc.php";
	$section = "dta";
	$breadcrumbs = array("Data Transfer Agreements" => "/controller/dtalist", ucwords($_GET['function'])." Data Transfer Agreement" => $s_current_page);
break;
case "dtaview"://done
	//$pageinc = $base_dir."dta/dta.view.inc.php";
	$pageinc= FS_INCLUSIVE_DTA ."/dta.view.inc.php";
	$section="dta";
	$breadcrumbs = array("Data Transfer Agreements" => "/controller/dtalist","View Data Transfer Agreement" => $s_current_page);
break;
case "dtaproc"://done
	//$pageinc = $base_dir."dta/dta.proc.inc.php";
	$pageinc = FS_INCLUSIVE_DTA."/dta.proc.inc.php";
	$section = "dta";
	break;
	//Certifications
case "certlist"://done
	//$pageinc=$base_dir."/certification/certification.list.inc.php";
	$pageinc= FS_INCLUSIVE_CERTIFICATION."/certification.list.inc.php";
	$section="certification";
	$breadcrumbs = array("Certifications" => "/controller/certlist");
break;

case "certform"://done
	//$pageinc=$base_dir."/certification/certification.form.inc.php";
	$pageinc = FS_INCLUSIVE_CERTIFICATION ."/certification.form.inc.php";
	$section="certification";
	$breadcrumbs = array("Certifications" => "/controller/certlist",ucwords($_GET['function'])." Certification" => $s_current_page);
break;

case "reviewlist":
	//$pageinc=$base_dir."reviews.list.h.inc.php";
	$pageinc= FS_ROOT_INCLUSIVE."reviews.list.h.inc.php";
	$section="reviews";
	$breadcrumbs = array("Reviews" => "/controller/reviewlist");
break;

	// Company
case "companylist":
	if ($_SESSION['s_userid']=="s.fortes@kenexus.com") {
		//$pageinc=$base_dir."/relationship/relationship.list.inc.php";
		$pageinc = FS_INCLUSIVE_RELATIONSHIP."/relationship.list.inc.php";
	} else {
		//$pageinc=$base_dir."linkedcompanies.list.h.inc.php";
		$pageinc = FS_ROOT_INCLUSIVE ."/linkedcompanies.list.h.inc.php";
	}

	$section="company";
	$breadcrumbs = array("Linked Companies" => "/controller/companylist");
break;


case "relationshipform":
	//$pageinc=$base_dir."/relationship/relationship.form.inc.php";
	$pageinc = FS_INCLUSIVE_RELATIONSHIP."/relationship.form.inc.php";
	$section="company";
	$breadcrumbs = array("Companies" => "/controller/companylist",ucwords($_GET['function'])." Company" => $s_current_page);
break;

cdsase "companyform":
	//$pageinc=$base_dir."company.form.inc.php";
	$pageinc= FS_ROOT_INCLUSIVE."/company.form.inc.php";
	$section="company";
	$breadcrumbs = array("Companies" => "/controller/companylist",ucwords($_GET['function'])." Company" => $s_current_page);
break;
 	// Assessments
case "myassessments": //done
	//$pageinc=$base_dir."/assessment/assessment.my.list.inc.php";
	$pageinc = FS_INCLUSIVE_ASSESSMENT."/assessment.my.list.inc.php";
	$section = "assessment";
	//$toolbarinc = "toolbar/action.assessment.inc.php";
	$toolbarinc = FS_INCLUSIVE_TOOLBAR . "/action.assessment.inc.php";
	$breadcrumbs = array("Assessments" => "/controller/assessmentlist");
break;

case "assessmentlist": //done
	//$pageinc=$base_dir."/assessment/assessment.list.inc.php";
	$pageinc = FS_INCLUSIVE_ASSESSMENT."/assessment.list.inc.php";
	$section = "assessment";
	//$toolbarinc="toolbar/action.assessment.inc.php";
	$toolbarinc= FS_INCLUSIVE_TOOLBAR . "/action.assessment.inc.php";
	$breadcrumbs = array("Assessments" => "/controller/assessmentlist");
break;



case "assessmentrequestform":
	//$pageinc=$base_dir."/assessmcent/assessment.request.form.inc.php";
	$pageinc = FS_INCLUSIVE_ASSESSMENT."/assessment.request.form.inc.php";
	$section = "assessment";
	$breadcrumbs = array("Assessments" => "/controller/assessmentlist"," Send Assessment Request" => "/controller/assessmentrequestform");
break;


case "assessmentrequestlist":
	//$pageinc=$base_dir."/assessment/assessment.request.list.inc.php";
	$pageinc = FS_INCLUSIVE_ASSESSMENT."/assessment.request.list.inc.php";
	$section = "assessment";
	$breadcrumbs = array("Assessments" => "/controller/assessmentlist"," Send Assessment Request" => "/controller/assessmentrequestform");

break;

case "assessmentinprogresslist":
	//$pageinc = $base_dir."/assessment/assessment.inprogress.list.inc.php";
	$pageinc = FS_INCLUSIVE_ASSESSMENT ."/assessment.inprogress.list.inc.php";
	$section = "assessment";
	$breadcrumbs = array("Assessments" => "/controller/assessmentlist"," Assessments In Progress" => "/controller/assessmentinprogresslist");
break;
case "assessmentsendreminder":
	//$pageinc=$base_dir."/assessment/assessment.request.reminder.inc.php";
	$pageinc= FS_INCLUSIVE_ASSESSMENT."/assessment.request.reminder.inc.php";
	$section="assessment";
	$breadcrumbs = array("Assessments" => "/controller/assessmentlist"," Send Assessment Request" => "/controller/assessmentrequestform");
break;
case "assessmentform":
	//$pageinc = $base_dir."/assessment/assessment.form.inc.php";
	$pageinc = FS_INCLUSIVE_ASSESSMENT."/assessment.form.inc.php";
	$section = "assessment";
	//$toolbarinc = "toolbar/action.assessment.inc.php";
	$toolbarinc = FS_INCLUSIVE_TOOLBAR."/action.assessment.inc.php";
	$breadcrumbs = array("Assessments" => "/controller/assessmentlist",ucwords($_GET['function'])." Assessment" => $s_current_page);
break;

	// Assessment Responses
case "assessmentresponselist":
    //$pageinc = $base_dir."/assessment/assessment.response.list.inc.php";
	$pageinc = FS_INCLUSIVE_ASSESSMENT."/assessment.response.list.inc.php";
	$section = "assessment";
	//$toolbarinc = "toolbar/action.assessment.inc.php";
	$toolbarinc = FS_INCLUSIVE_TOOLBAR."/action.assessment.inc.php";
	$breadcrumbs = array("Assessments" => "/controller/assessmentlist","Responses" => $s_current_page);
break;

case "assessmentresponseview":
	//$pageinc=$base_dir."/assessment/assessment.response.view.inc.php";
	$pageinc= FS_INCLUSIVE_ASSESSMENT."/assessment.response.view.inc.php";
	$section="assessment";
	//$toolbarinc="toolbar/action.assessment.inc.php";
	$toolbarinc= FS_INCLUSIVE_TOOLBAR."/action.assessment.inc.php";
	$l_a=strip_tags($_GET['a']);
	$breadcrumbs = array("Assessments" => "/controller/assessmentlist","List Responses" => "/controller/assessmentresponselist?assessment_id=".$l_a,"View Individual Response" => $s_current_page);

break;


// Assessment Sections

case "sectionform":
	//$pageinc = $base_dir."/assessment/section.form.inc.php";
//	$pageinc = FS_INCLUSIVE_ASSESSMENT."/section.form.inc.php";
	$pageinc = FS_INCLUSIVE_ASSESSMENT."/ajax/section.form.php";
	$section = "assessment";
	//$toolbarinc="toolbar/action.assessment.inc.php";
	$toolbarinc = FS_INCLUSIVE_TOOLBAR."/action.assessment.inc.php";
	$l_a=strip_tags($_GET['a']);
	$breadcrumbs = array("Assessments" => "/controller/assessmentlist");

break;


case "assessmenttemplatelist":
	//$pageinc=$base_dir."/assessment/assessment.template.list.inc.php";
	$pageinc = FS_INCLUSIVE_ASSESSMENT."/assessment.template.list.inc.php";
	$section = "assessment";
	//$toolbarinc = "toolbar/action.assessment.inc.php";
	$toolbarinc = FS_INCLUSIVE_TOOLBAR . "/action.assessment.inc.php";
	$l_a = strip_tags($_GET['a']);
	$breadcrumbs = array("Assessments" => "/controller/assessmentlist","Assessment Templates" => "/controller/assessmenttemplatelist");
break;

case "assessmenttemplateuse":
	//$pageinc=$base_dir."/assessment/assessment.template.use.inc.php";
	$pageinc = FS_INCLUSIVE_ASSESSMENT."/assessment.template.use.inc.php";
	$section = "assessment";
	$toolbarinc = FS_INCLUSIVE_TOOLBAR."/action.assessment.inc.php";
	$l_a=strip_tags($_GET['a']);
	$breadcrumbs = array("Assessments" => "/controller/assessmentlist","Assessment Templates" => "/controller/assessmenttemplatelist");
break;

	// AutoEnroll
case "autoenrolllist":
	//$pageinc=$base_dir."autoenroll/autoenroll.list.inc.php";
	$pageinc = FS_INCLUSIVE_AUTOENROLL."/autoenroll.list.inc.php";
	$section = "autoenroll";
	//$toolbarinc="toolbar/action.autoenroll.inc.php";
	$toolbarinc = FS_INCLUSIVE_TOOLBAR."/action.autoenroll.inc.php";
	$breadcrumbs = array("Auto Enroll" => "/controller/autoenrolllist");
break;

case "autoenrollform":
	//$pageinc=$base_dir."autoenroll/autoenroll.form.inc.php";
	$pageinc= FS_INCLUSIVE_AUTOENROLL."/autoenroll.form.inc.php";
	$section="autoenroll";
	//$toolbarinc="toolbar/action.autoenroll.inc.php";
	$toolbarinc= FS_INCLUSIVE_TOOLBAR."/action.autoenroll.inc.php";
	$breadcrumbs = array("Auto Enroll" => "/controller/autoenrolllist",ucwords($_GET['function'])." Company for AutoEnroll" => $s_current_page);
break;

case "autoenrollproc":
	//$pageinc=$base_dir."autoenroll/autoenroll.proc.inc.php";
	$pageinc = FS_INCLUSIVE_AUTOENROLL."/autoenroll.proc.inc.php";
	$section = "autoenroll";
	$toolbarinc = FS_INCLUSIVE_TOOLBAR."/action.autoenroll.inc.php";
break;

	// Asessment Questions
case "questionform":
	//$pageinc=$base_dir."/assessment/question.form.inc.php";
	$pageinc = FS_INCLUSIVE_ASSESSMENT."/ajax/question.form.inc.php";
	$section = "assessment";
	$toolbarinc = FS_INCLUSIVE_TOOLBAR."/action.assessment.inc.php";
	$breadcrumbs = array("Question" => "/controller/questionform",ucwords($_GET['function'])." Question" => $s_current_page);
break;

case "questionproc":
	//$pageinc=$base_dir."/assessment/question.proc.inc.php";
	$pageinc = FS_INCLUSIVE_ASSESSMENT."/question.proc.inc.php";
	$section="assessment";
	//$toolbarinc="toolbar/action.assessment.inc.php";
	$toolbarinc = FS_INCLUSIVE_TOOLBAR."/action.assessment.inc.php";
break;

case "questionlist":
	//$pageinc=$base_dir."/assessment/question.list.inc.php";
	$pageinc = FS_INCLUSIVE_ASSESSMENT."/question.list.inc.php";
	$section = "assessment";
	//$toolbarinc="toolbar/action.assessment.inc.php";
	$toolbarinc = FS_INCLUSIVE_TOOLBAR."/action.assessment.inc.php";
break;

case "assessmentpreview"://done
	//$pageinc = $base_dir."/assessment/assessment.preview.inc.php";
	$pageinc = FS_INCLUSIVE_ASSESSMENT."/assessment.preview.inc.php";
	$section = "assessment";
	//$toolbarinc = "toolbar/action.assessment.inc.php";
	$toolbarinc = FS_INCLUSIVE_TOOLBAR."/action.assessment.inc.php";
	$breadcrumbs = array("Assessments" => "/controller/assessmentlist","Preview Assessment" => $s_current_page);
break;

case "assessmentengage":
	//$pageinc=$base_dir."/assessment/assessment.engage.inc.php";
    require_once(FS_COMPONENT_FILECONTROL."/process.php");
	$pageinc = FS_INCLUSIVE_ASSESSMENT."/assessment.engage.inc.php";
	$section = "assessment";
	//$toolbarinc = "toolbar/action.assessment.inc.php";
	$toolbarinc = FS_INCLUSIVE_TOOLBAR."/action.assessment.inc.php";
	$breadcrumbs = array("Assessments" => "/controller/assessmentlist","Complete Assessment" => $s_current_page);
break;

case "questionaction": //done
	//$pageinc = $base_dir."/assessment/question.action.inc.php";
	$pageinc = FS_INCLUSIVE_ASSESSMENT."/question.action.inc.php";
	$section = "assessment";
	//$toolbarinc = "toolbar/action.assessment.inc.php";
	$toolbarinc = FS_INCLUSIVE_TOOLBAR."/action.assessment.inc.php";
	$pagetype="action";
break;

case "questionrisk":
	//$pageinc=$base_dir."/assessment/question.risk.form.inc.php";
	$pageinc = FS_INCLUSIVE_ASSESSMENT."/question.risk.form.inc.php";
	$section = "assessment";
	//$toolbarinc="toolbar/action.assessment.inc.php";
	$toolbarinc= FS_INCLUSIVE_TOOLBAR."/action.assessment.inc.php";
	$breadcrumbs = array("Question" => "/controller/questionform",ucwords($_GET['function'])." Question" => $s_current_page);
break;

case "test":
	$pageinc = $base_dir."test.php";
	$section = "assessment";
	//$toolbarinc="toolbar/action.assessment.inc.php";
	$toolbarinc= FS_INCLUSIVE_TOOLBAR."/action.assessment.inc.php";
break;

case "linkedcompanyview":
	$pageinc=$base_dir."/dev/linked.company.view.php";
	$section="assessment";
	//$toolbarinc="toolbar/action.assessment.inc.php";
	$toolbarinc= FS_INCLUSIVE_TOOLBAR."/action.assessment.inc.php";
break;

case "fileaccess":
	$pageinc="/home/trustbase/servers/gateway.trustbase.com/dev/filecontrol/download.php";
	$section="assessment";
break;

case "externalrequestform":
	//$pageinc=$base_dir."/assessment/externalrequest.form.inc.php";
	$pageinc = FS_INCLUSIVE_ASSESSMENT."/externalrequest.form.inc.php";
	$section = "assessment";
	//$toolbarinc = "toolbar/action.externalrequest.inc.php";

	$toolbarinc = FS_INCLUSIVE_TOOLBAR."/action.externalrequest.inc.php" ;
break;

case "externalrequestlist":
	//$pageinc=$base_dir."/assessment/externalrequest.list.inc.php";
	$pageinc = FS_INCLUSIVE_ASSESSMENT."/externalrequest.list.inc.php";
	$section = "assessment";
	//$toolbarinc="toolbar/action.externalrequest.inc.php";
	$toolbarinc = FS_INCLUSIVE_TOOLBAR."/action.externalrequest.inc.php";
break;

case "systemlog":

	if ($_SESSION["s_username"]=="s.fortes@kenexus.com") {
		//$pageinc = $base_dir."/admin/systemlog.list.php";
		$pageinc = FS_INCLUSIVE_ADMIN."/systemlog.list.php";
		$section = "assessment";
		//$toolbarinc = "toolbar/action.assessment.inc.php";
		$toolbarinc = FS_INCLUSIVE_TOOLBAR."/action.assessment.inc.php";
	} else {
		echo "Security Errror 151";
		exit;
	}
	break;

default:
	echo "Philadelphia Sub Controller detected an unauthorised operation.";
	exit;
	$pageinc = $base_dir."company.list.inc.php";
}*/


if ($toolbarinc) {
	function action_menu() {
		global $base_dir;
		global $toolbarinc;
		require($toolbarinc);
		//require($base_dir.$toolbarinc);
	}
}


require($pageinc);


?>