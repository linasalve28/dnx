<?php
//require_once("/home/trustbase/servers/gateway.trustbase.com/functions/certifications/functions.php");
require_once(FS_CERTIFICATION_FUNCTIONS . "/functions.php");

function main() {
	pb_system_log("List","Certifications",$id);
	global $s_identikey;
	global $s_username;
	global $db;
?>
  <div class="m-heading-1 border-green m-bordered">
    <h3>Certifications</h3>
    <p>
	    The following are certifications are registered to your company.
    </p>
      <p>
	      <a class="btn green-jungle" href="/controller/certform?function=add">Register New Certification</a>
    </p>
  </div>

	    <script>
$(document).ready(function(){
    $(".delete").click(function(e){
	    	    event.preventDefault(e);

	    if (confirm('Are you sure you wish to delete this Certification record?')) {

	    var c=$(this).attr("data-id");
        $.ajax({url: "/ax/unidelete", data: { oid: c,otype: "certification_record"},success: function(result){
	        if (result=='success') {
$("#span"+c).remove();
} else {
	alert('An error occurred');
}
        }});


        } else {

        }
    });
});
</script>

  <div class="portlet-body" style="display: block;">
                                      <div class="table">
                                          <table class="table table-striped table-bordered table-advance table-hover">
                                              <thead>
                                                  <tr>
                                                      <th>
                                                          <i class="fa fa-shield"></i> Certification </th>
                                                      <th class="hidden-xs">
                                                          <i class="fa fa-calendar"></i> Expiration </th>
                                                      <th>
                                                          <i class="fa fa-check"></i> Status </th>
                                                      <th> </th>
                                                  </tr>
                                              </thead>

    <tbody>
    <?php
	$statement = $db->prepare("select * from certification_record where identikey='$s_identikey' and object_status='active'");
	$statement->execute();

	// If no certifications
	$errcheck=$statement->rowCount();
	if ($errcheck==0) { ?>

<tr id="" >
                                                      <td colspan="4" align="center">
	                                                     No registered certifications were found. <a href="/controller/certform?function=add">Register a new certification</a>
                                                      </td>
</tr>

<?php

	}




	$dataconn = $statement->fetchAll(PDO::FETCH_ASSOC);

	foreach ($dataconn as $row){
		$id=$row['id'];

		$object_id=$row['object_id'];
		$certification_name=$row['certification_name'];
		$certification_ident=$row['certification_ident'];
		$certification_seal_image=$row['certification_seal_image'];
		$certification_icon_image=$row['certification_icon_image'];
		$certification_link=$row['certification_link'];
		$certification_details=$row['certification_details'];
		$certification_start_date=$row['certification_start_date'];
		$certification_expire_date=$row['certification_expire_date'];
		$status_verified=$row['status_verified'];
		$parent_system_certification_registry_object_id=$row['parent_system_certification_registry_object_id'];
?>



                                            <tr id="span<?php echo $object_id;?>">
                                                      <td>
	                                                      <?php echo certification_name($parent_system_certification_registry_object_id); ?>
                                                      </td>
                                                      <td>


                          <?php if ($certification_expire_date) {
			echo  date('d F Y',strtotime($certification_expire_date));
?>
                                                      </td>

                                                      <td>
                                                          <?php
			
			
			if (strtotime($certification_expire_date) < strtotime("Today")) {
echo "<span class='label label-sm label-danger label-mini'>EXPIRED</span>";
}  else if (strtotime($certification_expire_date) < strtotime("+30 days")) {
				?> <span class="label label-sm label-warning label-mini"><?php
				echo "RISK: Nearing Expiration";
				?> </span><?php
			} else {
?>
		                           <span class="label label-sm label-success label-mini">
		                           <?php
				echo ucwords($status_verified);
				?> </span><?php
			}
		}
		?> <?php echo $certification_dependant_status; ?> </span>
                                                      </td>
                                                      <td>

                                                   <div class="btn-group">
                                                          <button class="btn red dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Options
                                                            <i class="fa fa-angle-down"></i>
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                            <li>
                                                              <a href="/controller/certform?function=edit&id=<?php echo $object_id;?>">Edit </a>
                                                            </li>
                                                              <li class="divider"> </li>
                                                            <li>
                                                        <a data-id="<?php echo $object_id;?>" class="delete">Delete</a>
                                                            </li>
                                                                                                                            </ul>
                                                        </div>
                                                      </td>
                                                  </tr>

                                              <?php
	}
?>
                                              </tbody>
                                          </table>
                                      </div>
                                  </div>




  <?php
}
?>