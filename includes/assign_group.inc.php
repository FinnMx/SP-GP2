<?php
if (isset($_POST['submitAG'])){
	AssignGroup($_POST['group_id'], $_POST['project_id']);

}

function AssignGroup($GID, $PID){
	$db = new SQLite3('C:\xampp\htdocs\myDB.db');
    $sql = "UPDATE GROUPS SET Project_ID =:pid WHERE Group_ID =:gid";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':pid', $PID, SQLITE3_TEXT);
    $stmt->bindParam(':gid', $GID, SQLITE3_TEXT);
    $result = $stmt->execute();

    header("Location: ..\Manager.php");
}
?>