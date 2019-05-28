<?php 
	include("include.php");

class Cascade(){
	var $first;
	var $second;
	
	function showCascade(){
		
		
	}
	
	
	
}





function getDSGObject($parent_type,$parent_id,$child_type) {
	
	$query="select * from datamanager_object_container where parent_id='$parent_id' and $parent_type='' and child_type="";
	
}	
	
	

	
	$query="select * from datamanager_data subject_group where object_id='N41GHdm'";
	
	
	$statement = $db->prepare("select * from datamanager_data_subject_group where object_id='N41GHdm'");
	

 		$statement->execute();
 		while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
$object_id=$row['object_id'];
$identikey=$row['identikey'];
echo $name=$row['name'];
$description=$row['description'];

}
	
$object_id

select * relationshiptabel where the parent_id=$object_id and the child_type=dsg_prupose
	
	
	?>
	