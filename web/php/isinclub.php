<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$clubID = $_POST['clubID'];
$userID = $_POST['userID'];

$result = mysql_query('SELECT * FROM clubmember WHERE clubID = "'.$clubID.'" AND userID = "'.$userID.'"');

$inclub = FALSE;

if(mysql_num_rows($result) > 0) {
	$message = 'yes';
}
else {
	$message = 'no';
}

echo $message;


?>