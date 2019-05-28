<?php

// Version 2 Form Functions: April 2017

// ------------------------------------------- DATE BOX : UPDATE

//$i= A unique numerical id 
//$pref= a preference, could be rows for text field
//$value = value to set if edited

function create_fivestar($i,$pref,$value) {
?>
	<select name="response[<?php echo $i;?>]">
<option value='5'>5 Stars - Excellent</option>
<option value='4'>4 Stars - Good</option>
<option value='3'>3 Stars - Average</option>
<option value='2'>2 Stars - Poor</option>
<option value='1'>1 Star - Very Bad</option>
	</select>
<?php


}



function create_date($i,$pref,$value) {
?>


 <div class="input-group input-medium date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd M yyyy" data-date-viewmode="years">
                <input type="text" class="form-control" readonly value="<?php echo  $date_ended; ?>" name="response[<?php echo $i?>]" id="response[<?php echo $i; ?>]">
                <span class="input-group-btn">
                    <button class="btn default" type="button">
                      <i class="fa fa-calendar"></i>
                    </button>
                </span>
 </div>

<?php

}

// ------------------------------------------- TEXT BOX

function create_normal_textbox($i,$pref,$value) {
	if ($pref=="") {
		$pref="5";
	}
	echo "<textarea name='response[$i]' rows='$pref' style='width:100% '>$value</textarea>";
}

// ------------------------------------------- TEXT FIELD


function create_textfield($i,$pref,$value) {

	echo "<input name='response[$i]' type='text' size='$pref' value='$value' style='width:95%'>";


}
// ---- RADIO

function create_radio($i,$pref,$value) {
echo ;

	$items=explode(",",$pref);

	foreach ($items as $eachitem) {
		echo "<input type='radio' name='response[$i]' value='$eachitem' id='response[$i].$eachitem'> <label for='response[$i].$eachitem'>$eachitem</label><br>";
	}


}


// ------------------------------------------- HTML BOX




function yesno($title,$pref,$value,$i) {
	if ($pref=="") {
		$pref="5";
	}
	echo "<textarea name='custom_field[$i]' rows='$pref' style='width:100% '>$value</textarea>";

	echo "<script language='javascript1.2'>editor_generate('custom_field[$i]');</script> ";


}


// ------------------------------------------- CHECK BOX : checbox_migration function query

function create_checkbox($i,$pref,$value) {
	if (!$pref) {
		$pref=="checked";
	}
	if ($value) {
		$checked = $pref;
		$html_checked="checked='checked'";
	}

	$items=explode(",",$pref);

	foreach ($items as $eachitem) {
		echo "<input type=\"checkbox\" name=\"response[$i]\" value=\"$eachitem\"> ".$eachitem;
		echo "<br />";
	}






}

// ------------------------------------------- SELECT BOX

function create_selectbox($i,$pref,$value) { ?>
  <select name="response[<?php echo $i;?>]" id="<?php echo $i;?>">
<option></option>
<?php
	$items=explode(",",$pref);

	foreach ($items as $eachitem) {
		echo "<option value='$eachitem'>$eachitem</option>";
	}

?>
  </select>
<?php

}

?>