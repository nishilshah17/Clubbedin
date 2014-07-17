<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$clubID = $_POST['clubid'];
$userID = $_POST['uID'];

$result = mysql_query('SELECT * FROM clubmember WHERE clubID = "'.$clubID.'" AND userID = "'.$userID.'"');
$result2 = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$clubID.'"');
$inclub = FALSE;
$clubexists = FALSE;

if(mysql_num_rows($result2) > 0)
{
	$clubexists = TRUE;
	$row = mysql_fetch_assoc($result2);
	$clubName = $row["clubName"];
}

$result3 = mysql_query('SELECT * FROM banned WHERE userID = "'.$userID.'" AND clubID = "'.$clubID.'"');

if (mysql_num_rows($result3) > 0) {
	echo json_encode(array('num' => "3", 'clubname' => $row['clubName']));
}
else if((mysql_num_rows($result) == 0) && ($clubexists)) {
	mysql_query('INSERT INTO clubmember (clubID, userID) VALUES ("'.$clubID.'","'.$userID.'")');
	echo json_encode(array('num' => "1", 'clubname' => $row['clubName']));
}
else {
	if(mysql_num_rows($result) > 0)
	{
		echo json_encode(array('num' => "2", 'clubname' => $row['clubName']));
	}
	else
	{
		echo json_encode(array('num' => "4", 'clubname' => $row['clubName']));
	}
}



?>