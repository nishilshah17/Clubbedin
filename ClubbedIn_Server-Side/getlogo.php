<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$clubID = $_POST['clubID'];

$result = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$clubID.'"');
$row = mysql_fetch_assoc($result);

if (strlen($row['logopath']) > 0)
{
$imageurl = 'http://clubbedinapp.com/web/logos/'.$row['logopath'];

echo json_encode(array('logo' => $imageurl));
}

?>
