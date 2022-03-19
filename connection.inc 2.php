<?php
//this variable is used to indicate the creation is successfull or not.
$sqliteDebug = true;
try {
    // attempt connection.
    $db = new SQLite3('C:\xampp\htdocs\myDB.db');
} catch (Exception $exception) {
    // sqlite3 throws an exception when it is unable to connect.
    if ($sqliteDebug) {
        try {
            // attempt connection.
            $db = new SQLite3('/Applications/XAMPP/data/myDB.db');
        } catch (Exception $exception) {
            // sqlite3 throws an exception when it is unable to connect.
            echo '<p>There was an error connecting to the database!</p>';
            if ($sqliteDebug) {
                echo $exception->getMessage();
            }
        }
    }
}
