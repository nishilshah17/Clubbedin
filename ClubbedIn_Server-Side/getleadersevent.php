<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$eventID = $_POST['eventID'];
$leaders = array();
$result = mysql_query('SELECT * FROM events WHERE eventID = "'.$eventID.'"');
$row = mysql_fetch_assoc($result);
$clubID = $row['clubID'];

$result2 = mysql_query('SELECT * FROM clubleader WHERE clubID = "'.$clubID.'"');
while ($row2 = mysql_fetch_assoc($result2))
{
	array_push($leaders, array('id' => $row2['leaderID']));
}

echo json_encode($leaders);

?>