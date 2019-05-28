<?php
// Core Version 1.1

//require(core_functions.inc.php);
//require(core_security_functions_inc.php);



function pb_get_module_permission($user) {
	$db=db_conn();
	$statement = $db->prepare("select module_perm from access_users where userid = '$user' limit 1");
 	$statement->execute();
 	$row = $statement->fetch(PDO::FETCH_ASSOC);
	return $row['module_perm'];	
}

// This returns the External Version of the Identikey

function pb_get_external_identikey($user) {
	
	$statement = $db->prepare("select * from access_users where userid = '$user'");

 	$statement->execute();
 	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$external_identikey=$row['external_identikey'];
	}
	return $external_identikey;
}

// This creates the Salt for use during login

// ------------------------- SALT and PASSWORD FUNCTIONS

function pb_create_salt($string){
  return md5("Exn5@kend*£$@*£@".$string."jk7ib4lotbot0");
}

function create_password($string,$salt) {

  return sha1($string.$salt);

}


//----- GET VARIABLE IS A NUMBER Validation

function pb_variable_is_number($name,$method="get",$line="") {
// REMOVE AFTER DEBUGGING

  echo $line;


if ($method=="get") {
$variable=$_GET[$name];
} else if ($method=="post") {
$variable=$_POST[$name];

}
echo $variable;
if (is_numeric($variable)) {
} else {
echo "Security Violation: Variable ID recon";
$myurl = basename($_SERVER['PHP_SELF']) . "?" . $_SERVER['QUERY_STRING'];
pb_system_log("Security Violation","Get Variable not number",$myurl);
exit;
}

}

function pb_generate_unique_id($table) {
  return "1";
}

function pb_create_object_id($table) {
// This function uses another function to generate the string, then checks it against the database to see if its in use.
// If in use, it generates another string.
  do
  {

     $id = create_unique_id();
  }
  while (check_unique_id($id,$table));
return $id;
}

function create_unique_id() {
// This simple function generates the random string
 
 // Use this when not in dev
 // return sha1(time());

// Use the following in dev mode
return create_unique_access_id();
}


function check_unique_id($unique_id,$table) {
global $db;
 $query="select count(*) from $table where object_id='$unique_id'";

if ($db->query($query)->fetchColumn() > 0) {
  return true;
} else {
  return false;
}

}


// creates a 7 string unique code for access purposes
function create_unique_access_id() {
	
		$seed = str_split('abcdefghijklmnopqrstuvwxyz'
			.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
			.'0123456789'); // and any other characters
		shuffle($seed); // probably optional since array_is randomized; this may be redundant
		$rand = '';
		foreach (array_rand($seed, 7) as $k) $unique_access_id .= $seed[$k];
		return $unique_access_id;
}


//-------------------------- LOCK OUT FUNCTIONS

// Function checks if a user is on the restricted list


// This immediately halts a users access to the system


function check_lockout_ip() {
// This function should be called first on every page, and will check if the IP is banned
 if ($num > 0) {

echo "Error:SentinelAI Route Terminated";
exit;

 }
}

function update_lock_user_ip() {
// This function will lock a user account if a number of violations have occurred
if ($num > 2) {
  lockout_user_ip();
}

}

function lockout_user_ip() {
// This function will update the log regarding IP lockout
$statement = $db->prepare("INSERT INTO security_ip_lock (ip) VALUES (:ip)");
$statement->bindParam(':ip', $_SERVER['REMOTE_ADDR']);
$statement->execute();

}
function lockout_user_lock($userid,$event) {
  // This function will lock a user account_status
global $db;
  $statement = $db->prepare("UPDATE access_users SET  account_status = 'LOCKED' WHERE userid=:user");
  $statement->bindParam(':userid', $userid);
  $statement->execute();



}

// This increases or decrease a users lock out count, usually the number of times a username is entered incorrectly
function lockout_user_count($user,$action="increase",$event="Unlisted") {
  global $db;

  if ($action=="increase") {


    $statement = $db->prepare("select lock_count from access_users where user = :user");
    $statement->bindParam(':userid', $userid);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
      $lock_count=$row['lock_count'];
    }


    if ($lock_count>=5) {

      lockout_user_lock($user,$event);

    } else {
      $lock_count=$lock_count+1;
      $statement = $db->prepare("UPDATE access_users SET  lock_count = :lock_count WHERE userid=:user");
      $statement->bindParam(':lock_count', $lock_count);
      $statement->execute();
    }



  } else if ($action=="clear") {

    $statement = $db->prepare("UPDATE access_users SET  lock_count = '0' WHERE userid=:user");
    $statement->execute();

  }


}



// ------ SESSION MANAGEMENT

function get_session($session) {

  "select identikey from session_manager where session_id=$session";

}


// -------------------------- INPUT VALIDATION AND SECURITY FUNCTIONS
function sanitize_textstring() {
}

function check_edit_permission() {
}

function lock_record($i,$x,$xm) {
}


function sec_count_variables($num) {
  // This function compares the number of variables sent with the allowed number
  if (count($_POST)!==$num) {
    echo "Security Error";
    lockout_user($user,$event);
  }

}


function sec_lockout($user,$event) {
  // This function suspends a users account due to a security violation
  // log time, and nature of event, and the page, ip address, host name, and anything else
}








//validate_input($variation);
//santize_input($variation);


// The validation functions only respond if the variable is invalid. They do not require the variable to be set.
//validate_input($name,"text");
//validate_input($name,"numerical")
//validate_input($name,"notnull")
//validate_input($name,"");
