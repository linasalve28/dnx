<?php
//require_once("/home/trustbase/dbn/tb.db.conn.php");
require_once("../../config.inc.php");
include_once( DB_ROOT."/tb.db.conn.php");
function file_control_download($object_id,$access_key) {
	global $db;
	if (!$object_id) {
		echo "Critical Security Error";
		exit;
	}
		if (!$access_key) {
		echo "Critical Security Error";
		exit;
	}
	
	$query="select * from file_control where object_id = :object_id and access_key = :access_key limit 1";

	$statement = $db->prepare($query);
	$statement->bindParam(':object_id', $object_id);
		$statement->bindParam(':access_key', $access_key);
	$statement->execute();

	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		
	$enc_file_name=$row['enc_file_name'];
	$file_name=$row['file_name'];

	}
	
	if ($enc_file_name) {
        //$file = '/home/trustbase/secu/f/'.$enc_file_name;
        $file = FILES_ROOT."/".$enc_file_name;
        //echo filesize($file);
        header('Content-Description: File Transfer');
        header('Content-Type: application/force-download');
        header("Content-Transfer-Encoding: binary");
        header('Content-Length: ' . filesize($file));
        header('Content-Disposition: attachment; filename=' . basename($file_name));
        readfile($file);
	}
}

$object_id=$_GET['object_id'];
$access_key=$_GET['access_key'];
if ($object_id and $access_key) {
    file_control_download($object_id,$access_key);
}

?>