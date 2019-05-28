<?php
// Core API functions for use by ConsentBase API
class ConsentBaseAPI
{
  public $prop1 = "I'm a class property!";
 
 public function register_consent($ident,$apikey) {

	// check if consent already exists

	$ident=sha1($ident);
	
	$query="select * from consent where ident='$ident'";

	// if no create consent record
	$query="insert into consent";
	return $unique_consent_key;

}

function check_consent(,$apikey) {


}

 
  public function getProperty()
  {
      return $this->prop1 . "<br />";
  }
}





<?php 

// $language_code['Transfer from']="Transfert à partir de";
?>