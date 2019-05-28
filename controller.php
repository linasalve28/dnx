 <?php
ini_set( 'session.cookie_httponly', 1 );
ini_set( 'session.cookie_secure', 1 );
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();

if (isset($_GET['function'])) {
    if (($_GET['function']!=="add") and ($_GET['function']!=="edit") and ($_GET['function']!=="settitle") and ($_GET['function']!=="orderup") and ($_GET['function']!=="section_orderup") and ($_GET['function']!=="view") and ($_GET['function']!=="del")) {
        echo "Function Security has suspended your account. Error F1";
        exit;
    }
}
$errorcode = isset($_SESSION['errorcode']) ? $_SESSION['errorcode'] : '';
unset($_SESSION['errorcode']);
if ($_SESSION['s_timeout'] + 600 * 600 < time()) {
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
    $_SESSION["s_ref"] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    header("Location:".DOMAIN_PATH."/login.php");
    exit;
}
$s_identikey=$_SESSION['s_identikey'];
$s_username=$_SESSION['s_username'];
$s_userid=$_SESSION['s_userid'];
$s_current_page=$_SERVER['REQUEST_URI'];
require("controller.inc.php");
$page=$_GET['page'];
if ($pagetype=="action") {
    //include($pageinc);
    exit;
}
$_SESSION["s_identikey"];
if (function_exists('action_menu')) {
} else {
    function action_menu() {
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>		
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="PrivacyTrust 2018">

    <!--favicon icon-->
    <link rel="icon" type="image/png" href="/v2assets/img/favicon.png">

    <title>PrivacyBase</title>
    <!--web fonts-->
    <link href="//fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js'></script>
    <!--bootstrap styles-->
    <link href="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--icon font-->
    <link href="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/dashlab-icon/dashlab-icon.css" rel="stylesheet">
    <link href="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
    <link href="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/themify-icons/css/themify-icons.css" rel="stylesheet">
    <link href="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/weather-icons/css/weather-icons.min.css" rel="stylesheet">
    <!--custom scrollbar-->
    <link href="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/m-custom-scrollbar/jquery.mCustomScrollbar.css" rel="stylesheet">
    <!--jquery dropdown-->
    <link href="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/jquery-dropdown-master/jquery.dropdown.css" rel="stylesheet">
    <!--jquery ui-->
    <link href="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/jquery-ui/jquery-ui.min.css" rel="stylesheet">
    <!--iCheck-->
    <link href="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/icheck/skins/all.css" rel="stylesheet">
    <!--date picker-->
    <link href="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/date-picker/css/bootstrap-datepicker.css" rel="stylesheet">
    <!--vector maps -->
    <link href="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/vector-map/jquery-jvectormap-1.1.1.css" rel="stylesheet" >
    <!--custom styles-->
    <link href="<?php echo DOMAIN_PATH; ?>/v2assets/css/main.css" rel="stylesheet">
    <link href="<?php echo DOMAIN_PATH; ?>/v2assets/gateway.css" rel="stylesheet">
    <link href="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/chosen/chosen.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/html5shiv.js"></script>
    <script src="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/respond.min.js"></script>
    <![endif]-->
    <!--
    <script src="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/jquery-ui/jquery-ui.min.js"></script>
    -->
    <style>
        .highlightform{
            border-color: #FF0000;
        }
        .divhighlight{
            border-color: #FF0000;
            border-style: solid;
        }
        .errortext {
            color: #FF0000;
            font-family: "Trebuchet MS";
            font-size: 11px;
        }
	    @media (max-width: 767px) {
		   .container-fluid {
			   padding:0px;
		   }
        }
	</style>
    <style>
        .dz-hidden-input {
            z-index: 10000;
        }
        #fade_ajx{
            display: none;
            position:absolute;
            top: 0%;
            left: 0%;
            width: 100%;
            height: 100%;
            background-color: #ababab;
            z-index: 1001;
            -moz-opacity: 0.8;
            opacity: .70;
            filter: alpha(opacity=80);
        }
        #modal_ajx {
            display: none;
            position: absolute;
            top: 45%;
            left: 45%;
            width: 64px;
            height: 64px;
            padding:30px 15px 0px;
            border: 3px solid #ababab;
            box-shadow:1px 1px 10px #ababab;
            border-radius:20px;
            background-color: white;
            z-index: 1002;
            text-align:center;
            overflow: auto;
         }
    </style>
