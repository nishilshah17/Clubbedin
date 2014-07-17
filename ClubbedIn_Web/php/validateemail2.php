<?php

header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$userID = $_POST['userID'];
$email = $_POST['email'];

$result = mysql_query('SELECT * FROM user WHERE email = "'.$email.'"');
$row = mysql_fetch_assoc($result);

if (mysql_num_rows($result) == 0)
{
	echo "1";
} elseif ($row['userID'] == $userID) {
	echo "2";
} else {
	echo "3";
}


?>
