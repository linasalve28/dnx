<?php
function main() {
	global $db;
	$object_id=$_GET['dsrid'];
	
	$statement = $db->prepare("select * from request_request_details where object_id = :id");
	$statement->bindParam(':id', $object_id);
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
        <span class="caption-subject font-dark sbold uppercase">Data Subject Request</span>
      </div>
      <div class="portlet-body form">
        <form class="form-horizontal" role="form" action="/controller/dtaform" method="POST" enctype="multipart/form-data">

          <div class="form-group">

            <div class="col-md-9">

            </div>
          </div>
		
		  <!-- /input-group -->

          <div class="form-group">
            <div class="col-md-3">Subject Name</div>
            <div class="col-md-3">
               <?php echo $subject_name; ?>
            </div>
          </div>
          <!-- /input-group -->
          
                      <div class="form-group">
            <div class="col-md-3">Date Created </div>
            <div class="col-md-3">
               <?php 
	               if ($date_created) {
	               echo date("d F Y  - h:i:s",strtotime($date_created)); 
	               } ?>
            </div>
          </div>
          <!-- /input-group -->
          
                    <div class="form-group">
            <div class="col-md-3">Subject Email</div>
            <div class="col-md-3">
               <?php echo $subject_email; ?>
            </div>
          </div>
          <!-- /input-group -->
          
               <div class="form-group">
            <div class="col-md-3">Request Type</div>
            <div class="col-md-3">
               <?php echo $request_type; ?>
            </div>
          </div>
          <!-- /input-group -->
          
                   <div class="form-group">
            <div class="col-md-3">Request Details</div>
            <div class="col-md-3">
               <?php echo $request_details; ?>
            </div>
          </div>
          <!-- /input-group -->
		
		
		             <div class="form-group">
            <div class="col-md-3">Status </div>
            <div class="col-md-3">
               <?php echo $status; ?>
            </div>
          </div>
          <!-- /input-group -->
	<?php
		
		
		
		
	}
?>	