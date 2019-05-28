<link href="../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

<?php
/* 
include("/home/trustbase/servers/gateway.trustbase.com/functions/create.select.functions.php");
include("/home/trustbase/servers/gateway.trustbase.com/functions/create.countrylist.php");
include("/home/trustbase/servers/gateway.trustbase.com/component/filecontrol/process.php");
include("/home/trustbase/servers/gateway.trustbase.com/functions/dta/functions.php");
include("/home/trustbase/servers/gateway.trustbase.com/functions/certifications/functions.php");
 */
include_once(FS_ROOT_FUNCTIONS."/create.select.functions.php");
include_once(FS_ROOT_FUNCTIONS."/create.countrylist.php");
include_once(FS_COMPONENT_FILECONTROL."/process.php");
include_once(FS_DTA_FUNCTIONS."/functions.php");
include_once(FS_CERTIFICATION_FUNCTIONS."/functions.php");

function main(){
	global $db;
	global $errorcode;
	global $outcome;
	global $s_identikey;
	global $s_username;


	$function=$_GET['function'];
	$id=$_GET['id'];


	// If form submission detected, include the processing code
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		includeFS_INCLUSIVE_CERTIFICATION.("/certification.proc.inc.php");
	}



	if ($function=='edit' and $_SERVER['REQUEST_METHOD'] !== 'POST') {

		pb_check_object_permission("certification_record",$id,"userid","","edit");



		$statement = $db->prepare("select * from certification_record where object_id = :id");
		$statement->bindParam(':id', $id);
		$statement->execute();

		$errcheck=$statement->rowCount();

		if ($errcheck==0) {

			echo "A permission error has been detected";
			exit;

		}

		while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
			$id=$row['id'];
 $object_id=$row['object_id'];
$certification_details=$row['certification_details'];
$certification_start_date=$row['certification_start_date'];
$certification_expire_date=$row['certification_expire_date'];
$status_verified=$row['status_verified'];
$certification_other_data=$row['certification_other_data'];
$parent_system_certification_registry_object_id=$row['parent_system_certification_registry_object_id'];
$identikey=$row['identikey'];
$object_status=$row['object_status'];



			if ($certification_start_date) {
				$certification_start_date=date('d M Y', strtotime($certification_start_date));
			}

			if ($certification_expire_date) {
				$certification_expire_date=date('d M Y', strtotime($certification_expire_date));
			}
			
			
		
		}
	}

	// If form submittion has been successful, display message.
	if ($outcome=="success") {
		if ($function=="edit"){
			echo "<div class=\"alert alert-success\"><strong>Success!</strong> Certification Edited</div>";
		} else if ($function=="add") {
				echo "<div class=\"alert alert-success\"><strong>Success!</strong> Certification Registered</div>";
			}
	} else {

?>


  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>
  .ui-autocomplete-loading {
    background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
  }
  </style>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    function log( message ) {
	    // document.getElementById("birdid").value=message;
	      $("#company_id").val(message);
    }

    $( "#companies" ).autocomplete({
      source: "/dev/search3.php",
      minLength: 1,
      select: function( event, ui ) {
        log( ui.item.id );
      }
    });
  } );
  </script>






  <div class="portlet light ">
    <div class="portlet-title">
      <div class="caption">
        <i class="icon-settings font-dark"></i>
        <span class="caption-subject font-dark sbold uppercase">Certification</span>
      </div>
      <div class="portlet-body form">
        <form class="form-horizontal" role="form" action="/controller/certification/certform" method="POST" enctype="multipart/form-data">

          <div class="form-group">

            <div class="col-md-9">

            </div>
          </div>




          <div class="form-group">
            <label class="col-md-3 control-label">Certification</label>
            <div class="col-md-9">
  <div class="input-inline input-medium">
<select id="certification_select" name="certification_select" class="form-control">


<?php $certification_dependency=certification_list(""); ?>
	<option value="<?php echo $key;?>" <?php if ($function=="edit") { if ($parent_system_certification_registry_object_id==$key) { echo 'selected="selected"'; } } ?>><?php echo $value;?></option>
