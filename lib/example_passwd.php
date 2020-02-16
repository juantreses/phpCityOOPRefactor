<?php
/*
1.	Fill in your data
2.	Create :passwd.php in the Lib Map
3.	Copy the content of this file and put it in the passwd.php file
4.	Make sure you don't put passwd.php on the repo
*/

function GetConnectionData()
{
    return array("dbhost" => "localhost",
        "dbname" => "phpsteden",
        "dbuser" => "root? or other",
        "dbpasswd" => "YourPasswordGoesHere");
}

$connectionData = array('db_dsn' => 'mysql:host=localhost;dbname=phpsteden',
    "db_user" => "root? or other",
    "db_pass" => "YourPasswordGoesHere" );