<?php


function main(){
    global $s_identikey;
    global $s_username;
    global $db;
    ?>
    <div class="m-heading-1 border-green m-bordered">
        <h3>Data Transfers</h3>
        <p>
            Data Transfers indicate the flow of data from your company, to another. Transfers can be across borders, and can affect the responisiblity for the data.
        </p>
        <p>
            <a class="btn green-jungle" href="/controller/dtaform?function=add">Add New Data Transfer</a>
        </p>
    </div>
    <div class="portlet-body" style="display: block;">
        <div class="table">
            <table class="table table-striped table-bordered table-advance table-hover">
                <thead>
                <tr>
                    <th>
                        <i class="fa fa-chevron-up"></i> From </th>
                    <th class="hidden-xs">
                        <i class="fa fa-chevron-down"></i> To</th>
                    <th>
                        <i class="fa fa-signal"></i> Integrity </th>
                    <th> </th>
                </tr>
                </thead>

                <tbody>
                <script>
                    $(document).ready(function(){
                        $(".delete").click(function(e){
                            event.preventDefault(e);

                            if (confirm('Are you sure you wish to delete this Data Transfer Agreement?')) {

                                var c=$(this).attr("data-id");
                                $.ajax({url: "/ax/unidelete", data: { oid: c,otype: "dta"},success: function(result){
                                        if (result=='success') {
                                            $("#span"+c).remove();
                                        } else {
                                            alert('An error occurred');
                                        }
                                    }});


                            } else {

                            }
                        });
                    });
                </script>
                <?php


                $query="select * from dta_registry where identikey='$s_identikey' and object_status='active'";
                $statement = $db->prepare($query);
                $statement->execute();
                $errcheck=$statement->rowCount();
                if ($errcheck==0) { ?>

                    <tr id="" >
                        <td colspan="4" align="center">
                            No data transfers were found. <a href="/controller/dta/dtaform?function=add">Register a new data transfer</a>
                        </td>
                    </tr>

                    <?php
                }


                $dataconn = $statement->fetchAll(PDO::FETCH_ASSOC);

                foreach ($dataconn as $row){
                    $id=$row['id'];
                    $object_id=$row['object_id'];
                    $data_transfer_id=$row['data_transfer_id'];
                    $transfer_from_id=$row['transfer_from_id'];
                    $transfer_to_id=$row['transfer_to_id'];
                    $date_started=$row['date_started'];
                    $date_ended=$row['date_ended'];
                    $details=$row['details'];
                    $transfer_status=$row['transfer_status'];
                    $other_information=$row['other_information'];
                    $certification_dependant=$row['certification_dependant'];
                    $integrity_status=$row['integrity_status'];
                    ?>





                    <tr id="span<?php echo $object_id;?>">
                        <td>
                            <?php if ($transfer_from_id==$_SESSION['s_identikey']) { echo "". pb_getCompanyNameIdentikey($transfer_from_id)."";  } else { echo pb_getCompanyNameIdentikey($transfer_from_id); }?>
                        </td>
                        <td>
                            <?php if ($transfer_to_id==$_SESSION['s_identikey']) { echo "". pb_getCompanyNameIdentikey($transfer_to_id)."";  } else { echo pb_getCompanyNameIdentikey($transfer_to_id); }?>
                        </td>

                        <td>
                            <?php if ($integrity_status=="good") { ?>
                                <span class="label label-sm label-success label-mini"> <?php echo $integrity_status; ?> </span>
                            <?php } else if ($integrity_status=="at risk") { ?>
                                <span class="label label-sm label-warning label-mini"> <?php echo $integrity_status; ?> </span>
                            <?php } else if ($integrity_status=="pending") { ?>
                                <span class="label label-sm label-default label-mini"> <?php echo $integrity_status; ?> </span>
                            <?php } else if ($integrity_status=="poor") { ?>
                                <span class="label label-sm label-danger label-mini"> <?php echo $integrity_status; ?> </span>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="/controller/dta/dtaview?id=<?php echo $object_id;?>" class="btn dark btn-sm btn-outline sbold uppercase">
                                <i class="fa fa-edit"></i> View </a>
                            <div class="btn-group">
                                <button class="btn red dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Options
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="/controller/dta/dtaform?function=edit&id=<?php echo $object_id;?>">Edit </a>
                                    </li>



                                    <li>
                                        <a data-id="<?php echo $object_id;?>" class="delete">Delete</a>



                                    </li>


                                </ul>
                            </div>
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