<?php


  function main() {
global $s_identikey;
global $s_username;
    ?>
  <div class="m-heading-1 border-green m-bordered">
    <h3>Data Transfers</h3>
    <p>
	    Data Transfers indicate the flow of data from your company, to another. Transfers can be across borders, and can affect the responisiblity for the data.
    </p>
      <p>
	      <a class="btn green-jungle" href="/controller/dtaform?function=add">Add New Data Transfer</a>
    </p>
  </div>



  <div class="portlet-body" style="display: block;">
                                      <div class="table">
                                          <table class="table table-striped table-bordered table-advance table-hover">
                                              <thead>
                                                  <tr>
                                                      <th>
                                                          <i class="fa fa-chevron-up"></i> Company </th>
                                                             <th>
                                                          <i class="fa fa-chevron-up"></i> Assessment </th>
                                                          
                                                      <th class="hidden-xs">
                                                          <i class="fa fa-chevron-down"></i> Contact Name</th>
                                                      <th>
                                                          <i class="fa fa-signal"></i> Date Created </th>
                                                      <th>Status </th>
                                                      <th> </th>
                                                  </tr>
                                              </thead>

    <tbody>
	    <script>
$(document).ready(function(){
    $(".delete").click(function(e){
	    	    event.preventDefault(e);
	    
	    if (confirm('Are you sure you wish to delete this Data Transfer Agreement?')) {
		    
	    var c=$(this).attr("data-id");
        $.ajax({url: "/ax/unidelete", data: { oid: c,otype: "dta"},success: function(result){
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
                                              <?php
	                                              
	                                              
                                            require_once("/home/trustbase/dbn/ro.tb.db.conn.php");
											$query="select * from external_request_registry where created_by_identikey='$s_identikey'";
                                            $statement = $ro_db->prepare($query);
                                            $statement->execute();


$errcheck=$statement->rowCount();
if ($errcheck==0) { ?>

<tr id="" >
                                                      <td colspan="4" align="center">
	                                                     No Assessment Requests were found. <a href="/controller/externalrequestform?function=add">Register a new data transfer</a>
                                                      </td>
</tr>

<?php
	}


                                            $dataconn = $statement->fetchAll(PDO::FETCH_ASSOC);
									  
                                            fore$length = count($array);
                                            
                                            for ($i = 0; $i < $length; $i++) {
                                            
                                              print $array[$i];
                                            
                                            }ach ($dataconn as $row){
                                            $id=$row['id'];
                                            $object_id=$row['object_id'];
                                            $name=$row['name'];
                                            $request_object_id=$row['request_object_id'];
                                            $company=$row['company'];
                                             $created_date=date('d F Y',strtotime($row['created_date']));
                                              $request_status=$row['request_status'];
                                     

                                                                                        ?>





                                                  <tr id="span<?php echo $object_id;?>">
                                                      <td>
	                                                      <?php echo $company; ?>
                                                      </td>
                                                      <td>
                                                                            <?php echo pb_uni_select_item("assessment_registry",$request_object_id); ?>                               </td>

                                                      <td>
                                                      <td>
                                                                            <?php echo $created_date; ?>                               </td>

                                                      <td>
	                                                <?php echo $name; ?>
	                                                
	                                                </td>
	                                                <td>
		                                    <?php echo $request_status; ?>    
	                                                </td>
                                                      <td>
                                                          <a href="/controller/dtaview?id=<?php echo $object_id;?>" class="btn dark btn-sm btn-outline sbold uppercase">
                                                              <i class="fa fa-edit"></i> View </a>
                                                   <div class="btn-group">
                                                          <button class="btn red dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Options
                                                            <i class="fa fa-angle-down"></i>
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                            <li>
                                                              <a href="/controller/dtaform?function=edit&id=<?php echo $object_id;?>">Edit </a>
                                                            </li>
                                                            
                                                            
                                                            
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