<?php


function main() {
	global $db;
	global $errorcode;
	global $outcome;
	global $s_identikey;
	global $s_username;
?>
  <div class="m-heading-1 border-red m-bordered">
    <h3>Pending Subject Requests</h3>





  <div class="portlet-body" style="display: block;">
	<div class="table-scrollable">
		  <table class="table table-striped table-bordered table-advance table-hover">
			  <thead>
				  <tr>
					  <th>
						  <i class="fa fa-briefcase"></i> From </th>
					  <th class="hidden-xs">
						  <i class="fa fa-question"></i> Date Created </th>
					  <th>
						  <i class="fa fa-bookmark"></i> Status </th>
					  <th> </th>
				  </tr>
			  </thead>

    <tbody>

<?php
	// INSERT FETCH SQL STATEMENT

	$statement = $db->prepare("select * from request_request_details where identikey = :identikey and status='Open'");
	$statement->bindParam(':identikey', $s_identikey);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$object_id=$row['object_id'];
		$subject_name=$row['subject_name'];
		$subject_email=$row['subject_email'];
		$request_type=$row['request_type'];
		$request_details=$row['request_details'];
		$date_created=$row['date_created'];
		$status=$row['status'];

?>
                                                  <tr>
                                                      <td>
                                                       <?php echo $subject_name; ?>
                                                      </td>
                                                      <td>
                                                       <?php echo pb_format_date($date_created); ?>
                                                      </td>

                                                      <td>
                                                          <span class="label label-sm label-success label-mini"> <?php echo $status; ?> </span>
                                                      </td>
                                                      <td>
                                                          <a href="/controller/dsrview?dsrid=<?php echo $object_id;?>" class="btn dark btn-sm btn-outline sbold uppercase">
                                                              <i class="fa fa-edit"></i> View </a>
                                                         
                                                              
                                                      </td>
                                                  </tr>
                                              <?php
	}
?>
                                              </tbody>
                                          </table>
                                      </div>
                                  </div>
                                  
                                  
  </div>
                                  
                                    <div class="m-heading-1 border-blue m-bordered">
    <h3>Active Subject Requests</h3>





  <div class="portlet-body" style="display: block;">
                                      <div class="table-scrollable">
                                          <table class="table table-striped table-bordered table-advance table-hover">
                                              <thead>
                                                  <tr>
                                                      <th>
                                                          <i class="fa fa-briefcase"></i> From </th>
                                                      <th class="hidden-xs">
                                                          <i class="fa fa-question"></i> Date Created </th>
                                                      <th>
                                                          <i class="fa fa-bookmark"></i> Status </th>
                                                      <th> </th>
                                                  </tr>
                                              </thead>

    <tbody>

<?php
	// INSERT FETCH SQL STATEMENT

	$statement = $db->prepare("select * from request_request_details where identikey = :identikey and status='In Progress'");
	$statement->bindParam(':identikey', $s_identikey);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$object_id=$row['object_id'];
		$subject_name=$row['subject_name'];
		$subject_email=$row['subject_email'];
		$request_type=$row['request_type'];
		$request_details=$row['request_details'];
		$date_created=$row['date_created'];
		$status=$row['status'];

?>
                                                  <tr>
                                                      <td>
                                                       <?php echo $subject_name; ?>
                                                      </td>
                                                      <td>
                                                       <?php echo pb_format_date($date_created); ?>
                                                      </td>

                                                      <td>
                                                          <span class="label label-sm label-success label-mini"> <?php echo $status; ?> </span>
                                                      </td>
                                                      <td>
                                                          <a href="/controller/dsrview?dsrid=<?php echo $object_id;?>" class="btn dark btn-sm btn-outline sbold uppercase">
                                                              <i class="fa fa-edit"></i> View </a>
                                                      </td>
                                                  </tr>
                                              <?php
	}
?>
                                              </tbody>
                                          </table>
                                      </div>
                                  </div>


  </div>
 

  <?php
}
?>