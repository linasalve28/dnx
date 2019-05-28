<?php
	
require(DB_ROOT."/tb.db.conn.php");
	
	
// Database Connect string
$username="amexiac_adcycle";
$password="rainbow";
$database_name="amexiac_";
$host="amexia.com";

$db = new PDO("mysql:host=$host;dbname=$database_name;charset=utf8", $username, $password, array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

// Keywords
$keywords=array("name","ssn","birth","email","phone","health","medical");
	
// This will list the tables in a database
		
$statement = $db->prepare("SHOW DATABASES");
$statement->execute();

while ($row = $statement->fetch(PDO::FETCH_NUM)){

	echo $row['0'];
	echo "<br />";
	echo "<br />";

$query="SHOW COLUMNS FROM ".$row['0'];
$statement_x = $db->prepare($query);
$statement_x->execute();

while ($row_x = $statement_x->fetch(PDO::FETCH_NUM)){
	echo "<input type='checkbox'>";
	 $row_x['0'];
	echo "<br />";
	$hash_collection=$row[0];
}
echo "<br />";




}


?>