<?php

function main() {
	pb_system_log("Autoenroll Form ".$function,"AutoEnroll",$id);
	global $db;
	global $errorcode;
	global $outcome;

	$function=$_GET['function'];
	$id=$_GET['id'];

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		include(FS_INCLUSIVE_AUTOENROLL."/autoenroll.proc.inc.php");
	}

	if ($outcome=="success") {
		echo "<div class=\"alert alert-success\"><strong>Success!</strong> Enrollment Created </div>";
	} else {

		?>

		<div class="portlet light ">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-settings font-dark"></i>
					<span class="caption-subject font-dark sbold uppercase">Auto Enroll Company</span>
				</div>
			</div>
			<div class="portlet-body form">
				<form action="/controller/autoenrollform?function=add" method="post" class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-md-3 control-label">Company Name</label>
						<div class="col-md-9">
							<?php if(isset($errorcode['company_name'])) { echo $errorcode['company_name'];} ?>
							<input type='text' class="form-control" name='company_name' id='company_name' size='45' value='<?php echo $_POST['company_name'];?>'>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Contact name</label>
						<div class="col-md-9">
							<?php if(isset($errorcode['contact_name'])) { echo $errorcode['contact_name'];} ?>
							<input type='text' class="form-control" name='contact_name' id='contact_name' size='45' value='<?php echo $_POST['contact_name'];?>'>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Contact Email</label>
						<div class="col-md-9">
							<?php if(isset($errorcode['contact_email'])) { echo $errorcode['contact_email'];} ?>
							<input type='text' class="form-control" name='contact_email' id='contact_email' size='45' value='<?php echo $_POST['contact_email'];?>'>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Details</label>
						<div class="col-md-9">
							<input type='text' name='details' id='details' size='45' value='<?php echo $_POST['details'];?>'>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label"></label>
						<div class="col-md-9">
							<button type="submit" class="btn green">Submit</button>
				</form>
			</div>
		</div>

		<?php
	}
}
?>