<?php

header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$platform = $_POST['platform'];
$deviceID = $_POST['deviceID'];
$userID = $_POST['uID'];

$result = mysql_query('SELECT * FROM devids WHERE userID = "'.$userID.'" and deviceID = "'.$deviceID.'"');

if(mysql_num_rows($result) == 0) {

    mysql_query('INSERT INTO devids (userID, deviceID, platform) VALUES ("'.$userID.'", "'.$deviceID.'", "'.$platform.'")');
    
}

?>