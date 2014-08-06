<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';
include 'pushnotifs.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$adminID = $_POST['adminID'];
$clubID = $_POST['clubID'];

$result = mysql_query('SELECT * FROM clubleader WHERE leaderID = "'.$adminID.'" AND clubID = "'.$clubID.'"');

if ( mysql_num_rows($result) == 0)
{
	mysql_query('INSERT INTO clubleader (clubID, leaderID) VALUES ("'.$clubID.'", "'.$adminID.'")');
	echo "added";

require_once('class.phpmailer.php');

$result = mysql_query('SELECT * FROM user WHERE userID = "'.$adminID.'"');

$result2 = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$clubID.'"');

$row = mysql_fetch_assoc($result);
$row2 = mysql_fetch_assoc($result2);

$name = $row['name'];
$email = $row['email'];


$club = $row2['clubName'];

$message = "You are now admin for ".$club;
sendNotification($adminID, $message);

}




?>