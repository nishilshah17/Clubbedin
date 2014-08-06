<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';
include 'pushnotifs.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$eventID = $_POST['eventID'];

$result = mysql_query('SELECT * FROM events WHERE eventID = "'.$eventID.'"');
$row = mysql_fetch_assoc($result);
$clubID = $row['clubID'];
$eventName = $row['eventName'];

$result2 = mysql_query('SELECT * FROM clubmember WHERE clubID = "'.$clubID.'"');

while ($row2 = mysql_fetch_assoc($result2)) {

	$userID = $row2['userID'];

	$resultuser = mysql_query('SELECT * FROM user WHERE userID = "'.$userID.'"');

	$rowuser = mysql_fetch_assoc($resultuser);

	$email = $rowuser['email'];

	$name = $rowuser['name'];

	mysql_query('DELETE FROM events WHERE eventID = "'.$eventID.'"');
	mysql_query('DELETE FROM eventmember WHERE eventID = "'.$eventID.'"');
	mysql_query('DELETE FROM attendance WHERE eventID = "'.$eventID.'"');
	mysql_query('DELETE FROM attendance2 WHERE eventID = "'.$eventID.'"');
	mysql_query('DELETE FROM attendance3 WHERE eventID = "'.$eventID.'"');

    $message = "Sorry, ".$eventName." has been canceled!";
    sendNotification($userID, $message);
}

?>