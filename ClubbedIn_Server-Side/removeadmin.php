<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';
include 'pushnotifs.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$lid = $_POST['id'];
$clubID = $_POST['clubID'];

mysql_query('DELETE FROM clubleader WHERE leaderID = "'.$lid.'" AND clubID = "'.$clubID.'"');

require_once('class.phpmailer.php');

$result = mysql_query('SELECT * FROM user WHERE userID = "'.$lid.'"');

$result2 = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$clubID.'"');

$row = mysql_fetch_assoc($result);
$row2 = mysql_fetch_assoc($result2);

$name = $row['name'];
$email = $row['email'];
$club = $row2['clubName'];


$message = "You are no longer an admin for ".$club;
sendNotification($lid,$message);



?>