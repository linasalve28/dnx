<?php
function main() {
	
	
	$statement = $db->prepare("select * from dm_pii_categories");
			$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
			$object_id=$row['object_id'];
			$name=$row['name'];
			
			echo $name;
	
	
	}
	
	
}
?>