<?php
//Organisational page for all functions to be held in one place.
/**
 * Notes for functions
 * needed - fuction to calculate Engineer_cost from Engineer_rate and Timescale
 * needed - 
 */


//The following functions apply to the registration form
//Function to check for empty inputs.
function emptyInputApply($fName, $lName, $pword, $rePassword, $engineerRate, $groupID)
{

    if (empty($fName) || empty($lName) ||  empty($pword) || empty($rePassword) || empty($engineerRate) || empty($groupID)) {
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
function createEngineer($fName, $lName, $pword, $groupID, $engineerRate)
{

    //this variable is used to indicate the creation is successfull or not.
    $sqliteDebug = true;
    try {
        // attempt connection.
        $db = new SQLite3('C:\xampp\htdocs\myDB.db');
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
    $sql = "INSERT INTO Engineer(F_name,L_name, Password, Group_ID, Engineer_rate) VALUES (:fName, :lName, :pword, groupId :engineerRate, )";
    //prepare the SQL statement.
    $stmt = $db->prepare($sql);
    //give the values for the parameters.
    $stmt->bindParam(':fName', $fName, SQLITE3_TEXT);
    $stmt->bindParam(':lName', $lName, SQLITE3_TEXT);
    $stmt->bindParam(':pword', $pword, SQLITE3_TEXT);
    $stmt->bindParam(':groupId', $groupID, SQLITE3_TEXT);
    $stmt->bindParam(':engineerRate', $adminId, SQLITE3_TEXT);


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
