var app = {
myLog: document.getElementById("log"),
initialize: function() {
    this.bindEvents();
},
    // Bind Event Listeners
bindEvents: function() {
    document.addEventListener('deviceready', this.onDeviceReady, false);
    document.addEventListener('resume', this.onResume, false);
},
onResume: function() {
    app.myLog.value="";
    // Clear the badge number - if a new notification is received it will have a number set on it for the badge
    app.setBadge(0);
    app.getPending(); // Get pending since we were reopened and may have been launched from a push notification
},
onDeviceReady: function() {
    app.register(); // Call to register device immediately every time since unique token can change (per Apple)
    
    // This will cause to fire when app is active already
    document.addEventListener('push-notification', function(event) {
                              console.log('RECEIVED NOTIFICATION! Push-notification! ' + event);
                              app.myLog.value+=JSON.stringify(['\nPush notification received!', event]);
                              // Could pop an alert here if app is open and you still wanted to see your alert
                              //navigator.notification.alert("Received notification - fired Push Event " + JSON.stringify(['push-//notification!', event]));
                              });
    document.removeEventListener('deviceready', this.deviceready, false);
},
setBadge: function(num) {
    var pushNotification = window.plugins.pushNotification;
    app.myLog.value+="Clear badge... \n";
    pushNotification.setApplicationIconBadgeNumber(num);
},
receiveStatus: function() {
    var pushNotification = window.plugins.pushNotification;
    pushNotification.getRemoteNotificationStatus(function(status) {
                                                 app.myLog.value+=JSON.stringify(['Registration check - getRemoteNotificationStatus', status])+"\n";
                                                 });
},
getPending: function() {
    var pushNotification = window.plugins.pushNotification;
    pushNotification.getPendingNotifications(function(notifications) {
                                             app.myLog.value+=JSON.stringify(['getPendingNotifications', notifications])+"\n";
                                             console.log(JSON.stringify(['getPendingNotifications', notifications]));
                                             });
},
register: function() {
    var pushNotification = window.plugins.pushNotification;
    pushNotification.registerDevice({alert:true, badge:true, sound:true}, function(status) {
                                    app.myLog.value+=JSON.stringify(['registerDevice status: ', status])+"\n";
                                    app.storeToken(status.deviceToken);
                                    });
},
storeToken: function(token) {
    console.log("Token is " + token);
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.open("POST","http://127.0.0.1:8888",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("token="+token+"&message=pushnotificationtester");
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4) {
            //a response now exists in the responseTest property.
            console.log("Registration response: " + xmlhttp.responseText);
            app.myLog.value+="Registration server returned: " + xmlhttp.responseText;
        }
    }
}    
};