<?php
session_start();
	
require_once("./../../../config.inc.php");
include( DB_ROOT."/tb.db.conn.php");
include( FS_ROOT_FUNCTIONS ."/base.functions.php");

		
$s_identikey=$_SESSION['s_identikey'];
$s_username=$_SESSION['s_username'];
$s_userid=$_SESSION['s_userid'];
		?>