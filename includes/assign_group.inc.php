<?php
if (isset($_POST['submitAG'])) {
    AssignGroup($_POST['group_id'], $_POST['project_id_selected']);
}

function AssignGroup($GID, $PID)
{
    $user_agent = getenv("HTTP_USER_AGENT");

    if (strpos($user_agent, "Win") !== FALSE)
        $os = "Windows";
    elseif (strpos($user_agent, "Mac") !== FALSE)
        $os = "Mac";

    if ($os === "Windows") {
        $db = new SQLite3('C:\xampp\htdocs\myDB.db');
    } elseif ($os === "Mac") {
        $db = new SQLite3('/Applications/XAMPP/data/myDB.db');
    };

    $sql = "INSERT INTO Groups VALUES(:gid,:pid)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':pid', $PID, SQLITE3_TEXT);
    $stmt->bindParam(':gid', $GID, SQLITE3_TEXT);
    $result = $stmt->execute();

    echo $GID;

    header("Location: ..\Manager.php");
}
