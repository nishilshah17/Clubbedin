<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$clubID = $_POST['clubID'];

$leaders = array();
$result = mysql_query('SELECT * FROM clubleader WHERE clubID = "'.$clubID.'"');

while($row = mysql_fetch_assoc($result))
{

	array_push($leaders, array("id" => $row['leaderID']));
}

echo json_encode($leaders);

?>

