<?php
require("functions.php");

if (isset($_POST['submitCP'])) 
{
    $ProjectID = $_POST['project_id'];
    $ProjectName = $_POST['project_name'];
    $ProjectVal = $_POST["project_value"];
    $MaterialCost = $_POST["material_cost"];
    $AdditionalCost = $_POST["additional_cost" ];
    $Comments = $_POST["comments"];
    $CustomerSatisfaction = "" ;
    $Status = "active";
    $Timescale = $_POST["timescale"];


    if(emptyInputProject($ProjectID, $ProjectName, $ProjectVal, $MaterialCost, $Timescale)!==false)
    {
        header("Location:../manager.php?error=emptyinput");
        exit();
    }
    if(CreateProject($ProjectID, $ProjectName, $ProjectVal, $MaterialCost, $AdditionalCost, $Comments, $CustomerSatisfaction, $Status, $Timescale)!==true)
    {
        header("Location:../manager.php?error=stmtfailed");
        exit();
    }
    else {
        header("location:../manager.php?success=createdsuccessfully");
        exit();
    }

}
else 
{
    header("Location:../Manager.php?error=unauthorisedentry");
    exit();
}

