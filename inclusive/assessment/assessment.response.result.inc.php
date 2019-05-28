<?php

function chart_results($question_id) {

  $statement = $db->prepare("select response_data from response_item where question_id=:question_id");
  $statement->bindParam(':question_id', $question_id);
  $statement->execute();

  while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
  $response_data=$row['response_data'];
$response_data_collection[]=$response_data;
}

$count=array_count_values($results);
print_r($count);
}

  function main() {
    global $db;
    global $errorcode;
    global $outcome;
    global $s_identikey;
    global $s_username;
    ?>
  <div class="m-heading-1 border-green m-bordered">
    <h3>Responses</h3>
    <p>Data Transfers indicate the flow of data from your company, to another. Transfers can be across borders, and can affect the responisiblity for the data.

    </p>
  </div>



  <div class="portlet-body" style="display: block;">
                                      <div class="table">
                                          <table class="table table-striped table-bordered table-advance table-hover">
                                              <thead>
                                                  <tr>
                                                      <th>
                                                          <i class="fa fa-briefcase"></i> From </th>
                                                      <th class="hidden-xs">
                                                          <i class="fa fa-question"></i> To </th>
                                                      <th>
                                                          <i class="fa fa-bookmark"></i> Status </th>
                                                      <th> </th>
                                                  </tr>
                                              </thead>

    <tbody>


                                              <?php



 $assessment_id=$_GET['assessment_id'];

// First we get the Question ID that is the title
function title_data($response_code) {
  global $db;
$assessment_id=$_GET['assessment_id'];

  $statement = $db->prepare("select * from assessment_registry where unique_access_id='$assessment_id' order by id DESC");

  $statement->execute();
  while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
   $title_field=$row['title_field'];
  }

  $statement = $db->prepare("select * from assessment_response_item where response_code='$response_code' and question_id='$title_field' order by id DESC");
  $statement->execute();
  while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
return   $title_data=$row['response_data'];
  }





}







$statement = $db->prepare("select * from assessment_response where assessment_id='$assessment_id' order by id DESC");
echo "select * from assessment_response where assessment_id='$assessment_id' order by id DESC";
$statement->execute();


while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
$id=$row['id'];
$assessment_id=$row['assessment_id'];
$response_code=$row['response_code'];
$title=$row['title'];
$created_date=$row['created_date'];
$completed_date=$row['completed_date'];
$status=$row['status'];
$ip_address=$row['ip_address'];
$host_name=$row['host_name'];
$other_identifier=$row['other_identifier'];


                                            ?>



                                                  <tr>
                                                      <td>
                                                       <a href="/controller/assessmentresponseview?id=<?php echo $response_code;?>">
                                                         <?php echo title_data($response_code);?>

                                                       </a>
                                                      </td>
                                                      <td>
                                                       <?php echo date("h:i d M Y",strtotime($created_date));?>
                                                      </td>

                                                      <td>
                                                          <span class="label label-sm label-success label-mini"> <?php echo $certification_dependant_status; ?> </span>
                                                      </td>
                                                      <td>
                                                          <a href="/controller/dtaform?function=edit&id=<?php echo $id;?>" class="btn dark btn-sm btn-outline sbold uppercase">
                                                              <i class="fa fa-edit"></i> Edit </a>
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