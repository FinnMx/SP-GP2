<?php

/**
 * Simple example of extending the SQLite3 class and changing the __construct
 * parameters, then using the open method to initialize the DB.
 */

class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('myDB.db');
    }
}

$db = new MyDB();

$db->exec('CREATE TABLE Engineer(Engineer_ID STRING, F_name STRING, L_name STRING, Password STRING, Group_ID STRING, Engineer_rate INTEGER, Status STRING)');

$db->exec('CREATE TABLE Manager(Manager_ID STRING, F_name STRING, L_name STRING, Password STRING)');

$db->exec('CREATE TABLE Groups (Group_ID STRING, Project_ID STRING)');

$db->exec('CREATE TABLE Project(Project_ID STRING, Project_Name STRING Project_value MONEY, Engineer_cost MONEY, Material_cost MONEY, Additional_cost MONEY, Comments STRING, Customer_satisfaction INTEGER, Status STRING)');

$db->exec("INSERT INTO Manager VALUES('Martin1', 'Martin', 'D', 'Password1')");

$db->exec("INSERT INTO Engineer VALUES('Alex1', 'Alex', 'Patterson', 'Password1','1','9.50', 'active')");

?>

