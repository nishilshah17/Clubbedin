<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$clubID = $_POST['clubID'];
$topic = $_POST['textareapost'];
$userID = $_POST['uID'];

mysql_query('INSERT INTO topics (clubID, topic, userID) VALUES ("'.$clubID.'","'.$topic.'","'.$userID.'")');

?>
