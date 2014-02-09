<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$eventID = $_POST['eventID'];
$userID = $_POST['userID'];

if($eventID > 100000000 && $eventID <= 333333333)
	$result = mysql_query('SELECT * FROM eventmember WHERE eventID = "'.$eventID.'" AND userID = "'.$userID.'"');
elseif ($eventID > 333333333 && $eventID <= 666666666)
	$result = mysql_query('SELECT * FROM eventmember2 WHERE eventID = "'.$eventID.'" AND userID = "'.$userID.'"');
elseif ($eventID > 666666666 && $eventID <= 999999999)
	$result = mysql_query('SELECT * FROM eventmember3 WHERE eventID = "'.$eventID.'" AND userID = "'.$userID.'"');

$going = false;


if(mysql_num_rows($result) > 0)
{
	$going = true;
}

if ($going == false)
	echo "notgoing";
else echo "going";