<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$curClub = $_POST['curClub'];
$userID = $_POST['uID'];
$joinID = $_POST['clubid2'];

if(isset($userID)){
    if($curClub == $joinID)
    {
        $num = 1;
        //join club
        mysql_query('INSERT INTO clubmember (userID, clubID) VALUES ("'.$userID.'","'.$curClub.'")');
        
    } else {
        $num = 2;
        //error
    }
}

echo json_encode(array('num'=>$num));