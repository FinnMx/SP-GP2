<?php
//Back end code for add enginner optional form in managers page 

//Check to see if user did click submit rather than entering information into the url.
if (isset($_POST['submit'])) {

    //Assign values from customer input to variables.
    $fName = $_POST['first_name'];
    $lName = $_POST['last_name'];
    $pword = $_POST['password'];
    $rePassword = $_POST['re_password'];
    $engineerRate = $_POST['engineer_rate'];
    $groupID = ['group_id'];
    
    


    //link of functions page
    require_once 'functions.inc.php';

    //Check if any customer inputs are empty.
    if (emptyInputApply($fName, $lName, $email, $pword, $rePassword, $engineerRate, $groupID) !== false) {
        header("Location:../register.php?error=emptyinput");
        exit();
    }
    //Check if first name contains valid characters.
    if (invalidFN($fName) !== false) {
        header("Location:../register.php?error=invalidfirstname");
        exit();
    }
    //Check if lastr name contains valid characters.
    if (invalidLN($lName) !== false) {
        header("Location:../register.php?error=invalidlastname");
        exit();
    }
    //Check if email is valid.
    if (invalidEmail($email) !== false) {
        header("location:../register.php?error=invalidemail");
        exit();
    }
    //Check if email is taken
    if(emailMatch($email)!== false)
    {
        header("location:../register.php?error=emailtaken");
        exit();
    }
    //Check password and re-entered password match
    if (passwordMismatch($pword, $rePassword) !== false) {
        header("location:../register.php?error=passwordmissmatch");
        exit();
    }
    //Insert customer into database.
    if (createCustomer($fName, $lName, $email, $pword, $adminId ) !== true) {
        header("location:../register.php?error=stmtfailed");
        exit();
    } else {
        header("location:../registrationsuccessfull.php");
        exit();
    }
    
} else {
    header("Location:../register.php?error=unauthorisedentry");
    exit();
}

?>