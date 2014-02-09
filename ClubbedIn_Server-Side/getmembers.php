<?php
header("access-control-allow-origin: *");

$dbhost = 'localhost';
$dbuser = 'clubbed_admin';
$dbpass = 'ClubbedIn2013';
$db = 'clubbed_main';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$clubID = $_POST['clubID'];

$members = array();

$result = mysql_query('SELECT * FROM clubmember
						WHERE clubID = "'.$clubID.'"');

while ($row = mysql_fetch_assoc($result)) {

	$result2 = mysql_query('SELECT * FROM user WHERE userID = "'.$row['userID'].'"');
	$row2 = mysql_fetch_assoc($result2);

	array_push($members, array("name" => $row2['name'], "id" => $row['userID']));

}

$tmp = Array();
foreach($members as &$ma)
    $tmp[] = &$ma["name"];
$tmp = array_map('strtolower', $tmp);
array_multisort($tmp, $members);

	echo json_encode($members);

?>
