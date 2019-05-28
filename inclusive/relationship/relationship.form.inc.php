<link href="../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

<?php
 

include( FS_ROOT_FUNCTIONS."/create.select.functions.php");
include( FS_ROOT_FUNCTIONS."/create.countrylist.php");
include( FS_COMPONENT_FILECONTROL."/process.php");
include( FS_DTA_FUNCTIONS."/functions.php");
include( FS_CERTIFICATION_FUNCTIONS."/functions.php");  

function main() {
	global $db;
	global $errorcode;
	global $outcome;
	global $s_identikey;
	global $s_username;


	$function=$_GET['function'];
	$id=$_GET['id'];


	// If form submission detected, include the processing code
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		include(FS_INCLUSIVE_RELATIONSHIP."/relationship.proc.inc.php");
	}
	
	if ($function=='edit' and $_SERVER['REQUEST_METHOD'] !== 'POST'){
		
		pb_check_object_permission("relationship",$id,"userid","","edit");
		$statement = $db->prepare("select * from dta_registry where object_id = :id");
		$statement->bindParam(':id', $id);
		$statement->execute();

		$errcheck=$statement->rowCount();

		if ($errcheck==0) {
			echo "A permission error has been detected";
			exit;
		}
		
		while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
			
			$id=$row['object_id'];
			$data_transfer_id=$row['data_transfer_id'];
			$transfer_from_id=$row['transfer_from_id'];
			$transfer_to_id=$row['transfer_to_id'];
			$date_started=$row['date_started'];
			$date_ended=$row['date_ended'];
			$transfer_type=$row['transfer_type'];


			if ($transfer_type=="TO"){
				$target_company_name=pb_getCompanyNameIdentikey($transfer_to_id);
				$target_company_id=$transfer_to_id;
			} else {
				$target_company_name=pb_getCompanyNameIdentikey($transfer_from_id);
				$target_company_id=$transfer_from_id;
			}

			if ($date_started) {
				$date_started=date('d M Y', strtotime($date_started));
			}

			if ($date_ended) {
				$date_ended=date('d M Y', strtotime($date_ended));
			}
			$details=$row['details'];
			$transfer_status=$row['transfer_status'];
			$other_information=$row['other_information'];
			$certification_dependant=$row['certification_dependant'];
			$certification_dependant_status=$row['certification_dependant_status'];
			$cross_border_transfer=$row['cross_border_transfer'];
			$transfer_from_country=$row['transfer_from_country'];
			$transfer_to_country=$row['transfer_to_country'];
		}
	}

	// If form submittion has been successful, display message.
	if ($outcome=="success") {
		if ($function=="edit"){
			echo "<div class=\"alert alert-success\"><strong>Success!</strong> Data Transfer Agreement Edited </div>";
		} else if ($function=="add") {
				echo "<div class=\"alert alert-success\"><strong>Success!</strong> Data Transfer Agreement Created </div>";
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
      minLength: 2,
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
        <span class="caption-subject font-dark sbold uppercase">Relationship</span>
      </div>
      <div class="portlet-body form">
        <form class="form-horizontal" role="form" action="/controller/relationshipform" method="POST" enctype="multipart/form-data">

          <div class="form-group">

            <div class="col-md-9">

            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-9">

<div class="ui-widget">
  <label for="companies">The company / organization this relationship is being formed with or <a href="/controller/autoenrollform?function=add">add a new company</a></label>
  <?php echo $errorcode["companies"]; ?>
  <input id="companies" name="companies" class="form-control" placeholder="Start typing company name..." value="<?php 
	  
	  if ($target_companyname) { echo $target_company_name; } else { echo $_POST['companies']; } ?>">
</div>

  <input type=hidden id="company_id" name="company_id" value="<?php 
	  if ($target_company_id) {
	  echo $target_company_id;
	  } else {
		  echo $_POST['company_id'];
	  }  
  ?>">
              <?php //company_identikey_select("transfer_from_id",$transfer_from_id,$exclude); ?>
            </div>
          </div>

          <!-- /input-group -->

          <div class="form-group">
            <label class="col-md-3 control-label">Notes</label>
            <div class="col-md-9">
              <?php echo $errorcode["details"]; ?>
                <textarea class="form-control"  name="details" id="details" rows="3"><?php echo $details;?></textarea>

            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label">Certification Dependency</label>
            <div class="col-md-9">



      <script type="text/javascript" src="/assets/custom/multiselect.js"></script>
 <link rel="stylesheet" type="text/css" href="/assets/custom/multiselect.css">



<script type='text/javascript'>//<![CDATA[

 $(document).ready(function() {
     $('#certification_dependency').multiselect();

});
//]]>

</script>


<select id="certification_dependency" name="certification_dependency[]" multiple="multiple">
	
<?php $certification_dependency=certification_list("data"); 
	
foreach($certification_dependency as $key => $value)
{
 ?>
<option value="<?php echo $key;?>" <?php if ($function=="edit") { if (check_certification_dependency($key,$id)) { echo 'selected="selected"'; } } ?>><?php echo $value;?></option>
  <?php
}
	
?>

</select>

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
      <input type='hidden' id='id' name='id' value='<?php echo $id;?>'>
      <?php } ?>
        <input type='hidden' id='function' name='function' value='<?php echo $function; ?>'>
        </form>
  </div>




  <?php
	}
	pb_system_log("Form - ".$function,"DTA",$id);
}
?>
