<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$rand = FALSE;

while (!$rand)
{
	$clubID = rand(10000,99999);
	$result = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$clubID.'"');
	if(mysql_num_rows($result) == 0) {
		 $rand = TRUE;
	} else {
	}

}

$clubName = $_POST['name'];
$leaderID = $_POST['uID'];

echo $clubID;
echo $clubName;

mysql_query('INSERT INTO clubs (clubID, clubName,schoolName, description) VALUES ("'.$clubID.'","'.$clubName.'","'.$_POST['sname'].'","'.$_POST['desc'].'")');

mysql_query('INSERT INTO clubmember (clubID, userID) VALUES ("'.$clubID.'","'.$leaderID.'")');

mysql_query('INSERT INTO clubleader (leaderID, clubID) VALUES ("'.$leaderID.'","'.$clubID.'")');


?>