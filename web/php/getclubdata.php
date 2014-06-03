<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

if(isset($_POST['theid']))
{
    $clubID = $_POST['theid'];
}


$result = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$clubID.'"');
$row = mysql_fetch_assoc($result);
$clubName = $row['clubName'];
$cID = $row['clubID'];
$schoolName = $row['schoolName'];
$desc = $row['description'];


$json = json_encode(array('clubName' => $clubName, 'clubID' => $cID, 'schoolName' => $schoolName, 'description' => $desc));

echo $json;

?>