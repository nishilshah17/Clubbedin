<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$userID = $_POST['userID'];
$firstName = $_POST['editfname'];
$lastName = $_POST['editlname'];

mysql_query('UPDATE user SET name = "'.$firstName.' '.$lastName.'" WHERE userID = "'.$userID.'"');


?>