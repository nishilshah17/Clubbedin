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

$clubID = $_POST['clubID'];

$eventnames = array();


$result = mysql_query("SELECT passed, eventName, eventID, clubID, date, TIME_FORMAT(startTime, '%h:%i %p') AS finaltime FROM events
						WHERE clubID = '".$clubID."'
					  	ORDER BY date ASC, TIME(startTime) ASC");

while ($row = mysql_fetch_assoc($result)) {

$originaldate = $row['date'];
$date = new DateTime($originaldate);
$newdate = $date->format('m/d/Y');


	array_push($eventnames, array("name" => $row['eventName'], "id" => $row['eventID'], "date" => $newdate, "time" => $row['finaltime']));


}
	echo json_encode($eventnames);

?>
