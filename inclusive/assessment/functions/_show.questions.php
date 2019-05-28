<?php
function show_questions($assessment_id,$section) {
	global $db;
	global $dev;
	$s_identikey=$_SESSION['s_identikey'];


	if ($section=="all") {

		$query="select * from assessment_question where identikey='$s_identikey' and assessment_id='$assessment_id' and item_status <> 'deleted' order by order_id ASC	";

	} else if ($section=="unassigned") {

			$query="select * from assessment_question where identikey='$s_identikey' and assessment_id='$assessment_id' and item_status <> 'deleted' and section IS NULL order by order_id ASC";

		} else {

		$query="select * from assessment_question where identikey='$s_identikey' and assessment_id='$assessment_id' and item_status <> 'deleted' and section='$section' order by order_id ASC";

	}

	


	$statement = $db->prepare($query);
	$statement->bindParam(':oid', $assessment_id);
	$statement->execute();

	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

		$id=$row['object_id'];
		$question_text=stripslashes($row['question_text']);
		$question_type=$row['question_type'];
		$item_status=$row['item_status'];
		$order_id=$row['order_id'];
?>

<?php if (check_question_has_dependency($id)) { 
	echo "Condition found";
	} else { 
		?>
	
      <tr>

 <td style="padding:3px;">

          <div class="btn-group">
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i>
              <i class="fa fa-angle-down"></i>
            </button>
            <ul class="dropdown-menu">
<!--              <li>
                <a href="/controller/questionaction?function=dupe&qoid=<?php echo $id;?>"> Duplicate Question</a>
              </li> -->
              <li>
                <a href="/controller/questionform?function=edit&qoid=<?php echo $id;?>">  Edit Question</a>
              </li>
              <li>
                <a href="/controller/questionaction?function=del&qoid=<?php echo $id;?>">  Delete Question </a>
              </li>
              <li><a href="/controller/questionaction?function=settitle&qoid=<?php echo $id;?>&assessment_id=<?php echo $assessment_id;?>">Set as Title</a></li>
              
              <?php if ($order_id!=='1') { ?>
	           <li><a href="/controller/questionaction?function=orderup&qoid=<?php echo $id;?>&assessment_id=<?php echo $assessment_id;?>">Move Question Up</a></li>
	         <?php }  ?>



       <li class="divider"> </li>
                      <?php if ($question_type=="Radio") { ?>                <li>
 <a class="" href="/ax/questionconditions?qoid=<?php echo $id;?>" data-target="#ajax" data-toggle="modal">Conditions</a> </li>
<?php } ?>
              <li class="divider"> </li>

                     <?php if ($question_type=="Radio") { ?>
              <li>
                 <a class="" href="/ax/listrisk?qoid=<?php echo $id;?>" data-target="#ajax" data-toggle="modal">View Risks</a>
              </li>
              <li>
              <a class="" href="/ax/questionrisk?qoid=<?php echo $id;?>" data-target="#ajax" data-toggle="modal">Create Risk</a>
              </li>
              <?php } ?>
                          </ul>
          </div>
          <?php if (check_question_has_risk($id)) { echo "Risk found"; }?>

        </td>


        <td style="padding:10px;">

        <?php echo $order_id;?>. <?php echo $question_text;?> <?php if ($id==$title_field) { ?><span class="label label-sm label-success label-mini">Report Title</span>
        
        <?php } ?>
        </td>
        <td style="padding:3px;">
          <?php echo $question_type;?>
        </td>

      </tr>

      <?php
	      }
	      
	}

}

?>