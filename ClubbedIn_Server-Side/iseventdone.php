<?php
header("access-control-allow-origin: *");

$dbhost = 'localhost';
$dbuser = 'clubbed_admin';
$dbpass = 'ClubbedIn2013';
$db = 'clubbed_main';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$eventID = $_POST['eventID'];

$result = mysql_query('SELECT * FROM events WHERE eventID = "'.$eventID.'"');

$row = mysql_fetch_assoc($result);

$endtime = $row['startTime'];

$currenttime = new DateTime();
$currenttime->setTimezone(new DateTimeZone('America/New_York'));
$currenttimefin = $currenttime->format('H:i:s');

$originaldate = $row['date'];
$date = new DateTime($originaldate);
$eventdate = $date->format('m/d/Y');

$todaydate = new DateTime();
$todaydate->setTimezone(new DateTimeZone('America/New_York'));
$todaydate = $todaydate->format('m/d/Y');

if ($todaydate > $eventdate) {
	echo 'yes';
}
elseif ($todaydate == $eventdate) {
	if($currenttimefin > $endtime)
	{
		echo 'yes';
	}
	else {
		echo 'no';
	}
} else {
	echo 'no';
}