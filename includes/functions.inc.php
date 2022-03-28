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
//function to count number of engineers with a project
function countEngineers($projectID)
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

    $sql = "SELECT * from Project WHERE Project_ID = :pid";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':pid', $projectId, SQLITE3_TEXT);
    $stmt->execute();

    $rowCount = mysqli_num_rows($db);

    // Display result
    printf("Total rows in this table :  %d\n", $rowCount);

    return $rowCount;
}
//Function to convert Engineer_rate and Timescale into Engineer_cost
function calculateEngineerCost($projectId)
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
    $sql = "SELECT Timescale FROM Project WHERE Project_ID =:pid";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':pid', $projectId, SQLITE3_TEXT);
    $result = $stmt->execute();

    $arrayResult = []; //prepare an empty array first
    while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
        $arrayResult[] = $row; //adding a record until end of records
    }
    //stores the timescale
    $timescale = $arrayResult[0][0];
    $firstTotal = 0;
    $Zarray = array();
    $total = 0;

    //selects each group_ID working on the given project
    $sql = "SELECT DISTINCT Group_ID FROM Groups WHERE Project_ID=:pid";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':pid', $projectId, SQLITE3_TEXT);
    $result = $stmt->execute();

    $G2arrayResult = []; //prepare an empty array first
    while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
        $G2arrayResult[] = $row; //adding a record until end of records
    }

    for($i = 0; $i < count($G2arrayResult); $i++){
        $sql = "SELECT Engineer_rate FROM Engineer WHERE Group_ID = :gid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':gid', $G2arrayResult[$i][0], SQLITE3_TEXT);
        $result = $stmt->execute();

        $AggregateEngineerRate = []; //prepare an empty array first
        while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
        $AggregateEngineerRate[] = $row; //adding a record until end of records
        }

        $AggregateEngineerRate = call_user_func_array('array_merge', $AggregateEngineerRate);
        array_pop($AggregateEngineerRate);
        $total += array_sum($AggregateEngineerRate);
    }

    $total = $total * 8;
    $totalEngineerCost = $total * $timescale;
    
    $sql = "UPDATE Project SET Engineer_cost =:ec  WHERE Project_ID =:pid";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':ec', $totalEngineerCost, SQLITE3_TEXT);
    $stmt->bindParam(':pid', $projectId, SQLITE3_TEXT);
    $stmt->execute(); 
}

/*function GetAllEngineers($ProjectID){
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

    $sql = "SELECT DISTINCT Engineer_ID, F_name, L_name, Engineer.Group_ID, Engineer_rate FROM Engineer  
    INNER JOIN Groups
    ON Groups.Group_ID = Engineer.Group_ID
    INNER JOIN Project 
    ON Groups.Project_ID = Project.Project_ID
    WHERE Project.Project_ID = :pid"; //epic way to inner join everything

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':pid', $projectID, SQLITE3_TEXT);
    $result = $stmt->execute(); 

    $EarrayResult = []; //prepare an empty array first
    while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
        $EarrayResult[] = $row; //adding a record until end of records
    }

    $finalResult = $EarrayResult;

    return $finalResult;

}dont know why this wont work as a function but works on the page bruh*/


//function to calculate profit from other project metrics
function calculateProfit($projectId, $projectValue, $engineerCost, $materialCost, $additionalCost)
{
    $cost = $engineerCost + $materialCost + $additionalCost;
    $profit = $projectValue - $cost;

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

    $sql = "UPDATE Project SET Profit =:p  WHERE Project_ID =:pid";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':p', $profit, SQLITE3_TEXT);
    $stmt->bindParam(':pid', $projectId, SQLITE3_TEXT);
    $stmt->execute();
}
