<?php
	// Just a test to output submitted content
if(count($_POST)>0) {
	echo $_POST['question_text'];
	echo $_POST['selector'];
print_r($_POST['option']);
}
die();
?>