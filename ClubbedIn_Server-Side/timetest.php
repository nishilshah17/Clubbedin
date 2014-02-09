<?php
$dbhost = 'localhost';
$dbuser = 'clubbed_admin';
$dbpass = 'ClubbedIn2013';
$db = 'clubbed_main';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

	$currenttime = new DateTime();
	$currenttime->setTimezone(new DateTimeZone('America/New_York'));
	$currenttimefin = $currenttime->format('H:i:s');

	echo $currenttimefin.'<br>';

	$num = 922967002;

	$result = mysql_query('SELECT * FROM events WHERE eventID = "'.$num.'"');

	$row = mysql_fetch_assoc($result);

	$originaltime = $row['endTime'];
	echo $originaltime.'<br>';
	$time = new DateTime($originaltime);
	$timefin = $time->format('H:i:s');

	echo $timefin.'<br>';

	if ($currenttimefin > $originaltime)
	{
		echo "not passed";
	}

?>