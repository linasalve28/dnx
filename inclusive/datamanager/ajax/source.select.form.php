<?php require("include.php");
	
$statement = $db->prepare("select * from datamanager_sources where id = :id");
 		$statement->bindParam(':id', $id);
 		$statement->execute();

?>
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Select a Source</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    
    <div class="modal-body">
	    <ul>
 <?php
while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
$id=$row['id'];
$object_id=$row['object_id'];
$name=$row['title'];
$description=$row['description'];


echo "<li>$name</li>";
?>



<?php
}
?>
	    </ul>
          </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <input type="submit" value="Create Opportunity" class="btn btn-success">
    </div>
</form>
