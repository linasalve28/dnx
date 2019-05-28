<style>
  .connectedSortable {
    border: 1px solid #eee;
    min-height: 20px;
    list-style-type: none;
    margin: 0;
    padding: 5px 0 0 0;
    margin-right: 10px;
  }
  .connectedSortable li {
    margin: 0 5px 5px 5px;
    padding: 5px;
	cursor:move;
	
  }
  
.orphans{
    background: linear-gradient(-45deg, #3d74f1, #9986ee);
    padding: 25px;
    width: 95%;
    margin: 20px;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1), 0 6px 10px 0 rgba(0, 0, 0, 0.10);
    border-radius: 3px;
    border: 1px solid #d2dee9;
}
  
  </style>
  <?php

function main(){
	require("inc.globals.php");
	include_once( FS_ASSESSMENT_FUNCTIONS."/reorder.questions.inc.php" );
	include_once( FS_ASSESSMENT_FUNCTIONS."/show.question.item.php" );
	include_once( FS_ASSESSMENT_FUNCTIONS."/show.question.dependency.php" );
	include_once( FS_ASSESSMENT_FUNCTIONS."/show.button.php" );
	include_once( FS_ASSESSMENT_FUNCTIONS."/functions.php" );
	include_once( FS_ASSESSMENT_FUNCTIONS."/form.functions.php");
	$aoid = $_GET['aoid'];
	reorder_questions($aoid);
?>
<style>
ul.q {
    list-style: none;
}
li.q {
	font-family: sans-serif;
    border-radius: 5px;
    border: 1px solid #5d6256;
    background: #fbfbfb;
    padding: 25px;
    width: 95%;
    margin: 20px;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1), 0 6px 10px 0 rgba(0, 0, 0, 0.10);
}

.dropdown-pull-right {
    float: right !important;
    right: 0;
    left: auto;
}
.dropdown-pull-right>.dropdown-menu {
  right: 0;
  left: auto;
}

 li.s {
    border-radius: 3px;
	border: 1px solid #d2dee9;
	background: #348F50;  /* fallback for old browsers */
	background: -webkit-linear-gradient(to right, #56B4D3, #348F50);  /* Chrome 10-25, Safari 5.1-6 */
	background: linear-gradient(to right, #56B4D3, #348F50); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
	padding: 25px;
	width: 95%;
	margin: 20px;
	box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1), 0 6px 10px 0 rgba(0, 0, 0, 0.10);
}

li.q {

    border-radius: 5px;
    border: 1px solid #d2dee9;
    padding: 25px;
    width: 95%;
    margin: 20px;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1), 0 6px 10px 0 rgba(0, 0, 0, 0.10);
}

.dropdown-pull-right {
  float: right !important;
  right: 0;
  left: auto;
}

.dropdown-pull-right>.dropdown-menu {
  right: 0;
  left: auto;
}

</style>


<a href="/ax/assessment/sectionform?aoid=<?php echo $aoid;?>&function=add" class="f4"><button type="button" class="btn btn-success">Add Section</button></a>
<a href="/ax/assessment/questionform?aoid=<?php echo $aoid;?>&function=add" class="f4"><button type="button" class="btn btn-success">Add a Question</button></a>
<div id="feedback"></div>
<div id="info" style="padding-top: 10px;"></div>

<div class="portlet-body" style="display: block;">


<ul class='top_level_list' data-object-type="section1">
<?php
    $assessment_id = $aoid;
	$statement = $db->prepare("select * from assessment_section where parent_assessment_id = :assessment_id and section_status <> 'deleted' order by order_id");
	$statement->bindParam(':assessment_id', $assessment_id);
	$statement->execute();

	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

		$section_object_id = $row['object_id'];
		$section_title = $row['title'];
		$section_order_id = $row['order_id'];
		$section_object_id_arr[]="#sortable_".$section_object_id;
		
		echo "<li class='s basic-gradient' data-object-type='section'>";
		show_button($section_object_id,$type="section",$section_order_id);
		echo "<h4 class='text-light'>".$section_title."</h4>";
		echo "</li>";
		//show questions
        $item_status = 'active';
		$statement_x = $db->prepare("select object_id,question_type from assessment_question where assessment_id = :assessment_id and section=:section_object_id and item_status =:item_status order by order_id");
		$statement_x->bindParam(':assessment_id', $assessment_id);
		$statement_x->bindParam(':section_object_id', $section_object_id);
        $statement_x->bindParam(':item_status', $item_status);
        $statement_x->execute();

        //$rand=rand(1, 150);
        //$rand_arr[] = "#sortable_".$rand;
        $rand_arr[] = "#sortable_".$section_object_id;

		$i_count = 1;
		//echo "<ul class='q connectedSortable' id='sortable_$rand' data-object-type='section'>";
		echo "<ul class='q connectedSortable' id='sortable_$section_object_id' data-object-type='section'>";
		while ($row_x = $statement_x->fetch(PDO::FETCH_ASSOC)){
			$object_id = $row_x['object_id'];
			$question_type = $row_x['question_type'];
			if(check_question_has_dependency($object_id)!==true){
				show_question_item($object_id,$i_count,"");
				++$i_count;
			}
		}
		echo "</ul>";
	}
?>
</ul>
    <?php
    //if questions exist without Section, display below
    //This code is not required because section is compulsory while question adding 16 Jul 2018 LS
    /*
    $item_status = 'orphan';
    $statement = $db->prepare("select object_id,question_type from assessment_question WHERE assessment_id = :assessment_id and item_status =:item_status order by order_id");
    $statement->bindParam(':assessment_id', $assessment_id);
    $statement->bindParam(':item_status', $item_status);
    $statement->execute();
    $orphans=$statement->rowCount();
    if ($orphans>0) { ?>
        <ul class='top_level_list' data-object-type="section1">
            <div class='orphans' data-object-type='section'>
                <h4 class='text-light'>Follow the list of Questions without Section:</h4>
            </div>
        <?php
        $rand = rand(1, 150);
        $rand_arr[] = "#sortable_" . $rand;
        $q_count = 1;
        ?>
            <ul class='q ui-sortable' id='sortable_$rand' data-object-type='section'> <!-- connectedSortable>-->
                <?php
                while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
                    $object_id = $row['object_id'];
                    $question_type = $row['question_type'];
                    if (check_question_has_dependency($object_id) !== true) {
                        show_question_item($object_id, $q_count, "");
                        ++$q_count;
                    }
                }
                ?>
            </ul>
        </ul>
    <?php
    } */
    ?>
    <input name="aoid" id="aoid" type="hidden" value="<?php echo $assessment_id; ?>">
</div>

<?php
    if(isset($sort_arr)){
        $sort_arr=implode(",",$rand_arr);
    }

}
?>
