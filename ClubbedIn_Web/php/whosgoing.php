<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$eventID = $_POST['eventID'];

$members = array();

	if($eventID > 100000000 && $eventID <= 333333333)
		$result = mysql_query('SELECT * FROM eventmember WHERE eventID = "'.$eventID.'"');
	elseif ($eventID > 333333333 && $eventID <= 666666666)
		$result = mysql_query('SELECT * FROM eventmember2 WHERE eventID = "'.$eventID.'"');
	elseif ($eventID > 666666666 && $eventID <= 999999999)
		$result = mysql_query('SELECT * FROM eventmember3 WHERE eventID = "'.$eventID.'"');

while ($row = mysql_fetch_assoc($result)) {

	$result2 = mysql_query('SELECT * FROM user WHERE userID = "'.$row['userID'].'"');
	$row2 = mysql_fetch_assoc($result2);

	array_push($members, array("name" => $row2['name'], "id" => $row['userID']));

}

	echo json_encode($members);

?>
