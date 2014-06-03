<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$clubID = $_POST['clubID'];
$clubName = $_POST['editname'];
$schoolName = $_POST['editsname'];
$description = $_POST['editdesc'];

mysql_query('UPDATE clubs SET clubName = "'.$clubName.'", schoolName = "'.$schoolName.'", description = "'.$description.'" WHERE clubID = "'.$clubID.'"');

echo $clubID;
echo $clubName;
echo $schoolName;
echo $description;





?>