</head>
<body class="fixed-nav leftnav-floating" id="bodytag">
<div id="fade_ajx"></div>
<div id="modal_ajx">
    <img src="<?php echo DOMAIN_PATH; ?>/v2assets/img/loading.gif" alt="" class="loading">
</div>
<!--navigation : sidebar & header-->
<nav class="navbar navbar-expand-lg fixed-top navbar-light" id="mainNav">
    <!--brand name -->
    <a class="navbar-brand" href="#" data-jq-dropdown="#jq-dropdown-1">
        <img class="pr-3 float-left" src="<?php echo DOMAIN_PATH; ?>/assets/privacybase_logo.svg" width="65px"  alt=""/>
        <div class="float-left">
            <div>PrivacyBase <i class="fa fa-caret-down pl-2"></i></div>
            <span class="page-direction f12 weight300">
                <span>Powered by PrivacyTrust</span>
            </span>
        </div>
    </a>
    <!--/brand name-->
    <!--brand mega menu-->
    <div id="jq-dropdown-1" class="jq-dropdown">
        <div class="b-mega-menu">
            <div class="card card-shadow">
                <div class="card-header p-2 pl-3">
                    <div class="navbar-brand mt-2">
                        <img class="pr-3 float-left" src="<?php echo DOMAIN_PATH; ?>/assets/privacybase_logo.svg" srcset="<?php echo DOMAIN_PATH; ?>/assets/privacybase_logo@2x.svg 2x"  alt=""/>
                        <div class="float-left">
                            <div>PrivacyBase</div>
                                <span class="page-direction f12 weight300">
                                    <span>Powered by PrivacyTrust</span>
                                </span>
                        </div>
                    </div>
                    <div class="widget-action-link">
                        <ul class="nav nav-tabs wal-nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" d


                                   ata-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-home"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="analytics-tab" data-toggle="tab" href="#analytics" role="tab" aria-controls="analytics" aria-selected="false"><i class="fa fa-desktop"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="application-tab" data-toggle="tab" href="#application" role="tab" aria-controls="application" aria-selected="false"><i class="fa fa-magnet"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body p-0 ">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row no-gutters">
                                <div class="col-4 border-right">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="fa fa-home pr-2"></i> Application</a>
                                        <a class="nav-link" id="v-pills-report-tab" data-toggle="pill" href="#v-pills-report" role="tab" aria-controls="v-pills-report" aria-selected="false"><i class="fa fa-desktop pr-2"></i> Reports</a>
                                        <a class="nav-link" id="v-pills-management-tab" data-toggle="pill" href="#v-pills-management" role="tab" aria-controls="v-pills-management" aria-selected="false"><i class="fa fa-magnet pr-2"></i>Management</a>
                                        <a class="nav-link" id="v-pills-blog-tab" data-toggle="pill" href="#v-pills-blog" role="tab" aria-controls="v-pills-blog" aria-selected="false"><i class="fa fa-comments-o pr-2"></i>Blog</a>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                            <ul class="list-unstyled b-mega-menu-link">
                                                <li><a href="#">Bootstrap 4 Stable</a></li>
                                                <li class="active"><a href="javascript:;">DashLab Modern Admin</a></li>
                                                <li><a href="#">Awesome Widgets Collection</a></li>
                                                <li><a href="#">Developer Friendly Code</a></li>
                                                <li><a href="#">SASS and GULP Task</a></li>
                                                <li><a href="#">Fully Responsive</a></li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-report" role="tabpanel" aria-labelledby="v-pills-report-tab">
                                            <ul class="list-unstyled b-mega-menu-link">
                                                <li><a href="#">Daily Reports</a></li>
                                                <li><a href="javascript:;">Weekly Reports</a></li>
                                                <li class="active"><a href="#">Monthly Reports</a></li>
                                                <li><a href="#">Yearly Reports</a></li>
                                                <li><a href="#">HR Reports</a></li>
                                                <li><a href="#">Product Reports</a></li>
                                                <li><a href="#">Order Reports</a></li>
                                                <li><a href="#">Revenue Reports</a></li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-management" role="tabpanel" aria-labelledby="v-pills-management-tab">
                                            <ul class="list-unstyled b-mega-menu-link">
                                                <li><a href="#">HR Management</a></li>
                                                <li class="active"><a href="javascript:;">Product Management</a></li>
                                                <li><a href="#">Role Management</a></li>
                                                <li><a href="#">Sales Management</a></li>
                                                <li><a href="#">Employee Management</a></li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-blog" role="tabpanel" aria-labelledby="v-pills-blog-tab">
                                            <ul class="list-unstyled b-mega-menu-link">
                                                <li class="active"><a href="#">Educational Blog</a></li>
                                                <li> <a href="javascript:;">Technology Blog</a></li>
                                                <li><a href="#">Political Blog</a></li>
                                                <li><a href="#">Woocommerce Blog</a></li>
                                                <li><a href="#">Entertainment Blog</a></li>
                                                <li><a href="#">Newspapper Blog</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="analytics" role="tabpanel" aria-labelledby="analytics-tab">
                            <div class="p-5 m-4 text-center">
                                <i class="fa fa-desktop f50 text-muted mb-4"></i>
                                <p class="mb-5">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC</p>
                                <a href="#" class="btn btn-primary">Get Started</a>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="application" role="tabpanel" aria-labelledby="application-tab">
                            <div class="p-5 m-4 text-center">
                                <i class="fa fa-magnet f50 text-muted mb-4"></i>
                                <p class="mb-5">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33</p>
                                <a href="#" class="btn btn-purple">Get Started</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--/brand mega menu-->

    <!--responsive nav toggle-->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!--/responsive nav toggle-->

    <!--responsive rightside toogle-->
    <a href="javascript:;" class="nav-link right_side_toggle responsive-right-side-toggle">
        <i class="icon-options-vertical"> </i>
    </a>
    <!--/responsive rightside toogle-->

    <div class="collapse navbar-collapse" id="navbarResponsive">
        <!--left side nav-->
        <ul class="navbar-nav left-side-nav" id="accordion">
            <li class="nav-item-search" data-toggle="tooltip" data-placement="right" title="Search">
                <div class="nav-link nav-link-collapse collapsed" data-toggle="collapse">
                    <i class="vl_search"></i>
                    <span class="nav-link-text">
                        <input type="text" class="search-form" placeholder="Search..." style="width:75%"/>
                    </span>
                </div>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                <a class="nav-link nav-link-collapse collapsed menulink" data-go="<?php echo DOMAIN_PATH; ?>/controller/welcome">
                    <i class="vl_dashboard"></i>
                    <span class="nav-link-text" >Home </span>
                </a>
                <ul class="sidenav-second-level collapse show" id="dashboard" data-parent="#accordion">
    
                </ul>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Assessments">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" data-target="#assessment_list">
                    <i class="vl_slider-h-range"></i>
                    <span class="nav-link-text menulink" data-go="<?php echo DOMAIN_PATH; ?>/controller/assessment/list"> Assessments</span>
                </a>
                <ul class="sidenav-second-level collapse <?php if ($section=="assessment") { echo " show"; }?>" id="assessment_list" data-parent="#accordion">
                    <li <?php if ($section=="assessment" && $page=='list') { echo 'class="active"'; }?>> <a href="<?php echo DOMAIN_PATH; ?>/controller/assessment/list">View Assessments</a> </li>
                    <li <?php if ($section=="assessment" && $page=='form') { echo 'class="active"'; }?>> <a href="<?php echo DOMAIN_PATH; ?>/controller/assessment/form?function=add">Create Assessment</a></li>
                    <li <?php if ($section=="assessment" && $page=='templatelist' ) { echo 'class="active"'; }?>> <a href="<?php echo DOMAIN_PATH; ?>/controller/assessment/templatelist">Templates</a></li>
                    <li <?php if ($section=="assessment" && $page=='requestlist') { echo 'class="active"'; }?>> <a href="<?php echo DOMAIN_PATH; ?>/controller/assessment/requestlist">Requests</a></li>
                    <li <?php if ($section=="assessment" && $page=='inprogresslist') { echo 'class="active"'; }?>> <a href="<?php echo DOMAIN_PATH; ?>/controller/assessment/inprogresslist">Your Responses</a></li>
                    <li <?php if ($section=="assessment" && $page=='my') { echo 'class="active"'; }?>> <a href="<?php echo DOMAIN_PATH; ?>/controller/assessment/my">My Assessments</a></li>
                </ul>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Data Manager">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" data-target="#widgets" >
                    <i class="vl_bond"></i>
                    <span class="nav-link-text menulink" data-go="<?php echo DOMAIN_PATH; ?>/controller/datamanager/welcome">Data Manager</span>
                </a>
                <ul class="sidenav-second-level collapse <?php if ($section=="datamanager") { echo " show"; }?>" id="widgets" data-parent="#accordion">
                    <!--Data Subject Group-->
                    <li <?php if($section=="datamanager" && $page=='dsgform') { echo 'class="active"'; }?>> <a href="<?php echo DOMAIN_PATH; ?>/controller/datamanager/dsgform?function=add">Create Data Subject Group</a> </li>
                    <li <?php if($section=="datamanager" && $page=='dsglist') { echo 'class="active"'; }?>> <a href="<?php echo DOMAIN_PATH; ?>/controller/datamanager/dsglist">List Data Subject Groups</a> </li>
                    <!--<li <?php if ($section=="datamanager" && $page=='assessmentlist') { echo 'class="active"'; }?>> <a href="/widget-chart.html">Create Data Subject Category</a> </li>
                    <li <?php if ($section=="datamanager" && $page=='dtaform') { echo 'class="active"'; }?>> <a href="/controller/dtaform?function=add">Data Transfer</a> </li>
                    <li <?php if ($section=="datamanager" && $page=='dtalist') { echo 'class="active"'; }?>> <a href="/controller/dtalist">Data Transfer List</a></li>-->
                </ul>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Data Manager">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" data-target="#dsrlist" >
                    <i class="vl_book"></i>
                    <span class="nav-link-text menulink" data-go="/controller/subjectrequest/dsrlist">Data Requests</span>
                </a>
                <ul class="sidenav-second-level collapse <?php if ($section=="subjectrequest") { echo " show"; }?>" id="dsrlist" data-parent="#accordion">
                    <li <?php if($section=="subjectrequest" && $page=='dsrlist') { echo 'class="active"'; }?>> <a href="<?php echo DOMAIN_PATH; ?>/controller/subjectrequest/dsrlist">List Data Requests</a> </li>
                </ul>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Data Manager">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" data-target="#data-transfer" >
                    <i class="vl_direction-right"></i>
                    <span class="nav-link-text menulink" data-go="<?php echo DOMAIN_PATH; ?>/controller/dta/dtalist">Data Transfers</span>
                </a>
                <ul class="sidenav-second-level collapse <?php if ($section=="dta") { echo " show"; }?>" id="data-transfer" data-parent="#accordion">
                    <!--Data Subject Group-->
                    <li <?php if($section=="dta" && $page=='dtaform') { echo 'class="active"'; }?>> <a href="<?php echo DOMAIN_PATH; ?>/controller/dta/dtaform?function=add">Create Data Transfer Agreement</a> </li>
                    <li <?php if($section=="dta" && $page=='dtalist') { echo 'class="active"'; }?>> <a href="<?php echo DOMAIN_PATH; ?>/controller/dta/dtalist">List Data Transfer</a> </li>
                </ul>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Data Breach">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" data-target="#databreach" >
                    <i class="vl_direction-right"></i>
                    <span class="nav-link-text menulink" data-go="<?php echo DOMAIN_PATH; ?>/controller/databreach/databreach">Data Breach</span>
                </a>
                <ul class="sidenav-second-level collapse <?php if ($section=="databreach") { echo " show"; }?>" id="databreach" data-parent="#accordion">
                    <!--Data Subject Group-->
                    <li <?php if($section=="databreach" && $page=='databreach') { echo 'class="active"'; }?>> <a href="<?php echo DOMAIN_PATH; ?>/controller/databreach/databreach">List Data Breach</a> </li>
                </ul>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Data Manager">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" data-target="#consentmanager" >
                    <i class="vl_compass"></i>
                    <span class="nav-link-text menulink" data-go="<?php echo DOMAIN_PATH; ?>/controller/consentmanager">Consent Manager</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Data Manager">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" data-target="#certlist" >
                    <i class="vl_file"></i>
                    <span class="nav-link-text menulink" data-go="<?php echo DOMAIN_PATH; ?>/controller/certification/certlist">Certifications</span>
                </a>
                <ul class="sidenav-second-level collapse <?php if ($section=="certification") { echo " show"; } ?>" id="certlist" data-parent="#accordion">
                    <li <?php if ($section=="certification" && $page=='certlist') { echo 'class="active"'; } ?>> <a href="<?php echo DOMAIN_PATH; ?>/controller/certification/certlist" >List Certification</a> </li>
                    <li <?php if ($section=="certification" && $page=='certform') { echo 'class="active"'; } ?>> <a href="<?php echo DOMAIN_PATH; ?>/controller/certification/certform?function=add">Add Certification</a> </li>
                </ul>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Linked Companies">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" data-target="#companylist" >
                    <i class="vl_header"></i>
                    <span class="nav-link-text menulink" data-go="<?php echo DOMAIN_PATH; ?>/controller/company/companylist">Linked Companies</span>
                </a>
                <ul class="sidenav-second-level collapse <?php if ($section=="company") { echo " show"; }?>" id="companylist" data-parent="#accordion">
                    <li <?php if ($section=="company"  && $page=='companylist') { echo 'class="active"'; }?>> <a href="<?php echo DOMAIN_PATH; ?>/controller/company/companylist" >List Companies</a> </li>
                </ul>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="" data-original-title="Cookie Manager">
                <a class="nav-link nav-link-collapse collapsed menulink" data-go="<?php echo DOMAIN_PATH; ?>/controller/cookie">
                    <i class="vl_dashboard"></i>
                    <span class="nav-link-text">Cookie Manager </span>
                </a>
                <ul class="sidenav-second-level collapse show" id="dashboard" data-parent="#accordion">
                </ul>
            </li>
        </ul>
        <!--/left side nav-->

        <!--nav push link-->
        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="left-nav-toggler">
                    <i class="fa fa-angle-left"></i>
                </a>
            </li>
        </ul>
        <!--/nav push link-->

        <!--header leftside links-->
        <ul class="navbar-nav header-links">

        </ul>
        <!--/header leftside links-->

        <!--header rightside links-->
        <ul class="navbar-nav header-links ml-auto hide-arrow">

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-lg-3" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="vl_chat-bubble"></i>
                        <span class="d-lg-none">Messages
                            <span class="badge badge-pill badge-primary">9 New</span>
                        </span>
                    <div class="notification-alarm">
                        <span class="wave wave-danger"></span>
                        <span class="dot"></span>
                    </div>
                </a>

                <div class="dropdown-menu dropdown-menu-right header-right-dropdown-width pb-0" aria-labelledby="messagesDropdown">
                    <h6 class="dropdown-header weight500 ">Messages</h6>
                    <div class="dropdown-divider mb-0"></div>
                    <a class="dropdown-item border-bottom msg-unread" href="#">
                        <div class="float-left notificaton-thumb">
                            <img class="rounded-circle" src="/v2assets/img/avatar/avatar4.jpg" alt=""/>
                        </div>
                        <span class="weight500">Andrew Flinton</span>
                        <span class="small float-right text-muted">08:30 AM</span>

                        <div class="dropdown-message">
                            I hope that you will be there in time. See you then
                        </div>
                    </a>

                    <a class="dropdown-item border-bottom msg-unread" href="#">
                        <div class="float-left notificaton-thumb">
                            <img class="rounded-circle" src="/v2assets/img/avatar/avatar2.jpg" alt=""/>
                        </div>
                        <span class="weight500">John Doe</span>
                        <span class="small float-right text-muted">10:28 AM</span>

                        <div class="dropdown-message">
                            Hello this is an example message. Just want to show how it looks
                        </div>
                    </a>

                    <a class="dropdown-item border-bottom" href="#">
                        <div class="float-left notificaton-thumb">
                            <img class="rounded-circle" src="/v2assets/img/avatar/avatar3.jpg" alt=""/>
                        </div>
                        <span class="weight500">Dash Don</span>
                        <span class="small float-right text-muted">07:12 PM</span>

                        <div class="dropdown-message">
                            Hi, This is Dash Don form usa. I'm looking for someone who really good at design and frontend like mosaddek
                        </div>
                    </a>

                    <a class="dropdown-item border-bottom" href="#">
                        <div class="float-left notificaton-thumb">
                            <img class="rounded-circle" src="/v2assets/img/avatar/avatar1.jpg" alt=""/>
                        </div>
                        <span class="weight500">dkmosa</span>
                        <span class="small float-right text-muted">12:10 PM</span>

                        <div class="dropdown-message">
                            We build a beautiful dashboard admin panel for professional
                        </div>
                    </a>
                    <a class="dropdown-item small" href="#">View all messages</a>
                </div>
            </li>
