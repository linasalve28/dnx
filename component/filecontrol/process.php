<?php

function file_control_form($fieldname) {
	?>
    <script type="text/javascript">
        $(document).ready(function(){
        $('.add_<?php echo $fieldname; ?>_file').click(function(e){
          e.preventDefault();
          $(this).before("<input name='<?php echo $fieldname; ?>_file[]' type='file'/><br />");
        });
      });
     </script>
	<?php
}
function file_control_form_multiple($objid) {
    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.add_file_<?php echo $objid; ?>').click(function(e){
                e.preventDefault();
                $(this).before("<input name='file[<?php echo $objid; ?>][]' type='file'/><br />");
            });
        });
    </script>
    <?php
}

function file_control_list_files($parent_object_type,$parent_object_id,$parent_object_section="",$function="link") {
	global $db;

	if ($parent_object_section) {
		$statement = $db->prepare("select * from file_control where parent_object_type = :parent_object_type and parent_object_id=:parent_object_id and parent_object_section=:parent_object_section and object_status='active'");
		$statement->bindParam(':parent_object_section', $parent_object_section);
	} else {
		$statement = $db->prepare("select * from file_control where parent_object_type = :parent_object_type and parent_object_id=:parent_object_id and object_status='active'");
	}

	$statement->bindParam(':parent_object_type', $parent_object_type);
	$statement->bindParam(':parent_object_id', $parent_object_id);  $statement->execute();

	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
		$id=$row['id'];
		$file_name=$row['file_name'];
		$object_id=$row['object_id'];
		$access_key=$row['access_key'];
		$file_type=$row['file_type'];
		$enc_file_name=$row['enc_file_name'];


		if ($function=="link") {

			echo '<a href="/component/filecontrol/download.php?object_id='.$object_id.'&access_key='.$access_key.'">'.$file_name.'</a><br />';


		} else if ($function=="delete") {

				echo '<span id="span'.$object_id.'"><a href="/component/filecontrol/download.php?object_id='.$object_id.'&access_key='.$access_key.'">'.$file_name.'</a>';

				echo ' <button data-id="'.$object_id.'" class="delete btn btn-outline btn-circle dark btn-sm black">Delete</button></span><br />';

		} else {
			echo $file_name.'<br />';
		}
	}

}


function file_control_upload_modal($target_field="file",$parent_object_type,$parent_object_id,$parent_object_section="",$is_temp=false) {
    //$img = $_FILES[$target_field.'_file'];
    $img = $_FILES[$target_field];

    global $db;

    if(!empty($img)){
            //print_R($img);
            //$img_desc = reArrayFiles($img);
            //print_R($img_desc);


            if (!empty($img['name'])) {

                srand((double)microtime()*1000000);
                $enc_filename=time().rand(0,10000);
                $sever_enc_filename=md5($enc_filename);
                $newname=md5($sever_enc_filename).'.cap';

                $file_name=$img['name'];
                $file_type=$img['type'];
                $file_size=$img['size'];
                $access_key=create_unique_id();
                $is_moved  = false;
                //move_uploaded_file($val['tmp_name'],"/home/trustbase/secu/f/".$newname);
                if($is_temp==true){
                    //move to temp folder and status as temporary
                    $is_moved = move_uploaded_file($img['tmp_name'], FILES_ROOT_TEMP . "/" . $newname);
                    $object_status="temporary";
                }else {
                   $is_moved = move_uploaded_file($img['tmp_name'], FILES_ROOT . "/" . $newname);
                    $object_status="active";
                }
                $enc_file_name=$newname;
                if($is_moved ==true) {
                    $object_id = pb_create_object_id("file_control");

                    $query = "INSERT INTO file_control (id,object_id,file_name,file_type,enc_file_name,parent_object_type,parent_object_id,parent_object_section,access_key,upload_date,owner,owner_identikey,object_status) VALUES (:id,:object_id,:file_name,:file_type,:enc_file_name,:parent_object_type,:parent_object_id,:parent_object_section,:access_key,NOW(),:owner,:owner_identikey,:object_status)";
                    $statement = $db->prepare($query);
                    $statement->bindParam(':id', $id);
                    $statement->bindParam(':object_id', $object_id);
                    $statement->bindParam(':file_name', $file_name);
                    $statement->bindParam(':file_type', $file_type);
                    $statement->bindParam(':enc_file_name', $enc_file_name);
                    $statement->bindParam(':parent_object_type', $parent_object_type);
                    $statement->bindParam(':parent_object_id', $parent_object_id);
                    $statement->bindParam(':parent_object_section', $parent_object_section);
                    $statement->bindParam(':access_key', $access_key);
                    //$statement->bindParam(':upload_date', $upload_date);
                    $statement->bindParam(':owner', $_SESSION['s_userid']);
                    $statement->bindParam(':owner_identikey', $_SESSION['s_identikey']);
                    $statement->bindParam(':object_status', $object_status);
                    $statement->execute();
                    return array("status"=>"success","filename"=>$file_name);
                }else{
                    return array("status"=>"file_err","filename"=>"");
                }
            }


    }

}


