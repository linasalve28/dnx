<?php
// SQL IDENTIKEY CONFIRMED

function main() {
	global $db;
	global $errorcode;
	global $outcome;
	global $s_identikey;
	global $s_username;
	global $dev;
	?>
<div class="m-heading-1 border-green m-bordered">
	<h3>Assessments Templates</h3>
	<p>The following templates can be used to quickly create your own assessments
	</p>
</div>
<div class="portlet-body" style="display: block;">
	<div class="table">
		<table class="table table-striped table-bordered table-advance table-hover">
			<thead>
				<tr>
					<th>Assessment Template Name </th>
					<th> </th>
				</tr>
			</thead>
			<tbody>

			<?php
            $limit=10;
            $start=0;
            $query_total = "select count(*) from assessment_registry where assessment_type='shared'";
            $total_count = $db->query($query_total)->fetchColumn();
            if(isset($_GET['pid'])) {
                $pid=$_GET['pid'];
                if ($pid < 1) {
                    $pid="1";
                } else {
                    $start=($pid-1)*$limit;
                }
            } else {
                $pid="1";
            }

			$statement = $db->prepare("select id,object_id,identikey,title,created_date,assess_id,description,instructions,unique_access_id from assessment_registry where assessment_type='shared' order by title ASC LIMIT $start,$limit");

			$statement->execute();

			while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
				$id=$row['object_id'];
				$identikey=$row['identikey'];
				$title=$row['title'];
				$created_date=$row['created_date'];
				$assess_id=$row['assess_id'];
				$description=$row['description'];
				$instructions=$row['instructions'];
				$unique_access_id=$row['unique_access_id'];

			?>

				<tr>
					<td>
						<?php echo $title;?>
					</td>
					<td>
						<?php //if ($dev) { ?>
						<a href="/controller/assessment/templateuse?aoid=<?php echo $id; ?>">  <button type="button" class="btn blue-steel">Use this Template</button></a>
	</div>
					<?//php } ?>
					</td>
				</tr>

			<?php
			}
			?>
			</tbody>
		</table>
</div>

  <?php
    if ($total_count > 15) {
        pb_resultsPagination($query_total, $limit, $start, $pid, $mode = "");
    }

}
  ?>