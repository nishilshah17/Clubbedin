<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$clubID = $_POST['clubID'];

$topics = array();

$result = mysql_query('SELECT * FROM topics
						WHERE clubID = "'.$clubID.'"');

while ($row = mysql_fetch_assoc($result)) {

	array_push($topics, array("topic" => $row['topic'], "topicID" => $row['topicID']));

}

echo json_encode($topics);

?>
