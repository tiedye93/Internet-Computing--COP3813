<?php
// Do not change the following two lines.
$teamURL = dirname($_SERVER['PHP_SELF']) . DIRECTORY_SEPARATOR;
$server_root = dirname($_SERVER['PHP_SELF']);

// You will need to require this file on EVERY php file that uses the database.
// Be sure to use $db->close(); at the end of each php file that includes this!

$hn = 'localhost';  // Most likely will not need to be changed
$db = 'tbourque2012';   // Needs to be changed to your designated table database name
$un = 'tbourque2012';   // Needs to be changed to reflect your LAMP server credentials
$pw = 'Pooh103111'; // Needs to be changed to reflect your LAMP server credentials

//$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
//
//if($db->connect_errno > 0) {
//    die('Unable to connect to database [' . $db->connect_error . ']');
//}

