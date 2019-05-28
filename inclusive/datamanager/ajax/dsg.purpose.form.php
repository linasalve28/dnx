	 <?php $type=$_GET['type']; ?>
<form class="f1dfsdfdsfdsfsd" id="create_opp_form" name="create_opp_form" action="/inclusive/datamanager/ajax/dsg.purpose.create.proc.php" method="post">


    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><? echo $type; ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    
    <div class="modal-body">


<div class='form-group'>
	<label class='col-md-3 control-label'><?php echo ucwords($type); ?> Name</label>
		<div class='col-md-9'>
			<input type='text' class='form-control' value='<?php echo $name;?>' name='name' id='name'>
			</div>
				</div>

<div class='form-group'>
	<label class='col-md-3 control-label'><?php echo ucwords($type); ?> Description</label>
		<div class='col-md-9'>

			<input type='text' class='form-control' value='<?php echo $description;?>' name='description' id='description'>
			<input type="hidden" id="dsg_id" name="dsg_id" value="<?php echo $_GET['oid']; ?>">
			<? 
			
			if ($type=="purpose") { ?>
				<input type="hidden" id="type" name="type" value="purpose">			
			<? } else  { ?>
				<input type="hidden" id="type" name="type" value="activity">			
			<?php } ?>
			</div>
				</div>
          </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <input type="submit" value="Created <?php echo ucwords($type); ?>" class="btn btn-success">
    </div>
</form>
<script>
document.getElementById("purpose_name").focus();
</script>
