<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$topicID = $_POST['topicID'];
$userID = $_POST['userID'];

$comments = array();

$result = mysql_query('SELECT * FROM topics
						WHERE topicID = "'.$topicID.'"');

while ($row = mysql_fetch_assoc($result)) {

    if($row['userID'] == $userID)
        array_push($comments, array("comment" => $row['comment'], "type" => "send", "commentID" => $row['commentID']));
    else
        array_push($comments, array("comment" => $row['comment'], "type" => "receive", "commentID" => $row['commentID']));

}

$tmp = Array();
foreach($comments as &$ma)
    $tmp[] = &$ma["commentID"];
array_multisort($tmp, $comments);

echo json_encode($comments);

?>
