<?php
//needs cs comments to do something
if (isset($_POST['submitCS'])) {
   if (isset($_POST['submitCS'])) {

      $PID = $_POST['project_id_selected'];
      $CS = $_POST['customer_satisfaction'];
      if ($PID == '' || $CS == '') {
         header("Location: ../manager.php?errorcs=emptyinput");
         exit();
      } else {
         require_once("functions.inc.php");
         SetCustomerSatisfaction($PID, $CS);
      }
   }
}
