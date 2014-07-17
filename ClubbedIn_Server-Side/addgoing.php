<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$eventID = $_POST['eventID'];
$userID = $_POST['userID'];
$going = $_POST['going'];

if ($going == "going")
{
	if($eventID > 100000000 && $eventID <= 333333333)
		$result = mysql_query('SELECT * FROM eventmember WHERE eventID = "'.$eventID.'" AND userID = "'.$userID.'"');
	elseif ($eventID > 333333333 && $eventID <= 666666666)
		$result = mysql_query('SELECT * FROM eventmember2 WHERE eventID = "'.$eventID.'" AND userID = "'.$userID.'"');
	elseif ($eventID > 666666666 && $eventID <= 999999999)
		$result = mysql_query('SELECT * FROM eventmember3 WHERE eventID = "'.$eventID.'" AND userID = "'.$userID.'"');

	if(mysql_num_rows($result) == 0)
	{

	if($eventID > 100000000 && $eventID <= 333333333)
		mysql_query('INSERT INTO eventmember (eventID, userID) VALUES ("'.$eventID.'","'.$userID.'")');
	elseif ($eventID > 333333333 && $eventID <= 666666666)
		mysql_query('INSERT INTO eventmember2 (eventID, userID) VALUES ("'.$eventID.'","'.$userID.'")');
	elseif ($eventID > 666666666 && $eventID <= 999999999)
		mysql_query('INSERT INTO eventmember3 (eventID, userID) VALUES ("'.$eventID.'","'.$userID.'")');

	}
}
else
{
	if($eventID > 100000000 && $eventID <= 333333333)
		mysql_query('DELETE FROM eventmember WHERE eventID = "'.$eventID.'" AND userID = "'.$userID.'"');
	elseif ($eventID > 333333333 && $eventID <= 666666666)
		mysql_query('DELETE FROM eventmember2 WHERE eventID = "'.$eventID.'" AND userID = "'.$userID.'"');
	elseif ($eventID > 666666666 && $eventID <= 999999999)
		mysql_query('DELETE FROM eventmember3 WHERE eventID = "'.$eventID.'" AND userID = "'.$userID.'"');
}

?>
