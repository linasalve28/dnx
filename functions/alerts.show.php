<?php


function pb_alerts_show() {
?>
<script src="/lib/livestamp/moment.js"></script>
<script src="/lib/livestamp/livestamp.min.js"></script>
<?php

	global $s_username;
	global $db;

	$s_userid=$_SESSION['s_userid'];
	$query="select * from system_alerts where target_user='$s_userid' and read_status='unread' order by date ASC";

	$statement = $db->prepare($query);
	$statement->execute();

	$rows= $statement->rowCount();
	$statement="";


	$target_id=$_SESSION['s_username'];
	$query="select * from system_alerts where target_user='$s_userid' order by date DESC";

	$statement = $db->prepare($query);
	$statement->execute();


?>

		                                 <?php if ($rows > 0) { ?>
		                                  <span class="badge badge-default" style="background-color:  #e31d3c"> <?php echo $rows;?> </span>
		                                  <?php } ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="external">
                                        <h3>
                                            <span class="bold"><?php //echo $rows[0];?><?php echo $rows; ?> Pending</span> notifications</h3>
                                  <a href="/system/listnotifications">view all</a>
                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">

                                          <?php

	while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

		$object_id=$row['object_id'];
		$title=$row['title'];
		$read_status=$row['read_status'];
		$date=$row['date'];
?>
        <li>
                                                <a href="/system/alertlink?object_id=<?php echo $object_id; ?>">
                                                    <span class="time"data-livestamp="<?php echo strtotime($date); ?>"></span>
                                                    <span class="details">
                                                    <?php if ($read_status=='unread') { ?>
                                                        <span class="label label-sm label-icon label-success">
                                                          <i class="fa fa-bolt"></i>
                                                        </span>
                                                        <?php } else { ?>
                                                            <span class="label label-sm label-icon">

                                                        </span>
                                                        <?php } ?>
                                                        <?php echo $title;?> </span>
                                                </a>
                                            </li>
<?php
	}
?>



                                        </ul>
                                    </li>
                                </ul>

                                <?php




}
?>