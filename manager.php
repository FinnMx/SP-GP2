<?php
require("require.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container-fluid">
        <form action="includes/create_engineer.inc.php" method="post">
            <div>
                <br>
                <br>
                <label class="label">Create Engineer</label>
                <br>
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
                <input class="form-group col-md-4" type="number" name="engineer_rate" placeholder="Pay rate">
                <br>
                <label class="label">Assign to Group</label>
                <br>
                <input class="form-group col-md-4" type="number" name="group_id" placeholder="Group ID">
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
                <label class="label">Create Group</label>
                <br>
                <br>
                <label class="label">Group ID:</label>
                <br>
                <input class="form-group col-md-4" type="number" name="group_id" placeholder="Group ID">
                <br>
                <br>
                <label class="label">Project ID:</label>
                <br>
                <input class="form-group col-md-4" type="number" name="project_id" placeholder="Project ID">
                <br>
            </div>
            <div class="form-group col-md-4">
                <input class="btn btn-primary" type='submit' value="submit" name='submit'>
            </div>
        </form>



</body>

</html>