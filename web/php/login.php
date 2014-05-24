<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
	or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
	or die("Unable to select database: " . mysql_error());

$email = $_POST['loginemail'];
$password = $_POST['loginpassword'];
$password = md5($password);
$userID = 0;

$result = mysql_query('SELECT * FROM user WHERE email = "'.$email.'" AND password = "'.$password.'"');

if(mysql_num_rows($result) > 0)
{
	$row = mysql_fetch_assoc($result);
	$userID = $row['userID'];
}

	echo json_encode(array('userID' => $userID));

?>