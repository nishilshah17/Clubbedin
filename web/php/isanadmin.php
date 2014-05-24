<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$userID = $_POST['userID'];

$result = mysql_query('SELECT * FROM clubleader WHERE leaderID = "'.$userID.'"');
if (mysql_num_rows($result) > 0)
	echo json_encode(array('message' => 'true'));
else echo json_encode(array('message' => 'false'));
?>