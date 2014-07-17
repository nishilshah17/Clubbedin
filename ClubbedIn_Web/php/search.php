<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$query = $_POST['q'];
$member = $_POST['userID'];

$searchoptions = array();

$clubsresult = mysql_query('SELECT * FROM clubs');
$eventsresult = mysql_query('SELECT * FROM events');

while ($clubsrow = mysql_fetch_assoc($clubsresult))
{
	$clubname = $clubsrow['clubName'];
	$clubid = $clubsrow['clubID'];
	$schoolname = $clubsrow['schoolName'];

	if(stripos($clubname, $query) !== false)
		array_push($searchoptions, array("optionname" => $clubname, "optionid" => $clubid));
	else if (stripos($schoolname, $query) !== false)
		array_push($searchoptions, array("optionname" => $clubname, "optionid" => $clubid));
}

while ($eventsrow = mysql_fetch_assoc($eventsresult))
{
	$eventname = $eventsrow['eventName'];
	$eventid = $eventsrow['eventID'];
	$schoolresult = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$eventsrow['clubID'].'"');
	$schoolrow = mysql_fetch_assoc($schoolresult);
	$schoolname2 = $schoolrow['schoolName'];
	$clubID = $schoolrow['clubID'];

	$lastresult = mysql_query('SELECT * FROM clubmember WHERE clubID = "'.$clubID.'" AND userID = "'.$member.'"');

	if(stripos($eventname, $query) !== false && ($eventsrow['privacy'] == "1" || mysql_num_rows($lastresult) > 0))
		array_push($searchoptions, array("optionname" => $eventname, "optionid" => $eventid));
	else if (stripos($schoolname2, $query) !== false && ($eventsrow['privacy'] == "1" || mysql_num_rows($lastresult) > 0))
		array_push($searchoptions, array("optionname" => $eventname, "optionid" => $eventid));
}

$tmp = Array();
foreach($searchoptions as &$ma)
    $tmp[] = &$ma["optionname"];
$tmp = array_map('strtolower', $tmp);
array_multisort($tmp, $searchoptions);

echo json_encode($searchoptions);

?>