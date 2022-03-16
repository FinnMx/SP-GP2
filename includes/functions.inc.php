<?php
//Organisational page for all functions to be held in one place.
/**
 * Notes for functions
 * needed - fuction to calculate Engineer_cost from Engineer_rate and Timescale
 * needed - 
*/


//The following functions apply to the registration form
//Function to check for empty inputs.
function emptyInputApply($fName, $lName, $pword, $email)
{

    if (empty($fName) || empty($lName) || empty($email) || empty($pword)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
//Function to check for invalid chars in first name.
function invalidFN($fName)
{

    if (!preg_match("/^[a-zA-Z]*$/", $fName)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
//Function to check for invalid chars in last name.
function invalidLN($lName)
{

    if (!preg_match("/^[a-zA-Z]*$/", $lName)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
//Function to check for invalid email addresses.
function invalidEmail($email)
{

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
//Function to check if the inputted email is already in use.
function emailMatch($email)
{
    //this variable is used to indicate the creation is successfull or not.
    $sqliteDebug = true;
    try {
        // attempt connection.
        $db = new SQLite3('/Applications/XAMPP/data/publicnewsapplication.db');
    } catch (Exception $exception) {
        // sqlite3 throws an exception when it is unable to connect.
        echo '<p>There was an error connecting to the database!</p>';
        if ($sqliteDebug) {
            echo $exception->getMessage();
        }
    }
    //SQL select statement to identify customer details.
    $sql = "SELECT * FROM Member";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute();

    //prepare an empty array 
    $arrayResult = [];
    //Itereate through results to find matching details.
    while ($row = $result->fetchArray()) {
        $arrayResult[] = $row;
    }
    for ($i = 0; $i < count($arrayResult); $i++) :
        $emailExists = $arrayResult[$i]['Email'];


    endfor;
    //Compare inputed email with records taken from the database.
    if ($email == $emailExists) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
//Function to check that the password and re-entered password match.
function passwordMismatch($pword, $rePassword)
{
    if ($pword !== $rePassword) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
//Function to create a customer and assign to member table in the database.
function createCustomer($fName, $lName, $email, $pword, $adminId)
{

    //this variable is used to indicate the creation is successfull or not.
    $sqliteDebug = true;
    try {
        // attempt connection.
        $db = new SQLite3('/Applications/XAMPP/data/publicnewsapplication.db');
    }
    //catch exceptions.
    catch (Exception $exception) {
        // sqlite3 throws an exception when it is unable to connect.
        echo '<p>There was an error connecting to the database!</p>';
        if ($sqliteDebug) {
            echo $exception->getMessage();
        }
    }
    //SQL insert statement for insertion into the member table of the database.
    $sql = "INSERT INTO Member(First_name,Last_name, Email, Member_password, Admin_id) VALUES (:fName, :lName, :email, :pword, :adminId)";
    //prepare the SQL statement.
    $stmt = $db->prepare($sql);
    //give the values for the parameters.
    $stmt->bindParam(':fName', $fName, SQLITE3_TEXT);
    $stmt->bindParam(':lName', $lName, SQLITE3_TEXT);
    $stmt->bindParam(':email', $email, SQLITE3_TEXT);
    $stmt->bindParam(':pword', $pword, SQLITE3_TEXT);
    $stmt->bindParam(':adminId', $adminId, SQLITE3_TEXT);


    //execute the sql statement.
    $stmt->execute();

    //the logic.
    if ($stmt) {

        $created = true;
    } else {

        $created = false;
    }

    return $created;
}
//The following functions apply to the customer login form.
//Function to check if user inputs are left empty.
function emptyCustomerLogin($userEmail, $userPassword)
{
    if (empty($userEmail)  || empty($userPassword)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function loginCustomer($userEmail, $userPassword)
{
    //this variable is used to indicate the creation is successfull or not.
    $sqliteDebug = true;
    try {
        // attempt connection.
        $db = new SQLite3('/Applications/XAMPP/data/publicnewsapplication.db');
    } catch (Exception $exception) {
        // sqlite3 throws an exception when it is unable to connect.
        echo '<p>There was an error connecting to the database!</p>';
        if ($sqliteDebug) {
            echo $exception->getMessage();
        }
    }
    //SQL select statement to identify customer details.
    $sql = "SELECT * FROM Member";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute();

    //prepare an empty array 
    $arrayResult = [];
    //Itereate through results to find matching details.
    while ($row = $result->fetchArray()) {
        $arrayResult[] = $row;
    }
    for ($i = 0; $i < count($arrayResult); $i++) :
        $emailExists = $arrayResult[$i]['Email'];
        $pwdExists = $arrayResult[$i]['Member_password'];

    endfor;
    if (($userEmail !== $emailExists) && ($userPassword !== $pwdExists)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
//The following functions apply to the Admin login form.
//Function to check if user inputs are left empty.
function emptyAdminLogin($adminUsername, $adminPassword)
{
    if (empty($adminUsername)  || empty($adminPassword)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function loginUser($adminUsername, $adminPassword)
{
    //this variable is used to indicate the creation is successfull or not
    $sqliteDebug = true;
    try {
        // attempt connection
        $db = new SQLite3('/Applications/XAMPP/data/publicnewsapplication.db');
    } catch (Exception $exception) {
        // sqlite3 throws an exception when it is unable to connect
        echo '<p>There was an error connecting to the database!</p>';
        if ($sqliteDebug) {
            echo $exception->getMessage();
        }
    }

    $sql = "SELECT * FROM Admin";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute();

    $arrayResult = []; //prepare an empty array first
    while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
        $arrayResult[] = $row; //adding a record until end of records
    }
    for ($i = 0; $i < count($arrayResult); $i++) :
        $nameExists = $arrayResult[$i]['Username'];
        $pwdExists = $arrayResult[$i]['Admin_password'];

    endfor;
    if (($adminUsername !== $nameExists) && ($adminPassword !== $pwdExists)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
