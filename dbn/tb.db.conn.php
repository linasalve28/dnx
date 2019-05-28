<?php


$db = new PDO('mysql:host=localhost;dbname=jdnxaorg_trustbase;charset=utf8', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));


function db_conn() {
  static $db = false;
  if (!$db) {
$db = new PDO('mysql:host=localhost;dbname=jdnxaorg_trustbase;charset=utf8', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  }
  return $db;
}

?>