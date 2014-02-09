<?php
header("access-control-allow-origin: *");
print_r($_FILES);
$clubID = $_POST['clubID'];
$new_image_name = $clubID.".jpg";
move_uploaded_file($_FILES["file"]["tmp_name"], "/home4/clubbed/public_html/web/logos/".$new_image_name);

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

mysql_query('UPDATE clubs SET logopath = "'.$new_image_name.'" WHERE clubID = "'.$clubID.'"');
?>