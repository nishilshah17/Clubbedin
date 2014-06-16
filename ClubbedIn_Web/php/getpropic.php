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

$userID= $_POST['userID'];

$result = mysql_query('SELECT * FROM user WHERE usedID = "'.$userID.'"');
$row = mysql_fetch_assoc($result);

if (strlen($row['picpath']) > 0)
{
$imageurl = 'http://clubbedinapp.com/web/propics/'.$row['picpath'];

echo json_encode(array('logo' => $imageurl));
}

?>
