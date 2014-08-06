<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';
include 'pushnotifs.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$eventName = $_POST['editename'];
$desc = $_POST['editedesc'];
$date = date($_POST['editedate']);
$starttime = $_POST['editestarttime'];
$endtime = $_POST['editeendtime'];
$privacy = $_POST['editeswitch'];
$venue = $_POST['editeloc'];
$eventID = $_POST['eventID'];
$clubID = $_POST['clubID'];

mysql_query('UPDATE events SET eventName = "'.$eventName.'", date = "'.$date.'", description = "'.$desc.'", startTime = "'.$starttime.'", endTime = "'.$endtime.'", venue = "'.$venue.'", privacy = "'.$privacy.'" WHERE eventID = "'.$eventID.'"');

$result2 = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$clubID.'"');
$row2 = mysql_fetch_assoc($result2);

$resultevent = mysql_query('SELECT clubID, eventName, venue, description, date, TIME_FORMAT(startTime, "%h:%i %p") AS startTime2, TIME_FORMAT(endTime, "%h:%i %p") AS endTime2 FROM events WHERE eventID = "'.$eventID.'"');
$rowevent = mysql_fetch_assoc($resultevent);

$clubName = $row2['clubName'];

$date = new DateTime($date);
$date = $date->format('m/d/Y');

$startTime2 = $rowevent['startTime2'];
$endTime2 = $rowevent['endTime2'];
$description = $rowevent['description'];
$venue = $rowevent['venue'];


require_once('class.phpmailer.php');

$result2 = mysql_query('SELECT * FROM clubmember WHERE clubID = "'.$clubID.'"');

while ($row2 = mysql_fetch_assoc($result2)) {

	$userID = $row2['userID'];

	$resultuser = mysql_query('SELECT * FROM user WHERE userID = "'.$userID.'"');

	$rowuser = mysql_fetch_assoc($resultuser);

	$email = $rowuser['email'];

    sendNotification($userID,$eventName." has been edited.");
}



?>