<style>
.badge {
    display: inline-block !important;
    min-width: 10px !important;
    padding: 3px 7px !important;
    font-size: 12px !important;
    color: #fff !important;
    vertical-align: middle !important;
    background-color: #e31d3c !important;
    border-radius: 10px !important;
}
</style>
	        <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-lg-3" id="alertsDropdown" href="#" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="icon-bell"></i>
                    <span class="badge badge-danger"> 17 </span>
                        <span class="d-lg-none">Notification
                            <span class="badge badge-pill badge-warning">5 New</span>
                        </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right header-right-dropdown-width pb-0" aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header weight500">Notifications</h6>

                    <div class="dropdown-divider mb-0"></div>
                    <a class="dropdown-item border-bottom" href="#">
                            <span class="text-primary">
                            <span class="weight500">
                                <i class="vl_bell weight600 pr-2"></i>Weekly Update</span>
                            </span>
                        <span class="small float-right text-muted">03:14 AM</span>

                        <div class="dropdown-message f12">
                            PrivacyBase Update
                        </div>
                    </a>
                    <a class="dropdown-item small" href="#">View all notification</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-lg-3" id="userNav" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-thumb">
                        <img class="rounded-circle" src="<?php echo DOMAIN_PATH; ?>/v2assets/img/avatar/avatar1.jpg" alt=""/>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userNav">
                    <a class="dropdown-item" href="#">My Profile</a>
                    <a class="dropdown-item" href="#">Account Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo DOMAIN_PATH; ?>/logout.php">Sign Out</a>
                </div>
            </li>
        </ul>
        <!--/header rightside links-->

    </div>
