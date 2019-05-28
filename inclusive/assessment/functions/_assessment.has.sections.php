
<?php
function pb_assessment_has_sections($assessment_id) {
    global $db;
    $query="select id from assessment_section where parent_assessment_id='$assessment_id' and section_status <> 'deleted'";
    $statement = $db->prepare($query);
    $statement->execute();
    $errcheck=$statement->rowCount();
    if ($errcheck==0) {
        return false;
    } else {
        return true;
    }
}
?>