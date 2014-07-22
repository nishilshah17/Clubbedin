<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$userID = $_POST['userID'];
$clubID = $_POST['clubID'];

$attendance = array();

$result = mysql_query('SELECT * FROM attendance WHERE userID = "'.$userID.'"');

while ($row = mysql_fetch_assoc($result))
{
	$eventID = $row['eventID'];
	$result2 = mysql_query('SELECT * FROM events WHERE eventID = "'.$eventID.'"');
	$row2 = mysql_fetch_assoc($result2);

	$originaldate = $row2['date'];
	$date = new DateTime($originaldate);
	$newdate = $date->format('m/d/Y');

	$result3 = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$row2['clubID'].'"');
	$row3 = mysql_fetch_assoc($result3);
    
    if($clubID == $row2['clubID'] || $clubID == 0)
	   array_push($attendance, array('eventName' => $row2['eventName'],'date' => $newdate, 'venue' => $row2['venue'], 'clubName' => $row3['clubName']));
}

$result = mysql_query('SELECT * FROM attendance2 WHERE userID = "'.$userID.'"');

while ($row = mysql_fetch_assoc($result))
{
	$eventID = $row['eventID'];
	$result2 = mysql_query('SELECT * FROM events WHERE eventID = "'.$eventID.'"');
	$row2 = mysql_fetch_assoc($result2);

	$originaldate = $row2['date'];
	$date = new DateTime($originaldate);
	$newdate = $date->format('m/d/Y');

	$result3 = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$row2['clubID'].'"');
	$row3 = mysql_fetch_assoc($result3);
    
    if($clubID == $row2['clubID'] || $clubID == 0)
	   array_push($attendance, array('eventName' => $row2['eventName'],'date' => $newdate, 'venue' => $row2['venue'], 'clubName' => $row3['clubName']));
}

$result = mysql_query('SELECT * FROM attendance3 WHERE userID = "'.$userID.'"');

while ($row = mysql_fetch_assoc($result))
{
	$eventID = $row['eventID'];
	$result2 = mysql_query('SELECT * FROM events WHERE eventID = "'.$eventID.'"');
	$row2 = mysql_fetch_assoc($result2);

	$originaldate = $row2['date'];
	$date = new DateTime($originaldate);
	$newdate = $date->format('m/d/Y');

	$result3 = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$row2['clubID'].'"');
	$row3 = mysql_fetch_assoc($result3);

    if($clubID == $row2['clubID'] || $clubID == 0)
	   array_push($attendance, array('eventName' => $row2['eventName'],'date' => $newdate, 'venue' => $row2['venue'], 'clubName' => $row3['clubName']));
}
function cmp($a, $b){
    return strtotime($a['date']) - strtotime($b['date']);
}
usort($attendance, "cmp");

echo json_encode($attendance);
?>