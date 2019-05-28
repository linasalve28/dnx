<?php
// ------------------------------------------- DATE BOX : UPDATE
require_once(FS_COMPONENT_FILECONTROL."/process.php");
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

		} else if ($question_type=="UploadFile") {
            /*
             * file_control_form_multiple($qoid);
			 * create_fileupload($qoid,$preset_data,$option_data);
             */
            create_fileupload_inline($qoid,$preset_data,$option_data);
            //create_dropzone_modal($qoid,$preset_data,$option_data);

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
        $preset_data = date("d M Y",$preset_data);
		//$preset_data=date("d M Y",strtotime($preset_data));
	}
?>

<div class="input-group input-medium date date-picker date-form" data-date="" data-provide="datepicker" data-date-format="dd M yyyy" data-date-viewmode="years" data-id='<?php echo $object_id; ?>'>
	<span class="input-group-btn">
        <div class="btn-aline">
        <input type="text" class="form-control" readonly value="<?php echo  $preset_data; ?>" name="response[<?php echo $object_id?>]" id="response[<?php echo $object_id; ?>].date"  data-id='<?php echo $object_id; ?>'>
        </div>
        <button class="btn default btn" id="btn-date-response[<?php echo $object_id?>]" type="button" name="response[<?php echo $object_id?>]">
		  <i class="fa fa-calendar"></i>
		</button>
	</span>
</div>

<?php
}

function create_fileupload($object_id,$preset_data,$option_data){
   echo "<input name='file[$object_id][]' type='file' class=''/><br /><button type='button' class='add_file_$object_id'>+ Add More Files</button>";
}
function create_fileupload_inline($object_id,$preset_data,$option_data){
    echo "<input type='hidden' name='response[$object_id]' id='response[$object_id]' value='fileupload'>";
    echo "<a id='$object_id' class='btn btn-lg btn-success filecontrol' data-parent-object-id='1' data-parent-object-type='assessment_response'>Upload Files</a>
      <div id='loading$object_id'></div>                                       <div id='status$object_id'></div>";
}
function create_dropzone_modal($object_id,$preset_data,$option_data){
    echo "<input type='hidden' name='response[$object_id]' id='response[$object_id]' value='fileupload'>";
    echo "<button type='button' class='btn btn-info btn-lg' data-toggle='modal' data-target='#myModal' data-id='$object_id'>Upload Files</button>";
    echo "<div id='thumb_$object_id'></div>" ;
}
function create_dropzone_upload($object_id,$preset_data,$option_data){
?>
<script src="<?php echo WS_ASSETS; ?>/pages/scripts/ui-modals.min.js" type="text/javascript"></script>
<!-- New code strated bof-->
<!--<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
<link rel="stylesheet" type="text/css" href="http://fiddle.jshell.net/css/result-light.css">-->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/dropzone/3.8.4/css/basic.css">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/dropzone/3.8.4/dropzone.js"></script>
<!--<script type="text/javascript" src="<?php echo WS_ASSETS; ?>/global/plugins/dropzone/dropzone.js"></script>
<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>-->

<!--<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">-->

<script type="text/javascript">

    Dropzone.options.myAwesomeDropzone<?php echo $object_id; ?> = {
        paramName: "file",
        maxFilesize: 10,
        url: '/ax/dropzoneupload',
       // previewsContainer: "#dropzone-previews<?php echo $object_id; ?>",
        uploadMultiple: true,
        parallelUploads: 5,
        //maxFiles:2,0
        init: function () {
            var cd;
            this.on("success", function (file, response) {

                /*
                $('#dropzone-previews<?php //echo $object_id; ?> .dz-progress').hide();
                $('#dropzone-previews<?php //echo $object_id; ?> .dz-size').hide();
                $('#dropzone-previews<?php //echo $object_id; ?> .dz-error-mark').hide();
               */
                $('.dz-progress').hide();
                $('.dz-size').hide();
                $('.dz-error-mark').hide();

                console.log(response);
                //console.log(file);
                cd = response;

            });
            this.on("addedfile", function (file){
                var removeButton = Dropzone.createElement("<a href=\"#\">Remove file</a>");
                var _this = this;
                removeButton.addEventListener("click", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    _this.removeFile(file);
                    var name = "largeFileName=" + cd.largePicPath + "&smallFileName=" + cd.smallPicPath;
                    $.ajax({
                        type: 'POST',
                        url: 'DeleteImage',
                        data: name,
                        dataType: 'json'
                    });
                });
               // file.previewElement.appendChild(removeButton);
            });
        }
    };


    $(window).load(function(){

        /*$(document).on('click', '.image-popup-open', function(f) {
            $("#myModal<?php echo $object_id; ?>").modal('show');
        });*/

        $(document).on('click', '#<?php echo $object_id; ?>', function(f) {
            $("#myModal<?php echo $object_id; ?>").modal('show');
        });

        $(document).on('click', '#model-cl1<?php echo $object_id; ?>', function(f) {

            $('#myModal<?php echo $object_id; ?>').modal('hide');
             // $("#url-i-pr .select_img").contents().appendTo('#dropzone-previews<?php echo $object_id; ?>');
            $("#url-i-pr").html("");
            $("#url-ip").val("");
        });


    });

