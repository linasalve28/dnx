<?php
function company_identikey_select($selectname,$select,$exclude="") {
  global $db;
echo "<select name=\"$selectname\" id=\"$selectname\" class=\"form-control\">";
echo "<option value=\"\"";
if (!$select) { echo " SELECTED"; }
echo "></option>";



  $statement = $db->prepare("select company_name,company_identikey,company_legal_name from company order by company_name");
  $statement->execute();


  while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
    $company_name=$row['company_name'];
    $company_identikey=$row['company_identikey'];
    $company_legal_name=$row['company_legal_name'];

echo "<option value=\"$company_identikey\"";

if ($select) {
	if ($company_identikey==$select) { echo "SELECTED"; }
}

echo ">$company_name ($company_legal_name)</option>";

}


echo "</select>";
}
?>