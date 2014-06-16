<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$userID = $_POST['userID'];

$news = array();

$result = mysql_query('SELECT * FROM clubmember WHERE userID = "'.$userID.'"');

while ($row = mysql_fetch_assoc($result))
{
	$clubID = $row['clubID'];

	$result2 = mysql_query('SELECT * FROM announcements WHERE clubID = "'.$clubID.'"');

	while ($row2 = mysql_fetch_assoc($result2))
	{
		$title = $row2['title'];
		$info = $row2['info'];
		$clubID = $row['clubID'];

		$result3 = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$clubID.'"');
		$row3 = mysql_fetch_assoc($result3);
		$clubName = $row3['clubName'];

		array_push($news, array("club" => $clubName, "title" => $title, "info" => $info));
	}
}

$tmp = Array();
foreach($news as &$ma)
    $tmp[] = &$ma["club"];
$tmp = array_map('strtolower', $tmp);
array_multisort($tmp, $news);

	echo json_encode($news);





?>