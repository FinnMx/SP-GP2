<?php
//needs cs comments to do something
if (isset($_POST['submitCS'])) {
   if (isset($_POST['submitCS']))
   {

      $PID = $_POST['project_id'];
      $CS = $_POST['customer_satisfaction'];
      if ($PID == '' || $CS == '') {
         header("Location: ../manager.php?errorcs=emptyinput");
         exit();
      }
      else
      {
         SetCustomerSatisfaction($PID, $CS);
      }

   }
   
   
}

