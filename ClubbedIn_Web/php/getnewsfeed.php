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



$announcements = array();



$result = mysql_query('SELECT * FROM clubmember WHERE userID = "'.$userID.'"');



while ($row = mysql_fetch_assoc($result)) {



    $result2 = mysql_query('SELECT * FROM announcements WHERE clubID = "'.$row["clubID"].'"');



    $row2 = mysql_fetch_assoc($result2);



	array_push($announcements, array("title" => $row['title'], "info" => $row['info'], "num" => $row['num']));



}



echo json_encode($announcements);



?>