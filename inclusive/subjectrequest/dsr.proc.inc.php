<?php

// permission type: owner, edit, view
if ($function=="add") {
	} else if ($function=="edit") {
pb_check_object_permission("dsr",$object_id,"userid",$s_username,"edit",$mode="simple");

	}
?>