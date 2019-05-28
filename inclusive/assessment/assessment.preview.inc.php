<?php
// SQL IDENTIKEY CONFIRMED
function main() {
	global $db;
	include(FS_ROOT_FUNCTIONS."/form.functions.php");
	$assessment_id = $_GET['aoid'];
?>
<style>
		
ul {
    list-style: none;
    font-family: Roboto, "Helvetica Neue", sans-serif;
}
li {
    display: inline-block;
    margin-right: 15px;
}
input {
    visibility:hidden;
    border-style:solid;
}
label {
    cursor: pointer;
    padding:10px;
    border-style:solid;
    border-width:1px;
    border-color:grey;
}
input:checked + label {
    background: #2dbb1d;
    border-style:solid;
    color:rgba(255, 255, 255, 0.87)
}
		</style>
		
 <div class="portlet light ">
    <div class="portlet-title">
      <div class="caption">
        <i class="icon-settings font-dark"></i>
        <span class="caption-subject font-dark sbold uppercase">Assessment Preview</span>
      </div>
    </div>
      <div class="portlet-body form">
        <form class="form-horizontal" role="form" action="" method="POST" enctype="multipart/form-data">

<?php

	$statement = $db->prepare("select * from assessment_question where assessment_id=:assessment_id and identikey=:identikey order by order_id asc");
	$statement->bindParam(':assessment_id', $assessment_id);
	$statement->bindParam(':identikey', $_SESSION['s_identikey']);
	$statement->execute();


	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$id=$row['id'];
		$question_text=$row['question_text'];
		$question_object_id=$row['object_id'];
		$question_type=$row['question_type'];
		$question_additional_info=$row['question_additional_info'];
		$question_allow_null=$row['question_allow_null'];
		$question_allow_comment=$row['question_allow_comment'];
		$question_allow_attachment=$row['question_allow_attachment'];
		$options=$row['options'];
?>


		<div class="form-group">
            <div class="control-label col-md-1"></div>
            <div class="col-md-11">
			<?php echo stripslashes($question_text);?>
            </div>
        </div>
          

		<div class="form-group">
            <div class="control-label col-md-1"></div>
            <div class="col-md-11"><ul> <li>
	            
          <?php

		if ($question_type=="Text") {
			create_textfield($question_object_id,$title,$pref,$value);
		} else if ($question_type=="SelectBox") {
				create_selectbox($title,$options,"");
			} else if ($question_type=="Radio") {
				create_radio($question_object_id,$title,$options,"");
			} else if ($question_type=="TextArea") {
				create_normal_textbox($i,$title,$pref,$value);
			} else if ($question_type=="Checkbox") {
			create_checkbox($i,$options,$value);
			} else if ($question_type=="Date") {
			create_date($i,$options,$value);
			} else if ($question_type=="FiveStar") {
			create_fivestar($i,$options,$value);
			}
			
			
			


?>
            </li>
            </ul>
            </div>
          </div>
  


  <?php
	  ++$i;
	}
?>
	    <div class="form-actions">
      <div class="row">
        <div class="col-md-offset-3 col-md-9">
          <button type="submit" class="btn blue" value="Draft">Save as Draft</button>
          <button type="submit" class="btn green" value="Submit">Submit Assessment</button>
        </div>
      </div>
    </div>

	<?php
}

?>