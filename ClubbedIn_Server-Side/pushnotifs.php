<?php

    require_once 'ApnsPHP/Autoload.php';

function sendNotification($deviceID, $platform, $message){
    
    if($platform == "android"){
        
        $apiKey = "AIzaSyCgWcsMsAJ1grqvzVJOtMdz5fxSISwyxgM";
        $registrationId = $deviceID;
        
        $tickerText   = "ticker text message";
        $contentTitle = "Clubbed In";
        $contentText  = "content body";

        $response = sendNotification( 
                $apiKey, 
                array($registrationId), 
                array('message' => $message, 'tickerText' => $tickerText, 'contentTitle' => $contentTitle, "contentText" => $contentText)           );
 
        echo $response;
                
    } else if ($platform == "ios"){
    
        date_default_timezone_set('America/New_York');
        
        // Report all PHP errors
        error_reporting(-1);
        
        // Instantiate a new ApnsPHP_Push object
        $push = new ApnsPHP_Push(
            ApnsPHP_Abstract::ENVIRONMENT_SANDBOX,
            'server_certificates_bundle_sandbox.pem'
        );
        
        // Set the Provider Certificate passphrase
        // $push->setProviderCertificatePassphrase('test');
        
        // Set the Root Certificate Autority to verify the Apple remote peer
        $push->setRootCertificationAuthority('entrust_root_certification_authority.pem');
        
        // Connect to the Apple Push Notification Service
        $push->connect();
        
        // Instantiate a new Message with a single recipient
        $message = new ApnsPHP_Message($deviceID);
        
        // Set a custom identifier. To get back this identifier use the getCustomIdentifier() method
        // over a ApnsPHP_Message object retrieved with the getErrors() message.
        $message->setCustomIdentifier("Message-Badge-3");
        
        // Set badge icon to "3"
        $message->setBadge(3);
        
        // Set a simple welcome text
        $message->setText($message);
        
        // Play the default sound
        $message->setSound();
        
        // Set a custom property
        $message->setCustomProperty('acme2', array('bang', 'whiz'));
        
        // Set another custom property
        $message->setCustomProperty('acme3', array('bing', 'bong'));
        
        // Set the expiry value to 30 seconds
        $message->setExpiry(30);
        
        // Add the message to the message queue
        $push->add($message);
        
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

function getResponse($APIKey, $registrationID, $messageData)
{
   $headers = array("Content-Type:" . "application/json", "Authorization:" . "key=" . $apiKey);
    $data = array(
        'data' => $messageData,
        'registration_ids' => $registrationIdsArray
    );
 
    $ch = curl_init();
 
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers ); 
    curl_setopt( $ch, CURLOPT_URL, "https://android.googleapis.com/gcm/send" );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($data) );
 
    $response = curl_exec($ch);
    curl_close($ch);
 
    return $response;        
}

?>