<?php
		foreach($certification_dependency as $key => $value)
		{
?>
<option value="<?php echo $key;?>" <?php if ($function=="edit") { if ($parent_system_certification_registry_object_id==$key) { echo 'selected="selected"'; } } ?>><?php echo $value;?></option>
  <?php
		}

?>

</select>
  </div>




            </div>
          </div>


          <!-- /input-group -->

          <div class="form-group">
            <label class="control-label col-md-3">Start Date</label>
            <div class="col-md-3">
              <div class="input-group input-medium date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd M yyyy" data-date-viewmode="years">
                <input type="text" class="form-control" readonly name="date_started" id="date_started" value="<?php echo  $certification_start_date; ?>">
                <span class="input-group-btn">
                    <button class="btn default" type="button">
                      <i class="fa fa-calendar"></i>
                    </button>
                  </span>
              </div>
            </div>
          </div>
          <!-- /input-group -->

          <!-- /input-group -->

          <div class="form-group">
            <label class="control-label col-md-3">Expiration Date</label>
            <div class="col-md-3">
              <div class="input-group input-medium date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd M yyyy" data-date-viewmode="years">
                <input type="text" class="form-control" readonly value="<?php echo  $certification_expire_date; ?>" name="date_ended" id="date_ended">
                <span class="input-group-btn">
                    <button class="btn default" type="button">
                      <i class="fa fa-calendar"></i>
                    </button>
                  </span>
              </div>
            </div>
          </div>
          <!-- /input-group -->

          <!-- /input-group -->
          <div class="form-group">
            <label class="col-md-3 control-label">Other Information</label>
            <div class="col-md-9">
              <input type="text" class="form-control" value="<?php echo $certification_other_data;?>" name="certification_other_data" id="other_information">
            </div>
          </div>
          <script>
$(document).ready(function(){
    $(".delete").click(function(e){
	    	    event.preventDefault(e);

	    if (confirm('Are you sure you wish to delete this file?')) {

	    var c=$(this).attr("data-id");
	    var p=$(this).attr("data-p");
        $.ajax({url: "/dev/ajax/source.php", data: { oid: c},success: function(result){
	       if (result=='success') {
$("#span"+c).remove();
} else {
	alert("An error occurred");

}

        }});


        } else {

        }
    });
});
</script>
              <script>

      $(document).ready(function(){
        $('.add_supporting_file').click(function(e){
          e.preventDefault();
          $(this).before("<input name='supporting_file[]' type='file'/><br />");
        });
      });


          </script>
          <div class="form-group">
            <label class="col-md-3 control-label">Supporting Documents</label>
            <div class="col-md-9">


	     <?php if ($function=="edit") { ?>
	     <?php file_control_list_files("certification_record",$object_id,"supporting","delete"); ?>
<?php } ?>
	      <input name="supporting_file[]" type="file" class=""/><br />
      <button type='button' class="add_supporting_file">+ Add More Files</button>


            </div>
          </div>


            <script>
      $(document).ready(function(){
        $('.add_policy_file').click(function(e){
          e.preventDefault();
          $(this).before("<input name='policy_file[]' type='file'/><br />");
        });
      });
    </script>
          <div class="form-group">
            <label class="col-md-3 control-label">Related Policies</label>
            <div class="col-md-9">


	     <?php if ($function=="edit") { ?>
	     <?php file_control_list_files("certification_record",$object_id,"policy","delete"); ?>
<?php } ?>
	      <input name="policy_file[]" type="file" class=""/><br />
      <button type='button' class="add_policy_file">+ Add More Files</button>


            </div>
          </div>



            </div>
    </div>



    <div class="form-actions">
      <div class="row">
        <div class="col-md-offset-3 col-md-9">
          <button type="submit" class="btn green">Save</button>
          <button type="button" class="btn default">Cancel</button>
        </div>
      </div>
    </div>
    <?php if ($function=="edit") { ?>
      <input type='hidden' id='id' name='id' value='<?php echo $object_id;?>'>
      <?php } ?>
        <input type='hidden' id='function' name='function' value='<?php echo $function; ?>'>
        </form>
  </div>




  <?php
	}
	pb_system_log("Form - ".$function,"Certifications",$object_id);
}
?>