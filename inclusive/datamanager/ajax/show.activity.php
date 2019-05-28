<?php
require_once("include.php");

$purpose_id= $_GET['purpose'];
$activity_id=$_GET['activity'];


$statement = $db->prepare("select * from datamanager_activity_link where purpose_id = :purpose_id");

$statement->bindParam(':purpose_id', $purpose_id);
$statement->execute();


while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

	$activity_id[]=$row['activity_id'];

}


if (is_array($activity_id)) {
	foreach ($activity_id as $activity_id_use) {

		$statement = $db->prepare("select * from datamanager_activity where object_id = :object_id");

		$statement->bindParam(':object_id', $activity_id_use);
		$statement->execute();


		while ($row = $statement->fetch(PDO::FETCH_ASSOC)){


			$object_id=$row['object_id'];
			$name=$row['name'];
			$description=$row['description'];
			$identikey=$row['identikey'];


			$content.="<a class='btn btn-lg btn-primary mx-3 f2' href='/inclusive/datamanager/ajax/show.activity.php?activity=$object_id'>$name</a>";

		}


	}
}

$arr['outcome']="success";
$arr['refresh-div']="activity_body";
$arr['refresh-content']=$content;

echo json_encode($arr);





?>
	