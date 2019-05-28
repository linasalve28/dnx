<?php
function main() { 
  ?>
<table width="100%" border="0"><tr><td>Company Name </td></tr><?php
global $db;
$statement = $db->prepare("select * from company");
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


?> <tr><td><a href="/controller.php?page=companyform&id=<?php echo $id;?>&function=edit"><?php echo $company_name;?></a></td></tr><?php
++$i;
} ?>
</table>

<?php
}
?>