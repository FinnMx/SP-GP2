<?php

/**
 * Simple example of extending the SQLite3 class and changing the __construct
 * parameters, then using the open method to initialize the DB.
 */

class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('C:\xampp\htdocs\myDB.db');
    }
}

$db = new MyDB();

$db->exec('CREATE TABLE Engineer(Engineer_ID STRING, F_name STRING, L_name STRING, Password STRING, Group_ID STRING, Engineer_rate INTEGER)');

$db->exec('CREATE TABLE Manager(Manager_ID STRING, F_name STRING, L_name STRING, Password STRING)');

$db->exec('CREATE TABLE Groups (Group_ID STRING, Project_ID STRING)');

$db->exec('CREATE TABLE Project(Project_ID STRING, Project_value MONEY, Engineer_cost MONEY, Material_cost MONEY, Additional_cost MONEY, Comments STRING, Customer_satisfaction INTEGER)');

$db->exec("INSERT INTO Manager VALUES('Martin1', 'Martin', 'D', 'Password1')");


/**
 * Notes for Database
 * needed - project name in projects
 * needed - Timescale in "project" so "Pay_rate" (hourly/monthly?) can be converted into "Engineer_cost"
*/
