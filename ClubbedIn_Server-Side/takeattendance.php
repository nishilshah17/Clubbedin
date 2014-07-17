<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';
include 'pushnotifs.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$attendanceData = $_POST['attendance'];

foreach($attendanceData as $item) {
    $userID = $item['userID'];
    $eventID = $item['eventID'];
    $status = $item['status'];

    
    $result = mysql_query('SELECT * FROM events WHERE eventID = "'.$eventID.'"');
    $row = mysql_fetch_assoc($result);
    $eventName = $row['eventName'];
	
    if($eventID > 100000000 && $eventID <= 333333333)
		$result = mysql_query('SELECT * FROM attendance WHERE userID = "'.$userID.'" AND eventID = "'.$eventID.'"');
	elseif ($eventID > 333333333 && $eventID <= 666666666)
		$result = mysql_query('SELECT * FROM attendance2 WHERE userID = "'.$userID.'" AND eventID = "'.$eventID.'"');
	elseif ($eventID > 666666666 && $eventID <= 999999999)
		$result = mysql_query('SELECT * FROM attendance3 WHERE userID = "'.$userID.'" AND eventID = "'.$eventID.'"');

	if(mysql_num_rows($result) == 0)
	{
		if($status == 'checked')
		{
			if($eventID > 100000000 && $eventID <= 333333333)
				mysql_query('INSERT INTO attendance (eventID, userID) VALUES ("'.$eventID.'","'.$userID.'")');
			elseif ($eventID > 333333333 && $eventID <= 666666666)
				mysql_query('INSERT INTO attendance2 (eventID, userID) VALUES ("'.$eventID.'","'.$userID.'")');
			elseif ($eventID > 666666666 && $eventID <= 999999999)
				mysql_query('INSERT INTO attendance3 (eventID, userID) VALUES ("'.$eventID.'","'.$userID.'")');
            
            $message = "Your presence at ".$eventName." has been marked";
            sendNotification($userID, $message);
		}
	} else {
		if($status == 'unchecked')
		{
			if($eventID > 100000000 && $eventID <= 333333333)
				mysql_query('DELETE FROM attendance WHERE userID = "'.$userID.'" AND eventID = "'.$eventID.'"');
			elseif ($eventID > 333333333 && $eventID <= 666666666)
				mysql_query('DELETE FROM attendance2 WHERE userID = "'.$userID.'" AND eventID = "'.$eventID.'"');
			elseif ($eventID > 666666666 && $eventID <= 999999999)
				mysql_query('DELETE FROM attendance3 WHERE userID = "'.$userID.'" AND eventID = "'.$eventID.'"');
            
            $message = "You're missing out on ".$eventName."!";
            sendNotification($userID, $message);
		}

	}
	$result = mysql_query('SELECT * FROM attendancesubmit WHERE eventID = "'.$eventID.'"');

	if(mysql_num_rows($result) == 0)
	{

	mysql_query('INSERT INTO attendancesubmit (eventID) VALUES ("'.$eventID.'")');

	}

}

?>