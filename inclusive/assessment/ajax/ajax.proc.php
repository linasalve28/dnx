<?php


function main() {
    global $page;
    $function=$_POST['function'];
    if ($page=="sectionproc") {
        require("_section.proc.php");

        $arr['refresh-div']="#content_body";
        $arr['refresh-url']="/controller/questionlist?aoid=".$_POST['aoid']."#content_body";
        //$arr[]

    } else if ($page=="questionproc") {

        require("question.proc.php");

    }else if ($page=="engageproc"){

        require("assessment.engage.proc.php");

    }

    echo json_encode($arr);
}
?>