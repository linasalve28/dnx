<?php
session_start();

require_once("config.inc.php");
include(DB_ROOT."/tb.db.conn.php");

require(FS_ROOT_FUNCTIONS."/system.log.functions.php");
require(FS_ROOT_FUNCTIONS."/core_security_functions_inc.php");
require(FS_ROOT_FUNCTIONS."/validation.functions.php");


// Two incoming variables
$username=$_POST['username'];
$password=$_POST['password'];


if (!$username or !$password) {
	setcookie("loginfailure","failure", time()+60);
	// Execute login failure function to log this attempt and if necessary lock the account
	pb_system_log("Login FAILURE: Blank credentials","Login",$username,"");
    header("Location:".DOMAIN_PATH."/login.php");
	exit;
}
// Validation

$username=filter_var($username, FILTER_SANITIZE_EMAIL); // -> not a tag
$salt=pb_create_salt($username);
// Using Salt, we get the hashed version of password
$password_check=create_password($password,$salt);

$query="select identikey,first_name,last_name,userid,email from access_users where userid = '$username' and password = '$password_check' limit 1";

$statement = $db->prepare("select identikey,first_name,last_name,userid,email,role from access_users where userid = :userid and password = :password_check limit 1");
$statement->bindParam(':userid', $username);
$statement->bindParam(':password_check', $password_check);
$statement->execute();

$errcheck=$statement->rowCount();

if ($errcheck==0) {
	setcookie("loginfailure","failure", time()+60);
	// Execute login failure function to log this attempt and if necessary lock the account
	pb_system_log("Login FAILURE","Login",$username,"");

    header("Location:".DOMAIN_PATH."/login.php");
	exit;

} else {

	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$identikey=$row['identikey'];
		$username=$row['email'];
		$userid=$row['userid'];
		$role=$row['role'];
		$_SESSION["s_user_fullname"]=$row['first_name']." ".$row['last_name'];
	}
	$_SESSION["s_identikey"] = $identikey;
	$_SESSION["s_username"] = $email;
	$_SESSION["s_userid"] = $userid;
	$_SESSION["s_role"] = $role;

	$_SESSION["s_timeout"]=time();

	pb_system_log("Login SUCCESS","Login",$username,"");

	if (!$_SESSION["s_ref"]) {
		header("location:".DOMAIN_PATH."/controller/app/welcome");
	} else {

		$ref=$_SESSION['s_ref'];
		unset($_SESSION["s_ref"]);
		header("location:".$ref);
	}


}


?>