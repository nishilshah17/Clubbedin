<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
	or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
	or die("Unabble to select database: " . mysql_error());

$rand = FALSE;
$username = $_POST['signupname'];
$email = $_POST['signupemail'];
$password = $_POST['signuppassword'];
$password = md5($password);

while (!$rand)
{
	$userID = rand(100000000, 999999999);
	$result = mysql_query('SELECT * FROM user WHERE userID = "'.$userID.'"');
	if(mysql_num_rows($result) == 0) {
		$rand = TRUE;
	} else {
	}
}

mysql_query('INSERT INTO user (userID, name, email, password) VALUES ("'.$userID.'", "'.$username.'", "'.$email.'", "'.$password.'")');

echo json_encode(array('userID' => $userID));


?>