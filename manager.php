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

<body>

    <!--Form to create an engineer-->
    <div class="container-fluid">
        <form method="post">
            <div>
                <br>
                <br>
                <label class="label">Create Engineer</label>
                <br>
                <label class="label">First Name:</label>
                <br>
                <input class="form-group col-md-4" type="text" name="first_name" placeholder="First name">
                <br>
                <label class="label">Last name:</label>
                <br>
                <input class="form-group col-md-4" type="text" name="last_name" placeholder="Last name">
                <br>
                <label class="label">Password:</label>
                <br>
                <input class="form-group col-md-4" type="password" name="password" placeholder="Password">
                <br>
                <label class="label">Re-enter password:</label>
                <br>
                <input class="form-group col-md-4" type="password" name="re_password" placeholder="Re-enter password">
                <br>
                <label class="label">Pay Rate:</label>
                <br>
                <input class="form-group col-md-4" type="number" name="engineer_rate" placeholder="Pay rate" min="1">
                <br>
                <label class="label">Assign to Group</label>
                <br>
                <input class="form-group col-md-4" type="number" name="group_id" placeholder="Group ID" min="1">
                <br>

            </div>
            <div class="form-group col-md-4">
                <input class="btn btn-primary" type='submit' value="submit" name='submit'>
            </div>

            <?php 

        if (isset($_POST['submit'])){

            $boolCheck = passwordMismatch($_POST['password'], $_POST['re_password']);

            if($boolCheck !=1){
            
            $db = new SQLite3('C:\xampp\htdocs\myDB.db');
            $sql = "INSERT INTO Engineer VALUES(:eid,:fname,:lname,:pwd,:gid,:er)";
            $stmt = $db->prepare($sql);

            $EngineerID = substr($_POST['first_name'], 0).rand(1000,9999);

            echo "work";

            $stmt->bindParam(':eid', $EngineerID, SQLITE3_TEXT);
            $stmt->bindParam(':fname', $_POST['first_name'], SQLITE3_TEXT);
            $stmt->bindParam(':lname', $_POST['last_name'], SQLITE3_TEXT);
            $stmt->bindParam(':pwd', $_POST['password'], SQLITE3_TEXT);
            $stmt->bindParam(':gid',$_POST['group_id'], SQLITE3_TEXT);
            $stmt->bindParam(':er', $_POST['engineer_rate'], SQLITE3_TEXT);
            $result = $stmt->execute();

            }
        }


            ?>

        </form>
        <!--Form to create projects projects-->
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
                <input class="form-group col-md-4" type="number" name="group_id" placeholder="Group ID" min="1">
                <br>
                <label class="label">Project ID:</label>
                <br>
                <input class="form-group col-md-4" type="number" name="project_id" placeholder="Project ID" min="1">
                <br>
            </div>
            <div class="form-group col-md-4">
                <input class="btn btn-primary" type='submit' value="submit" name='submit'>
            </div>
        </form>
        <form action="includes/assign_group.inc.php" method="post">
            <div>
                <br>
                <br>
                <label class="label">Assign group to project</label>
                <br>
                <br>
                <label class="label">Group ID:</label>
                <br>
                <input class="form-group col-md-4" type="number" name="group_id" placeholder="Group ID" min="1">
                <br>
                <label class="label">Project ID:</label>
                <br>
                <input class="form-group col-md-4" type="number" name="project_id" placeholder="Project ID" min="1">
                <br>
            </div>
            <div class="form-group col-md-4">
                <input class="btn btn-primary" type='submit' value="submit" name='submit'>
            </div>
        </form>
        <!--Form to input customer satisfaction once project is complete -->
        <form action="customer_satisfaction.inc.php" method="post">
            <div>
                <br>
                <br>
                <label class="label">Please input customer feedback on project completion</label>
                <br>
                <br>
                <label class="label">Project ID:</label>
                <br>
                <input class="form-group col-md-4" type="number" name="group_id" placeholder="Project ID" min="1">
                <br>
                <label class="label">Customer satisfaction:</label>
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