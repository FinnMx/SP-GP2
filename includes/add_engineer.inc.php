<?php
//Back end code for add enginner optional form in managers page 

//Check to see if user did click submit rather than entering information into the url.
if (isset($_POST['submit'])) {

    //Assign values from Engineer input to variables.
    $fName = $_POST['first_name'];
    $lName = $_POST['last_name'];
    $pword = $_POST['password'];
    $rePassword = $_POST['re_password'];
    $engineerRate = $_POST['engineer_rate'];
    $groupID = ['group_id'];





    //link of functions page
    require_once 'functions.inc.php';

    //Check if any Engineer inputs are empty.
    if (emptyInputApply($fName, $lName, $pword, $rePassword, $engineerRate, $groupID) !== false) {
        header("Location:../manager.php?error=emptyinput");
        exit();
    }
    //Check if first name contains valid characters.
    if (invalidFN($fName) !== false) {
        header("Location:../manager.php?error=invalidfirstname");
        exit();
    }
    //Check if lastr name contains valid characters.
    if (invalidLN($lName) !== false) {
        header("Location:../manager.php?error=invalidlastname");
        exit();
    }
    //Check password and re-entered password match
    if (passwordMismatch($pword, $rePassword) !== false) {
        header("location:../manager.php?error=passwordmissmatch");
        exit();
    }
    //Insert Engineer into database.
    if (createEngineer($fName, $lName, $pword, $engineerRate, $groupID) !== true) {
        header("location:../manager.php?error=stmtfailed");
        exit();
    } else {
        header("location:../manager.php");
        exit();
    }
} else {
    header("Location:../manager.php?error=unauthorisedentry");
    exit();
}
