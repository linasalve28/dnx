<?php
function main() {
		pb_system_log("List","Autoenroll",$id);
  global $db;
?>

<div class="m-heading-1 border-green m-bordered">
    <h3>Auto Enrollment</h3>
    <p>  Auto Enrollment sends a request a company to register with Trustbase.   </p>
      
  </div>
  

<div class="table">
  <table class="table table-striped table-bordered table-advance table-hover">
                                    
                                              
	<tr><td>Company Name </td><td>Contact Name </td><td>Status </td></tr><?php
		$s_identikey=$_SESSION['s_identikey'];
$statement = $db->prepare("select * from autoenroll_registry where identikey='$s_identikey'");
  $statement->execute();
  $errcheck=$statement->rowCount();
if ($errcheck==0) { ?>

<tr id="" >
                                                      <td colspan="3" align="center">
	                                                     There are currently no suppliers pending auto enrollment for your company.
                                                      </td>
</tr>
<?php
	}
  
  while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
$id=$row['id'];

$company_name=$row['company_name'];
$contact_name=$row['contact_name'];
$status=$row['status'];

?> <tr><td><?php echo $company_name;?></td><td><?php echo $contact_name;?></td><td><?php echo $status;?></td></tr>
<?php
}
?>
</table>
</div>
<?php
}


?>