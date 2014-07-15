<?php
require_once 'ApnsPHP/Abstract.php';
require_once 'ApnsPHP/Exception.php';
require_once 'ApnsPHP/Feedback.php';
require_once 'ApnsPHP/Message.php';
require_once 'ApnsPHP/Log/Embedded.php';
require_once 'ApnsPHP/Log/Interface.php';
require_once 'ApnsPHP/Message/Custom.php';
require_once 'ApnsPHP/Message/Exception.php';
require_once 'ApnsPHP/Push/Exception.php';
require_once 'ApnsPHP/Push/Server.php';
require_once 'ApnsPHP/Push/Server/Exception.php';
include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$result = mysql_query('SELECT * FROM devids WHERE userID = 646225650');

$row = $result['deviceID'];
        
            date_default_timezone_set('America/New_York');
            $message = "Push notification testing!";


            // Instantiate a new Message with a single recipient
            $deviceToken = '4d2678ab6ebfeb69f9271f5e85978e1e4eb12b502ef84be92efe7df4c9e2d845';
            
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'clubbedinpush.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', 'ClubbedIn2013');

$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', 
    $err, 
    $errstr, 
    60, 
    STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, 
    $ctx);


// Create the payload body
$body['aps'] = array(
    'badge' => +1,
    'alert' => $message,
    'sound' => 'default'
);

$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
    echo 'Message not delivered' . PHP_EOL;
else
    echo 'Message successfully delivered amar'.$message. PHP_EOL;

// Close the connection to the server
fclose($fp);

?>