<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$eventID = $_POST['eventID'];

$members = array();

$result = mysql_query('SELECT * FROM events WHERE eventID = "'.$eventID.'"');
$row = mysql_fetch_assoc($result);

$clubID = $row['clubID'];

$result2 = mysql_query('SELECT * FROM clubmember WHERE clubID = "'.$clubID.'"');

while ($row2 = mysql_fetch_assoc($result2))
{
	$userID = $row2['userID'];
	$result3 = mysql_query('SELECT * FROM user WHERE userID = "'.$userID.'"');
	$row3 = mysql_fetch_assoc($result3);

	if($eventID > 100000000 && $eventID <= 333333333)
		$result4 = mysql_query('SELECT * FROM eventmember WHERE eventID = "'.$eventID.'" AND userID = "'.$userID.'"');
	elseif ($eventID > 333333333 && $eventID <= 666666666)
		$result4 = mysql_query('SELECT * FROM eventmember2 WHERE eventID = "'.$eventID.'" AND userID = "'.$userID.'"');
	elseif ($eventID > 666666666 && $eventID <= 999999999)
		$result4 = mysql_query('SELECT * FROM eventmember3 WHERE eventID = "'.$eventID.'" AND userID = "'.$userID.'"');

	if($eventID > 100000000 && $eventID <= 333333333)
		$result5 = mysql_query('SELECT * FROM attendance WHERE eventID = "'.$eventID.'" AND userID = "'.$userID.'"');
	elseif ($eventID > 333333333 && $eventID <= 666666666)
		$result5 = mysql_query('SELECT * FROM attendance2 WHERE eventID = "'.$eventID.'" AND userID = "'.$userID.'"');
	elseif ($eventID > 666666666 && $eventID <= 999999999)
		$result5 = mysql_query('SELECT * FROM attendance3 WHERE eventID = "'.$eventID.'" AND userID = "'.$userID.'"');

	$resultsubmit = mysql_query('SELECT * FROM attendancesubmit WHERE eventID = "'.$eventID.'"');

	if(mysql_num_rows($result4) > 0 && mysql_num_rows($resultsubmit) == 0)
	{
		$num = 1;
	}
	else if (mysql_num_rows($result5) > 0)
	{
		$num = 1;
	}
	else $num = 0;

	array_push($members, array('userID' => $userID, 'name' => $row3['name'], 'going' => $num));

}

if($eventID > 100000000 && $eventID <= 333333333)
	$result9 = mysql_query('SELECT * FROM eventmember WHERE eventID = "'.$eventID.'"');
elseif ($eventID > 333333333 && $eventID <= 666666666)
	$result9 = mysql_query('SELECT * FROM eventmember2 WHERE eventID = "'.$eventID.'"');
elseif ($eventID > 666666666 && $eventID <= 999999999)
	$result9 = mysql_query('SELECT * FROM eventmember3 WHERE eventID = "'.$eventID.'"');

while ($row9 = mysql_fetch_assoc($result9))
{
	$exists = 'FALSE' ;

	foreach($members as $member) {
		if ($member['userID'] == $row9['userID'])
			$exists = 'TRUE';

	}

		$resultsubmit = mysql_query('SELECT * FROM attendancesubmit WHERE eventID = "'.$eventID.'"');

		if($eventID > 100000000 && $eventID <= 333333333)
					$result11 = mysql_query('SELECT * FROM attendance WHERE eventID = "'.$eventID.'" AND userID = "'.$row9['userID'].'"');
		elseif ($eventID > 333333333 && $eventID <= 666666666)
					$result11 = mysql_query('SELECT * FROM attendance2 WHERE eventID = "'.$eventID.'" AND userID = "'.$row9['userID'].'"');
		elseif ($eventID > 666666666 && $eventID <= 999999999)
					$result11 = mysql_query('SELECT * FROM attendance3 WHERE eventID = "'.$eventID.'" AND userID = "'.$row9['userID'].'"');

		$result8 = mysql_query('SELECT * FROM user WHERE userID = "'.$row9['userID'].'"');
		$row8 = mysql_fetch_assoc($result8);

	if($exists == 'FALSE' && mysql_num_rows($resultsubmit) == 0)
	{
		array_push($members, array('userID' => $row9['userID'], 'name' => $row8['name'], 'going' => '1'));
	} elseif ($exists == 'FALSE' && mysql_num_rows($result11) > 0)
	{
		array_push($members, array('userID' => $row9['userID'], 'name' => $row8['name'], 'going' => '1'));
	} elseif ($exists == 'TRUE') {

	} else {
		array_push($members, array('userID' => $row9['userID'], 'name' => $row8['name'], 'going' => '0'));
	}
}

$tmp = Array();
foreach($members as &$ma)
    $tmp[] = &$ma["name"];
$tmp = array_map('strtolower', $tmp);
array_multisort($tmp, $members);

echo json_encode($members);

?>
