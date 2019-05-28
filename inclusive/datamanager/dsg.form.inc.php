<?php
// Data subject request form.
include(FS_ROOT_FUNCTIONS."/create.select.functions.php");
include(FS_ROOT_FUNCTIONS."/create.countrylist.php");

function main() {

	global $db;
	global $errorcode;
	global $outcome;
	global $s_identikey;
	global $s_username;
	$errorcode=[];

	$function=$_GET['function'];
	$id=$_GET['id'];

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		include(FS_INCLUSIVE_DATAMANAGER."/dsg.proc.inc.php");
	}

	if ($function=='edit' and $_SERVER['REQUEST_METHOD'] !== 'POST') {


		$object_id=$_GET['oid'];
		if (!$object_id) { echo "Unknown Data Subject Group"; exit; }

		$statement = $db->prepare("select * from datamanager_data_subject_group where object_id = :object_id");
		$statement->bindParam(':object_id', $object_id);
		$statement->execute();
		while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
			$object_id=$row['object_id'];
			$identikey=$row['identikey'];
			$name=$row['name'];
			$description=$row['description'];
			$country=$row['country'];

		}

	}

	// If form submittion has been successful, display message.

	if ($outcome=="success") {
		if ($function=="edit"){
			echo "<div class=\"alert alert-success\"><strong>Success!</strong> Data Subject Group Edited </div>";
		} else if ($function=="add") {
			echo "<div class=\"alert alert-success\"><strong>Success!</strong> Data Subject Group  Created </div>";
		}
	} else {

			?>

			<div class="portlet light ">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-settings font-dark"></i>
						<span class="caption-subject font-dark sbold uppercase">Data Subject Group</span>
					</div>

					<div class="portlet-body form">
						<form class="form-horizontal" role="form" action="/controller/datamanager/dsgform?function=add" method="POST">
							<div class="form-group">
								<div class="col-md-9">

								</div>
							</div>

							<table width="100%" border="0">
								<div class='form-group'>
									<label class='col-md-3 control-label'>Name</label>
									<div class='col-md-9'>
										<?php 
										
											echo $errorcode['name'];
										
											?>
										<input type='text' class='form-control' value='<?php echo $name;?>' name='name' id='name'>

									</div>
								</div>
								<div class='form-group'>
									<label class='col-md-3 control-label'>Description</label>
									<div class='col-md-9'>
										<?php 
										
											?>
										<input type='text' class='form-control' value='<?php echo $description;?>' name='description' id='description'>

									</div>
								</div>
								<?php if ($function=="edit") { ?>
									<input type='hidden' id='id' name='id' value='<?php echo $object_id;?>'>
								<?php } ?>
								<input type='hidden' id='function' name='function' value='<?php echo $function; ?>'>

								<div class='form-group'>
									<label class='col-md-3 control-label'>Country</label>
									<div class='col-md-4'>
										<?php 
											if ($errorcode['country']) {
											echo $errorcode['country']; 
											}
											

?>
										<?php pb_create_countrylist("country",$country); ?>
									</div>
								</div>
							</table>
					</div>
				</div>
				<div class="form-actions">
					<div class="row">
						<div class="col-md-offset-3 col-md-9">
							<button type="submit" class="btn green">
								<?php if ($function=="edit") {
									echo "Save Changes";
								} else if ($function=="add") {
									echo "Create Data Subject Group";
								} ?>
							</button>
							<button type="button" class="btn default">Cancel</button>
						</div>
					</div>
				</div>

				</form>
			</div>

			<?php
		}
	}

?>