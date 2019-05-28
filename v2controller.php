 <?php
ini_set( 'session.cookie_httponly', 1 );
ini_set( 'session.cookie_secure', 1 );
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
    header("Location:/login.php");
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
if ($s_userid=="s.fortes@kenexus.com") {
    $dev="yes";
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
    <link rel="icon" type="image/png" href="<?php echo DOMAIN_PATH; ?>/v2assets/img/favicon.png">

    <title>PrivacyBase</title>

    <!--web fonts-->
    <link href="//fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

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

    <!--vector maps -->
    <link href="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/vector-map/jquery-jvectormap-1.1.1.css" rel="stylesheet" >


    <!--custom styles-->
    <link href="<?php echo DOMAIN_PATH; ?>/v2assets/css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/html5shiv.js"></script>
    <script src="<?php echo DOMAIN_PATH; ?>/v2assets/vendor/respond.min.js"></script>
    <![endif]-->
    
    <style> 
	    
	    @media (max-width: 767px) {
		    .container-fluid{
			    padding:0px;
			    
		    }
		    }
	    </style>
</head>

<body class="fixed-nav leftnav-floating" id="bodytag">

<!--navigation : sidebar & header-->
<nav class="navbar navbar-expand-lg fixed-top navbar-light" id="mainNav">

    <!--brand name-->
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
                        <img class="pr-3 float-left" src="<?php echo DOMAIN_PATH; ?>/assets/privacybase_logo.svg" srcset="/assets/privacybase_logo@2x.svg 2x"  alt=""/>
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
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-home"></i></a>
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
                            <input type="text" class="search-form" placeholder="Search PrivacyBase"/>
                        </span>
                </div>
            </li>

	
             <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                <a class="nav-link nav-link-collapse collapsed menulink" data-go="/controller/welcome">
                    <i class="vl_dashboard"></i>
                    <span class="nav-link-text" >Home </span>
                </a>
                <ul class="sidenav-second-level collapse show" id="dashboard" data-parent="#accordion">
    
                </ul>
            </li>

	
<li class="nav-item" data-toggle="tooltip" data-placement="right" title="UI Elements">
                <a class="nav-link nav-link-collapse collapsed menulink" data-toggle="collapse" data-target="ui_elements" data-go="/controller/assessmentlist">
                    <i class="vl_slider-h-range"></i>
                    <span class="nav-link-text">Assessments</span>
                </a>
                <ul class="sidenav-second-level collapse <?php if ($section=="assessment") { echo " show"; }?>" id="ui_elements" data-parent="#accordion">
                    <li> <a href="/controller/assessmentlist">View Assessments</a> </li>
                    <li> <a href="/controller/assessmentform?function=add">Create Assessment</a></li>
                    <li> <a href="/controller/assessmenttemplatelist">Templates</a></li>
                    <li> <a href="/controller/assessmentrequestlist">Requests</a></li>
                    <li> <a href="/controller/assessmentinprogresslist">Your Responses</a></li>
                    <li> <a href="/controller/myassessments">My Assessments</a></li>
  
                </ul>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Data Manager">
                <a class="nav-link nav-link-collapse collapsed menulink" data-toggle="collapse" data-target="#widgets" data-go="/controller/datamanager">
                    <i class="vl_bond"></i>
                    <span class="nav-link-text">Data Manager</span>
                </a>
                <ul class="sidenav-second-level collapse <?php if ($section=="datamanager") { echo " show"; }?>" id="widgets" data-parent="#accordion">
                    <li> <a href="widget-basic.html">Create Data Subject Group</a> </li>
                    <li> <a href="widget-chart.html">Create Data Subject Category</a> </li>
                </ul>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Calendar">
                <a class="nav-link" href="calendar-external-events.html">
                    <i class="vl_calendar"></i>
                    <span class="nav-link-text">Calendar <span class="badge badge-primary">2</span> </span>
                </a>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Icons">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" data-target="#icons">
                    <i class="vl_hand-mike"></i>
                    <span class="nav-link-text">Icons</span>
                </a>
                <ul class="sidenav-second-level collapse" id="icons" data-parent="#accordion">
                    <li> <a href="icon-fontawesome.html">Fontawesome Icons</a> </li>
                    <li> <a href="icon-simple-line.html">Simple Line Icons</a> </li>
                    <li> <a href="icon-themify.html">Themify Icons</a> </li>
                    <li> <a href="icon-weather.html">Weather Icons</a> </li>
                </ul>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Forms">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" data-target="#forms">
                    <i class="vl_form"></i>
                    <span class="nav-link-text">Forms</span>
                </a>
                <ul class="sidenav-second-level collapse" id="forms" data-parent="#accordion">
                    <li> <a href="form-basic.html">Basic Forms</a> </li>
                    <li> <a href="form-checkbox-radio.html">Checkbox & Radio</a> </li>
                    <li> <a href="form-input-group.html">Input Group</a> </li>
                    <li> <a href="form-validation.html">Form Validation</a> </li>
                    <li> <a href="editor-summernote.html">Editor Summernote</a> </li>
                    <li> <a href="form-dropzone.html">Dropzone</a> </li>
                    <li> <a href="form-pickers.html">Pickers</a> </li>
                    <li> <a href="form-select2.html">Select 2</a> </li>
                    <li> <a href="form-multi-select.html">Multiple Select</a> </li>
                    <li> <a href="form-wizard.html">Form Wizard</a> </li>
                    <li> <a href="form-switch.html">Switchery</a> </li>
                </ul>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Data Tables">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" data-target="#d_tables">
                    <i class="vl_grid-even"></i>
                    <span class="nav-link-text">Data Tables</span>
                </a>
                <ul class="sidenav-second-level collapse" id="d_tables" data-parent="#accordion">
                    <li> <a href="table-basic.html">Basic Table</a> </li>
                    <li> <a href="table-datatable.html">Data Table</a> </li>
                    <li> <a href="table-ajax-datatable.html">Ajax Data Table</a> </li>
                </ul>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" data-target="#charts">
                    <i class="vl_graph-bar"></i>
                    <span class="nav-link-text">Charts</span>
                </a>
                <ul class="sidenav-second-level collapse" id="charts" data-parent="#accordion">
                    <li> <a href="chartjs.html">Chartjs</a> </li>
                    <li> <a href="echarts.html">eCharts</a> </li>
                    <li> <a href="amcharts.html">amCharts</a> </li>
                </ul>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Exra Pages">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" data-target="#extra_pages">
                    <i class="vl_files"></i>
                    <span class="nav-link-text">Extra Pages</span>
                </a>
                <ul class="sidenav-second-level collapse" id="extra_pages" data-parent="#accordion">
                    <li> <a href="profile.html">Profile</a> </li>
                    <li> <a href="invoice.html">Invoice</a> </li>
                    <li> <a href="blank-page.html">Blank Page</a> </li>
                    <li> <a href="login.html">Login Page</a> </li>
                    <li> <a href="registration.html">Registration Page</a> </li>
                    <li> <a href="404.html">404 Error</a> </li>
                </ul>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Layouts">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" data-target="#layouts">
                    <i class="vl_board"></i>
                    <span class="nav-link-text">Layouts</span>
                </a>
                <ul class="sidenav-second-level collapse" id="layouts" data-parent="#accordion">
                    <li> <a href="layout-top-nav.html">Top Nav </a></li>
                    <li> <a href="layout-dark-nav.html">Dark Left Nav</a> </li>
                    <li> <a href="blank-page.html">Light Left Nav</a> </li>
                    <li> <a href="layout-default-collapsed.html">Nav Collapsed Light</a></li>
                    <li> <a href="layout-dark-nav-collapsed.html">Nav Collapsed Dark</a></li>
                    <li> <a href="layout-floating-leftside-dark.html">Floating Nav Dark</a></li>
                    <li> <a href="layout-floating-leftside-dark-collapsed.html">Floating Collapsed Dark </a></li>
                    <li> <a href="layout-floating-leftside-light.html">Floating Nav Light </a></li>
                    <li> <a href="layout-floating-leftside-light-collapsed.html">Floating Collapsed Light </a></li>
                </ul>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" data-target="#multi_menu">
                    <i class="vl_sitemap1"></i>
                    <span class="nav-link-text">Menu Levels</span>
                </a>
                <ul class="sidenav-second-level collapse" id="multi_menu" data-parent="#accordion">
                    <li>
                        <a href="#">Second Level Item</a>
                    </li>
                    <li>
                        <a href="#">Second Level Item</a>
                    </li>
                    <li>
                        <a href="#">Second Level Item</a>
                    </li>
                    <li>
                        <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" data-target="#multi_menu_2">Third Level</a>
                        <ul class="sidenav-third-level collapse" id="multi_menu_2">
                            <li>
                                <a href="#">Third Level Item</a>
                            </li>
                            <li>
                                <a href="#">Third Level Item</a>
                            </li>
                            <li>
                                <a href="#">Third Level Item</a>
                            </li>
                        </ul>
                    </li>
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
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-lg-2" id="actionNav" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Application
                </a>
                <div class="dropdown-menu" aria-labelledby="actionNav">
                    <a class="dropdown-item" href="#">Bootstrap 4 Stable</a>
                    <a class="dropdown-item" href="#">DashLab Modern Admin</a>
                    <a class="dropdown-item" href="#">Awesome Widgets Collection</a>
                    <a class="dropdown-item" href="#">Developer Friendly Code</a>
                    <a class="dropdown-item" href="#">SASS and GULP Task</a>
                    <a class="dropdown-item" href="#">Fully Responsive</a>
                    <a class="dropdown-item" href="#">Latest Version Plugins</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-lg-2" id="reportNav" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Reports
                </a>
                <div class="dropdown-menu" aria-labelledby="reportNav">
                    <a class="dropdown-item" href="#">Daily Reports</a>
                    <a class="dropdown-item" href="#">Weekly Reports</a>
                    <a class="dropdown-item" href="#">Monthly Reports</a>
                    <a class="dropdown-item" href="#">Yearly Reports</a>
                    <a class="dropdown-item" href="#">HR Reports</a>
                    <a class="dropdown-item" href="#">Product Reports</a>
                    <a class="dropdown-item" href="#">Order Reports</a>
                    <a class="dropdown-item" href="#">Revenue Reports</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-lg-2" id="orderNav" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Management
                </a>
                <div class="dropdown-menu" aria-labelledby="orderNav">
                    <a class="dropdown-item" href="#">HR Management</a>
                    <a class="dropdown-item" href="#">Product Management</a>
                    <a class="dropdown-item" href="#">Role Management</a>
                    <a class="dropdown-item" href="#">Sales Management</a>
                    <a class="dropdown-item" href="#">Employee Management</a>
                </div>
            </li>
        </ul>
        <!--/header leftside links-->

        <!--header rightside links-->
        <ul class="navbar-nav header-links ml-auto hide-arrow">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-lg-3" id="messagesDropdown" href="#" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
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
                    <div class="notification-alarm">
                        <span class="wave wave-warning"></span>
                        <span class="dot bg-warning"></span>
                        
                    </div>
                </a>

                <div class="dropdown-menu dropdown-menu-right header-right-dropdown-width pb-0" aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header weight500">Notification</h6>

                    <div class="dropdown-divider mb-0"></div>
                    <a class="dropdown-item border-bottom" href="#">
                            <span class="text-primary">
                            <span class="weight500">
                                <i class="vl_bell weight600 pr-2"></i>Weekly Update</span>
                            </span>
                        <span class="small float-right text-muted">03:14 AM</span>

                        <div class="dropdown-message f12">
                            This week project update report generated. All team members are requested to check the updates
                        </div>
                    </a>

                    <a class="dropdown-item border-bottom" href="#">
                            <span class="text-danger">
                            <span class="weight500">
                                <i class="vl_Download-circle weight600 pr-2"></i>Server Error</span>
                            </span>
                        <span class="small float-right text-muted">10:34 AM</span>

                        <div class="dropdown-message f12">
                            Unexpectedly server response stop. Responsible members are requested to fix it soon
                        </div>
                    </a>

                    <a class="dropdown-item border-bottom" href="#">
                            <span class="text-success">
                            <span class="weight500">
                                <i class="vl_screen weight600 pr-2"></i>Monthly Meeting</span>
                            </span>
                        <span class="small float-right text-muted">12:30 AM</span>

                        <div class="dropdown-message f12">
                            Our monthly meeting will be held on tomorrow sharp 12:30. All members are requested to attend this meeting.
                        </div>
                    </a>

                    <a class="dropdown-item small" href="#">View all notification</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-lg-3" id="userNav" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-thumb">
                        <img class="rounded-circle" src="/v2assets/img/avatar/avatar1.jpg" alt=""/>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userNav">
                    <a class="dropdown-item" href="#">My Profile</a>
                    <a class="dropdown-item" href="#">Account Settings</a>
                    <a class="dropdown-item" href="#">Inbox <span class="badge badge-primary">3</span></a>
                    <a class="dropdown-item" href="#">Message <span class="badge badge-success">5</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="login.html">Sign Out</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="javascript:;" class="nav-link right_side_toggle">
                    <i class="icon-options-vertical"> </i>
                </a>
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
				<div class="card-body" id="content_body">			
						<?php main(); ?>
				</div>
			</div>



    </div>


</div>
<!--/main content wrapper-->

<!--right sidebar-->
<div class="right-sidebar" id="right_side_bar">
    <div class="card border-0">
        <div class="card-body pb-0">
            <!--close toggle-->
            <a href="javascript:;" class="right_side_toggle float-right close-sidebar-icon">
                <i class=" ti-shift-right"> </i>
            </a>
            <!--/close toggle-->
        </div>
        <div class="card-body pt-2">

            <div class="right-widget">
                <div class="custom-title-wrap bar-primary mb-4">
                    <div class="custom-title">Today's Activity</div>
                </div>

                <ul class="list-unstyled base-timeline">
                    <li class="time-dot-primary">
                        <div class="base-timeline-info">
                            <a href="#">John123</a> Successfully purchased item#26
                        </div>
                        <small class="text-muted">
                            28 mins ago
                        </small>
                    </li>
                    <li class="time-dot-danger">
                        <div class="base-timeline-info">
                            <a href="#" class="text-danger">Farnandez</a> placed the order for accessories
                        </div>
                        <small class="text-muted">
                            2 days ago
                        </small>
                    </li>
                    <li class="time-dot-purple">
                        <div class="base-timeline-info">
                            User <a href="#" class="text-purple">Lisa Maria</a> checked out from the market
                        </div>
                        <small class="text-muted">
                            12 mins ago
                        </small>
                    </li>
                </ul>
            </div>

            <div class="right-widget">
                <div class="custom-title-wrap bar-danger mb-4">
                    <div class="custom-title">Active Users</div>
                </div>

                <ul class="list-unstyled mb-0 list-widget">
                    <li class="cursor">
                        <div class="media mb-4">
                            <div class="st-alphabet mr-3">
                                <img class="rounded-circle" src="/v2assets/img/avatar/avatar1.jpg" alt=" ">
                                <span class="status bg-success"></span>
                            </div>
                            <div class="media-body ">
                                <div class="float-left">
                                    <h6 class="text-uppercase mb-0">shirley hoe</h6>
                                    <span class="text-muted">Online</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="cursor">
                        <div class="media mb-4">
                            <div class="st-alphabet mr-3">
                                <img class="rounded-circle" src="/v2assets/img/avatar/avatar2.jpg" alt=" ">
                                <span class="status bg-warning"></span>
                            </div>
                            <div class="media-body ">
                                <div class="float-left">
                                    <h6 class="text-uppercase mb-0">james alexender</h6>
                                    <span class="text-muted">Screaming...</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="cursor">
                        <div class="media mb-4">
                            <div class="st-alphabet mr-3">
                                <img class="rounded-circle" src="/v2assets/img/avatar/avatar3.jpg" alt=" ">
                                <span class="status bg-info"></span>
                            </div>
                            <div class="media-body">
                                <div class="float-left">
                                    <h6 class="text-uppercase mb-0">ursula sitorus</h6>
                                    <span class="text-muted">Start Exploring</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="cursor">
                        <div class="media mb-3">
                            <div class="st-alphabet mr-3">
                                <img class="rounded-circle" src="/v2assets/img/avatar/avatar4.jpg" alt=" ">
                                <span class="status bg-danger"></span>
                            </div>
                            <div class="media-body">
                                <div class="float-left">
                                    <h6 class="text-uppercase mb-0">jonna pinedda</h6>
                                    <span class="text-muted">Busy</span>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="right-widget">

                <div class="custom-title-wrap bar-success mb-4">
                    <div class="custom-title">Notification</div>
                </div>

                <div >
                    <div class="dropdown-divider mb-0"></div>
                    <a class="nav-link border-bottom px-0 py-3" href="#">
                            <span class="text-primary">
                            <span class="weight700 f12">
                                <i class="vl_bell weight600 pr-2"></i>Weekly Update</span>
                            </span>
                        <span class="small float-right text-muted">03:14 AM</span>

                        <div class="text-dark f12">
                            This week project update report generated. All team members are requested to check the updates
                        </div>
                    </a>

                    <a class="nav-link border-bottom px-0 py-3" href="#">
                            <span class="text-danger">
                            <span class="weight700 f12">
                                <i class="vl_Download-circle weight600 pr-2"></i>Server Error</span>
                            </span>
                        <span class="small float-right text-muted">10:34 AM</span>

                        <div class="text-dark f12">
                            Unexpectedly server response stop. Responsible members are requested to fix it soon
                        </div>
                    </a>

                    <a class="nav-link border-bottom px-0 py-3" href="#">
                            <span class="text-success">
                            <span class="weight700 f12">
                                <i class="vl_screen weight600 pr-2"></i>Monthly Meeting</span>
                            </span>
                        <span class="small float-right text-muted">12:30 AM</span>

                        <div class="text-dark f12">
                            Our monthly meeting will be held on tomorrow sharp 12:30. All members are requested to attend this meeting.
                        </div>
                    </a>

                    <div class="text-center mt-3">
                        <a class="nav-link px-0" href="#">View all notification</a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<!--/right sidebar-->
   <!-- Modals -->
    <!-- Large Modal -->
<div class="modal fade" id="modal-large" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="modal-lg-content">
   	    <!-- Modal Start -->
	    <?php echo "test";?>

    
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

    
    <!-- End Modals -->
<!--basic scripts-->
<script src="/v2assets/vendor/jquery/jquery.min.js"></script>
<script src="/v2assets/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="/v2assets/vendor/popper.min.js"></script>
<script src="/v2assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/v2assets/vendor/jquery-dropdown-master/jquery.dropdown.js"></script>
<script src="/v2assets/vendor/m-custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/v2assets/vendor/icheck/skins/icheck.min.js"></script>
<script src="/v2assets/gateway.js"></script>

<!-- Chosen -->


  <script src='https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js'></script>
<script>
      $(function() {
        $('.chosen-select').chosen();
        $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
      });
      </script>
      
      

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<!--[if lt IE 9]>
<script src="/v2assets/vendor/modernizr.js"></script>
<![endif]-->

<!--basic scripts initialization-->
<script src="/v2assets/js/scripts.js"></script>

<script>
$( document ).ready(function() {
$(".menulink").click(function() {
window.location.href = $(this).data("go");

});
});
	
                             
 

</script>

</body>
</html>

