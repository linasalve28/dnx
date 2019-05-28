<?php
	function main() {
		global $db;
		$question_object_id=$_GET['qoid'];
		$statement = $db->prepare("select * from assessment_risk where question_object_id='$question_object_id'");
 		$statement->execute();
 		
 		?>
 		
 		<table class="table table-striped table-bordered table-advance table-hover" width="650px">
                                              <thead>
                                                  <tr>
                                                      <th>
                                                          If Answers EQUALS </th>
                                                      <th class="hidden-xs">
                                                         Risk </th>
                                                      <th> Details
                                                            </th>
                                                      <th> Remediation</th>
                                                                                                            <th> </th>
                                                  </tr>
                                              </thead>
                                              
                                              <?php
	                                              
 		while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
echo $id=$row['id'];
$object_id=$row['object_id'];
$question_object_id=$row['question_object_id'];
$equal_to=$row['equal_to'];
 $risk_level=$row['risk_level'];
$risk_details=$row['risk_details'];
$risk_remediation=$row['risk_remediation'];
?>
<tr>
	
	         <td>
                     <?php echo $equal_to;?></td>
             <td>
                   <?php echo $risk_level;?>
             </td>
             <td>
                  <?php echo $risk_details;?>
             </td>
             <td>
                 <?php echo $risk_remediation;?>
             </td>
             <td><a class="" data-dismiss="modal" href="/ax/questionrisk?function=edit&object_id=<?php echo $object_id;?>" data-target="#ajax" data-toggle="modal">Edit</a>
             </td>
</tr>
                                   

<?php

}
?>
 		</table>
		<?php
		
	}
	
	
?>