<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$userID = $_POST['userID'];
$clubs = array();
$result = mysql_query('SELECT * FROM clubleader WHERE leaderID = "'.$userID.'"');

while ($row = mysql_fetch_assoc($result))
{
	$result2 = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$row['clubID'].'"');
	$row2 = mysql_fetch_assoc($result2);

	$clubName = $row2['clubName'];
	$clubID = $row['clubID'];

	array_push($clubs, array('clubName' => $clubName, 'clubID' => $clubID));
}

$tmp = Array();
foreach($clubs as &$ma)
    $tmp[] = &$ma["clubName"];
$tmp = array_map('strtolower', $tmp);
array_multisort($tmp, $clubs);

echo json_encode($clubs);

?>