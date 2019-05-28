<?php
// This function will keep a log of all actions associated with an item.
function pb_system_log($event,$item_system,$item_id,$other_data="") {
    global $db;
    $username=$_SESSION['s_userid'];
    $identikey=$_SESSION['s_identikey'];
    $ip=$_SERVER['REMOTE_ADDR'];
    $statement = $db->prepare("INSERT INTO system_log (id,username,identikey,createdtime,event,item_id,item_system,other_data,ip) VALUES (:id,:username,:identikey,now(),:event,:item_id,:item_system,:other_data,:ip)");
    $statement->bindParam(':id', $id);
    $statement->bindParam(':username', $username);
    $statement->bindParam(':identikey', $identikey);
    $statement->bindParam(':event', $event);
    $statement->bindParam(':item_id', $item_id);
    $statement->bindParam(':item_system', $item_system);
    $statement->bindParam(':other_data', $other_data);
    $statement->bindParam(':ip', $ip);
    $statement->execute();
}
?>