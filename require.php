<?php
//Session start function, for variables across all pages during the session.
session_start();
//displays header and footer on all pages.
require("header.php");
require("footer.php");
require("includes/functions.inc.php");
require("includes/assign_group.inc.php");
require("includes/connection.inc.php");
require("includes/create_project.inc.php");
require("includes/customer_satisfaction.inc.php");
require("includes/reassign_member.inc.php");
