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

if(isset($_POST['id']))
{
    $eventID = $_POST['id'];
}


$result = mysql_query('SELECT clubID, eventName, privacy, description, date, venue, TIME_FORMAT(startTime, "%h:%i %p") AS startTime2, TIME_FORMAT(endTime, "%h:%i %p") AS endTime2 FROM events WHERE eventID = "'.$eventID.'"');
$row = mysql_fetch_assoc($result);
$result2 = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$row['clubID'].'"');
$row2 = mysql_fetch_assoc($result2);
$eventName = $row['eventName'];
$description= $row['description'];
$originaldate = $row['date'];
$clubName = $row2['clubName'];
$date = new DateTime($originaldate);
$newdate = $date->format('m/d/Y');
$startTime2 = $row['startTime2'];
$endTime2 = $row['endTime2'];
$venue = $row['venue'];
$privacy = $row['privacy'];


$json = json_encode(array('privacy' => $privacy, 'eventName' => $eventName, 'description' => $description, 'startTime' => $startTime2, 'endTime' => $endTime2, 'date' => $newdate, 'clubName' => $clubName, 'venue' => $venue));

echo $json;

?>