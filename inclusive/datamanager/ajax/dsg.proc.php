<?php
// IDENTIKEY CONFIRMED

require("include.php");

// Declare Variables
$name=$_POST['name'];
$object_id=$_POST['object_id'];
$description=$_POST['description'];
$identikey=$s_identikey;
$size=$_POST['size'];

$function=$_POST['function'];


if (!$function) {
	$function="add";
}



//check Name
if(pb_validate_required($name)== false) {

			$arr['validate']['name']="You need to include a name";
							$errorcode=1;
}

//check description
if (pb_validate_required($description)==false) {
				$arr['validate']['description']="You need to include a description of the Data Subject Group";
				$errorcode=1;
}

if ($errorcode) {
	$outcome="error";
		$arr['outcome']="fail";
} else {

	if ($function == "add") {


try {

// Execute Database
		$statement = $db->prepare("INSERT INTO datamanager_data_subject_group (object_id,identikey,name,description,size) VALUES (:object_id,:identikey,:name,:description,:size)");

		$object_id = pb_create_object_id("datamanager_data_subject_group");

		$statement->bindParam(':object_id', $object_id);
		$statement->bindParam(':size', $size);
		$statement->bindParam(':identikey', $identikey);
		$statement->bindParam(':name', $name);
		$statement->bindParam(':description', $description);
		$statement->execute();

	
			$arr['outcome']="success";
				$arr['smessage']="Data Subject Group Created";
		
} catch(PDOException $e) {
	http_response_code(500);
	echo '{"error":{"text":'. $e->getMessage() .'}}';
}



$lastid=$db->lastInsertId();

$statement = $db->prepare("select * from datamanager_data_subject_group where id = :id");
 		$statement->bindParam(':id', $lastid);
 		$statement->execute();
 		while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
$object_id=$row['object_id'];

}


// Country insert
try {
		
foreach ($_POST['country'] as $countrycode) {
		$statement = $db->prepare("INSERT INTO datamanager_countries (object_id,object_type,country) VALUES (:object_id,:object_type,:country)");

$object_type="dsg_group";

$statement->bindParam(':object_id', $object_id);
$statement->bindParam(':object_type', $object_type);
$statement->bindParam(':country', $countrycode);
$statement->execute();

}
		
		
	
			$arr['outcome']="success";
				$arr['smessage']="Data Subject Group Created";	
	


} catch(PDOException $e) {
	http_response_code(500);
	echo '{"error":{"secondary text":'. $e->getMessage() .'}}';
}







	} else if ($function=="edit") {


if (!$object_id) {
	echo "errr";
	exit;
}



		
		$statement = $db->prepare("UPDATE datamanager_data_subject_group SET name = :name,description = :description, size=:size WHERE object_id = :object_id and identikey=:identikey");


$statement->bindParam(':object_id', $object_id);
$statement->bindParam(':size', $size);
$statement->bindParam(':identikey', $identikey);
$statement->bindParam(':name', $name);
$statement->bindParam(':description', $description);
$statement->execute();
		

		$statement = $db->prepare("DELETE from datamanager_countries where object_id=:object_id and object_type=:object_type");
$object_type="dsg_group";
	$statement->bindParam(':object_id', $object_id);
$statement->bindParam(':object_type', $object_type);
$statement->execute();

	foreach ($_POST['country'] as $countrycode) {
		$statement = $db->prepare("INSERT INTO datamanager_countries (object_id,object_type,country) VALUES (:object_id,:object_type,:country)");



$statement->bindParam(':object_id', $object_id);
$statement->bindParam(':object_type', $object_type);
$statement->bindParam(':country', $countrycode);
$statement->execute();
	
} 
$arr['outcome']="success";
		$arr['smessage']="Data Subject Group Edited";
		$arr['force-refresh']="yes";


}
}

	echo json_encode($arr);

?>