<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$userID = $_POST['uID'];
$userID = 339236670;

$clubnames = array();

$result = mysql_query('SELECT * FROM clubmember WHERE userID = "'.$userID.'"');

while ($row = mysql_fetch_assoc($result)) {

    $result2 = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$row["clubID"].'"');
    $row2 = mysql_fetch_assoc($result2);

    if(mysql_num_rows($result2)==0)
    {
    }
    else
    {
	array_push($clubnames, array("name" => $row2['clubName'], "id" => $row['clubID']));
	}


}
	echo json_encode($clubnames);


?>