function file_control_upload($target_field="file",$parent_object_type,$parent_object_id,$parent_object_section="") {
	$img = $_FILES[$target_field.'_file'];

	global $db;

	if(!empty($img)){
		$img_desc = reArrayFiles($img);

		foreach($img_desc as $val)
		{

			if (!empty($val['name'])) {

				srand((double)microtime()*1000000);
				$enc_filename=time().rand(0,10000);
				$sever_enc_filename=md5($enc_filename);
				$newname=md5($sever_enc_filename).'.cap';

				$file_name=$val['name'];
				$file_type=$val['type'];
				$file_size=$val['size'];
				$access_key=create_unique_id();

				//move_uploaded_file($val['tmp_name'],"/home/trustbase/secu/f/".$newname);
                move_uploaded_file($val['tmp_name'], FILES_ROOT . "/" . $newname);
                $object_status="active";

				$enc_file_name=$newname;
				$object_id=pb_create_object_id("file_control");

				$query="INSERT INTO file_control (id,object_id,file_name,file_type,enc_file_name,parent_object_type,parent_object_id,parent_object_section,access_key,upload_date,owner,owner_identikey,object_status) VALUES (:id,:object_id,:file_name,:file_type,:enc_file_name,:parent_object_type,:parent_object_id,:parent_object_section,:access_key,NOW(),:owner,:owner_identikey,:object_status)";
				$statement = $db->prepare($query);

				$statement->bindParam(':id', $id);
				$statement->bindParam(':object_id',$object_id);
				$statement->bindParam(':file_name', $file_name);
				$statement->bindParam(':file_type', $file_type);
				$statement->bindParam(':enc_file_name', $enc_file_name);
				$statement->bindParam(':parent_object_type', $parent_object_type);
				$statement->bindParam(':parent_object_id', $parent_object_id);
				$statement->bindParam(':parent_object_section', $parent_object_section);
				$statement->bindParam(':access_key', $access_key);
				//$statement->bindParam(':upload_date', $upload_date);
				$statement->bindParam(':owner', $_SESSION['s_userid']);
				$statement->bindParam(':owner_identikey', $_SESSION['s_identikey']);
				$statement->bindParam(':object_status', $object_status);
				$statement->execute();

			}

		}
	}

}

function reArrayFiles($file)
{
	$file_ary = array();
	$file_count = count($file['name']);
	$file_key = array_keys($file);

	for($i=0;$i<$file_count;$i++)
	{
		foreach($file_key as $val)
		{
			$file_ary[$i][$val] = $file[$val][$i];
		}
	}
	return $file_ary;
}


// Deletes a file

function file_control_delete_file($object_id) {
global $db;

	$statement = $db->prepare("UPDATE file_control SET object_status = :object_status WHERE object_id=:object_id limit 1");
	$object_status="deleted";

	$statement->bindParam(':object_id', $object_id);
	$statement->bindParam(':object_status', $object_status);
	$statement->execute();
}
function file_control_list($response_id,$qoid) {
    global $db;
    $return_arr = array();
    $statement = $db->prepare("select file_name,access_key from file_control where parent_object_id = :response_id and parent_object_section= :qoid");
    $statement->bindParam(':response_id', $response_id);
    $statement->bindParam(':qoid', $qoid);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        //$id=$row['id'];
        $file_name=$row['file_name'];
        $access_key=$row['access_key'];
        $return_arr[] = "<a href=".WS_COMPONENT_FILECONTROL."/download.php?acce=$access_key'>$file_name</a>";
    }
  return $return_arr ;
}
?>