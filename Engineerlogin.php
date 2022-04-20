<?php
//session,header and footer
require("require.php");
require("headerLogin.php");
ob_start();
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
              <a href="index.php"><input type="Button" value="MANAGER LOGIN" class="btn btn-inv" style="width:100%"></a>
            </div>
            <div class="col">
              <a href="Engineerlogin.php"><input type="Button" value="ENGINEER LOGIN" class="btn btn-main" style="width:100%"></a>
            </div>
          </div>

          <br><br>

          <b style="color:#0C4582">ENGINEER ID</b>
          <div class="form-group">
            <input type="text" placeholder="EngineerID" name="EngineerID" class="form-control b-input">
          </div>
          <b style="color:#0C4582">PASSWORD</b>
          <div class="form-group">
            <input type="password" placeholder="Password" name="password" class="form-control b-input">
          </div>

        </div>

        <br>
        <input type="submit" value="LOGIN" name="submit" class="btn btn-main">

      </form>
    </div>

  </div>

  <?php
  //error_reporting(0);

  if (isset($_POST['submit'])) {

    //Manager login routine

    if ($_POST['EngineerID'] == '' || $_POST['password'] == '') {
      echo "Please fill all fields";
    } else {

      $sql = "SELECT Engineer_ID, Password FROM Engineer WHERE Engineer_ID =:EID AND Status = 'active'";
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':EID', $_POST['EngineerID'], SQLITE3_TEXT);
      $result = $stmt->execute();
      $arrayResult = [];

      $_SESSION['EID'] = $_POST['EngineerID'];

      while ($row = $result->fetchArray(SQLITE3_NUM)) { // how to read the result from the query
        $arrayResult = $row;
      }

      if ($_POST['EngineerID'] == $arrayResult[0] && $_POST['password'] == $arrayResult[1]) {
        header("Location: engineer.php?eid=".$_POST['EngineerID']);
        ob_end_flush();
      } else {

        echo "invalid login";
      }
    }
  }
  ?>

</body>

</html>