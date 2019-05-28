<?php


  function main() {
    global $db;
    global $errorcode;
    global $outcome;
    global $s_identikey;
    global $s_username;
    ?>
  <div class="m-heading-1 border-green m-bordered">
    <h3>SYSTEM TITLE</h3>
    <p>SYSTEM DESCRIPTION
      <a class="btn green-jungle" href="/controller/dtaform?function=add">Add New Data Transfer</a>
    </p>
  </div>



  <div class="portlet-body" style="display: block;">
                                      <div class="table-scrollable">
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
      // INSERT FETCH SQL STATEMENT   
                                            
                                            
?>



                                                  <tr>
                                                      <td>
                                                       <?php echo $transfer_from_id;?>
                                                      </td>
                                                      <td>
                                                       <?php echo $transfer_to_id; ?>
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