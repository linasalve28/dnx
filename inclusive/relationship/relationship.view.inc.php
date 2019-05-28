<link href="../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

<?php
include(FS_ROOT_FUNCTIONS."/create.select.functions.php");
include(FS_ROOT_FUNCTIONS."/create.countrylist.php");
include(FS_COMPONENT_FILECONTROL."/process.php");
include(FS_CERTIFICATION_FUNCTIONS."/functions.php");

function main() {
  global $db;
  global $errorcode;
  global $outcome;
  global $s_identikey;
  global $s_username;
  global $s_userid;


  $function=$_GET['function'];
  $object_id=$_GET['id'];



// Check if user is permitted to view this item
pb_check_object_permission("dta",$object_id,"userid",$s_userid,"view");




    $statement = $db->prepare("select * from dta_registry where object_id = :object_id");
    $statement->bindParam(':object_id', $object_id);
    $statement->execute();
    
    
      $errcheck=$statement->rowCount();
      if ($errcheck==0) {
	      echo "DATA TRANSFER AGREEMENT NOT FOUND";
	      exit;
      }
    
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
      $id=$row['id'];
       $object_id=$row['object_id'];

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
  

  // If form submittion has been successful, display message.


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
  
 

  <div class="portlet light ">
    <div class="portlet-title">
      <div class="caption">
        <i class="icon-settings font-dark"></i>
        <span class="caption-subject font-dark sbold uppercase">Data Transfer Agreement <?php
	        
	        // This needs to be renabled to allow for an edit button to appear
	  //     if (pb_check_object_permission("dta",$object_id,"userid","","edit","advanced")==true) {
		  //     echo 'edit';
	   //    }
		        
		        ?></span>
      </div>
      <div class="portlet-body form">
        <form class="form-horizontal" role="form" action="/controller/dtaform" method="POST" enctype="multipart/form-data">

          <div class="form-group">

            <div class="col-md-9">

            </div>
          </div>


   <div class="form-group">
            <label class="col-md-3 control-label">Transfer Type</label>
            <div class="col-md-9" style="padding-top: 7px;">
	<?php if ($transfer_type=="TO") { echo "Outbound"; } else if ($transfer_type=="FROM") { echo "Inbound"; } ?>
            </div>
          </div>
          

          <div class="form-group">
            <label class="col-md-3 control-label">Transfer <?php if ($transfer_type=="TO") { echo "to"; } else if ($transfer_type=="FROM") { echo "from"; } ?>:</label>
            <div class="col-md-9" style="padding-top: 7px;">

<div class="ui-widget">
  <?php echo $errorcode["companies"]; ?>
<?php echo $target_company_name; ?>
</div>
 
            </div>
          </div>

          
          <!-- /input-group -->

          <div class="form-group">
            <label class="control-label col-md-3">Start Date</label>
            <div class="col-md-3" style="padding-top: 7px;">
   <?php echo $date_started; ?>
                       </div>
          </div>
          <!-- /input-group -->

          <!-- /input-group -->

          <div class="form-group">
            <label class="control-label col-md-3">Date Ended</label>
            <div class="col-md-3" style="padding-top: 7px;">
            
          <?php echo  $date_ended; ?>
                            </div>
          </div>
          <!-- /input-group -->
  
          </script>

          <div class="form-group">
            <label class="col-md-3 control-label">Cross Border Data Transfer : </label>
            <div class="col-md-9" style="padding-top: 7px;">
                  <?php 
	                  if ($cross_border_transfer=="yes") {
		                  
		                  echo "Yes";
		                  
	                  } else {
		                  
		                  echo "No";
	                  }
	                  ?>

            </div>
          </div>


<?php       if ($cross_border_transfer=="yes") { ?>
          <div class="form-group" id="origin">
            <label class="control-label col-md-3">Country of Origin</label>
            <div class="col-md-4" style="padding-top: 7px;">

<?php echo show_country_name($transfer_to_country); ?>

            </div>
          </div>

          <div class="form-group" id="destination">
            <label class="control-label col-md-3">Destination Country</label>
            <div class="col-md-4" style="padding-top: 7px;">

<?php echo show_country_name($transfer_from_country); ?>

            </div>
          </div>
<?php } ?>

          <!-- /input-group -->

          <div class="form-group">
            <label class="col-md-3 control-label">Details</label>
            <div class="col-md-9" style="padding-top: 7px;">

<?php echo $details;?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label">Transfer Status</label>
            <div class="col-md-9" style="padding-top: 7px;">
 <?php echo $transfer_status;?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label">Other Information</label>
            <div class="col-md-9" style="padding-top: 7px;">
       <?php echo $other_information;?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label">Certifications Required</label>
            <div class="col-md-9" style="padding-top: 7px;">
              <?php
	              $query="select * from dta_certification_dependency where parent_dta_object_id='$object_id'";
	              $statement = $db->prepare($query);
 		$statement->execute();

while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

	$id=$row['id'];
	 $parent_dta_object_id=$row['parent_dta_object_id'];


	$certification=$row['certification'];


if (certification_record_status($transfer_to_id,$certification)=="valid") {
	echo "<img src='/assets/img/valid.png' />";


	} else {
	echo "<img src='/assets/img/alert.png' />";

} 
echo " ".certification_name($certification);
echo "<br />";


}
	              
	              ?>
            </div>
          </div>
          
        
          
       
         

          <div class="form-group">
            <label class="col-md-3 control-label">Status</label>
            <div class="col-md-9">
	                                                                
            </div>
          </div>
          

          <div class="form-group">
            <label class="col-md-3 control-label">Policies</label>
            <div class="col-md-9"  style="padding-top: 7px;">
	     <?php file_control_list_files("dta",$object_id,"policy"); ?>
          </div>
          </div>
          
          
            <div class="form-group">
            <label class="col-md-3 control-label">Related Contracts</label>
            <div class="col-md-9"  style="padding-top: 7px;">
	        <?php file_control_list_files("dta",$object_id,"contract"); ?>
            </div>
          </div>

      </div>
    </div>
    <div class="form-actions">
      <div class="row">
        <div class="col-md-offset-3 col-md-9">

        </div>
      </div>
    </div>

        </form>
  </div>




<?php
	pb_system_log("View","DTA",$object_id);
  }
?>