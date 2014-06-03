<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
	or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
	or die("Unable to select database: " . mysql_error());

$password = md5($password);
$userID = $_POST['userID'];
$isUserID = false;

$result = mysql_query('SELECT * FROM user');

while($row == mysql_fetch_assoc($result))
{
   if(md5($row['userID'] == $userID))
   {
       $isUserID = true;
   }
}

	echo json_encode(array('val' => $isUserID));

?>