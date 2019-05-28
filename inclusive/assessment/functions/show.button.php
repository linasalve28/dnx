<?php
function show_button($qoid,$type="question",$order_id){ //    show_button($section_object_id,$type="section",$section_order_id);
    $aoid=$_GET['aoid'];
    ?>

    <div class="btn-group float-right">
        <?php if ($type=="question") { ?>
            <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
        <?php  } else if ($type=="section") { ?>
            <button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>

        <?php  } ?>


        <div class="dropdown-menu">
            <?php if ($type=="question") { ?>

                <a class="dropdown-item f4" href="/ax/assessment/questionform?function=edit&qoid=<?php echo $qoid;?>">Edit Question</a>
                <a class="dropdown-item f4" href="/ax/assessment/questionform?function=del&aoid=<?php echo $aoid;?>&qoid=<?php echo $qoid;?>">Delete Question</a>
                <a class="dropdown-item" href="/ax/assessment/questionaction?function=settitle&qoid=<?php echo $qoid;?>&assessment_id=<?php echo $aoid;?>">Set as Title</a>
                <a class="dropdown-item f1" href="/ax/assessment/questionaction?function=orderup&qoid=<?php echo $qoid;?>&assessment_id=<?php echo $aoid;?>">Move Question Up</a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item f4" href="/ax/assessment/questionconditions?qoid=<?php echo $qoid;?>">Conditions</a>
                <a class="dropdown-item f4" href="/ax/assessment/listrisk?qoid=<?php echo $qoid;?>">View Risks</a>
                <a class="dropdown-item f4" href="/ax/assessment/questionriskform?qoid=<?php echo $qoid;?>&function=add">Create Risk</a>
                <a class="dropdown-item" href="#"></a>

            <?php }  else if ($type=="section") {
                if ($order_id!=='1'){ ?>
                    <a class="dropdown-item" href="/ax/assessment/questionaction?function=section_orderup&soid=<?php echo $qoid;?>&assessment_id=<?php echo $aoid;?>"> Move Section Up</a>
                <?php } ?>
                <a class="dropdown-item f4" href="/ax/assessment/questionform?function=add&aoid=<?php echo $aoid;?>&soid=<?php echo $qoid;?>">Add a Question</a>
                <a class="dropdown-item f4" href="/ax/assessment/sectionform?function=edit&soid=<?php echo $qoid;?>">Edit Section</a>
                <a class="dropdown-item f4" href="/ax/assessment/sectionform?function=del&aoid=<?php echo $aoid;?>&soid=<?php echo $qoid;?>">Delete Section</a>
            <?php } ?>
        </div>
    </div>


    <?php
}
?>