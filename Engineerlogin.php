<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>

  <a href="index.php"> 
    <input type="button" value="Back">
  </a>


      <form style="width: 175px; text-align: center; position: absolute; top: 35%; left: 45%;" method="post"> 

      <h2>Engineer Login</h2> 

      <div class="form-group">
        <input type="text" placeholder="EngineerID" name="EngineerID" class="form-control"> 
      </div>

      <div class="form-group">
        <input type="password" placeholder="Password" name ="password" class="form-control"> 
      </div>

        <input type="submit" value="Login" name="submit" class="btn btn-primary btn-sm"> 

      </form> 

      <?php
      error_reporting(0);

      if (isset($_POST['submit'])){

        //Manager login routine

          if($_POST['EngineerID']== '' || $_POST['password'] == ''){
                echo "Please fill all fields";
          }

          else{

            $db = new SQLite3('C:\xampp\htdocs\myDB.db');
            $sql = "SELECT Engineer_ID, Password FROM Enigneer WHERE Engineer_ID =:EID";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':EID', $_POST['EngineerID'], SQLITE3_TEXT);
            $result= $stmt->execute();
            $arrayResult = [];

            while($row=$result->fetchArray(SQLITE3_NUM)){ // how to read the result from the query
              $arrayResult = $row;                              
            }

            if($_POST['EngineerID'] == $arrayResult[0] && $_POST['password'] == $arrayResult[1]){

              header("Location: engineer.php");

            }

            else{

              echo "invalid login";
            }
          }
      }
      ?>

</body>

</html>