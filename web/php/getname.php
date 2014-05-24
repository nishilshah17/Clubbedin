<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$userID = $_POST['id'];

$result = mysql_query('SELECT * FROM user WHERE userID = "'.$userID.'"');
$row = mysql_fetch_assoc($result);
$userName = $row['name'];

$json = json_encode(array('name' => $userName));

echo $json;

?>