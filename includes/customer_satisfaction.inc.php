<?php
//needs cs comments to do something
if (isset($_POST['submitCS'])) {
   if (isset($_POST['submitCS'])) {

      $PID = $_POST['project_id'];
      $CS = $_POST['customer_satisfaction'];
      if ($PID == '' || $CS == '') {
         header("Location: ../manager.php?errorcs=emptyinput");
         exit();
<<<<<<< HEAD
      }
      else
      {
=======
      } else {
>>>>>>> d801b8a301db0984b86b7fc57fa0d2dd7f1e6bb5
         require_once("functions.inc.php");
         SetCustomerSatisfaction($PID, $CS);
      }
   }
}
