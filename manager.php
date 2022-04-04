<?php
//session,header and footer
require("require.php");

//error_reporting(0);

ob_start(); // start session allows us to transfer data through pages. 
?>
<!--Basic html 5 setup-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<br>

<body>
    <div class="container">

        <!-- CREATE
        ----------------------------------------------------------------------------------------------------->

        <h1 style="color:#fff">CREATE</h1>
        <hr style="border:2px; color:white"><br>

        <div class="row">

            <div class="col-md-2"></div>

            <!-- CREATE ENGINEER -->
            <div class="col-md-4">
                <div class="w-box">
                    <!--Form to create an engineer-->
                    <form method="post">
                        <div>
                            <h3 style="color:#0C4582; text-align:center">CREATE ENGINEER</h3>
                            <br>

                            <b style="color:#0C4582">FIRST NAME</b>
                            <input class="form-group b-input" type="text" name="first_name" placeholder="First name">
                            <br><br>

                            <b style="color:#0C4582">LAST NAME</b>
                            <input class="form-group b-input" type="text" name="last_name" placeholder="Last name">
                            <br><br>

                            <b style="color:#0C4582">PASSWORD</b>
                            <input class="form-group b-input" type="password" name="password" placeholder="Password">
                            <br><br>

                            <b style="color:#0C4582">RE-ENTER PASSWORD</b>
                            <input class="form-group b-input" type="password" name="re_password" placeholder="Re-enter password">
                            <br><br>

                            <b style="color:#0C4582">PAY RATE</b>
                            <input class="form-group b-input" type="number" name="engineer_rate" placeholder="Pay rate" min="1">
                            <br><br>

                            <b style="color:#0C4582">ASSIGN TO GROUP</b>
                            <div class="row">
                                <div class="col">
                                    <select class="form-group col-md-12" name="group_id" id="group_id">
                                        <?php
                                        $sql = "SELECT DISTINCT Group_ID FROM Groups"; // selecting only unique group_ID's from the table.
                                        $stmt = $db->prepare($sql);
                                        $result = $stmt->execute();

                                        $arrayResult = []; //prepare an empty array first
                                        while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
                                            $arrayResult[] = $row; //adding a record until end of records
                                        }

                                        for ($i = 0; $i < count($arrayResult); $i++) : //for loop to echo out each group ID into the select box 
                                            $value = $arrayResult[$i]['Group_ID'];
                                            echo '<option value="' . $value . '" selected>' . $value . '</option>';
                                        ?>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <input class="btn btn-main" type='submit' value="CREATE NEW GROUP" name='create_new_group'>
                                </div>
                            </div>

                            <br><br>

                            <div class="form-group">
                                <input class="btn btn-main" type='submit' value="CREATE NEW ENGINEER" name='submitE'>
                            </div>
                            <?php
                            //Error messages for create engineer form
                            if (isset($_GET["error"])) {
                                if ($_GET["error"] == "emptyinput") {
                                    echo "Empty fields are not allowed";
                                } elseif ($_GET["error"] == "invalidfirstname") {
                                    echo "First name field will only accept characters!";
                                } elseif ($_GET["error"] == "invalidlastname") {
                                    echo "Last name field will only accept characters!";
                                } elseif ($_GET["error"] == "passwordmissmatch") {
                                    echo "Password missmatch!";
                                } elseif ($_GET["error"] == "stmtfailed") {
                                    echo "We seem to be having technical issues please try again later!";
                                }
                                //Success message if all checks are passed    
                            } else if (isset($_GET["success"])) {
                                if ($_GET["success"] == "createdsuccessfully") {
                                    echo "Successfully created";
                                }
                            }

                            if (isset($_POST['create_new_group'])) { //method to create new group ID from largest

                                $sql = "SELECT MAX(group_id) FROM Groups"; // the MAX(..) function selects the highest value in the column
                                $stmt = $db->prepare($sql);
                                $result = $stmt->execute();
                                $arrayResult = []; //prepare an empty array first
                                while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
                                    $arrayResult[] = $row; //adding a record until end of records
                                }
                                $sql = "INSERT INTO Groups VALUES(:gid +1,0)"; // inserts a new group into the database
                                $stmt = $db->prepare($sql);
                                $stmt->bindParam(':gid', $arrayResult[0][0], SQLITE3_TEXT);

                                $result = $stmt->execute();
                            }
                            if (isset($_POST['submitE'])) {
                                $fName = $_POST['first_name'];
                                $lName = $_POST['last_name'];
                                $pword = $_POST['password'];
                                $rePword = $_POST['re_password'];
                                $eRate = $_POST['engineer_rate'];
                                $GID = $_POST['group_id'];

                                //Check if any inputs are empty.
                                if (emptyInputEngineer($fName, $lName, $pword, $rePword, $eRate) !== false) {
                                    header("Location:manager.php?error=emptyinput");
                                    exit();
                                }
                                //Check if first name contains valid characters.
                                if (invalidFN($fName) !== false) {
                                    header("Location:manager.php?error=invalidfirstname");
                                    exit();
                                }
                                //Check if last name contains valid characters.
                                if (invalidLN($lName) !== false) {
                                    header("Location:manager.php?error=invalidlastname");
                                    exit();
                                }
                                //Check passwords match
                                if (passwordMismatch($pword, $rePword) !== false) {
                                    header("Location:manager.php?error=passwordmissmatch");
                                    exit();
                                }
                                //Create engineer
                                if (createEngineer($fName, $lName, $pword, $GID, $eRate) !== true) {
                                    header("location:manager.php?error=stmtfailed");
                                    exit();
                                } else {
                                    header("location:manager.php?success=createdsuccessfully");
                                    exit();
                                }
                            }
                            ?>

                        </div>
                    </form>
                </div>
            </div>

            <!-- CREATE PROJECT -->
            <div class="col-md-4">
                <div class="w-box">
                    <!--Form to create projects-->
                    <form action="includes/create_project.inc.php" method="post">
                        <div>
                            <h3 style="color:#0C4582; text-align:center">CREATE PROJECT</h3>
                            <br>
                            <?php
                            $sql = "SELECT MAX(Project_ID) FROM Project"; // the MAX(..) function selects the highest value in the column
                            $stmt = $db->prepare($sql);
                            $result = $stmt->execute();
                            $NarrayResult = []; //prepare an empty array first
                            while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
                                $NarrayResult[] = $row; //adding a record until end of records
                            }
                            $newID = $NarrayResult[0][0] +1;
                            ?>

                            <b style="color:#0C4582">PROJECT ID</b>
                            <input class="form-group b-input" type="number" value="<?= $newID ?>" name="project_id" placeholder="Project ID" min="1" readonly>
                            <br><br>

                            <b style="color:#0C4582">PROJECT NAME</b>
                            <input class="form-group b-input" type="text" name="project_name" placeholder="Project name">
                            <br><br>

                            <b style="color:#0C4582">PROJECT VALUE</b>
                            <input class="form-group b-input" type="number" name="project_value" placeholder="Project Value" min="1">
                            <br><br>

                            <b style="color:#0C4582">TIMESCALE</b>
                            <input class="form-group b-input" type="number" name="timescale" placeholder="Timescale" min="1">
                            <br><br>

                            <b style="color:#0C4582">MATERIAL COST</b>
                            <input class="form-group b-input" type="number" name="material_cost" placeholder="Material cost" min="1">
                            <br><br>

                            <b style="color:#0C4582">ADDITIONAL COST</b>
                            <input class="form-group b-input" type="number" name="additional_cost" placeholder="Additional cost" min="1">
                            <br><br>

                            <b style="color:#0C4582">COMMENTS</b>
                            <input class="form-control b-input" type="text" name="comments" placeholder="Comments on cost and job specifics">
                            <br>


                            <br>
                            <div class="form-group">
                                <input class="btn btn-main" type='submit' value="CREATE PROJECT" name='submitCP'>
                            </div>
                            <br>

                            <?php
                            if (isset($_GET["errorp"])) {
                                if ($_GET["errorp"] == "emptyinput") {
                                    echo "Empty fields are not allowed";
                                }
                            } else if (isset($_GET["successp"])) {
                                if ($_GET["successp"] == "createdsuccessfully") {
                                    echo "Successfully created";
                                }
                            }
                            ?>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>


        <!-- GROUPS 
        ----------------------------------------------------------------------------------------------------->

        <h1 style="color:#fff">GROUPS & PROJECTS</h1>
        <hr style="border:2px; color:white"><br>

        <div class="row">
            <div class="col-md-2"></div>

            <div class="col-md-4">

                <!-- VIEW GROUP -->
                <div class="w-box">

                    <!--Form to view groups assigned projects -->
                    <form method="post">
                        <h3 style="color:#0C4582; text-align:center">VIEW GROUP</h3>
                        <br>
                        <div class="row" style="text-align:center">
                            <div class="col">
                                <b style="color:#0C4582">SELECT GROUP</b>
                                <br>
                                <select class="form-group" name="group_id_selected" id="group_id">
                                    <?php
                                    $sql = "SELECT DISTINCT Group_ID FROM Groups";
                                    $stmt = $db->prepare($sql);
                                    $result = $stmt->execute();

                                    $arrayResult = []; //prepare an empty array first
                                    while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
                                        $arrayResult[] = $row; //adding a record until end of records
                                    }

                                    for ($i = 0; $i < count($arrayResult); $i++) :
                                        $value = $arrayResult[$i]['Group_ID'];
                                        echo '<option value="' . $value . '">' . $value . '</option>';

                                    ?>

                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input class="btn btn-main" type='submit' value="VIEW" name='submitG' />
                                    <?php
                                    if (isset($_POST['submitG'])) {
                                        $_SESSION['group_id_selected'] = $_POST['group_id_selected'];
                                        header("Location: ViewGroups.php?gid=" . $_POST['group_id_selected']);
                                        ob_end_flush();
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <br>

                <!-- VIEW PROJECT -->
                <div class="w-box">

                    <!--Form to view projects -->
                    <form method="post">
                        <h3 style="color:#0C4582; text-align:center">VIEW PROJECT</h3>
                        <br>
                        <div class="row" style="text-align:center">
                            <div class="col">
                                <b style="color:#0C4582">SELECT PROJECT</b>
                                <br>
                                <select class="form-group" name="project_id_selected" id="project_id">
                                    <?php
                                    $sql = "SELECT Project_ID FROM Project WHERE Status =:st";
                                    $stmt = $db->prepare($sql);
                                    $status = 'Active';
                                    $stmt->bindParam(':st', $status, SQLITE3_TEXT);
                                    $result = $stmt->execute();

                                    $arrayResult = []; //prepare an empty array first
                                    while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
                                        $arrayResult[] = $row; //adding a record until end of records
                                    }

                                    for ($i = 0; $i < count($arrayResult); $i++) :
                                        $value = $arrayResult[$i]['Project_ID'];
                                        echo '<option value="' . $value . '">' . $value . '</option>';

                                    ?>

                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input class="btn btn-main" type='submit' value="VIEW" name='submitP'>
                                    <?php
                                    if (isset($_POST['submitP'])) {
                                        $_SESSION['project_id_selected'] = $_POST['project_id_selected']; // sets the SESSION variable to the POST input
                                        header("Location: ViewProject.php?pid=" . $_POST['project_id_selected']);
                                        ob_end_flush();
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <br>

            </div>

            <!-- ASSIGN GROUPS -->
            <div class="col-md-4">
                <div class="w-box" style="text-align:center">

                    <!--Form to assign groups to projects-->
                    <form action="includes/assign_group.inc.php" method="post">
                        <div>
                            <h3 style="color:#0C4582; text-align:center">ASSIGN GROUPS</h5>
                                <br>
                                <div class="row">
                                    <div class="col">
                                        <b style="color:#0C4582">ASSIGN GROUP</b>
                                        <br>
                                        <select class="form-group" name="group_id" id="group_id">
                                            <?php
                                            $sql = "SELECT DISTINCT Group_ID FROM Groups";
                                            $stmt = $db->prepare($sql);
                                            $result = $stmt->execute();

                                            $arrayResult = []; //prepare an empty array first
                                            while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
                                                $arrayResult[] = $row; //adding a record until end of records
                                            }

                                            for ($i = 0; $i < count($arrayResult); $i++) :
                                                $value = $arrayResult[$i]['Group_ID'];
                                                echo '<option value="' . $value . '">' . $value . '</option>';

                                            ?>

                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-1"><b style="color:#0C4582">TO</b></div>
                                    <div class="col">
                                        <b style="color:#0C4582">PROJECT</b>
                                        <br>
                                        <select class="form-group" name="project_id_selected" id="project_id">
                                        <?php
                                        $sql = "SELECT Project_ID FROM Project WHERE Status =:st";
                                        $stmt = $db->prepare($sql);
                                        $status = 'Active';
                                        $stmt->bindParam(':st', $status, SQLITE3_TEXT);
                                        $result = $stmt->execute();

                                        $arrayResult = []; //prepare an empty array first
                                        while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
                                            $arrayResult[] = $row; //adding a record until end of records
                                        }

                                        for ($i = 0; $i < count($arrayResult); $i++) :
                                            $value = $arrayResult[$i]['Project_ID'];
                                            
                                            echo '<option value="' . $value . '">' . $value . '</option>';

                                    ?>

                                    <?php endfor; ?>
                                    </select>
                                    </select>
                                    </div>
                                </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <input class="btn btn-main" type='submit' value="CONFIRM ASSIGNMENT" name='submitAG'>
                        </div>
                    </form>
                </div>
            </div>


        </div>
        <br>


        <!-- CUSTOMER FEEDBACK
        ----------------------------------------------------------------------------------------------------->

        <h1 style="color:#fff">CUSTOMER FEEDBACK</h1>
        <hr style="border:2px; color:white"><br>

        <div class="row">
            <div class="col-md-2"></div>

            <!-- CUSTOMER FEEDBACK -->
            <div class="col-md-8">
                <div class="w-box">
                    <!--Form to input customer satisfaction once project is complete -->
                    <form action="includes/customer_satisfaction.inc.php" method="post">
                        <h3 style="color:#0C4582; text-align:center">CUSTOMER FEEDBACK</h5>
                            <br>
                            <div class="row" style="text-align:center">
                                <div class="col">
                                    <b style="color:#0C4582">PROJECT ID</b>
                                    <br>
                                    <select class="form-group" name="project_id_selected" id="project_id">
                                    <?php
                                    $sql = "SELECT Project_ID FROM Project WHERE Status =:st";
                                    $stmt = $db->prepare($sql);
                                    $status = 'Active';
                                    $stmt->bindParam(':st', $status, SQLITE3_TEXT);
                                    $result = $stmt->execute();

                                    $arrayResult = []; //prepare an empty array first
                                    while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
                                        $arrayResult[] = $row; //adding a record until end of records
                                    }

                                    for ($i = 0; $i < count($arrayResult); $i++) :
                                        $value = $arrayResult[$i]['Project_ID'];
                                        echo '<option value="' . $value . '">' . $value . '</option>';

                                    ?>

                                    <?php endfor; ?>
                                    </select>
                                    </div>
                                    <div class="col">
                                    <b style="color:#0C4582">CUSTOMER SATISFACTION (1-10)</b>
                                    <br>
                                    <input class="form-group" type="number" name="customer_satisfaction" min="0" max="10">
                                    <br>
                                </div>


                                <b style="color:#0C4582">COMMENTS</b>
                                <br><br>
                                <input class="form-control b-input" type="text" name="xxxxx" placeholder="Comments and notes on customer satisfaction with project">
                                <br>
                                <div class="form-group">
                                    <br>
                                    <input class="btn btn-main" type='submit' value="SUBMIT" name='submitCS'>
                                </div>
                                <br>
                                <?php
                                if (isset($_GET["errorcs"])) {
                                    if ($_GET["errorcs"] == "emptyinput") {
                                        echo "Empty fields are not allowed";
                                    }
                                } else if (isset($_GET["successcs"])) {
                                    if ($_GET["successcs"] == "updatesuccess") {
                                        echo "Successfully updated this project is now closed!";
                                    }
                                }
                                ?>
                            </div>


                    </form>
                </div>
            </div>

            <div class="row">

            </div> <!-- container -->
            <br><br>
</body>

</html>