<?php
header("access-control-allow-origin: *");
print_r($_FILES);
$userID= $_POST['userID'];
$new_image_name = $clubID.".jpg";
move_uploaded_file($_FILES["file"]["tmp_name"], "/home4/clubbed/public_html/web/propics/".$new_image_name);

$dbhost = 'localhost';
$dbuser = 'clubbed_admin';
$dbpass = 'ClubbedIn2013';
$db = 'clubbed_main';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

mysql_query('UPDATE user SET picpath= "'.$new_image_name.'" WHERE userID= "'.$userID.'"');
?>