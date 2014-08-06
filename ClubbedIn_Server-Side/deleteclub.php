<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';
include 'pushnotifs.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$clubID = $_POST['clubID'];

$resultclubname = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$clubID.'"');
$rowclubname = mysql_fetch_assoc($resultclubname);

$clubName = $rowclubname['clubName'];

$result2 = mysql_query('SELECT * FROM clubmember WHERE clubID = "'. $clubID.'"');

while ($row2 = mysql_fetch_assoc($result2)) {

	$userID = $row2['userID'];

	$resultuser = mysql_query('SELECT * FROM user WHERE userID = "'.$userID.'"');

	$rowuser = mysql_fetch_assoc($resultuser);

	$userEmail = $rowuser['email'];
	$name = $rowuser['name'];

	mysql_query('DELETE FROM clubleader WHERE clubID = "'.$clubID.'"');
	mysql_query('DELETE FROM clubmember WHERE clubID = "'.$clubID.'"');
	mysql_query('DELETE FROM clubs WHERE clubID = "'.$clubID.'"');
	mysql_query('DELETE FROM events WHERE clubID = "'.$clubID.'"');
	mysql_query('DELETE FROM announcements WHERE clubID = "'.$clubID.'"');
    
    $message = $club." has been deleted!";
    sendNotification($userID, $message);
}

?>