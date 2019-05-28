<?php
// Set Section Function 
function set_section($menu_section) {
	global $section;
	if ($menu_section==$section) {
	  echo "nav-item start active open";
	} else {
	  echo "nav-item";
	}
}
?>

<div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
    <!-- eDOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
        <li class="<?php set_section("home"); ?>">
            <a href="<?php echo WS_CONTROLLER;?>/welcome" class="nav-link nav-toggle">
                <i class="icon-home"></i>
                <span class="title">Home</span>
                <span class="arrow open"></span>
            </a>
        </li>        
        <li class="<?php set_section("assessment"); ?>">
            <a href="<?php echo WS_CONTROLLER;?>/assessmentlist" class="nav-link nav-toggle">
                <i class="fa fa-check"></i>
                <span class="title">Assessments</span>
                <span class="selected"></span>
                <span class="arrow"></span>
            </a>
        </li>        
        <li class="<?php set_section("datamanager"); ?>">
            <a href="<?php echo WS_CONTROLLER;?>/datamanager" class="nav-link nav-toggle">
                <i class="fa fa-database"></i>
                <span class="title">Data Manager</span>
                <span class="selected"></span>
                <span class="arrow"></span>
            </a>
        </li>
        <li class="<?php set_section("dsr"); ?>">
            <a href="<?php echo WS_CONTROLLER;?>/dsrlist" class="nav-link nav-toggle">
                <i class="fa fa-users"></i>
                <span class="title">Data Requests</span>
                                <span class="selected"></span>
                <span class="arrow"></span>
            </a>
        </li>        
        <li class="<?php set_section("dta"); ?>">
            <a href="<?php echo WS_CONTROLLER;?>/dtalist" class="nav-link nav-toggle">
                <i class="fa fa-exchange"></i>
                <span class="title">Data Transfers</span>
                                <span class="selected"></span>
                <span class="arrow"></span>
            </a>
        </li>
        <li class="<?php set_section("breach"); ?>">
            <a href="<?php echo WS_CONTROLLER;?>/databreach" class="nav-link nav-toggle">
                <i class="fa fa-exclamation-triangle"></i>
                <span class="title">Data Breach</span>
                                <span class="selected"></span>
                <span class="arrow"></span>
            </a>
        </li>        
        <li class="<?php set_section("consent"); ?>">
            <a href="<?php echo WS_CONTROLLER;?>/consentmanager" class="nav-link nav-toggle">
                <i class="fa fa-plus-square"></i>
                <span class="title">Consent Manager</span>
                <span class="selected"></span>
                <span class="arrow"></span>
            </a>
        </li>
        <li class="<?php set_section("certification"); ?>">
            <a href="<?php echo WS_CONTROLLER;?>/certlist" class="nav-link nav-toggle">
                <i class="fa fa-shield"></i>
                <span class="title">Certifications</span>
                <span class="selected"></span>
                <span class="arrow"></span>
            </a>
        </li>
        <li class="<?php set_section("company"); ?>">
            <a href="<?php echo WS_CONTROLLER;?>/companylist" class="nav-link nav-toggle">
                <i class="fa fa-list"></i>
                <span class="title">Linked Companies</span>
                <span class="selected"></span>
                <span class="arrow"></span>
            </a>
        </li>
      </div>
