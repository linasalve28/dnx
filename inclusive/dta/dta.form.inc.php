<link href="../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

<?php
include(FS_ROOT_FUNCTIONS."/create.select.functions.php");
include(FS_ROOT_FUNCTIONS."/create.countrylist.php");
include(FS_ROOT_FUNCTIONS."/form.functions.php");
include(FS_COMPONENT_FILECONTROL."/process.php");
include(FS_DTA_FUNCTIONS."/functions.php");
include(FS_CERTIFICATION_FUNCTIONS."/functions.php");

function main() {
	global $db;
	global $errorcode;
	global $outcome;
	global $s_identikey;
	global $s_username;


	$function = $_GET['function'];
	$id = $_GET['id'];


	// If form submission detected, include the processing code
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		include(FS_INCLUSIVE_DTA."/dta.proc.inc.php");
	}
	
	if ($function=='edit' and $_SERVER['REQUEST_METHOD'] !== 'POST') {
		pb_check_object_permission("dta",$id,"userid","","edit");
		
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


			if ($transfer_type=="TO") {
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
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!--ls   <link rel="stylesheet" href="https://resources/demos/style.css">-->
  <style>
  .ui-autocomplete-loading {
    background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
  }
  </style>
  <!-- ls<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
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

  });
  </script>

<div class="portlet light ">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-settings font-dark"></i>
			<span class="caption-subject font-dark sbold uppercase">Data Transfer Agreement</span>
		</div>
		<div class="portlet-body form">
			<form class="form-horizontal" role="form" action="/controller/dta/dtaform?function=add" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<div class="col-md-9">

				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">Transfer Type</label>
				<div class="col-md-9">
					<div class="ui-widget">
					<?php
						if ($transfer_type=="FROM") {
							$from_html='checked="checked"';
						} else {
							$to_html='checked="checked"';
						}
					?>
						<input type="radio" name="transfer_type" class="" value="TO" id="TO" <?php echo $to_html;?>> <label for="TO">Inbound</label><br>
						<input type="radio" name="transfer_type" class="" value="FROM" id="FROM" checked="checked" <?php echo $from_html;?>> <label for="FROM">Outbound</label><br>
					</div>
				</div>
			</div>

			<div class="form-group">
			<label class="col-md-3 control-label"></label>
            <div class="col-md-9">
                <div class="ui-widget">
                <label for="companies">The company / organization this data transfer is being formed with or <a href="/controller/autoenrollform?function=add">add a new company</a></label>
                    <?php if(isset($errorcode["company_name"])){echo $errorcode["company_name"];} ?>
                    <input id="companies" name="companies" class="form-control" placeholder="Start typing company name..." value="<?php
                    /* if ($target_companyname) { echo $target_company_name; } else { echo $_POST['companies']; } ?>">*/
                    if ($target_company_name) { echo $target_company_name; } else { echo $_POST['companies']; } ?>">
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
			<label class="control-label col-md-3">Start Date</label>
				<div class="col-md-3">
					<div class="input-group input-medium date date-picker" data-date="<?php echo $date_started; ?>" data-date-format="dd M yyyy" data-date-viewmode="years">
				  <!--
					  <input type="text" class="form-control" readonly name="date_started" id="date_started" value="<?php echo $date_started; ?>">
					-->
						<input type="text" class="form-control" readonly name="date_started" id="date_started" value="<?php echo $date_started; ?>">
						<span class="input-group-btn" id="cal_date_started">
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
			<label class="control-label col-md-3">Date Ended</label>
				<div class="col-md-3">
					<div class="input-group input-medium date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd M yyyy" data-date-viewmode="years">
						<input type="text" class="form-control" uib-datepicker="dd-M-yyyy" readonly value="<?php echo  $date_ended; ?>" name="date_ended" id="date_ended">
						<span class="input-group-btn" id="cal_date_ended">
						<button class="btn default" type="button">
							<i class="fa fa-calendar"></i>
						</button>
						</span>
					</div>
				</div>
			</div>
			<!-- /input-group -->
			<script>
			$(document).ready(function() {
                alert('hello');
			  $("#int_border").click(function() {
				$("#origin").toggle();
				$("#destination").toggle();
			  });
                //Aline-date-picker
                $('#date_started').datepicker({
                    orientation: "bottom auto",
                    dateFormat: 'dd M yy',
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                });
                //call the calendar through the icon
                $("#cal_date_started").click(function() {
                    $('#date_started').datepicker('show');
                });
                //input field working with datepicker when clicked
                $('#date_ended').datepicker({
                    orientation: "bottom auto",
                    dateFormat: 'dd M yy',
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                });
                //call the calendar through the icon
                $("#cal_date_ended").click(function() {
                    $('#date_ended').datepicker('show');
                });

			});
			</script>

			<div class="form-group">
				<label class="col-md-3 control-label"></label>
				<div class="col-md-9">
					<div class="checkbox-list">
						<label> <?php if(isset($errorcode["cross_border_transfer"])){echo $errorcode["cross_border_transfer"];} ?>
						<span class=""><input type="checkbox" id='int_border' id="cross_border_transfer" name="cross_border_transfer" value="yes" <?php if ($cross_border_transfer=="yes") { echo "checked"; } ?>></span> Cross Border Data Transfer </label>
					</div>
				</div>
			</div>

			<div class="form-group" id="origin" <?php if ($cross_border_transfer!=="yes") { echo "style=\"display:none;\""; } ?>>
				<label class="control-label col-md-3">Origin</label>
				<div class="col-md-4">
                    <?php if(isset($errorcode["transfer_to_country"])){echo $errorcode["transfer_to_country"];} ?>
                    <?php echo pb_create_countrylist("transfer_to_country",$transfer_to_country); ?>
				</div>
			</div>

			<div class="form-group" id="destination" <?php if ($cross_border_transfer!=="yes") { echo "style=\"display:none;\""; } ?>>
				<label class="control-label col-md-3">Destination</label>
				<div class="col-md-4">
                    <?php if(isset($errorcode["transfer_from_country"])){echo $errorcode["transfer_from_country"];} ?>
                    <?php echo pb_create_countrylist("transfer_from_country",$transfer_from_country); ?>
				</div>
			</div>

			<!-- /input-group -->

			<div class="form-group">
				<label class="col-md-3 control-label">Describe the type of data being transferred and the reason</label>
				<div class="col-md-9">
                    <?php if(isset($errorcode["details"])){echo $errorcode["details"];} ?>
                    <textarea class="form-control"  name="details" id="details" rows="3"><?php echo $details;?></textarea>

				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">Other Information</label>
				<div class="col-md-9">
				  <input type="text" class="form-control" value="<?php echo $other_information;?>" name="other_information" id="other_information">

				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">Certification Dependency</label>
				<div class="col-md-9">

                    <!--
                    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
                    <script type="text/javascript" src="js/jquery.min.js"></script>
                    <script type="text/javascript" src="js/bootstrap.min.js"></script>

                    <script type="text/javascript" src="<?php echo WS_ASSETS;?>/custom/multiselect.js"></script>
                    <link rel="stylesheet" type="text/css" href="<?php echo WS_ASSETS;?>/custom/multiselect.css">
                    -->

					<script type='text/javascript'>
						$(document).ready(function() {
						    alert('hello2');

                            $('.add_policy_file').click(function(e){
                                alert('add policy file');
                                 e.preventDefault();
                                $(this).before("<input name='policy_file[]' type='file'/><br />");
                            });

							$('#certification_dependency').multiselect();
                            $(".delete").click(function(e){
                                event.preventDefault(e);
                                if (confirm('Are you sure you wish to delete this file?')) {
                                    var c=$(this).attr("data-id");
                                    var p=$(this).attr("data-p");
                                    $.ajax({url: "/dev/ajax/source.php", data: { oid: c},success: function(result){
                                            if (result=='success'){
                                                $("#span"+c).remove();
                                            } else {
                                                alert("An error occurred");
                                            }

                                        }
                                    });
                                } else {

                                }
                            });
						});

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

			<div class="form-group">
				<label class="col-md-3 control-label">Status</label>
				<div class="col-md-9">
					<div class="input-inline input-medium">
					<select class="form-control" name="status">
						<option selected="selected">Draft</option>
						<option>Active</option>
					</select>

                    <script type='text/javascript'>
                        /*
                        $(document).ready(function() {


                            $(".delete").click(function(e){
                                event.preventDefault(e);
                                if (confirm('Are you sure you wish to delete this file?')) {
                                    var c=$(this).attr("data-id");
                                    var p=$(this).attr("data-p");
                                    $.ajax({url: "/dev/ajax/source.php", data: { oid: c},success: function(result){
                                            if (result=='success'){
                                                $("#span"+c).remove();
                                            } else {
                                                alert("An error occurred");
                                            }

                                        }
                                    });
                                } else {

                                }

                            });
						}); */
					</script>
					</div>
				</div>
			</div>

             <script type='text/javascript'>
				$(document).ready(function(){
                    alert('hello4');


				});
			</script>

			<div class="form-group">
				<label class="col-md-3 control-label">Policies</label>
				<div class="col-md-9">
					<?php if ($function=="edit") { ?>

						<?php file_control_list_files("dta",$id,"policy","delete"); ?>

					<?php } ?>
					<input name="policy_file[]" type="file" class=""/><br />
					<button type='button' class="add_policy_file">+ Add More Files</button>
				</div>
			</div>

            <script type='text/javascript'>
				$(document).ready(function(){
					$('.add_contract_file').click(function(e){
						e.preventDefault();
						$(this).before("<input name='contract_file[]' type='file'/><br />");
					});
				});
			</script>

			<div class="form-group">
				<label class="col-md-3 control-label">Related Contracts</label>
				<div class="col-md-9">

					<?php if ($function=="edit") { ?>

						<?php file_control_list_files("dta",$id,"contract","delete"); ?>
                    <?php } ?>
					<input name="contract_file[]" type="file" class=""/><br />
					<button type='button' class="add_contract_file">+ Add More Files</button>

				</div>
			</div>

		</div>
	</div>


<div class="form-actions">
	<div class="row">
		<div class="col-md-offset-3 col-md-9">
			<button type="submit" class="btn green">Save</button>
			<a href="/controller/dtalist"><button type="button" class="btn default">Cancel</button></a>
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