</script>
<div id="myModal<?php echo $object_id; ?>" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">
                    <ul class="nav nav-pills" id="ImgTab">
                        <li class="active"><a href="#uplod">Upload</a></li>
                    </ul>
                </div>
                <div id='content' class="tab-content">
                    <div class="tab-pane active" id="uplod">
                        <!--id="my-awesome-dropzone"-->
                        <form action="<?php echo DOMAIN_PATH; ?>/ax/dropzoneupload" class="dropzone" id="my-awesome-dropzone<?php echo $object_id; ?>" enctype="multipart/form-data">
                            <input type="hidden" id="aoid" name="aoid" value="<?php echo $assessment_id; ?>">
                        </form>
                    </div>
                    <div id="dropzone-previews<?php echo $object_id; ?>"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="model-cl1<?php echo $object_id; ?>">Done</button>
            </div>
        </div>
    </div>
 </div>
<!-- New code strated eof-->
    <?php
    //echo "<a class=\"\" href=\"/ax/dropzoneupload?qoid=$object_id\" data-target=\"#ajax\" data-toggle=\"modal\">Click to upload</a>
    echo "<i class=\"fa fa-image image-popup-open\" id='$object_id' data-toggle=\"modal\" >Click to upload</i>";
}
// ------------------------------------------- TEXT BOX
function create_textbox($object_id,$preset_value,$option_data) {
    if ($preset_value == "Non applicable"){
        $preset_value = "";
    }
    echo "<textarea name='response[$object_id]' rows='10' style='width:100% '  class='form-control textarea-form' data-id='$object_id' id='response[$object_id].textarea' >$preset_value</textarea>";
}

// ------------------------------------------- TEXT FIELD
function create_textfield($object_id,$preset_value) {
    if ($preset_value == "Non applicable"){
        $preset_value = "";
    }
	echo "<input name='response[$object_id]' type='text' size='80' value='$preset_value' style='width:95%' class='form-control' data-id='$object_id' id='response[$object_id].text' >";
}

// -------------------------------------------- RADIO
function create_radio($object_id,$preset_data,$option_data,$allow_other="no") {

	$items=explode(",",$option_data);
    foreach ($items as $eachitem) {
		$eachitem=stripslashes($eachitem);
		if ($preset_data==$eachitem) {
			$html_checked="checked=\"checked\" ";
		} else {
			$html_checked="";
		}

		echo "<input type='radio' class='radio_item' name='response[$object_id]' value='$eachitem' data-id='$object_id' id='response[$object_id].$eachitem' $html_checked > <label for='response[$object_id].$eachitem'>$eachitem</label></br> ";
	}

	if ($allow_other=="Yes") {
	 ?>
        <input type="radio" class="other" id="<?php echo "response[".$object_id."].other";?>" name="response[<?php echo $object_id; ?>]" data-id="<?php echo $object_id; ?>" value="Other"> <label for="<?php echo "response[".$object_id."].other";?>">Other</label> <span id="other_field_<?php echo $object_id; ?>"></span>
    <?php
	}
}
// ------------------------------------------- CHECK BOX : checkbox_migration function query
function create_checkbox($object_id,$preset_data,$option_data,$allow_other="no") {
	if ($preset_data) {		
		if (is_array($preset_data)) {			
			$preset_data_items=$preset_data;
		} else {
		    $preset_data_items=explode("{{SEP}}",$preset_data);
		}
	}

	if (!$preset_value) {
		$pref="checked";
	}
	if ($value) {
		$checked = $preset_data;
		$html_checked="checked='checked'";
	}
	if ($option_data) {
		$items=explode(",",$option_data);
	}
	if (is_array($items)) {

		foreach ($items as $eachitem) {
			if (is_array($preset_data_items)) {
				if (in_array($eachitem,$preset_data_items)) {
					$html_checked="checked='checked'";
				} else {
					$html_checked="";
				}
			}

		echo "<input type=\"checkbox\" class='checkbox-form' data-id='" . $object_id . "' name=\"response[$object_id][]\" id='response[$object_id].$eachitem' value=\"$eachitem\" $html_checked> <label for='response[$object_id].$eachitem'>$eachitem</label>";
		echo "<br />";
		}


	}

	if ($allow_other=="Yes") { ?>

		<input type="checkbox" class="other" id="<?php echo "response[".$object_id."].other";?>" name="<?php echo "response[".$object_id."].other";?>" data-id="<?php echo $object_id; ?>" value="Other"> <label for="<?php echo "response[".$object_id."].other";?>">Other</label> <span id="other_field_<?php echo $object_id; ?>"></span>

<?php
	}
}


// ------------------------------------------- SELECT BOX

function create_selectbox($object_id,$preset_data,$option_data) {
	echo "<select name='response[$object_id]' id='response[$object_id].select' data-id='" . $object_id . "' class='select_box'>";
	echo "<option value=''></option>";
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
	echo "<input name='response[$object_id]' type='hidden' value='$preset_value' />";
}

?>