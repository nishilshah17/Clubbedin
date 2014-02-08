            var userID = 0;
            var curClub = 0;

    $("#clubname").submit(function (e) {
        var serData = $('#clubname').serialize() + "&uID=" + userID;
        e.preventDefault();
        $.ajax({
            url: 'http://www.clubbedin.isadcharity.org/createclub.php',
            crossDomain: true,
            type: 'post',
            data: serData,
            success: function (data) {
                $("#result").html(data);
                $.mobile.changePage($('#page-tasklist'));
            },
        });
    });

    $("#getclubid").submit(function (e) {
        var serData = $('#getclubid').serialize() + "&uID=" + userID;
        e.preventDefault();
        $.ajax({
            url: 'http://www.clubbedin.isadcharity.org/joinclub.php',
            crossDomain: true,
            type: 'post',
            data: serData,
            success: function (data) {
                $('#message1, #message2').empty();
                var json = jQuery.parseJSON(data);
                $('#message1').append('<h1>' + json.message + '</h1>');
                $('#message2').append('<a href=\"' + json.redirect + '\"><h2>' + json.message2 + '</h2></a>');
                $.mobile.changePage($('#postmessage'));
            },
        });
    });

    $(document).on('pageinit', '#page-tasklist', function () {
        getClubs();
    });

    /*$(document).on('pageinit', '#defaultclub', function () {
        getEvents();
    });*/

    function getClubs() {
        $.ajax({
            url: 'http://www.clubbedin.isadcharity.org/getclubs.php',
            crossDomain: true,
            type: 'post',
            data: {
                'uID': userID
            },
            success: function (data) {
                $('#clubcontent').empty();
                var json = jQuery.parseJSON(data);
                for (var i = 0; i < json.length; i++)
                    $('#clubcontent').append('<li><a href="#" data-club-id=\"' + json[i].id + '\" rel="external">' + json[i].name + '</a></li>');
                $('#clubcontent').listview('refresh');
            },
        });
    };

    $(document).on('click', '#clubcontent li a', function () {
        getClubData($(this).data('club-id'));
    });

    function getClubData(id) {
        console.log(id);
        $.ajax({
            url: 'http://www.clubbedin.isadcharity.org/getclubdata.php',
            crossDomain: true,
            type: 'post',
            data: {
                'theid': id
            },
            success: function (data2) {
                $('#hdr').empty();
                $('#defcont').empty();
                $('#addbuttons').empty();
                var json = jQuery.parseJSON(data2);
                $.mobile.changePage($('#defaultclub'));
                if (json.leaderID == userID) {
                    var htmlStrings = [
                        '<a href="#" data-role="button" data-inline="true" data-iconpos="notext" data-icon="gear" data-theme="b">Edit</a>',
                        '<a href="#newevent1" data-role="button" data-iconpos="notext" data-inline="true" data-icon="plus" data-theme="b">New Event</a>'
                    ];
                    $('#addbuttons').append(htmlStrings.join(''));
                    $('#defaultclub').trigger('pagecreate');
                }
                $('#hdr').append(json.clubName);
                $('#defcont').append('<strong>Club ID: </strong>' + json.clubID + '<br/><br/>');
                $('#defcont').append('<strong>School: </strong>' + json.schoolName + '<br/><br/>');
                $('#defcont').append('<strong>Description: </strong>' + json.description + '<br/><br/>');
                $('#defcont').append('<strong>Leader ID: </strong>' + json.leaderID + '<br/>');
                curClub = json.clubID;


            },
        });

    };

    $(document).ready(function () {

        jQuery.validator.addMethod('selectcheck', function (value) {
            return (value != 'none');
        }, "Select!");

        jQuery.validator.setDefaults({
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            }
        });
    });

    $('#newevent1info').submit(function (event) {
        event.preventDefault();

        if ($(this).validate({
            rules: {
                ename: {
                    required: true
                },
                descevent: {
                    required: true
                },
                date: {
                    required: true
                },
                starttime: {
                    required: true
                },
                endtime: {
                    required: true
                },
            }
        }).form()) {

            var serData = $('#newevent1info').serialize() + "&clubID=" + curClub;
            alert(serData);
            $.ajax({
                url: 'http://www.clubbedin.isadcharity.org/newevent.php',
                crossDomain: true,
                type: 'post',
                data: serData,
                success: function (data) {
                alert("success")
                    $('<div>').simpledialog2({
                        mode: 'button',
                        headerText: 'Success!',
                        headerClose: true,
                        buttonPrompt: 'Event has been created...',
                        buttons: {
                            'OK': {
                                click: function () {
                                    getClubData(curClub);
                                }
                            },
                        }
                    })
                }
            });
        } else {
            return false;
        }
    });

    function fillmembers() {
        //return all the members in the club
    };

   /* function getEvents() {
        $.ajax({
            url: 'http://www.clubbedin.isadcharity.org/getevents.php',
            crossDomain: true,
            type: 'post',
            data: {
                'clubID': curClub
            },
            success: function (data) {
                $('#eventlist').empty();
                var json = jQuery.parseJSON(data);
                for (var i = 0; i < json.length; i++)
                    $('#eventlist').append('<li><a href="#" data-club-id=\"' + json[i].id + '\" rel="external">' + json[i].name + '</a></li>');
                $('#eventlist').listview('refresh');
            },
        });

        */
    }