<?php
function main(){
global $s_identikey;
global $s_username;
    ?>
    <div class="m-heading-1 border-green m-bordered">
		<h3>Data Transfers</h3>
		<p>Data Transfers indicate the flow of data from your company, to another. Transfers can be across borders, and can affect the responisiblity for the data.
	    <a class="btn green-jungle" href="/controller/dtaform?function=add">Add New Data Transfer</a>
		</p>
	</div>
    <div class="portlet-body" style="display: block;">
	  <div class="table-scrollable">
		  <table class="table table-striped table-bordered table-advance table-hover">
			  <thead>
				  <tr>
					  <th>
						  <i class="fa fa-briefcase"></i> From </th>
					  <th class="hidden-xs">
						  <i class="fa fa-question"></i> To </th>
					  <th>
						  <i class="fa fa-bookmark"></i> Status </th>
					  <th> </th>
				  </tr>
			  </thead>
			<tbody>
			<?php
			require_once("/home/trustbase/dbn/ro.tb.db.conn.php");

			$statement = $ro_db->prepare("select * from system_log order by createdtime DESC");
			$statement->execute();

			$dataconn = $statement->fetchAll(PDO::FETCH_ASSOC);

			foreach ($dataconn as $row){
			$id=$row['id'];
$username=$row['username'];
$identikey=$row['identikey'];
$createdtime=$row['createdtime'];
$event=$row['event'];
$item_id=$row['item_id'];
$item_system=$row['item_system'];
$other_data=$row['other_data'];
$ip=$row['ip'];
			?>



				  <tr>
					  <td>
					   <?php echo $username;?>
					  </td>
					  <td>
					  <?php echo $event;?>     <?php echo $item_id;?>                                                 </td>

					  <td>
					<?php echo $other_data;?>
					  </td>
					  <td>
						  <?php echo $createdtime;?>                                                      
						  
							  <?php echo $item_system;?>                                                      
						  </td>
				  </tr>





			  <?php
		  }


		  ?>
			  </tbody>
		  </table>
	  </div>
                                  </div>




<?php
  }
?>