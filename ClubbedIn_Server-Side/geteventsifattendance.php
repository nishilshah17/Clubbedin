<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$userID = $_POST['userID'];

$events = array();

$result = mysql_query('SELECT * FROM clubleader WHERE leaderID = "'.$userID.'"');

while ($row = mysql_fetch_assoc($result))
{
	$result2 = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$row['clubID'].'"');
	$row2 = mysql_fetch_assoc($result2);

	$clubID = $row['clubID'];

	$result3 = mysql_query('SELECT * FROM events WHERE clubID = "'.$row['clubID'].'"');

	while($row3 = mysql_fetch_assoc($result3))
	{
		$date = new DateTime();
		$date->setTimezone(new DateTimeZone('America/New_York'));
		$date = $date->format('m/d/Y');

		$eventdate = $row3['date'];
		$eventdate = new DateTime($eventdate);
		$eventdate = $eventdate->format('m/d/Y');

		$eventstarttime = $row3['startTime'];
		$eventendtime = $row3['endTime'];

		$currenttime = new DateTime();
		$currenttime->setTimezone(new DateTimeZone('America/New_York'));
		$currenttime = $currenttime->format('H:i:s');

		if($date == $eventdate)
		{

			$result4 = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$row3['clubID'].'"');
			$row4 = mysql_fetch_assoc($result4);

			if($currenttime > $eventstarttime && $currenttime < $eventendtime)
				array_push($events, array('eventID' => $row3['eventID'], 'eventName' => $row3['eventName'],'date' => $eventdate, 'clubName' => $row4['clubName']));
		}
	}
}

echo json_encode($events);




?>