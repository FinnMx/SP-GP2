<?php
if (isset($_POST['submitCP'])) {

    $pName = $_POST['project_name'];
    $pValue = $_POST['project_value'];
    $mCost = $_POST['material_cost'];
    $timescale = $_POST['timescale'];


    if ($pName == '' ||  $pValue  == '' || $mCost == '' || $timeScale = '') {
        header("Location: ../manager.php?errorp=emptyinput");
        exit();
    } else {
        require_once("functions.inc.php");
        CreateProject($_POST['project_id'], $_POST['project_name'], $_POST['project_value'], $_POST['material_cost'], $_POST['additional_cost'], $_POST['comments'], 0, "Active", $_POST['timescale']);
    }
}
