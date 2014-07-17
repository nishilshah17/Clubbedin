<?php
	header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$userID = $_POST['userID'];
$password = $_POST['curpassword'];
$password = md5($password);


	$result = mysql_query('SELECT * FROM user WHERE userID = "'.$userID.'"');
	$row = mysql_fetch_assoc($result);
	$currentpassword = $row['password'];

if ($password == $currentpassword)
	echo "true";
else echo "false";

?>