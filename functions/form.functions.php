<?php
// ------------------------------------------- DATE BOX : UPDATE

function create_sixstar($i,$value,$defaultvalue) {
	?>
<select name="response[<?php echo $i;?>]">
<option value='6'>6 Stars - Perfect</option>
<option value='5'>5 Stars - Excellent</option>
<option value='4'>4 Stars - Good</option>
<option value='3'>3 Stars - Average</option>
<option value='2'>2 Stars - Poor</option>
<option value='1'>1 Star - Very Bad</option>
	</select>
<?php
}


function create_fivestar($i,$value,$defaultvalue) {
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



function create_date($id,$value,$defaultvalue) {
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

function create_normal_textbox($i,$title,$pref,$value) {
	if ($pref=="") {
		$pref="5";
	}
	echo "<textarea name='custom_field[$i]' rows='$pref' style='width:100% '>$value</textarea>";
}

// ------------------------------------------- TEXT FIELD


function create_textfield($i,$title,$pref,$value) {

	echo "<input name='response[$i]' type='text' size='$pref' value='$value' style='width:95%'>";

}
// ---- RADIO

function create_radio($i,$title,$pref,$value) {
		$items=explode(",",$pref);

	foreach ($items as $eachitem) {
		$eachitem=stripslashes($eachitem);
		echo "<input type='radio' name='response[$i]' value='$eachitem' id='response[$i].$eachitem'> <label for='response[$i].$eachitem'>$eachitem</label> ";
	}
	

}

// ------------------------------------------- CHECK BOX : checkbox_migration function query

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

function create_selectbox($i,$pref,$value) { 
echo "<select name='response[$i]' id='response[$i]'>";
echo "<option></option>";
	$items=explode(",",$pref);
	foreach ($items as $eachitem) {
		echo "<option value='$eachitem'>$eachitem</option>";
	}
 echo "</select>";
}

// ------------------------------------------- HIDDEN FIELD

function create_hidden_field($i,$pref) {
	echo "<input name='response[$i]' type='hidden' value='$pref' />";	
}


?>