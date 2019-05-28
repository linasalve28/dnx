<?php
	
function main() { ?>

	<div class="m-heading-1 border-green m-bordered">
    <h3>Databases</h3>
    <p> <br />
	    <a class="btn green-jungle" href="/controller/datascanform?function=add">Register New Database</a>
<a class="btn green-jungle" href="/controller/datascanform?function=add">Quick Scan Database</a>
    </p>
  </div>



  <div class="portlet-body" style="display: block;">
                                      <div class="table">
                                          <table class="table table-striped table-bordered table-advance table-hover">
                                              <thead>
                                                  <tr>
                                                      <th>
                                                          Databases </th>
                                                                  <th> Last Scan</th>
                                                      <th> </th>
                                                  </tr>
                                              </thead>

    <tbody>
                                              <?php
global $db;
    global $errorcode;
    global $outcome;
    global $s_identikey;
    global $s_username;


	$statement = $db->prepare("select * from datamanager_scan_database where identikey = :identikey");
	$statement->bindParam(':identikey', $s_identikey);
	$statement->execute();
	
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

		 $database_name=$row['database_name'];   
		 $object_id=$row['object_id'];   
		  $last_scan_date=$row['last_scan_date'];   
		  		
                                              ?>
                                           <tr>
                                                      <td>
                                                       <?php echo $database_name;?>
                                                      </td>       
                                                            <td>
                                                       <?php echo $last_scan_date;?>
                                                      </td>                                 
                                                      <td>
                                                        <div class="btn-group">
                                                          <button class="btn red dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Options
                                                            <i class="fa fa-angle-down"></i>
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                            <li>
                                                              <a href="/controller/dsgform?oid=<?php echo $object_id;?>&function=edit">Edit Data Subject Group</a>
                                                            </li>

                                              
                                                            <li>
                                                              <a href="/controller/assessmentpreview?oid=<?php echo $object_id;?>&function=add"> Add
                                                                                                            </a>
                                                            </li>
                                                                 <li>
                                                              <a href="/controller/assessmentengage?oid=<?php echo $object_id;?>"> Engage View
                                                                                                            </a>
                                                            </li>       

                                                            <li>
                                                              <a href="/controller/externalrequestform?aoid=<?php echo $id; ?>"> Send to Client</a>
                                                            </li>
                                                        
                         
                                          
                                                          <li>
                                                            <li>
                                                              <a href="https://www.trustbase.com/v/v.php?id=<?php echo $unique_access_id;?>" target="_blank"> View Live on site</a>
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