<?php
session_start();

// This destroys the log in sessions
unset($_SESSION["s_username"]);
unset($_SESSION["s_identikey"]);

header("location:login.php");

?>