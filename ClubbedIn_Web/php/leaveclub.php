<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$clubID = $_POST['clubID'];
$userID = $_POST['userID'];

mysql_query('DELETE FROM clubleader WHERE clubID = "'.$clubID.'" AND leaderID = "'.$userID.'"');
mysql_query('DELETE FROM clubmember WHERE clubID = "'.$clubID.'" AND userID = "'.$userID.'"');

?>