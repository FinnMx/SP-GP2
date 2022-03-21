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

  <div class="container">

    <br><br><br>

    <div class="w-box" style="width:40%">
      <form method="post">

        <div style="text-align:center">
          <div class="row">
          <div class="col">
              <a href="index.php"><input type="Button" value="MANAGER LOGIN" class="btn btn-main" style="width:100%"></a>
            </div>
            <div class="col">
              <a href="Engineerlogin.php"><input type="Button" value="ENGINEER LOGIN" class="btn btn-inv" style="width:100%"></a>
            </div>
          </div>

          <br>

          <b style="color:#0C4582">USERNAME</b>
          <div class="form-group">
            <input type="text" placeholder="ManagerID" name="ManagerID" class="form-control b-input">
          </div>
          <b style="color:#0C4582">PASSWORD</b>
          <div class="form-group">
            <input type="password" placeholder="Password" name="password" class="form-control b-input">
          </div>
          
        </div>

        <input type="submit" value="Login" name="submit" class="btn btn-main">

      </form>
    </div>

  </div>

  <?php
  error_reporting(0);

  if (isset($_POST['submit'])) {

    //Manager login routine

    if ($_POST['ManagerID'] == '' || $_POST['password'] == '') {
      echo "Please fill all fields";
    } else {

      //require('connection.php');
      $db = new SQLite3('/Applications/XAMPP/data/myDB.db');
      $sql = "SELECT Manager_ID, Password FROM Manager WHERE Manager_ID =:MID";
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':MID', $_POST['ManagerID'], SQLITE3_TEXT);
      $result = $stmt->execute();
      $arrayResult = [];

      while ($row = $result->fetchArray(SQLITE3_NUM)) { // how to read the result from the query
        $arrayResult = $row;
      }

      if ($_POST['ManagerID'] == $arrayResult[0] && $_POST['password'] == $arrayResult[1]) {

        header("Location: manager.php");
      } else {

        echo "invalid login";
      }
    }
  }
  ?>

</body>

</html>