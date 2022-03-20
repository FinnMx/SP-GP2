<?php
//session,header and footer
require("require.php");
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

    <!--Form to create an engineer-->
    <div class="container">
    <div class="row">

        <div class="col-md-2"></div>
        <div class="col-md-4">
        <div class="w-box">
            <form method="post">
                <div>
                    <h5 style="color:#0C4582; text-align:center">CREATE ENGINEER</h3>
                    <br>
                    
                    <b style="color:#0C4582">FIRST NAME</b>                        
                    <input class="form-group b-input" type="text" name="first_name" placeholder="First name">
                    <br>

                    <b style="color:#0C4582">LAST NAME</b>
                    <input class="form-group b-input" type="text" name="last_name" placeholder="Last name">
                    <br>

                    <b style="color:#0C4582">PASSWORD</b>                    
                    <input class="form-group b-input" type="password" name="password" placeholder="Password">
                    <br>

                    <b style="color:#0C4582">RE-ENTER PASSWORD</b>
                    <input class="form-group b-input" type="password" name="re_password" placeholder="Re-enter password">
                    <br>

                    <b style="color:#0C4582">PAY RATE</b>
                    <input class="form-group b-input" type="number" name="engineer_rate" placeholder="Pay rate" min="1">
                    <br>

                    <b style="color:#0C4582">ASSIGN TO GROUP</b>
                    <select class="form-group col-md-12" name="group_id" id="group_id">
                        <?php
                        $db = new SQLite3('C:\xampp\htdocs\myDB.db');
                        $sql = "SELECT Group_ID FROM Groups";
                        $stmt = $db->prepare($sql);
                        $result = $stmt->execute();

                        $arrayResult = []; //prepare an empty array first
                        while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
                        $arrayResult[] = $row; //adding a record until end of records
                        }

                        for ($i = 0; $i < count($arrayResult); $i++) :
                        $value = $arrayResult[$i]['Group_ID'];
                        echo '<option value="'.$value.'">'.$value.'</option>';
                        ?>

                        <?php endfor;?>
                    </select>
                    <br>

                    <div class="form-group col-md-4">
                        <input class="btn btn-main" type='submit' value="submitE" name='submitE'>
                    </div>
                    <?php 
                        if (isset($_POST['submitE'])){

                            $boolCheck = passwordMismatch($_POST['password'], $_POST['re_password']);
                            echo $boolCheck;

                            if($boolCheck !=1){
                            
                                $db = new SQLite3('C:\xampp\htdocs\myDB.db');
                                $sql = "INSERT INTO Engineer VALUES(:eid,:fname,:lname,:pwd,:gid,:er,:st)";
                                $stmt = $db->prepare($sql);

                                $status = "active";

                                $EngineerID = substr($_POST['first_name'], 0).rand(1000,9999);

                                $stmt->bindParam(':eid', $EngineerID, SQLITE3_TEXT);
                                $stmt->bindParam(':fname', $_POST['first_name'], SQLITE3_TEXT);
                                $stmt->bindParam(':lname', $_POST['last_name'], SQLITE3_TEXT);
                                $stmt->bindParam(':pwd', $_POST['password'], SQLITE3_TEXT);
                                $stmt->bindParam(':gid',$_POST['group_id'], SQLITE3_TEXT);
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


        <!--Form to create projects projects-->
        <div class="col-md-4">
        <div class="w-box">
            <form action="includes/create_project.inc.php" method="post">
                <div>
                    <br>
                    <br>
                    <label class="label">Create Project</label>
                    <br>
                    <label class="label">Project ID:</label>
                    <br>
                    <input class="form-group col-md-4" type="number" name="project_id" placeholder="Project ID" min="1">
                    <br>
                    <label class="label">Project name:</label>
                    <br>
                    <input class="form-group col-md-4" type="text" name="project_name" placeholder="Project name">
                    <br>
                    <label class="label">Project Value:</label>
                    <br>
                    <input class="form-group col-md-4" type="number" name="project_value" placeholder="Project Value" min="1">
                    <br>
                    <label class="label">Engineer Cost:</label>
                    <br>
                    <input class="form-group col-md-4" type="number" name="engineer_cost" placeholder="Engineer Cost" min="1">
                    <br>
                    <label class="label">Material cost:</label>
                    <br>
                    <input class="form-group col-md-4" type="number" name="material_cost" placeholder="Material cost" min="1">
                    <br>
                    <label class="label">Additional cost:</label>
                    <br>
                    <input class="form-group col-md-4" type="number" name="additional_cost" placeholder="Additional cost" min="1">
                    <br>
                    <label class="label">Comments:</label>
                    <br>
                    <input class="form-control input-lg" type="text" name="comments" placeholder="Comments on cost and job specifics">
                    <br>
                </div>
                <div class="form-group col-md-4">
                    <input class="btn btn-primary" type='submit' value="submit" name='submit'>
                </div>

            </form>
        </div>
        </div>


        <!--Form to assign groups to projects-->
        <form action="includes/assign_group.inc.php" method="post">
            <div>
                <br>
                <br>
                <label class="label">Assign group to project</label>
                <br>
                <br>
                <label class="label">Group ID:</label>
                <br>
                <select class="form-group col-md-4" name="group_id" id="group_id">
                <?php
                $db = new SQLite3('C:\xampp\htdocs\myDB.db');
                $sql = "SELECT Group_ID FROM Groups";
                $stmt = $db->prepare($sql);
                $result = $stmt->execute();

                $arrayResult = []; //prepare an empty array first
                while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
                $arrayResult[] = $row; //adding a record until end of records
                }

                for ($i = 0; $i < count($arrayResult); $i++) :
                    $value = $arrayResult[$i]['Group_ID'];
                    echo '<option value="'.$value.'">'.$value.'</option>';
                
                ?>

                <?php endfor;?>
                </select>                
                <br>
                <select class="form-group col-md-4" name="project_id" id="project_id">
                <?php
                $db = new SQLite3('C:\xampp\htdocs\myDB.db');
                $sql = "SELECT Project_ID FROM Project";
                $stmt = $db->prepare($sql);
                $result = $stmt->execute();

                $arrayResult = []; //prepare an empty array first
                while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
                $arrayResult[] = $row; //adding a record until end of records
                }

                for ($i = 0; $i < count($arrayResult); $i++) :
                    $value2 = $arrayResult[$i]['Project_ID'];
                    echo '<option value="'.$value2.'">'.$value2.'</option>';
                
                ?>

                <?php endfor;?>
                </select>
                <br>
            </div>
            <div class="form-group col-md-4">
                <input class="btn btn-primary" type='submit' value="submit" name='submit'>
            </div>
        </form>
        <!--Form to input customer satisfaction once project is complete -->
        <form action="includes/customer_satisfaction.inc.php" method="post">
            <div>
                <br>
                <br>
                <label class="label">Please input customer feedback on project completion</label>
                <br>
                <br>
                <label class="label">Project ID:</label>
                <br>
                <select class="form-group col-md-4" name="project_id" id="project_id">
                <?php
                $db = new SQLite3('C:\xampp\htdocs\myDB.db');
                $sql = "SELECT Project_ID FROM Project";
                $stmt = $db->prepare($sql);
                $result = $stmt->execute();

                $arrayResult = []; //prepare an empty array first
                while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
                $arrayResult[] = $row; //adding a record until end of records
                }

                for ($i = 0; $i < count($arrayResult); $i++) :
                    $value3 = $arrayResult[$i]['Project_ID'];
                    echo '<option value="'.$value3.'">'.$value3.'</option>';
                
                ?>
                <?php endfor;?>
                </select>
                <br>
                <label class="label">Customer satisfaction (1-10):</label>
                <br>
                <input class="form-group col-md-4" type="number" name="customer_satisfaction" placeholder="Customer satisfaction" min="0" max="10">
                <br>
            </div>
            <div class="form-group col-md-4">
                <input class="btn btn-primary" type='submit' value="submit" name='submit'>
            </div>
        </form>




</body>

</html>