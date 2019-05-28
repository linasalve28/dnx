<?php
// SQL IDENTIKEY CONFIRMED

function main() {
	global $db;
	global $errorcode;
	global $outcome;
	global $s_identikey;
	global $s_username;
	global $dev;
?>


  <div class="m-heading-1 border-green m-bordered">
    <h3>Data Breach</h3>
    <p>Log, monitor and respond to data breaches.
    </p>
  </div>



  <div class="portlet-body" style="display: block;">
                                      <div class="table">
                                          <table class="table table-striped table-bordered table-advance table-hover">
                                              <thead>
                                                  <tr>
                                                      <th>
                                                          Breach Summary </th>


                                                      <th> </th>
                                                  </tr>
                                              </thead>

    <tbody>
                                              <?php

	//                                              $statement = $db->prepare("select id,object_id,identikey,title,created_date,assess_id,description,instructions,unique_access_id from assessment_registry where identikey='$s_identikey'");


	$statement = $db->prepare("select * from databreach_registry");

	$statement->execute();

	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$id=$row['object_id'];
		$title=$row['title'];
		$created_date=$row['created_date'];
		$assess_id=$row['assess_id'];
		$description=$row['description'];
		$instructions=$row['instructions'];
		$unique_access_id=$row['unique_access_id'];

?>
                                                  <tr>
                                                      <td>
                                                       <?php echo $title;?>
                                                      </td>



                                                      <td>

                                                      <?php if ($dev) { ?>

                                                        <div class="btn-group">
                                                          <button class="btn red dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Options
                                                            <i class="fa fa-angle-down"></i>
                                                          </button>
                                                          <ul class="dropdown-menu">

                                                            <li>
                                                              <a href="/controller/assessment/form?aoid=<?php echo $id;?>&function=edit">Edit Assessment</a>
                                                            </li>

                                                            <li>
                                                              <a href="/controller/assessment/questionform?aoid=<?php echo $id;?>&function=add">Add Question</a>
                                                            </li>
                                                            <li>    <a href="/controller/assessment/requestform?aoid=<?php echo $id;?>&function=edit">Send Assessment Request</a></li>
                                                            <li>
                                                              <a href="/controller/assessment/preview?aoid=<?php echo $id;?>&function=add"> Preview  </a>
                                                            </li>
                                                            <li>
                                                              <a href="/controller/assessment/engage?aoid=<?php echo $id;?>"> Engage View </a>
                                                            </li>
                                                            <li>
                                                              <a href="/controller/assessment/questionlist?aoid=<?php echo $id;?>">  List Questions    </a>
                                                            </li>
                                                              <li class="divider"> </li>
                                                            <li>
                                                              <a href="javascript:;"> View Results </a>
                                                            </li>

                                                            <li>
                                                              <a href="/controller/assessment/responselist?aoid=<?php echo $unique_access_id;?>"> View Responses</a>
                                                            </li>

                                                            <li class="divider"> </li>
                                                          <li>
                                                            <li>
                                                              <a href="/controller/externalrequestform?aoid=<?php echo $id; ?>"> Send to Client</a>
                                                            </li>
                                                            <li>
                                                              <a href="javascript:;"> Suspend Assessment</a>
                                                            </li>
                                                          </li>
                                                            <li class="divider"> </li>
                                                          <li>
                                                            <li>
                                                              <a href="https://www.trustbase.com/v/v.php?id=<?php echo $unique_access_id;?>" target="_blank"> View Live on site</a>
                                                            </li>
                                                          </ul>
                                                        </div>
                                                        <?php } else { ?>

                                                                             <div class="btn-group">
                                                          <button class="btn red dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Options
                                                            <i class="fa fa-angle-down"></i>
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                                   <li>
                                                              <a href="/controller/questionform?aoid=<?php echo $id;?>&function=add">Add Question</a>
                                                            </li>
                                                            <li>
                                                              <a href="/controller/assessmentengage?aoid=<?php echo $id;?>&function=edit">Begin Assessment</a>
                                                            </li>
                                                            <li>
                                                              <a href="/controller/assessmentrequestform?aoid=<?php echo $id;?>&function=edit">Send Assessment Request</a>
                                                            </li>

                                                              <li class="divider"> </li>
                                                            <li>
                                                              <a href="javascript:;"> View Results </a>
                                                            </li>

                                                            <li>
                                                              <a href="/controller/assessmentresponselist?aoid=<?php echo $unique_access_id;?>"> View Responses</a>
                                                            </li>

                                                            <li>
                                                              <a href="/controller/externalrequestform?aoid=<?php echo $id; ?>"> Send to Client</a>
                                                            </li>



                                                          </ul>
                                                        </div>
                                                        <?php } ?>
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