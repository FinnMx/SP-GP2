<?php
//Organisational page for all functions to be held in one place.
/**
 * Notes for functions
 * needed - fuction to calculate Engineer_cost from Engineer_rate and Timescale
 * needed - 
 */


//------------------------------ The following functions apply to the engineer creation form -----------------------------------------------------------

//Function to check for empty inputs.
function emptyInputEngineer($fName, $lName, $pword, $rePword, $eRate)
{

    if (empty($fName) || empty($lName) ||  empty($pword) || empty($rePword) || empty($eRate)) {
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
//Function to create a engineer and insert into engineer table in the database.
function createEngineer($fName, $lName, $pword, $GID, $eRate)
{
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

    $sql = "INSERT INTO Engineer VALUES(:eid,:fname,:lname,:pwd,:gid,:er,:st)";
    $stmt = $db->prepare($sql);
    $status = "active";

    $EngineerID = substr($_POST['first_name'], 0) . rand(1000, 9999); // generates the EngineerID with a random number.

    $stmt->bindParam(':eid', $EngineerID, SQLITE3_TEXT);
    $stmt->bindParam(':fname', $fName, SQLITE3_TEXT);
    $stmt->bindParam(':lname', $lName, SQLITE3_TEXT);
    $stmt->bindParam(':pwd', $pword, SQLITE3_TEXT);
    $stmt->bindParam(':gid', $GID, SQLITE3_TEXT);
    $stmt->bindParam(':er', $eRate, SQLITE3_TEXT);
    $stmt->bindParam(':st', $status, SQLITE3_TEXT);
    $stmt->execute();

    //the logic.
    if ($stmt) {

        $created = true;
    } else {

        $created = false;
    }

    return $created;
}
//------------------------------ The following functions apply to the project creation form -----------------------------------------------------------
//Checking for empty inputs.AdditionalCost, Comments, CustomerSatisfaction and Status can be left blank or are auto-assigned, so are not checked.
function emptyInputProject($ProjectID, $ProjectName, $ProjectVal, $MaterialCost, $Timescale)
{

    if (empty($ProjectID) || empty($ProjectName) ||  empty($ProjectVal) || empty($MaterialCost) || empty($Timescale)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
//function to create a new project.
function CreateProject($ProjectID, $ProjectName, $ProjectVal, $MaterialCost, $AdditionalCost, $Comments, $CustomerSatisfaction, $Status, $Timescale)
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
    }

    $sql = "INSERT INTO Project VALUES(:pid,:pname,:pval,:ecost,:mcost,:addcost,:comments,:cs,:status,:ts)";
    $stmt = $db->prepare($sql);
    $EngineerCost = 0;


    $stmt->bindParam(':pid', $ProjectID, SQLITE3_TEXT);
    $stmt->bindParam(':pname', $ProjectName, SQLITE3_TEXT);
    $stmt->bindParam(':pval', $ProjectVal, SQLITE3_TEXT);
    $stmt->bindParam(':ecost', $EngineerCost, SQLITE3_TEXT);
    $stmt->bindParam(':mcost', $MaterialCost, SQLITE3_TEXT);
    $stmt->bindParam(':addcost', $AdditionalCost, SQLITE3_TEXT);
    $stmt->bindParam(':comments', $Comments, SQLITE3_TEXT);
    $stmt->bindParam(':cs', $CustomerSatisfaction, SQLITE3_TEXT);
    $stmt->bindParam(':status', $Status, SQLITE3_TEXT);
    $stmt->bindParam(':ts', $Timescale, SQLITE3_TEXT);

    $stmt->execute();

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

    for ($i = 0; $i < count($G2arrayResult); $i++) {
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
