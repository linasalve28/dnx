<?php
function pb_success_message($message) {
	echo "<div class=\"alert alert-success\"><strong>Success!</strong> $message </div>";
}

function system_response($message) { ?>

<div class="alert alert-success" id="system_response">
  <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
  <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
  <div><?php echo $message; ?></div>
  </div>

<?php
	   } 
?>