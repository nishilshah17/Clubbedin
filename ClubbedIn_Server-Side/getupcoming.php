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

$userID = $_POST['uID'];

$events = array();
$clubIDs = array();
$eventIDs = array();

$result = mysql_query('SELECT * FROM clubmember WHERE userID = "'.$userID.'"');

$finalresult = 0;

while ($row = mysql_fetch_assoc($result)) {

    $result2 = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$row["clubID"].'"');
    $row2 = mysql_fetch_assoc($result2);

    if(mysql_num_rows($result2)==0)
    {
    }
    else
    {
		$clubIDs[] = $row2['clubID'];

	}
}

$finalresult = mysql_query("SELECT passed, eventID, date, endTime, TIME_FORMAT(startTime, '%h:%i %p') AS finaltime FROM events WHERE clubID IN (" . implode(',', $clubIDs) . ") ORDER BY date ASC, TIME(startTime) ASC");

while($finalrow = mysql_fetch_assoc($finalresult)) {

if($finalrow['passed']==0)
{
	$originaldate = $finalrow['date'];
	$date = new DateTime($originaldate);
	$newdate = $date->format('m/d/Y');

	$todaydate = new DateTime();
	$todaydate->setTimezone(new DateTimeZone('America/New_York'));
	$todaydatefin = $todaydate->format('m/d/Y');

	$originaltime = $finalrow['endTime'];

	$currenttime = new DateTime();
	$currenttime->setTimezone(new DateTimeZone('America/New_York'));
	$currenttimefin = $currenttime->format('H:i:s');

	if(  strtotime($newdate) <  strtotime($todaydatefin))
		mysql_query('UPDATE events SET passed="1" WHERE eventID = "'.$finalrow['eventID'].'"');
	if(  strtotime($newdate) ==  strtotime($todaydatefin))
	{
		if($originaltime < $currenttimefin)
			mysql_query('UPDATE events SET passed="1" WHERE eventID = "'.$finalrow['eventID'].'"');
	}
}

}


$finalresult = mysql_query("SELECT passed, eventName, eventID, clubID, date, TIME_FORMAT(startTime, '%h:%i %p') AS finaltime FROM events WHERE clubID IN (" . implode(',', $clubIDs) . ") ORDER BY date ASC, TIME(startTime) ASC");

while($finalrow = mysql_fetch_assoc($finalresult)) {

$originaldate = $finalrow['date'];
$date = new DateTime($originaldate);
$newdate = $date->format('m/d/Y');

$lastresult = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$finalrow['clubID'].'"');
$lastrow = mysql_fetch_assoc($lastresult);

if($finalrow['passed']==0) {
	array_push($events, array("name" => $finalrow['eventName'], "id" => $finalrow['eventID'], "date" => $newdate, "time" => $finalrow['finaltime'], "clubName" => $lastrow['clubName']));
	array_push($eventIDs, $finalrow['eventID']);
}
}

//PART 2

$result = mysql_query('SELECT * FROM eventmember WHERE userID = "'.$userID.'"');
while ($row = mysql_fetch_assoc($result)) {

	$finalresult = mysql_query("SELECT passed, eventID, date, endTime, TIME_FORMAT(startTime, '%h:%i %p') AS finaltime FROM events WHERE eventID = '".$row['eventID']."' ORDER BY date ASC, TIME(startTime) ASC");

	if(mysql_num_rows($finalresult) > 0)
	{
		$finalrow = mysql_fetch_assoc($finalresult);

		if($finalrow['passed']==0)
		{
			$originaldate = $finalrow['date'];
			$date = new DateTime($originaldate);
			$newdate = $date->format('m/d/Y');

			$todaydate = new DateTime();
			$todaydate->setTimezone(new DateTimeZone('America/New_York'));
			$todaydatefin = $todaydate->format('m/d/Y');

			$originaltime = $finalrow['endTime'];

			$currenttime = new DateTime();
			$currenttime->setTimezone(new DateTimeZone('America/New_York'));
			$currenttimefin = $currenttime->format('H:i:s');

			if( $newdate < $todaydatefin)
				mysql_query('UPDATE events SET passed="1" WHERE eventID = "'.$finalrow['eventID'].'"');
			if( $newdate == $todaydatefin)
			{
				if($originaltime < $currenttimefin)
					mysql_query('UPDATE events SET passed="1" WHERE eventID = "'.$finalrow['eventID'].'"');
			}
		}

		$originaldate = $finalrow['date'];
		$date = new DateTime($originaldate);
		$newdate = $date->format('m/d/Y');

		$lastresult = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$finalrow['clubID'].'"');
		$lastrow = mysql_fetch_assoc($lastresult);

		if($finalrow['passed']==0) {
			if(in_array($finalrow['eventID'], $eventIDs) !== true)
				array_push($events, array("name" => $finalrow['eventName'], "id" => $finalrow['eventID'], "date" => $newdate, "time" => $finalrow['finaltime'], "clubName" => $lastrow['clubName']));
		}
	}
}



echo json_encode($events);


?>