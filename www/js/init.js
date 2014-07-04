        $(document).on("mobileinit", function() {
        $.mobile.touchOverflowEnabled = true; // required
        $.mobile.defaultPageTransition = 'none'; // optional - for better performance on Android
        $.mobile.defaultDialogTransition = 'none';
        $.mobile.loadingMessageTextVisible = true; // optional - added to show text message
        $.mobile.buttonMarkup.hoverDelay = 0; // optional added to remove sluggishness - jqm default 200
        $.mobile.allowCrossDomainPages = true;
        $.support.cors = true;
        });
    
    // Wait for PhoneGap to load
        function getImage() {
            // Retrieve image file location from specified source
            navigator.camera.getPicture(uploadPhoto, function(message) {
            alert('Get Picture Failed. Please Try Again.');
            },{
            quality: 50,
            destinationType: navigator.camera.DestinationType.FILE_URI,
            sourceType: navigator.camera.PictureSourceType.PHOTOLIBRARY
            });
        }
    
        function uploadPhoto(imageURI) {
            var options = new FileUploadOptions();
            options.fileKey="file";
            options.fileName=curClub+imageURI.substr(imageURI.lastIndexOf('/')+1);
            options.mimeType="image/jpeg";
        
            var params = new Object();
            params.clubID = curClub ;
            options.params = params;
            options.chunkedMode = false;
        
            var ft = new FileTransfer();
            ft.upload(imageURI, "http://clubbedinapp.com/web/php/upload.php", win, fail, options);
        }
    
        function win(r) {
            console.log("Code = " + r.responseCode);
            console.log("Response = " + r.response);
            console.log("Sent = " + r.bytesSent);;
        }
    
        function fail(error) {
            alert("An error has occurred: Code = " + error.code);
        }