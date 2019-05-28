<?php
function main() {

  $function=$_GET['function'];
  $id=$_GET['id'];


global $db;

if ($function=="edit") {
  $statement = $db->prepare("select * from company where id = :id");
    $statement->bindParam(':id', $id);
   		$statement->execute();
   		while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
  $id=$row['id'];
  $company_name=$row['company_name'];
  $company_legal_name=$row['company_legal_name'];
  $company_ident=$row['company_ident'];
  $company_logo=$row['company_logo'];
  $company_description=$row['company_description'];
  $company_facebook=$row['company_facebook'];
  $company_twitter=$row['company_twitter'];
  $company_linkedin=$row['company_linkedin'];
  $contact_phone=$row['contact_phone'];
  $contact_address=$row['contact_address'];
  $contact_email=$row['contact_email'];
  $company_followers=$row['company_followers'];
  $view_count=$row['view_count'];
  $trust_rating=$row['trust_rating'];
  $performance_rating=$row['performance_rating'];
  $created_date=$row['created_date'];
  $last_modified=$row['last_modified'];
  $last_content=$row['last_content'];

}
  }
?>

  <form>
  <table width="100%" border="0" cellspacing="2">
  <tr>
  <td>Id </td>
  <td><input type='text' name='id' id='id' size='45' value='<?php echo $id;?>'></td>
  </tr>

  <tr>
  <td>Company Name </td>
  <td><input type='text' name='company_name' id='company_name' size='45' value='<?php echo $company_name;?>'></td>
  </tr>

  <tr>
  <td>Company Legal_name </td>
  <td><input type='text' name='company_legal_name' id='company_legal_name' size='45' value='<?php echo $company_legal_name;?>'></td>
  </tr>

  <tr>
  <td>Company Ident </td>
  <td><input type='text' name='company_ident' id='company_ident' size='45' value='<?php echo $company_ident;?>'></td>
  </tr>

  <tr>
  <td>Company Logo </td>
  <td><input type='text' name='company_logo' id='company_logo' size='45' value='<?php echo $company_logo;?>'></td>
  </tr>

  <tr>
  <td>Company Description </td>
  <td><input type='text' name='company_description' id='company_description' size='45' value='<?php echo $company_description;?>'></td>
  </tr>

  <tr>
  <td>Company Facebook </td>
  <td><input type='text' name='company_facebook' id='company_facebook' size='45' value='<?php echo $company_facebook;?>'></td>
  </tr>

  <tr>
  <td>Company Twitter </td>
  <td><input type='text' name='company_twitter' id='company_twitter' size='45' value='<?php echo $company_twitter;?>'></td>
  </tr>

  <tr>
  <td>Company Linkedin </td>
  <td><input type='text' name='company_linkedin' id='company_linkedin' size='45' value='<?php echo $company_linkedin;?>'></td>
  </tr>

  <tr>
  <td>Contact Phone </td>
  <td><input type='text' name='contact_phone' id='contact_phone' size='45' value='<?php echo $contact_phone;?>'></td>
  </tr>

  <tr>
  <td>Contact Address </td>
  <td><input type='text' name='contact_address' id='contact_address' size='45' value='<?php echo $contact_address;?>'></td>
  </tr>

  <tr>
  <td>Contact Email </td>
  <td><input type='text' name='contact_email' id='contact_email' size='45' value='<?php echo $contact_email;?>'></td>
  </tr>

  <tr>
  <td>Company Followers </td>
  <td><input type='text' name='company_followers' id='company_followers' size='45' value='<?php echo $company_followers;?>'></td>
  </tr>

  <tr>
  <td>View Count </td>
  <td><input type='text' name='view_count' id='view_count' size='45' value='<?php echo $view_count;?>'></td>
  </tr>

  <tr>
  <td>Trust Rating </td>
  <td><input type='text' name='trust_rating' id='trust_rating' size='45' value='<?php echo $trust_rating;?>'></td>
  </tr>

  <tr>
  <td>Performance Rating </td>
  <td><input type='text' name='performance_rating' id='performance_rating' size='45' value='<?php echo $performance_rating;?>'></td>
  </tr>

  <tr>
  <td>Created Date </td>
  <td><input type='text' name='created_date' id='created_date' size='45' value='<?php echo $created_date;?>'></td>
  </tr>

  <tr>
  <td>Last Modified </td>
  <td><input type='text' name='last_modified' id='last_modified' size='45' value='<?php echo $last_modified;?>'></td>
  </tr>

  <tr>
  <td>Last Content </td>
  <td><input type='text' name='last_content' id='last_content' size='45' value='<?php echo $last_content;?>'></td>
  </tr>

  </table><input type='hidden' id='id' name='id' value='$id'><input type='hidden' id='function' name='function' value='<?php echo $function; ?>'>
    <input type="submit" value="Save"></form>

<?php
}

?>