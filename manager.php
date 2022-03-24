<?php
//session,header and footer
require("require.php");

session_start();
error_reporting(0);
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
                                            $sql = "SELECT Group_ID FROM Groups";
                                            $stmt = $db->prepare($sql);
                                            $result = $stmt->execute();

                                            $arrayResult = []; //prepare an empty array first
                                            while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
                                                $arrayResult[] = $row; //adding a record until end of records
                                            }

                                            for ($i = 0; $i < count($arrayResult); $i++) :
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

                                if (isset($_POST['create_new_group'])) { //method to create new group ID from largest

                                    $sql = "SELECT MAX(group_id) FROM Groups";
                                    $stmt = $db->prepare($sql);
                                    $result = $stmt->execute();
                                    $arrayResult = []; //prepare an empty array first
                                    while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
                                        $arrayResult[] = $row; //adding a record until end of records
                                    }
                                    $sql = "INSERT INTO Groups VALUES(:gid +1,0)";
                                    $stmt = $db->prepare($sql);
                                    $stmt->bindParam(':gid', $arrayResult[0][0], SQLITE3_TEXT);

                                    $result = $stmt->execute();
                                }
                                if (isset($_POST['submitE'])) {

                                    $boolCheck = passwordMismatch($_POST['password'], $_POST['re_password']);
                                    echo $boolCheck;

                                    if ($boolCheck != 1) {

                                        $sql = "INSERT INTO Engineer VALUES(:eid,:fname,:lname,:pwd,:gid,:er,:st)";
                                        $stmt = $db->prepare($sql);

                                        $status = "active";

                                        $EngineerID = substr($_POST['first_name'], 0) . rand(1000, 9999);

                                        $stmt->bindParam(':eid', $EngineerID, SQLITE3_TEXT);
                                        $stmt->bindParam(':fname', $_POST['first_name'], SQLITE3_TEXT);
                                        $stmt->bindParam(':lname', $_POST['last_name'], SQLITE3_TEXT);
                                        $stmt->bindParam(':pwd', $_POST['password'], SQLITE3_TEXT);
                                        $stmt->bindParam(':gid', $_POST['group_id'], SQLITE3_TEXT);
                                        $stmt->bindParam(':er', $_POST['engineer_rate'], SQLITE3_TEXT);
                                        $stmt->bindParam(':st', $status, SQLITE3_TEXT);
                                        $result = $stmt->execute();

                                        echo "account succesfully created";
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

                                <b style="color:#0C4582">PROJECT ID</b>
                                <input class="form-group b-input" type="number" name="project_id" placeholder="Project ID" min="1">
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
                        </div>
                        <br>
                        <div class="form-group">
                            <input class="btn btn-main" type='submit' value="CREATE PROJECT" name='submitCP'>
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
                    <form action="ViewGroups.php" method="post">
                        <h3 style="color:#0C4582; text-align:center">VIEW GROUP</h3>
                        <br>
                        <div class="row" style="text-align:center">
                            <div class="col">
                                <b style="color:#0C4582">SELECT GROUP</b>
                                <br>
                                <select class="form-group" name="group_id_selected" id="group_id">
                                    <?php
                                    $sql = "SELECT Group_ID FROM Groups";
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
                                    <input class="btn btn-main" type='submit' value="VIEW" name='submitG'>
                                    <?php
                                    if (isset($_POST['submitG'])) {
                                        $_SESSION['group_id_selected'] = $_POST['group_id_selected'];
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

                    <!--Form to view groups assigned projects -->
                    <form action="ViewProject.php" method="post">
                        <h3 style="color:#0C4582; text-align:center">VIEW PROJECT</h3>
                        <br>
                        <div class="row" style="text-align:center">
                            <div class="col">
                                <b style="color:#0C4582">SELECT PROJECT</b>
                                <br>
                                <select class="form-group" name="project_id_selected" id="project_id">
                                    <?php
                                    $sql = "SELECT Project_ID FROM Project";
                                    $stmt = $db->prepare($sql);
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
                                        $_SESSION['project_id_selected'] = $_POST['project_id_selected'];
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
                                        $sql = "SELECT Group_ID FROM Groups";
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
                                    <select class="form-group" name="project_id" id="project_id">
                                        <?php
                                        $sql = "SELECT Project_ID FROM Project";
                                        $stmt = $db->prepare($sql);
                                        $result = $stmt->execute();

                                        $arrayResult = []; //prepare an empty array first
                                        while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
                                            $arrayResult[] = $row; //adding a record until end of records
                                        }

                                        for ($i = 0; $i < count($arrayResult); $i++) :
                                            $value2 = $arrayResult[$i]['Project_ID'];
                                            echo '<option value="' . $value2 . '">' . $value2 . '</option>';

                                        ?>

                                        <?php endfor; ?>
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
                                <select class="form-group" name="project_id" id="project_id">
                                    <?php
                                    $sql = "SELECT Project_ID FROM Project";
                                    $stmt = $db->prepare($sql);
                                    $result = $stmt->execute();

                                    $arrayResult = []; //prepare an empty array first
                                    while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
                                        $arrayResult[] = $row; //adding a record until end of records
                                    }

                                    for ($i = 0; $i < count($arrayResult); $i++) :
                                        $value3 = $arrayResult[$i]['Project_ID'];
                                        echo '<option value="' . $value3 . '">' . $value3 . '</option>';

                                    ?>
                                    <?php endfor; ?>
                                </select>                                
                            </div>
                            <div class="col">
                                <b style="color:#0C4582">CUSTOMER SATISFACTION (1-10)</b>
                                <br>
                                <input class="form-group" type="number" name="customer_satisfaction" min="0" max="10">                                                               
                            </div>
                        </div>

                        <b style="color:#0C4582">COMMENTS</b>
                        <br>
                        <input class="form-control b-input" type="text" name="xxxxx" placeholder="Comments and notes on customer satisfaction with project">
                        <br>
                        <div class="form-group">
                            <input class="btn btn-main" type='submit' value="SUBMIT" name='submitCS'>
                        </div>
                    </form>
                </div>
            </div>

        <div class="row">

    </div> <!-- container -->
    <br><br>
</body>

</html>