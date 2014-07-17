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

function sendNotification($userID, $message){
    
    $result = mysql_query('SELECT * FROM devids WHERE userID = "'.$userID.'"');
    while($row = mysql_fetch_assoc($result)) {
        $deviceID = $row['deviceID'];
        $platform = $row['platform'];
        
        if($platform == "android"){
            
                    $apiKey = "AIzaSyBR91yAjsZyM7MIQTE1zqI-w4iGFqGjTrQ";
                    $registrationId = $deviceID;
                    
                    $registrationIDs = array($registrationId);
                
                    $url = 'https://android.googleapis.com/gcm/send';
                
                    $fields = array(
                        'registration_ids' => $registrationIDs,
                        'data' => array( "message" => $message, "title" => "Clubbed In" ),
                    );
                    $headers = array(
                        'Authorization: key=' . $apiKey,
                        'Content-Type: application/json'
                    );
                
                    $ch = curl_init();
                    curl_setopt( $ch, CURLOPT_URL, $url);
                    curl_setopt( $ch, CURLOPT_POST, true);
                    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $fields));
                
                    $result = curl_exec($ch);
                
                    curl_close($ch);
                    echo $result;    
        }
                
        if($platform == "ios") {
                    date_default_timezone_set('America/New_York');
        
                    // Report all PHP errors
                    error_reporting(-1);
                    
                    // Instantiate a new ApnsPHP_Push object
                    $push = new ApnsPHP_Push(
                        ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION,
                        'clubbedinpush.pem'
                    );
                    
                    // Set the Provider Certificate passphrase
                    //$push->setProviderCertificatePassphrase('test');
                    
                    // Set the Root Certificate Autority to verify the Apple remote peer
                    $push->setRootCertificationAuthority('entrust_root_certification_authority.pem');
                    
                    // Connect to the Apple Push Notification Service
                    $push->connect();
                    
                    // Instantiate a new Message with a single recipient
                    $notif = new ApnsPHP_Message($deviceID);
                    
                    // Set a custom identifier. To get back this identifier use the getCustomIdentifier() method
                    // over a ApnsPHP_Message object retrieved with the getErrors() message.
                    $notif->setCustomIdentifier("Message-Badge-1");
                    
                    // Set badge icon to "3"
                    $notif->setBadge(1);
                    
                    // Set a simple welcome text
                    $notif->setText($message);
                    
                    // Play the default sound
                    $notif->setSound();
                    
                    // Set a custom property
                    $notif->setCustomProperty('acme2', array('bang', 'whiz'));
                    
                    // Set another custom property
                    $notif->setCustomProperty('acme3', array('bing', 'bong'));
                    
                    // Set the expiry value to 30 seconds
                    $notif->setExpiry(30);
                    
                    // Add the message to the message queue
                    $push->add($notif);
                    
                    // Send all messages in the message queue
                    $push->send();
                    
                    // Disconnect from the Apple Push Notification Service
                    $push->disconnect();
                    
                    // Examine the error message container
                    $aErrorQueue = $push->getErrors();
                    if (!empty($aErrorQueue)) {
                        var_dump($aErrorQueue);
                    }
        }
    }
}
?>