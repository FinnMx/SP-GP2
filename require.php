<?php
//Session start function, for variables across all pages during the session.
//session_start();
//displays header and footer on all pages.
require("header.php");
require("footer.php");
require("includes/functions.inc.php");
require("includes/assign_group.inc.php");
//require("includes/connection.inc.php");
require("includes/create_project.inc.php");
require("includes/customer_satisfaction.inc.php");
require("includes/reassign_member.inc.php");


$user_agent = getenv("HTTP_USER_AGENT");

if (strpos($user_agent, "Win") !== FALSE)
    $os = "Windows";
elseif (strpos($user_agent, "Mac") !== FALSE)
    $os = "Mac";

if ($os === "Windows") {
    $db = new SQLite3('C:\xampp\htdocs\myDB.db');
} elseif ($os === "Mac") {
    try {
        $db = new SQLite3('/Applications/XAMPP/data/myDB.db');
    } catch (Exception $e) {
        $db = new SQLite3('/Applications/MAMP/htdocs/SP-GP2/myDB.db');
    }
};
