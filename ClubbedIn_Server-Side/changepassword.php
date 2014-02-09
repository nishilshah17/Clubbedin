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

$userID = $_POST['userID'];
$password = $_POST['newpassword'];


	$result = mysql_query('UPDATE user SET password = "'.md5($password).'" WHERE userID = "'.$userID.'"');

?>