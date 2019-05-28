<?php
	function main() {
		global $db;
		$object_id=$_GET['dsr_id'];
		
		$statement = $db->prepare("select * from request_request_details where object_id = :id");
 		$statement->bindParam(':id', $id);
 		$statement->execute();
 		while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$id=$row['id'];
		$object_id=$row['object_id'];
		$subject_name=$row['subject_name'];
		$subject_email=$row['subject_email'];
		$request_type=$row['request_type'];
		$request_details=$row['request_details'];
		$date_created=$row['date_created'];
		$status=$row['status'];
		$identikey=$row['identikey'];

}
		
		?>
		<div class="portlet light ">
  <div class="portlet-title">
    <div class="caption">
      <i class="icon-settings font-dark"></i>
      <span class="caption-subject font-dark sbold uppercase">Viewing Data Subject Request</span>
    </div>
    <div class="portlet-body form">

      // CHANGE FORM ACTION
      <form class="form-horizontal" role="form" action="/controller/dtaform" method="POST">

        <div class="form-group">

          <div class="col-md-9">

          </div>
        </div>

		
		
		
<?php
		
		
		
		
	}
?>