</nav>
<!--/navigation : sidebar & header-->

<!--main content wrapper-->
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="card card-shadow mb-4 pt-0">
            <div class="card-body">
                    <?php main(); ?>
            </div>
        </div>
    </div>
</div>
<!--/main content wrapper-->

   <!-- Modals -->
    <!-- Large Modal -->
<div class="modal fade" id="modal-large" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="modal-lg-content">
   	    <!-- Modal Start -->
	    

    
	    <!-- Modal End -->
    </div>
  </div>
</div>


<!--  Small Modal -->
<div class="modal fade" id="modal-small" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" id="modal-sm-content">
	    <!-- Modal Start -->
	    

    
	    <!-- Modal End -->
	    </div>
  </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-confirm">
  <div class="modal-dialog modal-sm">
  <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>

    	<div class="modal-body">
    	Are you sure you wish to proceed?
      </div>
      <div class="modal-footer">
        <a class="btn btn-danger f2" id="f5-confirm" href="">Yes</a>
        <button class="btn btn-secondary" data-dismiss="modal" id="f5-dismiss">No</button>
      </div>   
  </div>
</div>
</div>
<!-- End Modals -->

<!--basic scripts-->
<script>
    $( document ).ready(function() {
        $(".menulink").click(function() {
            window.location.href = $(this).data("go");
        });

        /*
        $( "#sortable1, #sortable2" ).sortable({
            connectWith: ".connectedSortable",
            start: function (event, ui) {
                myArguments = {}; // Reset the array
            },
        }).disableSelection(); */
    });

    function openModal() {
        document.getElementById('modal_ajx').style.display = 'block';
        document.getElementById('fade_ajx').style.display = 'block';
    }
    function closeModal() {
        document.getElementById('modal_ajx').style.display = 'none';
        document.getElementById('fade_ajx').style.display = 'none';
    }

    $( function() {
        //$( "#sortable1, #sortable2, #sortable3, #sortable4").sortable({
        $("ul[id*='sortable']").sortable({
             connectWith: ".q",
             cursor: 'move',
             cancel: ".ui-state-disabled",
             // That's fired first
             start: function (event, ui) {
                 myArguments = {}; // Reset the array
             },
             // That's fired second
             remove: function (event, ui) {
                 // Get array of items in the list where we removed the item
                 myArguments = assembleData(this, myArguments);
             },
             // That's fired thrird
             receive: function (event, ui) {
                 // Get array of items where we added a new item
                 myArguments = assembleData(this, myArguments);
             },
             update: function (e, ui) {
                 if (this === ui.item.parent()[0]) {
                     // In case the change occures in the same container
                     if (ui.sender == null) {
                         myArguments = assembleData(this, myArguments);
                     }
                 }
             },
             // That's fired last
             stop: function (event, ui) {
                 var aoid = document.getElementById('aoid').value;
                 // Send JSON to the server
                 //$("#info").html("Send JSON to the server: <pre>"+JSON.stringify(myArguments)+"</pre>");
                 $.ajax({
                     data: {
                         data: myArguments,
                         aoid: aoid
                     },
                     type: 'POST',
                     //url: '/ajax.controller.php?page=assessmentquestionmoveresponse',
                     url: '/ax/assessment/questionmoveresponse',
                     beforeSend: function () {
                         // show image here
                         openModal();
                     },
                     success: function (data) {
                         if (data !== '') {
                             var obj_data = JSON.parse(data);
                             if (obj_data['response'] !== 'undefined' && obj_data['response'] !== '' && obj_data['permission'] === true) {
                                 //<span class="label label-danger label-autoenroll">You need to specify the company name where the data is being transferred from</span>
                                 //var parsed = JSON.parse(obj_data['response']);
                                 var parsed = obj_data['response'];
                                 // $("#info").append('result'+ parsed);
                                 for (i in parsed) {
                                     //alert("#seq_"+parsed[i]);
                                     $("#seq_" + i).text(parsed[i] + '.');
                                 }
                             } else if (obj_data['permission'] === false) {
                                 $("#info").html('<span class="label label-danger">' + obj_data['response'] + '</span>');
                             }
                         }
                         closeModal();
                     },
                     error: function (xhr) {
                         $('#info').html(xhr.status + " " + xhr.statusText);
                     },
                 });
             },
             /*
             update: function (event, ui) {
                 var data = $(this).sortable('serialize');
                 alert(data);
                 $.ajax({
                     data: data,
                     type: 'POST',
                     url: '/inclusive/assessment/ajax/question.move.response.php',
                     success: function(data){
                         $("#info").append('result'+ data);
                     },
                     error: function(xhr) {
                       $('#info').html( xhr.status + " " + xhr.statusText);
                     },
                 });
                 var data = $(this).sortable('toArray');
                 $("#info").html("JSON:<pre>"+JSON.stringify(data)+"</pre>");
             },*/
         }).disableSelection();
        // Here we will store all data
        var myArguments = {};
        function assembleData(object, arguments) {
            var data = $(object).sortable('toArray'); // Get array data
            var step_id = $(object).attr("id"); // Get step_id and we will use it as property name
            var arrayLength = data.length; // no need to explain
            // Create step_id property if it does not exist
            if(!arguments.hasOwnProperty(step_id)){
                arguments[step_id] = new Array();
            }
            //Loop through all items
            for (var i = 0; i < arrayLength; i++) {
                var image_id = data[i];
                // push all image_id onto property step_id (which is an array)
                arguments[step_id].push(image_id);
            }
            return arguments;
        }
    });
</script>
<script src="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/popper.min.js"></script>
<script src="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/jquery-dropdown-master/jquery.dropdown.js"></script>
<script src="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/m-custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/icheck/skins/icheck.min.js"></script>
<script src="<?php echo DOMAIN_PATH; ?>/v2assets/gateway.js"></script>
<!-- Chosen -->
<!-- date Picker BOF-->
<script src="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/date-picker/js/bootstrap-datepicker.min.js"></script>
<!--init date picker-->
<script src="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/js-init/pickers/init-date-picker.js"></script>
<!-- date Picker EOF-->

<script>
$(function() {
  $('.chosen-select').chosen();
  $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
});
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<!--[if lt IE 9]>
<script src="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/modernizr.js"></script>
<![endif]-->
<!--basic scripts initialization-->
<script src="<?php echo DOMAIN_PATH; ?>/v2assets/js/scripts.js"></script>
</body>
</html>