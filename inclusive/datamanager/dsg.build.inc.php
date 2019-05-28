<script>
	var target_activity="0";
	</script>
	<?php

$countries = pb_list_countries();


function list_countries($object_id,$object_type) {
	global $db;
	global $countries;
	$statement = $db->prepare("select * from datamanager_countries where object_id = :object_id and object_type=:object_type");
	$object_type="dsg_group";
	$statement->bindParam(':object_id', $object_id);
	$statement->bindParam(':object_type', $object_type);
	$statement->execute();
	$i;
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$countryname[]=$countries[$row['country']];
		++$i;
	}

	return $countryname;
}


function main() { ?>

	<div class="m-heading-1 border-green m-bordered">
    <h3>Data Subject Groups</h3>
    <p>Data Subject Groups are groups of people your company collects information about. For example, UK Clients. <br />
	    <a class="btn btn-success f4" href="/inclusive/datamanager/ajax/dsg.form.php?function=add">Create Data Subject Group</a>

    </p>
  </div>
  <link rel="stylesheet" href="/v2assets/vendor/chosen/chosen.css">
<?php
	global $db;
	global $errorcode;
	global $outcome;
	global $s_identikey;
	global $s_username;
	
	$id=$_GET['oid'];

$query="select * from "
	$statement = $db->prepare("select * from datamanager_data_subject_group where object_id=:object_id and identikey = :identikey limit 1");
	$statement->bindParam(':identikey', $s_identikey);
	$statement->bindParam(':object_id', $id);
		
	$statement->execute();
	$i=1;
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

		$dsg_name=$row['name'];
		$object_id=$row['object_id'];
		$object_description=$row['description'];
		$size=$row['size'];

?>
                                      <div class="row">
                                                    <div class="col-md-12">                     
	                        <div class="card card-shadow mb-4 pt-0">
	                        				<div class="card-header">
	                        					<div class="custom-title-wrap bar-danger">
	                        						<div class="custom-title">
		                        						<div class="row">
		                        						<div class="col-md-6">
			                        						Data Subject Group
		                        						</div>
		                        						<div class="col-md-6">
			                        						
		                        						</div>
		                        						</div>
		                        						
		                        						</div>	    
	                        					</div>
	                        				</div>
	                        				<div class="card-body">
	                        			
	                        						Group
	                        			
	                        				</div>
	                        			</div>                         
               <div class="card card-shadow mb-4 pt-0">
	                        				<div class="card-header">
	                        					<div class="custom-title-wrap bar-danger">
	                        						<div class="custom-title">Purpose</div>
	                        						<a class="btn btn-success f4 ml-auto" href="/inclusive/datamanager/ajax/dsg.purpose.form.php?oid=<?php echo $object_id; ?>&function=add&type=purpose">Create Purpose</a>
	                        					</div>
	                        				</div>
	                        				<div class="card-body" id="purpose_body">
	                        			
	                        			<?php
	                        			$statement = $db->prepare("select * from datamanager_purpose_link where dsg_id = :object_id");
 		$statement->bindParam(':object_id', $id);
 		$statement->execute();
 		while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
$id=$row['id'];
$object_id=$row['object_id'];
$dsg_id=$row['dsg_id'];
$purpose_id[]=$row['purpose_id'];
$identikey=$row['identikey'];

}
foreach ($purpose_id as $target_purpose) {
	
	$statement = $db->prepare("select * from datamanager_purpose where object_id = :object_id");
 		$statement->bindParam(':object_id', $target_purpose);
 		$statement->execute();
 		while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

$object_id=$row['object_id'];
$name=$row['name'];
$description=$row['description'];
$identikey=$row['identikey'];

echo "<a class='btn btn-lg btn-warning mx-3 f2 setclick' data-id='$object_id' href='/inclusive/datamanager/ajax/show.activity.php?activity=$object_id'>$name</a>";

}
	
	
}

?>
</div>
</div>        
<script>
	                 $(document).ready(function(){
	                     $(".setclick").click(function(){
	                 
	                 
	                 alert($(this).data("id"));
	                     });
	                 });
	                 </script>
	                 
	                 
<div class="card card-shadow mb-4 pt-0">
	                        				<div class="card-header">
	                        					<div class="custom-title-wrap bar-danger">
	                        						<div class="custom-title">Activity</div>
	                        						<a class="btn btn-success f4 ml-auto" href="/inclusive/datamanager/ajax/dsg.purpose.form.php?oid=<?php echo $object_id; ?>&function=add&type=activity">Create Activity</a>
	                        					</div>
	                        				</div>
	                        				<div class="card-body" id="activity_body">	                        			
	                        			Select a purpose to see related activities.			
	                        				</div>
	                        			</div>                                  
                                                    </div>
                                      </div>
      <?php }

	}


?>

