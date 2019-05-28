<?php
// ------------------------------------------- DATE BOX : UPDATE

function question_field_display($question_type,$qoid,$preset_data,$option_data="",$allow_other="No") {

	if ($question_type=="Text") {

		create_textfield($qoid,$preset_data,$option_data);

	} else if ($question_type=="SelectBox") {

			create_selectbox($qoid,$preset_data,$option_data);

		} else if ($question_type=="Radio") {

			create_radio($qoid,$preset_data,$option_data,$allow_other);

		} else if ($question_type=="TextArea") {

			create_textbox($qoid,$preset_data,$option_data);

		} else if ($question_type=="Checkbox") {

			create_checkbox($qoid,$preset_data,$option_data,$allow_other);

		} else if ($question_type=="Date") {

			create_date($qoid,$preset_data,$option_data);

		} else if ($question_type=="FiveStar") {

			create_fivestar($qoid,$preset_data,$option_data);

		}


}


function create_sixstar($object_id,$preset_data,$option_data) {
?>
<select name="response[<?php echo $object_id;?>]">
<option value='6'>6 Stars - Perfect</option>
<option value='5'>5 Stars - Excellent</option>
<option value='4'>4 Stars - Good</option>
<option value='3'>3 Stars - Average</option>
<option value='2'>2 Stars - Poor</option>
<option value='1'>1 Star - Very Bad</option>
	</select>
<?php
}


function create_fivestar($object_id,$preset_data,$option_data) {
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



function create_date($object_id,$preset_data,$option_data) {
if ($preset_data) {
$preset_data=date("d M Y",$preset_data);
}
?>

 <div class="input-group input-medium date date-picker" data-date="" data-date-format="dd M yyyy" data-date-viewmode="years">
                <input type="text" class="form-control" readonly value="<?php echo  $preset_data; ?>" name="response[<?php echo $object_id?>]" id="response[<?php echo $object_id; ?>]">
                <span class="input-group-btn">
                    <button class="btn default" type="button">
                      <i class="fa fa-calendar"></i>
                    </button>
                </span>
 </div>

<?php
}




// ------------------------------------------- TEXT BOX

function create_textbox($object_id,$preset_value,$option_data) {
	echo "<textarea name='response[$object_id]' rows='10' style='width:100% '  class='form-control'>$preset_value</textarea>";
}

// ------------------------------------------- TEXT FIELD


function create_textfield($object_id,$preset_value) {
	echo "<input name='response[$object_id]' type='text' size='80' value='$preset_value' style='width:95%' class='form-control'>";
}

// ---- RADIO

function create_radio($object_id,$preset_data,$option_data,$allow_other="no") {

	$items=explode(",",$option_data);

	foreach ($items as $eachitem) {
		$eachitem=stripslashes($eachitem);
		if ($preset_data==$eachitem) { 
			$html_checked="checked=\"checked\" ";
			} else {
				$html_checked="";
			}
		
		echo "<input type='radio' name='response[$object_id]' value='$eachitem' id='response[$object_id].$eachitem' $html_checked > <label for='response[$object_id].$eachitem'>$eachitem</label></br> ";
	}
	
		if ($allow_other=="Yes") { ?>
		
		<input type="radio" class="other" id="<?php echo "response[".$object_id."].other";?>" name="response[<?php echo $object_id; ?>]" data-id="<?php echo $object_id; ?>" value="Other"> <label for="<?php echo "response[".$object_id."].other";?>">Other</label> <span id="other_field_<?php echo $object_id; ?>"></span>
		
<?php		
	}

}

// ------------------------------------------- CHECK BOX : checkbox_migration function query

function create_checkbox($object_id,$preset_data,$option_data,$allow_other="no") {

if ($preset_data) {
	 $preset_data_items=explode("{{SEP}}",$preset_data);
	 }

	if (!$preset_value) {
		$pref=="checked";
	}
	if ($value) {
		$checked = $preset_data;
		$html_checked="checked='checked'";
	}
	
	if ($option_data) {
	$items=explode(",",$option_data);
	}
	
	if (is_array($items) and is_array($preset_data_items)) {
	foreach ($items as $eachitem) {
			 
		if (in_array($eachitem,$preset_data_items)) {
		 	$html_checked="checked='checked'";
		 	
	 } else {
		 	$html_checked="";
		 
	 }
	 }
	 
		echo "<input type=\"checkbox\" name=\"response[$object_id][]\" id='response[$object_id].$eachitem' value=\"$eachitem\" $html_checked> <label for='response[$object_id].$eachitem'>$eachitem</label>";
		echo "<br />";
	}
	
	if ($allow_other=="Yes") { ?>
		
		<input type="checkbox" class="other" id="<?php echo "response[".$object_id."].other";?>" name="<?php echo "response[".$object_id."].other";?>" data-id="<?php echo $object_id; ?>" value="Other"> <label for="<?php echo "response[".$object_id."].other";?>">Other</label> <span id="other_field_<?php echo $object_id; ?>"></span>
		
<?php		
	}
}


// ------------------------------------------- SELECT BOX

function create_selectbox($object_id,$preset_data,$option_data) {
	echo "<select name='response[$object_id]' id='response[$object_id]'>";
	echo "<option></option>";
	$items=explode(",",$option_data);
	foreach ($items as $eachitem) {
		if ($preset_data==$eachitem) { 
			$html_checked="selected";
			} else {
				$html_checked="";
			}
		echo "<option value='$eachitem' $html_checked>$eachitem</option>";
	}
	echo "</select>";
}

// ------------------------------------------- HIDDEN FIELD

function create_hidden_field($object_id,$preset_value,$option_data) {
	echo "<input name='response[$object_id]' type='hidden' value='$preset_data' />";
}

?>
