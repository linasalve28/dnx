<?php
	
	$object_id=$_GET['object_id'];
	

	$statement = $db->prepare("select * from system_alerts where object_id = :object_id");
 		$statement->bindParam(':object_id', $object_id);
 		$statement->execute();
 		while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

$content=$row['content'];

}





$statement = $db->prepare("UPDATE system_alerts SET read_status='read' WHERE object_id=:object_id");
 		$statement->bindParam(':object_id', $object_id);
 		$statement->execute();


	
	header("location:".WS_CONTROLLER."/".$content);
	
	
	
?>