

document.addEventListener("deviceready", startApp, false);

		var userID = 0;
        var deviceID;

		function startApp(){
			userID = window.localStorage.getItem('uID');

			if (userID > 0){
				$.mobile.changePage("#page-tasklist", {
					transition : "flip",
				});
			}
			else{
				$.mobile.changePage("#page-unauthorized", {
					transition : "flip",
				});
			}
            initPush();
            loadContent();
            getClubs();

		}

        function initPush() {
            
            var pushNotification;
        
            pushNotification = window.plugins.pushNotification;

                pushNotification.register(
                    tokenHandler,
                    errorHandler,
                    {
                        "badge":"true",
                        "sound":"true",
                        "alert":"true",
                        "ecb":"onNotificationAPN"
                    });
            
            function errorHandler (error) {
                alert('error = ' + error);
            }
        
            function successHandler (result) {
                //alert('result = ' + result);
            }
    
            function tokenHandler (result) {

                deviceID = result;
                //alert('device token = ' + result);
                $.ajax({
                       url: 'http://clubbedinapp.com/web/php/adddevice.php',
                       crossDomain: true,
                       type: 'post',
                       data: {
                            'uID': userID,
                            'platform': 'ios',
                            'deviceID': result
                       },
                       success: function(data) {
                       
                       }
                });
            }
    
        }

        function loadContent() {
            $.ajax({
                url: 'http://clubbedinapp.com/web/php/getclubs.php',
                crossDomain: true,
                async: false,
                type: 'post',
                data: {
                   'uID': userID
                },
                success: function (data) {
                   window.localStorage.setItem("clubs",data);
                   
                   //loadClubData here
                   var json = jQuery.parseJSON(data);
                   for (var i=0; i<json.length; i++)
                   {
                   (function(i2) {
                    var id = json[i].id;
                    $.ajax({
                        url: 'http://clubbedinapp.com/web/php/getclubdata.php',
                        crossDomain: true,
                        type: 'post',
                        data: {
                            'theid': id
                        },
                        success: function (data2) {
                           window.localStorage['club'+id] = data2;
                        },
                    });
                    }(i));
                   }
                   
                },
                error: function () {
                   alert("Error: could not connect to server");
                }
            });
            $.ajax({
                url: 'http://clubbedinapp.com/web/php/newsfeed.php',
                crossDomain: true,
                async: false,
                type: 'post',
                data: {
                   'userID': userID
                },
                success: function(data) {
                   window.localStorage.setItem("newsfeed",data);
                },
                error: function () {
                   alert("Error: could not connect to server");
                }
            });
            $.ajax({
                url: 'http://clubbedinapp.com/web/php/getupcoming.php',
                crossDomain: true,
                async: false,
                type: 'post',
                data: {
                    'uID': userID
                },
                success: function (data) {
                   window.localStorage.setItem("upcoming",data);
                },
                error: function (data) {
                    alert("Error: could not connect to server");
                }
            });

        }

        $(document).on("mobileinit", function(){
            $.mobile.defaultPageTransition   = 'none';
            $.mobile.defaultDialogTransition = 'none';
        });

        $(document).on("mobileinit", function(){
            $.mobile.buttonMarkup.hoverDelay = 0;
        });

        $(document).ajaxStart(function() {
            $.mobile.loading('show');
        });
        $(document).ajaxStop(function() {
            $.mobile.loading('hide');
		});

	    var curClub = 0;
	    var curEvent = 0;

	    $('#signupform').submit( function (e) {
	        if ($(this).validate({
	            rules: {
	                signupname: {
	                    required: true
	                },
	                signupemail: {
	                    required: true,
	                    email: true
	                },
	                signuppassword: {
	                    minlength: 6
	                },
	                signupconfirm: {
	                    minlength: 6,
	                    equalTo: "#signuppassword"
	                }
	            }
	        }).form()) {
                $('#invalidsignup').empty();
	            e.preventDefault();
	            var serData = $('#signupform').serialize();
                $.ajax({
                    url: 'http://clubbedinapp.com/web/php/validateemail.php',
                    crossDomain: true,
                    type: 'post',
                    data: serData,
                    success: function (data) {
                        if(data == 'yes')
                        {
                            $.ajax({
                                url: 'http://clubbedinapp.com/web/php/signup.php',
                                crossDomain: true,
                                type: 'post',
                                data: serData,
                                success: function (data) {
                                    var json = jQuery.parseJSON(data);
                                    window.localStorage.setItem('uID',json.userID);
                                    startApp();
                                    getClubs();
                                }
                            });
                        } else if (data == 'no'){
                            $('#invalidsignup').append('<p class="error"><b>Email Already In Use!</b></p>');

                        }
                    },
                    error: function (data) {
                        alert("Error: could not connect to server");
					}
                });

	        } else {
	            return false;
	        }

	        return false;
	    });

	    function exportAttendance(club) {

				$.ajax({
	                url: 'http://clubbedinapp.com/web/php/exportAttendance.php',
	                crossDomain: true,
	                type: 'post',
	                data: {
						'clubID': club
					},
	                success: function () {
	                	alert('Attendance sent to admin(s) by email.');
	                }
	            });
		};

	    $('#loginform').submit( function (e) {
	        if ($(this).validate({
	            rules: {
	                loginemail: {
	                    required: true,
	                    email: true
	                },
	                loginpassword: {
						required: true
	                }
	            }
	        }).form()) {
                $('#invalidlogin').empty();
	            e.preventDefault();
	            var serData = $('#loginform').serialize();
	            $.ajax({
	                url: 'http://clubbedinapp.com/web/php/login.php',
	                crossDomain: true,
	                type: 'post',
	                data: serData,
	                success: function (data) {
	                	var json = jQuery.parseJSON(data);
	                	if(json.userID > 0) {
							window.localStorage.setItem('uID',json.userID);
							startApp();
	//		   				$.mobile.changePage('#page-tasklist');
	                    } else {
							$('#invalidlogin').append('<p class="error"><b>Login Failed!</b></p>');
	                    }
	                },
	                error: function (data) {
						alert("Error: could not connect to server");
					}
	            });

	        } else {
	            return false;
	        }

	        return false;
	    });

        $('#changepasswordform').submit( function (e) {
            if ($(this).validate({
                rules: {
                    curpassword: {
                        required: true,
                    },
                    newpassword: {
                        required: true,
                        minlength: 6
                    },
                    newpasswordconfirm: {
                        required: true,
                        equalTo: "#newpassword"
                    }
                }
            }).form()) {
                $('#changepassworderror').empty();
                e.preventDefault();
                var serData = $('#changepasswordform').serialize() + "&userID=" + userID;
                $.ajax({
                    url: 'http://clubbedinapp.com/web/php/getpassword.php',
                    crossDomain: true,
                    type: 'post',
                    data: serData,
                    success: function (data) {
                        if(data == "true") {
                            var serData2 = $('#changepasswordform').serialize() + "&userID=" + userID;
                            $.ajax({
                            url: 'http://clubbedinapp.com/web/php/changepassword.php',
                            crossDomain: true,
                            type: 'post',
                            data: serData2,
                            success: function (data) {
                                $.mobile.changePage('#settings');
                             }
                            });
                        } else {
                            $('#changepassworderror').append('<p class="error"><b>Current Password Incorrect!</b></p>');
                        }
                    }
                });

            } else {
            return false;
            }

            return false;
        });

	    $("#settingslogout").click(function (e) {

	    e.preventDefault();

	    $('<div>').simpledialog2({
	        mode: 'button',
	        headerText: 'Logout',
	        headerClose: true,
	        buttonPrompt: 'Are you sure you want to logout of Clubbed In?',
	        buttons: {
	            'Yes': {
	                click: function () {
                            removeDevice();
                            localStorage.clear();
                            window.localStorage.setItem('uID',0);
                            $.mobile.changePage('#page-tasklist');

	                }
	            },
	            'No': {
	                click: function () {
	                }
	            }
	        }
	    });

	    return false;
	    });

        function removeDevice() {
            $.ajax({
                url: 'http://clubbedinapp.com/web/php/removedevice.php',
                crossDomain: true,
                type: 'post',
                data: {
                   'deviceID' : deviceID
                },
                success: function (data) {

                }
            });
        }


    $("#deleteclub").click(function (e) {

    e.preventDefault();

    $('<div>').simpledialog2({
        mode: 'button',
        headerText: 'Delete',
        headerClose: true,
        buttonPrompt: 'Are you sure you want to delete this club?',
        buttons: {
            'Yes': {
                click: function () {
                    $.ajax({
                        url: 'http://clubbedinapp.com/web/php/deleteclub.php',
                        crossDomain: true,
                        type: 'post',
                        data: {
                            'clubID' : curClub
                        },
                        success: function (data) {
                            $.mobile.changePage('#page-tasklist');
                            refreshClubs(0);
                        }
                    });
                }
            },
            'No': {
                click: function () {
                }
            }
        }
    });

    return false;
    });

    $("#deleteevent").click(function (e) {

        e.preventDefault();

        $('<div>').simpledialog2({
            mode: 'button',
            headerText: 'Delete',
            headerClose: true,
            buttonPrompt: 'Are you sure you want to delete this event?',
            buttons: {
                'Yes': {
                    click: function () {
                        $.ajax({
                            url: 'http://clubbedinapp.com/web/php/deleteevent.php',
                            crossDomain: true,
                            type: 'post',
                            data: {
                                'eventID' : curEvent
                            },
                            success: function (data) {
                                $.mobile.changePage('#page-tasklist');
                                getClubs();
                            }
                        });
                    }
                },
                'No': {
                    click: function () {
                    }
                }
            }
        });

    return false;
    });

    $('#newann').submit( function () {

        var t = $('#t').val();
        var m = $('#m').val();

        $.ajax({
            url: 'http://clubbedinapp.com/web/php/newannouncement.php',
            crossDomain: true,
            type: 'post',
            data: {
                'clubID' : curClub,
                't' : t,
                'm' : m
            },
            success: function (data) {
                refreshNews();
            }
        });

        return false;
    });

    $("#clubname").submit(function (e) {

        if ($(this).validate({
            rules: {
                name: {
                    required: true
                },
            }
        }).form()) {

        var serData = $('#clubname').serialize() + "&uID=" + userID;
        e.preventDefault();
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/createclub.php',
            crossDomain: true,
            type: 'post',
            data: serData,
            success: function (data) {
               $.mobile.changePage($('#page-tasklist'));
               refreshClubs(0);
            },
        });

        } else {
            return false;
        }
    return false;
    });


    $("#postform").submit(function (e) {

        if ($(this).validate({
            rules: {
                textareapost: {
                    required: true
                },
            }
        }).form()) {

        var serData = $('#postform').serialize() + "&uID=" + userID + "&clubID=" + curClub;
        e.preventDefault();
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/newthread.php',
            crossDomain: true,
            type: 'post',
            data: serData,
            success: function (data) {
                $.mobile.changePage($('#defaultclub'));
               getClubInfo(curClub, 2);
            },
        });

        } else {
            return false;
        }
    return false;
    });

    $("#contactform").submit(function (e) {

        $('#appendaftercontact').empty();
        if ($(this).validate({
            rules: {
                message: {
                    required: true
                },
            }
        }).form()) {

            e.preventDefault();
            $.ajax({
                url: 'http://clubbedinapp.com/web/php/contactus.php',
                crossDomain: true,
                type: 'post',
                data: {
                    'userID': userID,
                    'message': $('#message').val()
                },
                success: function (data) {
                    $('#appendaftercontact').append("<b>Thanks! You will receive a response within 24-48 hours.</b>");
                }
            });

        } else {
            return false;
        }
        return false;
    });

    $( document ).on( "pageinit", "#searchevents", function() {

        $( "#searchlist" ).on( "listviewbeforefilter", function ( e, data ) {
        var $ul = $( this ),
        $input = $( data.input ),
        value = $input.val(),
        html = "";
        $ul.html( "" );
        if ( value && value.length > 1 ) {
            $ul.html( "<li><div class='ui-loader'><span class='ui-icon ui-icon-loading'></span></div></li>" );
            $ul.listview( "refresh" );
            $.ajax({
                url: "http://clubbedinapp.com/web/php/search.php",
                type: "post",
                crossDomain: true,
                data: {
                    'q': value,
                    'userID': userID
                },
                success: function(data) {
                    var json = jQuery.parseJSON(data);
                    for (var i = 0; i < json.length; i ++)
                    {
                        html += '<li><a data-option-id=\"' + json[i].optionid + '\">' + json[i].optionname + '</a></li>';
                    }
                    $ul.html( html );
                    $ul.listview( "refresh" );
                    $ul.trigger( "updatelayout");
                }
            });
        }
        });
    });

    $("#getclubid").submit(function (e) {
        var serData = $('#getclubid').serialize() + "&uID=" + userID;
        e.preventDefault();
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/joinclub.php',
            crossDomain: true,
            type: 'post',
            data: serData,
            success: function (data) {
                $('#joincluberror').empty();
                var json = jQuery.parseJSON(data);
                if(json.num == '1') {
                    loadContent();
                    $.mobile.changePage('#page-tasklist');
                    getClubs();
                } else if (json.num == '2') {
                    $('#joincluberror').append('<p class="error">You are already in '+json.clubname+'!</p>');
                } else if (json.num == '3') {
                    $('#joincluberror').append('<p class="error">You have been banned from '+json.clubname+'!</p>');
                } else if (json.num == '4') {
                    $('#joincluberror').append('<p class="error">There is no club with that ID!</p>');
                }

            },
        });

    return false;
    });

    $("#getclubid2").submit(function (e) {
        var serData = $('#getclubid2').serialize() + "&uID=" + userID + "&curClub=" + curClub;
        e.preventDefault();
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/joinclubsearch.php',
            crossDomain: true,
            type: 'post',
            data: serData,
            success: function (data) {
                $('#errorjoining').empty();
                var json = jQuery.parseJSON(data);
               if(json.num == 1) {
                    $.mobile.changePage('#defaultclub');
                    getClubInfo(curClub, 2);
               } else {
                    $('#errorjoining').append("<strong>Incorrect ID. Please retry.</strong>");
               }
            }
        });

        return false;
    });

    $('#changenameinfo').submit( function(e) {

        if ($(this).validate({
            rules: {
                firstname: {
                    required: true
                },
                lastname: {
                    required: true
                }
            }
        }).form()) {

            e.preventDefault();
            $.ajax({
                url: 'http://clubbedinapp.com/web/php/editname.php',
                crossDomain: true,
                type: 'post',
                data: {
                    'editfname': $('#firstname').val(),
                    'editlname': $('#lastname').val(),
                    'userID': userID
                },
                success: function (data) {
                    $.mobile.changePage('#settings');

                },
         	    error: function (data) {
		 						alert("Error: could not connect to server");
				}
            });

        } else {
            return false;
        }
        return false;
    });

    $('#changeemailinfo').submit( function(e) {

        if ($(this).validate({
            rules: {
                email: {
                    required: true,
                    email: true
                }
            }
        }).form()) {
                $('#changemailerror').empty();
                e.preventDefault();
                $.ajax({
                    url: 'http://clubbedinapp.com/web/php/validateemail2.php',
                    crossDomain: true,
                    type: 'post',
                    data: {
                        'email': $('#email').val(),
                        'userID': userID
                    },
                    success: function (data) {
                        if(data=="1"){
                             $.ajax({
                                        url: 'http://clubbedinapp.com/web/php/editemail.php',
                                        crossDomain: true,
                                        type: 'post',
                                        data: {
                                            'email': $('#email').val(),
                                            'userID': userID
                                        },
                                        success: function (data) {
                                            $.mobile.changePage('#settings');
                                        }
                             });
                        } else if (data=="2") {
                            $('#changemailerror').append('<p class="error">This Is Your Email!</p>')
                        } else if (data=="3") {
                            $('#changemailerror').append('<p class="error">Email Taken!</p>')
                        }
                    },
        	        error: function (data) {
								alert("Error: could not connect to server");
					}
                });
        } else {
            return false;
        }
        return false;
    });

    $(document).on('pageinit', '#page-tasklist', function () {
        $('#clubcontent').listview();
    });

    $("#page-tasklist").on('pagebeforeshow',function() {
        getClubs();
    })

    function refreshClubs(num) {
            $.ajax({
                async: false,
                url: 'http://clubbedinapp.com/web/php/getclubs.php',
                crossDomain: true,
                type: 'post',
                data: {
                   'uID': userID
                },
                success: function (data) {
                   window.localStorage.setItem("clubs",data);
                },
                error: function () {
                   alert("Error: could not connect to server");
                }
            });
        if(num == 0)
            getClubs();
    }

    function refreshUpcoming(num) {
            $.ajax({
                async: false,
                url: 'http://clubbedinapp.com/web/php/getupcoming.php',
                crossDomain: true,
                type: 'post',
                data: {
                    'uID': userID
                },
                success: function (data) {
                   window.localStorage.setItem("upcoming",data);
                },
                error: function (data) {
                    alert("Error: could not connect to server");
                }
            });
        if(num == 0)
            getUpcomingEvents();
    }

    $('#editmembers').on('pageshow', function() {
        getEditMembers();
    })

    function getEditMembers() {
        $('#editmemberstitle').empty();
        $('#editmemberslist').empty();
    $.ajax({
        url: 'http://clubbedinapp.com/web/php/getclubname.php',
        crossDomain: true,
        type: 'post',
        data: {
            'clubID': curClub
        },
        success: function (data) {

            var json = jQuery.parseJSON(data);
            $('#editmemberstitle').append(json.name);
        }
    });
    $.ajax({
        url: 'http://clubbedinapp.com/web/php/getmembers.php',
        crossDomain: true,
        type: 'post',
        data: {
        'clubID': curClub
        },
        success: function (data) {
            var json = jQuery.parseJSON(data);
            for (var i = 0; i < json.length; i++)
            {
                $('#editmemberslist').append('<li><a><h3 class="ui-li-heading">' + json[i].name + '</h3></a><a id=\"' + json[i].id + '\" data-club="club" class="deleteMe5"></a></li>');
            }
                $('#editmemberslist').listview('refresh');
            }
        });
    };

    $('.deleteMe5').live('click', function(){

    var removeID = $(this).attr('id');
    var removeFrom = $(this).parent();
    var type = 0;
    var delAtt = 0;

    if(userID == removeID)
    {
    $('<div>').simpledialog2({
                            mode: 'button',
                            headerText: 'Error',
                            headerClose: true,
                            buttonPrompt: 'You cannot remove yourself! If you wish to leave the club, go to settings, and click Leave Club.',
                            buttons: {
                                'OK': {
                                    click: function () {
                                    }
                                }
                            }
                        });

    } else {

    $('<div>').simpledialog2({
        mode: 'button',
        headerText: 'Remove',
        headerClose: true,
        buttonPrompt: 'Are you sure you want to remove this member?',
        buttons: {
            'Yes': {
                click: function () {
                    $('<div>').simpledialog2({
                        mode: 'button',
                        headerText: '',
                        headerClose: true,
                        buttonPrompt: 'Delete all attendance records of this member?',
                        buttons: {
                            'Yes': {
                                click: function () {
                    $.ajax({
                        url: 'http://clubbedinapp.com/web/php/removemember.php',
                        crossDomain: true,
                        type: 'post',
                        data: {
                            'id': removeID,
                            'clubID':curClub,
                            'type': 1,
                            'delAtt': 1
                        },
                        success: function(data) {
                        }
                    });
                    removeFrom.remove();
                                }
                            },
                            'No': {
                                click: function () {
                    $.ajax({
                        url: 'http://clubbedinapp.com/web/php/removemember.php',
                        crossDomain: true,
                        type: 'post',
                        data: {
                            'id': removeID,
                            'clubID':curClub,
                            'type': 1,
                            'delAtt': 0
                        },
                        success: function(data) {
                        }
                    });
                    removeFrom.remove();
                                }
                            }
                        }
                    });
                }
            },
            'Ban Permanently': {
                click: function() {
                    $('<div>').simpledialog2({
                        mode: 'button',
                        headerText: '',
                        headerClose: true,
                        buttonPrompt: 'Delete all attendance records of this member?',
                        buttons: {
                            'Yes': {
                                click: function () {
                    $.ajax({
                        url: 'http://clubbedinapp.com/web/php/removemember.php',
                        crossDomain: true,
                        type: 'post',
                        data: {
                            'id': removeID,
                            'clubID':curClub,
                            'type': 2,
                            'delAtt': 1
                        },
                        success: function(data) {
                        }
                    });
                    removeFrom.remove();
                                }
                            },
                            'No': {
                                click: function () {
                    $.ajax({
                        url: 'http://clubbedinapp.com/web/php/removemember.php',
                        crossDomain: true,
                        type: 'post',
                        data: {
                            'id': removeID,
                            'clubID':curClub,
                            'type': 2,
                            'delAtt': 0
                        },
                        success: function(data) {
                        }
                    });
                    removeFrom.remove();
                                }
                            }
                        }
                    });
                }
            },
            'No': {
                click: function () {
                }
            }
        }
    });

    }
    });

    $(document).on('pageinit', '#addanevent', function () {
        $('#clubcontent2').listview();
        getEventClubs();
    });

    $(document).on('pageinit', '#newsfeed', function () {
        $('#newsfeedcontent').listview();
    });

    jQuery('#newsfeed').on('pagebeforeshow', function() {
        getNewsFeed();
    });

    function refreshNewsfeed(num) {
            $.ajax({
                async: false,
                url: 'http://clubbedinapp.com/web/php/newsfeed.php',
                crossDomain: true,
                type: 'post',
                data: {
                   'userID': userID
                },
                success: function(data) {
                   window.localStorage.setItem("newsfeed",data);
                },
                error: function () {
                   alert("Error: could not connect to server");
                }
            });
        if(num==0)
            getNewsFeed();
    }

    function getEventClubs() {
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/getclubs.php',
            crossDomain: true,
            type: 'post',
            data: {
                'uID': userID
            },
            success: function (data) {
                $('#clubcontent2').empty();
                var json = jQuery.parseJSON(data);
                for (var i = 0; i < json.length; i++)
                {
                    var clubID = json[i].id;
                    var clubName = json[i].name;

                    $.ajax({
                        url: 'http://clubbedinapp.com/web/php/getleaders.php',
                        crossDomain: true,
                        type: 'post',
                        data: {
                            'clubID': clubID
                        },
                        success: function (data2) {
                            var json2 = jQuery.parseJSON(data2);
                            for (var x = 0; x< json2.length; x++)
                            {
                                if(userID == json2[x].id)
                                    $('#clubcontent2').append('<li><a href="#" data-clubevent-id=\"' + clubID + '\" rel="external">' + clubName + '</a></li>').trigger('create');
                            }
                        $('#clubcontent2').listview('refresh');
                        }
                    });
                }
            }
        });
    };

    function refreshAdmins() {
        getLeaders(true);
    };

    function refreshNews() {
        getAnnouncements('#annlist2');
    };

    function refreshLeave() {
        getLeaveClubs();
    };

    function getLeaveClubs() {
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/getclubs.php',
            crossDomain: true,
            type: 'post',
            data: {
                'uID': userID
            },
            success: function (data) {
                $('#leavelist').empty();
                var json = jQuery.parseJSON(data);
                for (var i = 0; i < json.length; i++)
                    $('#leavelist').append('<li><a><h3 class="ui-li-heading">' + json[i].name + '</h3></a><a id=\"' + json[i].id + '\" data-club="club" class="deleteMe2"></a></li>');
                $('#leavelist').listview('refresh');
            }
        });


    };

    function getClubs() {
        var json = jQuery.parseJSON(window.localStorage.getItem("clubs"));

        var clubcontent = $('#clubcontent');
        
        clubcontent.empty();

        for (var i = 0; i < json.length; i++){
            clubcontent.append('<li class="listview"><a href="#" style="color:#000" data-club-id=\"' + json[i].id + '\" rel="external">' + json[i].name + '</a></li>');
        }
        if(json.length == 0){
               clubcontent.append('<li>No clubs. Join or create one!</li>')
        }
        
        clubcontent.listview("refresh");

    };

    function getNewsFeed() {
        
        var json = jQuery.parseJSON(window.localStorage.getItem("newsfeed"));
        var newsfeedcontent = $('#newsfeedcontent');
        
        newsfeedcontent.empty();
        
        for (var i = 0; i < json.length; i++){
               newsfeedcontent.append('<li class="listview"><h3 class="ui-li-heading">' + json[i].title + '</h3><p class="ui-li-aside ui-li-desc">'+json[i].club+'</p><p class="ui-li-desc">'+json[i].info+'</p></li>');
        }
        if(json.length == 0){
            newsfeedcontent.append('<li>No News! Check back later.</li>')
        }
        
        newsfeedcontent.listview('refresh');
        
    }

    function getUpcomingEvents() {
        
        var json = jQuery.parseJSON(window.localStorage.getItem("upcoming"));
        var upcominglist = $('#upcominglist');
        
        upcominglist.empty();
        
        for(var i=0; i<json.length; i++){
            upcominglist.append('<li class="listview"><a href="#" class="ui-link-inherit" data-event-id=\"' + json[i].id + '\" rel="external"><p class="ui-li-aside ui-li-desc">'+json[i].clubName+'</p><h3 class="ui-li-heading">' + json[i].name + '</h3><p class="ui-li-desc"><strong>'+json[i].date+' '+json[i].time+'</strong></p></a></li>');
        }
        if(json.length == 0){
            upcominglist.append('<li>No Upcoming Events!</li>');
        }
        
        upcominglist.listview('refresh');
		
    }

    $(document).on('click', '#clubcontent li a', function () {
        getClubInfo($(this).data('club-id'), 1);
        curClub=$(this).data('club-id');
    });

    $(document).on('pageinit', '#attendance', function () {
        $('#alist').listview();
    });

    $(document).ready( function () {
        $(document).on('click', '.attendanceclass', function () {
            $.ajax({
                url: 'http://clubbedinapp.com/web/php/isanadmin.php',
                crossDomain: true,
                type: 'post',
                data: {
                    'userID': userID
                },
                success: function (data) {
                    $('#alist').empty();
                    var json = jQuery.parseJSON(data);
                    $('#alist').append('<li><a id="myattendancelink" href="#myattendance">My Attendance</a></li>');
                    if(json.message == 'true')
                    {
                        $('#alist').append('<li><a href="#takeattendance" id="takeattendancelink">Take Attendance</a></li>');
                        $('#alist').append('<li><a id="viewattendancelink" href="#viewattendance">View Attendance</a></li>');
                        $('#alist').append('<li><a href="#exportattendance" id="exportattendancelink">Export Attendance</a></li>');
                    }
                    $('#alist').listview('refresh');

                }
            });
        });
    });

    $('#takeattendance').on('pageshow', function () {
        $('#takeattendancelist').empty();
        $.mobile.changePage('#takeattendance');
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/geteventsifattendance.php',
            crossDomain: true,
            type: 'post',
            data: {
                'userID': userID
            },
            success: function (data) {
                $('#takeattendancelist').empty();
                var json = jQuery.parseJSON(data);
                for (var i = 0; i < json.length; i++)
                {
                    $('#takeattendancelist').append('<li><a id=\"' + json[i].eventID + '\"><h3 class="ui-li-heading">' + json[i].eventName + '</h3><p class="ui-li-aside ui-li-desc"><strong>'+json[i].clubName+'</strong></p><p class="ui-li-desc"><strong>'+json[i].date+'</strong></p></a></li>').trigger('create');
                    $('#takeattendancelist').listview('refresh');
                }
                if (json.length == 0)
                {
                    $('#takeattendancelist').append('<li><h4>No Events</h4></li>');
                    $('#takeattendancelist').listview('refresh');
                }
            }
        });
    });

        $(document).on('pageinit', '#defaultevent', function () {
           $('#whosgoinglist').listview();
        });

    $(document).on('click', '#editattendanceback', function () {
        $.mobile.changePage('#defaultevent');
        getEventData(curEvent, 5);
    });

    $(document).on('pageinit', '#editattendance', function() {
        $('input: checkbox').checkboxradio();
    });

    $(document).ready(function () {
    $('#editattendance').on('pageshow', function () {
		var eac = $('#editattendancecontent')
        eac.empty();
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/iseventdone.php',
            crossDomain: true,
            type: 'post',
            data: {
                'eventID': curEvent
            },
            success: function (data) {;
                var done = data;
                if(done == 'yes')
                {
                    eac.append('<p>Who Attended?</p><form id="editattendanceform"><div data-role="fieldcontain"><fieldset data-role="controlgroup" id="editattendancelist"></fieldset></div><input type="submit" value="Save Attendance" data-inline="true" /></form>');
                    $.ajax({
                        url: 'http://clubbedinapp.com/web/php/getattendancemembers.php',
                        crossDomain: true,
                        type: 'post',
                        data: {
                            'eventID': curEvent
                        },
                        success: function (data) {
                            var json = jQuery.parseJSON(data);
                            for (var i = 0; i < json.length; i++)
                            {
                                $('#editattendancelist').append('<input type="checkbox" id=\"' + json[i].userID + '\" class="custom" /><label for=\"' + json[i].userID + '\">'+json[i].name+'</label>');
                                if(json[i].going == 1)
                                {
                                    $("#"+json[i].userID).attr("checked",true).trigger("create");
                                }
                            }
                            $('input: checkbox').checkboxradio("refresh");
                            eac.trigger('create');
                        }
                    });
                } else {
                    eac.append('<h4>This function will be available when the event starts.</h4>');
                }
            }
        });
    });

    $(document).on('submit', '#editattendanceform', function (e) {

        e.preventDefault();

        var attendanceData = [];

        $('#editattendanceform input[type=checkbox]').each(function() {
            if ($(this).attr('checked')) {
                attendanceData.push({
                    "eventID" : curEvent,
                    "userID"  : $(this).attr('id'),
                    "status"       : 'checked'
                });
            }
            else {
                attendanceData.push({
                    "eventID" : curEvent,
                    "userID"  : $(this).attr('id'),
                    "status"       : 'unchecked'
                });
            }
        });
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/takeattendance.php',
            crossDomain: true,
            type: 'post',
            data: {'attendance': attendanceData},
            success: function(data) {
                $('<div>').simpledialog2({
                    mode: 'button',
                    headerText: '',
                    headerClose: true,
                    buttonPrompt: 'Attendance was submitted successfully.',
                    buttons: {
                        'OK': {
                            click: function () {
                                $.mobile.changePage('#page-tasklist');
                                getClubs();
                            }
                    }
                }
                });
            }
        });
        return false;
    });

    return false;
    });


    $(document).on('click', '#takeattendancelist li a', function () {
        var eventID = $(this).attr('id');
        curEvent = eventID;
        $.mobile.changePage('#takeattendance2');
        $('#takeattendancelist2').empty();
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/getattendancemembers.php',
            crossDomain: true,
            type: 'post',
            data: {
                'eventID': eventID
            },
            success: function (data) {
                var json = jQuery.parseJSON(data);
                for (var i = 0; i < json.length; i++)
                {
                    $('#takeattendancelist2').append('<input type="checkbox" id=\"' + json[i].userID + '\" class="custom" /><label for=\"' + json[i].userID + '\">'+json[i].name+'</label>').trigger('create');
                    if(json[i].going == 1)
                    {
                        $("#"+json[i].userID).attr("checked",true).checkboxradio("refresh");
                    }
                }
                $('input: checkbox').checkboxradio("refresh");
            }
        });

    });

    $('#takeattendanceform').submit( function(e) {
        
        e.preventDefault();

        var attendanceData = [];

        $('#takeattendanceform input[type=checkbox]').each(function() {
            if ($(this).attr('checked')) {
                attendanceData.push({
                    "eventID" : curEvent,
                    "userID"  : $(this).attr('id'),
                    "status"       : 'checked'
                });
            }
            else {
                attendanceData.push({
                    "eventID" : curEvent,
                    "userID"  : $(this).attr('id'),
                    "status"       : 'unchecked'
                });
            }
        });
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/takeattendance.php',
            crossDomain: true,
            type: 'post',
            data: {'attendance': attendanceData},
            success: function(data) {
                $('<div>').simpledialog2({
                    mode: 'button',
                    headerText: '',
                    headerClose: true,
                    buttonPrompt: 'Attendance was submitted successfully.',
                    buttons: {
                        'OK': {
                            click: function () {
                                $.mobile.changePage('#page-tasklist');
                                getClubs();
                            }
                        }
                    }
                });
            }
        });
        return false;
    });

    $('#viewattendance').on('pageshow', function() {

        $('#viewattendancelist').empty();

        $.ajax({
            url: 'http://clubbedinapp.com/web/php/getleaderclubs.php',
            crossDomain: true,
            type: 'post',
            data: {
                'userID': userID
            },
            success: function (data) {
                var json = jQuery.parseJSON(data);
                for (var i = 0; i < json.length; i++)
                {
                    $('#viewattendancelist').append('<li><a id=\"' + json[i].clubID + '\">'+json[i].clubName+'</a></li>').trigger('create');
                    $('#viewattendancelist').listview('refresh');
                }
            }
        });
    });

        $('#exportattendance').on('pageshow', function() {

	        $('#exportattendancelist').empty();

	        $.ajax({
	            url: 'http://clubbedinapp.com/web/php/getleaderclubs.php',
	            crossDomain: true,
	            type: 'post',
	            data: {
	                'userID': userID
	            },
	            success: function (data) {
	                var json = jQuery.parseJSON(data);
	                for (var i = 0; i < json.length; i++)
	                {
	                    $('#exportattendancelist').append('<li><a id=\"' + json[i].clubID + '\">'+json[i].clubName+'</a></li>').trigger('create');
	                    $('#exportattendancelist').listview('refresh');
	                }
	            }
	        });
    });

    $('#myattendance').on('pageshow', function () {

        $('#myattendancelist').empty();
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/getmyattendance.php',
            crossDomain: true,
            type: 'post',
            data: {
                'userID': userID
            },
            success: function (data) {
                var json = jQuery.parseJSON(data);
                for (var i = 0; i < json.length; i++)
                {
                    $('#myattendancelist').append('<li data-icon="check"><a><h3 class="ui-li-heading">' + json[i].eventName + '</h3><p class="ui-li-aside ui-li-desc"><strong>'+json[i].clubName+'</strong></p><p class="ui-li-desc"><strong>'+json[i].date+': '+json[i].venue+'</strong></p></a></li>').trigger('create');
                }
                if(json.length == 0) {
                    $('#myattendancelist').append('<li><b>You have not attended any events.</b></li>');
                }
                $('#myattendancelist').listview('refresh');
            }
        });
    });

    $(document).on('click', '#adminsid', function () {
        $.mobile.changePage($('#admins'));
    });

    $(document).on('click', '#upcominglist li a', function () {
        getEventData($(this).data('event-id'), 1);
        addSwitch($(this).data('event-id'));
    });

    $(document).on('click', '#viewattendancelist li a', function () {
        $.mobile.changePage('#viewattendance2');
        $('#viewattendancelist2').empty();
        $('#attendancename').empty();
        var clubID = $(this).attr('id');
        $('#backtoviewattendance').data('id', clubID);
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/getclubname.php',
            crossDomain: true,
            type: 'post',
            data: {
                'clubID': clubID
            },
            success: function (data) {
                var json = jQuery.parseJSON(data);
                $('#attendancename').append(json.name);
            }
        });
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/getmembers.php',
            crossDomain: true,
            type: 'post',
            data: {
                'clubID': clubID
            },
            success: function (data) {
                var json = jQuery.parseJSON(data);
                for (var i = 0; i < json.length; i++)
                {
                $('#viewattendancelist2').append('<li><a id=\"' + json[i].id + '\">'+json[i].name+'</a></li>').trigger('create');
                }
                $('#viewattendancelist2').listview('refresh');
            }
        });

    });

    $(document).on('click', '#exportattendancelist li a', function () {

	        var clubID = $(this).attr('id');
	        exportAttendance(clubID);

    });

    $(document).on('click', '#viewattendancelist2 li a', function () {
        $.mobile.changePage('#viewattendance3');
        $('#attendancename2').empty();
        $('#viewattendancelist3').empty();
        var userID = $(this).attr('id');
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/getusername.php',
            crossDomain: true,
            type: 'post',
            data: {
                'userID': userID
            },
            success: function (data) {
                var json = jQuery.parseJSON(data);
                $('#attendancename2').append(json.name);
            }
        });
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/getmyattendance.php',
            crossDomain: true,
            type: 'post',
            data: {
                'userID': userID
            },
            success: function (data) {
                var json = jQuery.parseJSON(data);
                for (var i = 0; i < json.length; i++)
                {
                    $('#viewattendancelist3').append('<li data-icon="check"><a><h3 class="ui-li-heading">' + json[i].eventName + '</h3><p class="ui-li-aside ui-li-desc"><strong>'+json[i].clubName+'</strong></p><p class="ui-li-desc"><strong>'+json[i].date+': '+json[i].venue+'</strong></p></a></li>').trigger('create');
                    $('#viewattendancelist3').listview('refresh');
                }
                if(json.length == 0)
                {
                    $('#viewattendancelist3').append('<li><h4>This member has not attended any events.</h4></li>');
                    $('#viewattendancelist3').listview('refresh');
                }
            }
        });

    });

    $(document).on('click', '#contactlink', function () {
        var num = 1;
        $('#boldemail').empty();
        $('#appendaftercontact').empty();
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/getemail.php',
            crossDomain: true,
            type: 'post',
            data: {
                'userID': userID
            },
            success: function (data) {
                var json = jQuery.parseJSON(data);
                $('#boldemail').append(json.email);
            }
        });

    });

    $(document).on('click', '#changeemaillink', function () {
        var finalemail = "";
        var num = 1;

        $.ajax({
            url: 'http://clubbedinapp.com/web/php/getemail.php',
            crossDomain: true,
            type: 'post',
            data: {
                'userID': userID
            },
            success: function (data) {
                var json = jQuery.parseJSON(data);
                finalemail = json.email;
                $('#email').val(finalemail);
            }
        });

    });

    $(document).on('click', '#leaveclub', function () {

    });

    $(document).on('click', '#eventlist li a', function () {
        getEventData($(this).data('event-id'), 3);
        addSwitch($(this).data('event-id'));
    });

    $(document).on('click', '#searchlist li a', function () {
        var id = $(this).data('option-id');
        afterSearch(id);
    });

    $(document).on('click', '#alleventslist li a', function () {
        getEventData($(this).data('event-id'), 2);
        addSwitch($(this).data('event-id'));
    });

    $(document).on('click', '#clubcontent2 li a', function() {
       curClub = $(this).data('clubevent-id');
       $.mobile.changePage($('#newevent1'));
    });

    function afterSearch(searchid) {

        if(searchid.toString().length > 7 ){
            $.mobile.changePage('#defaultevent');
            getEventData(searchid, 4);
        }
        else {
            $.ajax({
                url: 'http://clubbedinapp.com/web/php/isinclub.php',
                crossDomain: true,
                type: 'post',
                data: {
                    'clubID': searchid,
                    'userID': userID
                },
                success: function (data) {
                    if(data == "yes"){
                        $.mobile.changePage('#defaultclub');
                        getClubInfo(searchid, 2);
                    }
                    else {
                        $.ajax({
                            url: 'http://clubbedinapp.com/web/php/getclubdata.php',
                            crossDomain: true,
                            type: 'post',
                            data: {
                                'theid': searchid
                            },
                            success: function (data2) {
                                curClub = searchid;
								var asc = $('#aftersearchcontent')
                                $('#aftersearchheader, #aftersearchcontent, #memlistaftersearch').empty();
                                var json = jQuery.parseJSON(data2);
                                $.mobile.changePage($('#aftersearch'));
                                getAfterLogo();
                                $('#aftersearchheader').append(json.clubName);
                                asc.append('<strong>School: </strong>' + json.schoolName + '<br/><br/>');
                                asc.append('<strong>Description: </strong>' + json.description + '<br/><br/>');
                            }
                        });
                    }
                }
            });
        }
    };

    function getAfterLogo() {
        $('#aftersearchimage').empty();
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/getlogo.php',
            crossDomain: true,
            type: 'post',
            data: {
            'clubID': curClub
            },
            success: function (data) {
                var json = jQuery.parseJSON(data);
                if(json == null) {
                    $('#aftersearchimage').append('<img class="holder" src="images/unknown.jpg" align="left">');
                } else {
                    $('#aftersearchimage').append('<img class="holder" src=\"' + json.logo + '\" align="left">');
                }
        }
        });
    }

    function addSwitch(eventID) {

        $.ajax({
            url: 'http://clubbedinapp.com/web/php/going.php',
            crossDomain: true,
            type: 'post',
            data: {
                'eventID': eventID,
                'userID': userID
            },
            success: function (data) {
                if(data == "going")
                {
                    var fts = $('#goingswitch');
                    fts.val('going');
                    fts.slider('refresh');
                } else {
                    var fts = $('#goingswitch');
                    fts.val('notgoing');
                    fts.slider('refresh');
                };
            }
        });
    };
    var leaders = new Array();

    function getLeaders(bool) {
        leaders.length=0;
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/getleaders.php',
            crossDomain: true,
            type: 'post',
            data: {
                'clubID': curClub
            },
            success: function (data) {
                var json = jQuery.parseJSON(data);
                for (var i =0; i< json.length; i++)
                {
                    leaders.push(json[i].id);
                }
                if(!bool)
                {
                    var done=false;
                    for (var i = 0; i < leaders.length ; i++)
                    {
                        if (leaders[i] == userID && !done) {
                            var htmlStrings = [
                                '<a class="hdrbtn" href="#edit" data-rel="dialog" data-role="button" data-inline="true" data-iconpos="notext" data-icon="gear" data-theme="f">Edit</a>',
                                '<a class="hdrbtn" href="#add" data-rel="dialog" data-role="button" data-iconpos="notext" data-inline="true" data-icon="plus" data-theme="f">New Event</a>'
                            ];
                            $('#addbuttons').append(htmlStrings.join(''));
                            $('#defaultclub').trigger('pagecreate');
                            done=true;
                        }
                    }
                } else if (bool) {
                    var leaderID;
                    $('#adminslist').empty();
                    var x =0;
                    for (var i = 0; i < leaders.length; i++)
                    {
                        $.ajax({
                            url: 'http://clubbedinapp.com/web/php/getname.php',
                            crossDomain: true,
                            type: 'post',
                            data: {
                                'id': leaders[i]
                            },
                            success: function(data3) {
                                var json3 = jQuery.parseJSON(data3);
                                $('#adminslist').append('<li><a>'+json3.name+'</a><a id=\"' + leaders[x++] + '\" class="deleteMe"></a></li>');
                                $('#adminslist').listview('refresh');
                            }
                        });
                    }
                    $.ajax({
                        url: 'http://clubbedinapp.com/web/php/getclubname.php',
                        crossDomain: true,
                        type: 'post',
                        data: {
                            'clubID': curClub
                        },
                        success: function(data2) {
                            $('#adminshdr').empty();
                            var json2 = jQuery.parseJSON(data2);
                            $('#adminshdr').append(json2.name);
                        }
                    });
                }
            },
        });
        getPossibleAdmins();

    };

    $(document).on('pageinit', '#admins', function () {
        $('#adminslist').listview();
    });

    $('#admins').on('pageshow', function () {
       getLeaders(true);
    });


    $('.deleteMe').live('click', function(){

        if(leaders.length>1)
        {
            $(this).parent().remove();
            var removeID = $(this).attr('id');

            $.ajax({
                url: 'http://clubbedinapp.com/web/php/removeadmin.php',
                crossDomain: true,
                type: 'post',
                data: {
                    'id': removeID,
                    'clubID':curClub
                },
                success: function(data) {
                }
            });
        } else
        {
            $('<div>').simpledialog2({
                mode: 'button',
                headerText: 'Stop!',
                headerClose: true,
                buttonPrompt: 'You cannot remove the last admin!',
                buttons: {
                    'OK': {
                    click: function () {
                    }
                },
                }
            })
        }

        var index = leaders.indexOf($(this).attr('id'));
        leaders.splice(index, 1);


    $('#adminslist').listview('refresh');
    refreshAdmins();
    });


    $('.deleteMe2').live('click', function(){

        var parent = $(this).parent();
        var removeID = $(this).attr('id');

        if($(this).data('club') == 'club') {
            $('<div>').simpledialog2({
                mode: 'button',
                headerText: 'Leave Club',
                headerClose: true,
                buttonPrompt: 'Are you sure you want to leave this club?',
                buttons: {
                    'Yes': {
                        click: function () {

                            parent.remove();

                            $.ajax({
                                url: 'http://clubbedinapp.com/web/php/leaveclub.php',
                                crossDomain: true,
                                type: 'post',
                                data: {
                                    'clubID': removeID,
                                    'userID': userID
                                }
                            });
                            $('#leavelist').listview('refresh');
                            refreshClubs(1);
                        }
                    },
                    'No': {
                        click: function () {
                        }
                    }
                }
            })
        }
        else {
            parent.remove();

            $.ajax({
                url: 'http://clubbedinapp.com/web/php/removeannouncements.php',
                crossDomain: true,
                type: 'post',
                data: {
                    'id': removeID,
                    'clubID':curClub
                },
                success: function(data) {

                }
            });
            $('#annlist2').listview('refresh');
        }
    });

    function getPossibleAdmins() {

        $.ajax({
            url: 'http://clubbedinapp.com/web/php/getmembers.php',
            crossDomain: true,
            type: 'post',
            data: {
                'clubID': curClub
            },
            success: function (data) {
                var json = jQuery.parseJSON(data);
                $('#admindiv').empty();
                $('#admindiv').append('<select name="selectadmin" id="selectadmin"><option value="none">Select</option>');
                for (var i=0; i< json.length; i++) {
                    if(json[i].id != userID)
                        $('#selectadmin').append('<option value=\"' + json[i].id + '\" class="adminoption">'+json[i].name+'</option>');
               }
                $('#admindiv').append('</select>');
                $('#admindiv select').selectmenu();
             }
        });
    };

    $('#adminbutton').click(function() {
        addID = $('#selectadmin').val();

        if(addID != "none"){
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/addadmin.php',
            crossDomain: true,
            type: 'post',
            data: {
                'clubID': curClub,
                'adminID': addID
            },
            success: function (data) {

                if(data.length == 0)
                {
                $('<div>').simpledialog2({
                    mode: 'button',
                    headerText: '',
                    headerClose: true,
                    buttonPrompt: json.message,
                    buttons: {
                    'OK': {
                    click: function () {

                    }
                    },
                    }
                })
                }
                refreshAdmins();
            }
        });
        };
    });

    function getClubData(id, num) {
        curClub = id;
        console.log("Club: "+id);
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/getclubdata.php',
            crossDomain: true,
            type: 'post',
            data: {
                'theid': id
            },
            success: function (data2) {
                window.localStorage.setItem(id,data2);
                $('#hdr, #defcont, #addbuttons, #annlist, #eventlist, #memberlist, #threads').empty();
                $('#annlist, #eventlist, #memberlist').trigger('collapse');
                var json = jQuery.parseJSON(data2);
                $.mobile.changePage($('#defaultclub'));
                getLeaders();
                if(num == 2)
                {
                    document.getElementById("clubbutton").href="#searchevents";
                    document.getElementById("clubbutton").onclick="";
                }
                $('#hdr').append(json.clubName);
                $('#defcont').append('<strong>Club ID: </strong>' + json.clubID + '<br/><br/>');
                $('#defcont').append('<strong>School: </strong>' + json.schoolName + '<br/><br/>');
                $('#defcont').append('<strong>Description: </strong>' + json.description + '<br/><br/>');
                getEvents(false);
                getAnnouncements('#annlist');
                getMembers();
		        getLogo();
                getThreads();
            },
        });
    };

function getClubInfo(id, num) {
    curClub = id;
    var json = jQuery.parseJSON(window.localStorage.getItem('club'+id));
    $.mobile.changePage($('#defaultclub'));
    $('#hdr, #defcont, #addbuttons, #annlist, #eventlist, #memberlist, #threads').empty();
    $('#annlist, #eventlist, #memberlist').trigger('collapse');
    getLeaders();
    if(num == 2)
    {
        document.getElementById("clubbutton").href="#searchevents";
        document.getElementById("clubbutton").onclick="";
    }
    $('#hdr').append(json.clubName);
    $('#defcont').append('<strong>Club ID: </strong>' + json.clubID + '<br/><br/>');
    $('#defcont').append('<strong>School: </strong>' + json.schoolName + '<br/><br/>');
    $('#defcont').append('<strong>Description: </strong>' + json.description + '<br/><br/>');
    getEvents(false);
    getAnnouncements('#annlist');
    getMembers();
    getLogo();
    //getThreads();
    
}

/*function getThreads() {

    $.ajax({
           url: 'http://clubbedinapp.com/web/php/getthreads.php',
           crossDomain: true,
           type: 'post',
           data: {
                'clubID': curClub
           },
           success: function(data) {
                var json = jQuery.parseJSON(data);
                if(json.length == 0)
                {
                    $('#threads').append('<li>No conversations :(</li>');
                }
                else {
                    if(json.length<5)
                    {
                        for(var i=0; i<json.length;i++){
                            $('#threads').append('<li data-topic-id=\"' + json[i].topicID +'>'+json[i].topic+'</li>');
                        }
                    } else {
                        for(var i=0; i<4;i++){
                            $('#threads').append('<li data-topic-id=\"' + json[i].topicID +'>'+json[i].topic+'</li>');
                        }
                    }
                }
                $('#threads').listview('refresh');
           }
    });
}*/

    function getLogo() {
        $('#clubimage').empty();
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/getlogo.php',
            crossDomain: true,
            type: 'post',
            data: {
                'clubID': curClub
            },
            success: function (data) {
                var json = jQuery.parseJSON(data);
                if(json == null) {
//                    $('#clubimage').append('<img class="holder" src="images/unknown.jpg" align="left">');
                      $('#clubimage').css('background-image','url(../images/unknown.jpg) !important;');
                } else {
                     $('#clubimage').append('<img class="clubimg" src=\"' + json.logo + '\" align="center">');
//                     $('#clubimage').css('background-image','url('+json.logo+');');
                    
                }
            }
        });
    }


    function getEventData(id, num) {
        console.log("Event: "+id);
        $.ajax({
            async: false,
            url: 'http://clubbedinapp.com/web/php/geteventdata.php',
            crossDomain: true,
            type: 'post',
            data: {
                'id': id
            },
            success: function (data) {
				var econt = $('#econt')
                $('#econt, #ehdr, #etoggle').empty();
                var json = jQuery.parseJSON(data);
                
                $.mobile.changePage($('#defaultevent'));
                if(num == 1){
                    $('#ehdr').append('<a href="#upcoming" data-role="button" data-inline="true" data-icon="arrow-l" data-theme="f">Back</a>');
                } else if (num == 2) {
                    $('#ehdr').append('<a href="#moreevents" data-role="button" data-inline="true" data-icon="arrow-l" data-theme="f">Back</a>');
                } else if (num == 3) {
                    $('#ehdr').append('<a href="#defaultclub" data-role="button" data-inline="true" data-icon="arrow-l" data-theme="f">Back</a>');
                } else if (num == 4) {
                    $('#ehdr').append('<a href="#searchevents" data-role="button" data-inline="true" data-icon="arrow-l" data-theme="f">Back</a>');
                }  else if (num == 5) {
                    $('#ehdr').append('<a href="#page-tasklist" data-role="button" data-inline="true" data-icon="arrow-l" data-theme="f">Back</a>');
                }
                econt.empty();
                $('#ehdr').append('<h1 class="ui-title" role="heading" id="myTitle2">'+json.clubName+'</h1>');
                $('#eventtitle').empty();
                $('#eventtitle').append('<h3>'+json.eventName+'</h3>');
                $('#etoggle').append('<span id="mySelect2" style="margin-bottom:10px;"><select name="switch" id="goingswitch" data-theme="f" data-role="slider" data-mini="true"><option value="notgoing"></option><option value="going">Going</option></select></span><br><br>');
                $('#defaultevent').trigger('pagecreate');
                $('#ehdr').append('<div class="ui-btn-right" id="addbuttons2" data-theme="f" data-role="controlgroup" data-type="horizontal"></div>');
                econt.append('<p align="left" style="margin-bottom:0;"><strong>Hosted by: </strong><i style="float:right;">' + json.clubName + '</i></p><hr>');
                econt.append('<p align="left" style="margin-bottom:0;"><strong>Description: </strong><i style="float:right;">' + json.description + '</i></p><hr>');
                econt.append('<p align="left" style="margin-bottom:0;"><strong>Date: </strong><i style="float:right;">' + json.date + '</i></p><hr>');
                econt.append('<p align="left" style="margin-bottom:0;"><strong>Time: </strong><i style="float:right;">' + json.startTime + " - " + json.endTime + '</i></p><hr>');
                econt.append('<p align="left" style="margin-bottom:0;"><strong>Venue: </strong><i style="float:right;">' + json.venue +'</i></p><br>');
                curEvent = id;
            }
        });
        addSwitch(id);
        addWhosGoing(id);

        $.ajax({
            async: false,
            url: 'http://clubbedinapp.com/web/php/getleadersevent.php',
            crossDomain: true,
            type: 'post',
            data: {
                'eventID': id
            },
            success: function(data) {
                var json = jQuery.parseJSON(data);
                for (var i = 0; i< json.length; i++)
                {
                    if(json[i].id == userID)
                    {
                        var htmlStrings = [
                           '<a class="hdrbtn" href="#edite" data-role="button" data-rel="dialog" data-inline="true" data-iconpos="notext" data-icon="gear" data-theme="f">Edit</a>'
                        ];
                        $('#addbuttons2').append(htmlStrings.join(''));
                        $('#defaultevent').trigger('pagecreate');
                    }
                }
            }
        });

    };

    function addWhosGoing(eventID) {
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/whosgoing.php',
            crossDomain: true,
            type: 'post',
            data: {
                'eventID': eventID
            },
            success: function (data) {
                $('#whosgoinglist').empty();
                var json = jQuery.parseJSON(data);
                for (var i = 0; i < json.length; i++)
                {
                    $('#whosgoinglist').append('<li><h1>'+json[i].name+'</h1></li>');
                }
                if(json.length == 0) {
                $('#whosgoinglist').append('<li>None</li>');
                }
                $('#whosgoinglist').listview('refresh');
            }
        });
    };

    $(document).on('click', '#editeventid', function () {
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/geteventdata.php',
            crossDomain: true,
            type: 'post',
            data: {
                'id': curEvent
            },
            success: function (data2) {

                var json = jQuery.parseJSON(data2);
                $('#editename').val(json.eventName);
                $('#editedesc').val(json.description);
                $('#editeloc').val(json.venue);
                $('#editeswitch').val(json.privacy).slider('refresh');

            }
        });
    });

    $('#editeventinfo').submit( function (e) {
        if ($(this).validate({
            rules: {
                editename: {
                    required: true
                },
                editedesc: {
                    required: true
                },
                editedate: {
                    required: true
                },
                editevenue: {
                    required: true
                },
                editestarttime: {
                    required: true
                },
                editeendtime: {
                    required: true
                }
            }
        }).form()) {

            e.preventDefault();
            $.ajax({
                url: 'http://clubbedinapp.com/web/php/editevent.php',
                crossDomain: true,
                type: 'post',
                data: {
                    'editename': $('#editename').val(),
                    'editedesc': $('#editedesc').val(),
                    'editedate': $('#editedate').val(),
                    'editeloc': $('#editeloc').val(),
                    'editestarttime': $('#editestarttime').val(),
                    'editeendtime': $('#editeendtime').val(),
                    'editeswitch': $('#editeswitch').val(),
                    'eventID': curEvent
                },
                success: function (data) {
                    $.mobile.changePage('#defaultevent');
                    getEventData(curEvent, 1);
                }
            });

        } else {
            return false;
        }

        return false;
    });

    $(document).on('pageinit', '#defaultclub', function() {

        $('#eventlist').listview();
        var tempBool = false;
        getEvents(tempBool);
        getAnnouncements('#annlist');

        $('#memlist').listview();
        getMembers(tempBool);
        $('#threads').listview();

    });

    $(document).on('pageinit', '#upcoming', function() {
        $('#upcominglist').listview();
    });


    jQuery('#upcoming').on('pagebeforeshow', function() {
        getUpcomingEvents();
    });
                  

    $(document).on('pageinit', '#leaveclub', function() {
        $('#leavelist').listview();
    });

    $(document).on('pageinit', '#editclubinfo', function() {
       editClubInfo();

    });

    $(document).on('pageinit', '#editann', function() {
        getAnnouncements('#annlist2');
    });

    function getMembers(all) {
            $.ajax({
            url: 'http://clubbedinapp.com/web/php/getmembers.php',
            crossDomain: true,
            type: 'post',
            data: {
                'clubID': curClub
            },
            success: function (data) {
				var memlist = $('#memlist')
                memlist.empty();
                var json = jQuery.parseJSON(data);
                if(json.length <  10)
                {
                    for (var i = 0; i < json.length; i++)
                    {
                        memlist.append('<li>'+json[i].name+'</li>');
                    }
                    memlist.listview('refresh');
                }
                else if(json.length >9 && !all)
                {
                    for (var i = 0; i < 9; i++)
                    {
                        memlist.append('<li>'+json[i].name+'</li>');
                    }
                    memlist.append('<li><a href="#allmembers" onclick="getMembers(true)">All</a></li>');
                    memlist.listview('refresh');
                }
                else if (all)
                {
					var memlist2 = $('#memlist2')
                    memlist2.listview();
                    memlist2.empty();
                    var json = jQuery.parseJSON(data);

                    for (var i = 0; i < json.length; i++)
                    {
                        memlist2.append('<li>'+json[i].name+'</li>');
                    }
                    memlist2.listview('refresh');
                }
            }
        });
    };

function getMembersAfterSearch(all) {

            $.ajax({
            url: 'http://clubbedinapp.com/web/php/getmembers.php',
            crossDomain: true,
            type: 'post',
            data: {
                'clubID': curClub
            },
            success: function (data) {
				var memlist = $('#memlistaftersearch')
                memlist.empty();
                var json = jQuery.parseJSON(data);
                if(json.length <  10)
                {

                    for (var i = 0; i < json.length; i++)
                    {
                        memlist.append('<li>'+json[i].name+'</li>');
                    }
                    memlist.listview('refresh');
                }
                else if(json.length >9 && !all)
                {
                    for (var i = 0; i < 9; i++)
                    {
                        memlist.append('<li>'+json[i].name+'</li>');
                    }
                    memlist.append('<li><a href="#allmembers" onclick="getMembersAfterSearch(true)">All</a></li>');
                    memlist.listview('refresh');
                }
                else if (all)
                {
					var memlist2 = $('#memlist2aftersearch')
                    memlist2.listview();
                    memlist2.empty();
                    var json = jQuery.parseJSON(data);

                    for (var i = 0; i < json.length; i++)
                    {
                        memlist2.append('<li>'+json[i].name+'</li>');
                    }
                    memlist2.listview('refresh');
                } else if (json.length == 0) {
                    memlist.append('<li>None</li>');
                }
            }
        });
    };


    function editClubInfo() {

        $.ajax({
            url: 'http://clubbedinapp.com/web/php/getclubdata.php',
            crossDomain: true,
            type: 'post',
            data: {
                'theid': curClub
            },
            success: function (data2) {

                var json = jQuery.parseJSON(data2);
                $('#editname').val(json.clubName);
                $('#editsname').val(json.schoolName);
                $('#editdesc').val(json.description);
            },
        });

    };

    $("#editclubname").submit(function (e) {

        if ($(this).validate({
            rules: {
                editname: {
                    required: true
                }
            }
        }).form()) {

            var serData = $('#editclubname').serialize() + "&clubID=" + curClub;
            e.preventDefault();
            $.ajax({
                url: 'http://clubbedinapp.com/web/php/editclubinfo.php',
                crossDomain: true,
                type: 'post',
                data: serData,
                success: function (data) {
                    $.mobile.changePage('#defaultclub');
                    getClubData(curClub, 1);
                }
            });

    } else {
    return false;
    }

    return false;
    });

    $('#aftersearch').on('pageshow', function() {
        getMembersAfterSearch(false);
    })

    $('#alleventsswitch').change( function() {

        var val = this.value;
        if(val=="off")
            getEvents(true);
        else
            getPastEvents();

    });

    $('#etoggle').on('change', '#goingswitch', function() {

        var val = this.value;

        $('#goingswitch').data('theme', 'e');
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/addgoing.php',
            crossDomain: true,
            type: 'post',
            data: {
                "eventID" : curEvent,
                "userID" : userID,
                "going" : val
            },
            success: function (data) {
                addWhosGoing(curEvent);

            }
        });
    });

    function getPastEvents() {

        $.ajax({
            url: 'http://clubbedinapp.com/web/php/getpastevents.php',
            crossDomain: true,
            type: 'post',
            data: {
                'clubID': curClub
            },
            success: function (data) {
				var alleventslist = $('#alleventslist')
                alleventslist.empty();
                var json = jQuery.parseJSON(data);
                for (var i = 0; i < json.length; i++)
                {
                    alleventslist.append('<li><a href="#" class="ui-link-inherit" data-event-id=\"' + json[i].id + '\" rel="external"><h3 class="ui-li-heading">' + json[i].name + '</h3><p class="ui-li-aside ui-li-desc"><strong>'+json[i].date+' '+json[i].time+'</strong></p></a></li>');
                }
                if(json.length == 0) {
                    alleventslist.append('<li>No Past Events</li>');
                }
                alleventslist.listview('refresh');
            }
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
                venue: {
                    required: true
                },
                starttime: {
                    required: true
                },
                endtime: {
                    required: true
                }
            }
        }).form()) {
            var privacy = $('#switch').slider().val();
            var serData = $('#newevent1info').serialize() + "&clubID=" + curClub + "&privacy=" + privacy + "&curID"+ userID;
            $.ajax({
                url: 'http://clubbedinapp.com/web/php/newevent.php',
                crossDomain: true,
                type: 'post',
                data: serData,
                success: function (data) {
                    $('<div>').simpledialog2({
                        mode: 'button',
                        headerText: 'Success!',
                        headerClose: true,
                        buttonPrompt: 'Event has been created...',
                        buttons: {
                            'OK': {
                                click: function () {
                                    refreshUpcoming(1);
                                    getClubInfo(curClub, 1);
                                }
                            },
                        }
                    })
                }
            });
        } else {
            return false;
        }
        return false;
    });

    function getEvents(all) {
    $.ajax({
        url: 'http://clubbedinapp.com/web/php/getevents.php',
        crossDomain: true,
        type: 'post',
        data: {
            'clubID': curClub
        },
        success: function (data) {
			var eventlist = $('#eventlist')
            eventlist.empty();
            var json = jQuery.parseJSON(data);
            if(json.length>3 && all==false)
            {
                for (var i = 0; i < 4; i++)
                {
                    eventlist.append('<li><a href="#" class="ui-link-inherit" data-event-id=\"' + json[i].id + '\" rel="external"><h3 class="ui-li-heading">' + json[i].name + '</h3><p class="ui-li-aside ui-li-desc"><strong>'+json[i].date+' '+json[i].time+'</strong></p></a></li>');
                }

                eventlist.listview('refresh');
                $('#ev2').empty();
                $('#ev2').append('<button onclick="triggerAllEventsTrue()">More Events</button>').trigger('create');
            }
            else if(all==true)
            {
				var alleventslist = $('#alleventslist')
				var alleventsswitch = $('#alleventsswitch')
                alleventslist.listview();
                alleventslist.empty();
                alleventsswitch.val('off');
                alleventsswitch.slider('refresh');
                for (var i = 0; i < json.length; i++)
                {
                    alleventslist.append('<li><a href="#" class="ui-link-inherit" data-event-id=\"' + json[i].id + '\" rel="external"><h3 class="ui-li-heading">' + json[i].name + '</h3><p class="ui-li-aside ui-li-desc"><strong>'+json[i].date+' '+json[i].time+'</strong></p></a></li>');
                }
                if (json.length == 0) {
                    alleventslist.append('<li><h4>No Events! Click the slider to include past events.</h4></li>');
                }
                alleventslist.listview('refresh');
                $.ajax({
                    url: 'http://clubbedinapp.com/web/php/getclubname.php',
                    crossDomain: true,
                    type: 'post',
                    data: {
                        'clubID': curClub
                    },
                    success: function(data) {
                        $('#alleventshdr').empty();
                        var json2 = jQuery.parseJSON(data);
                        $('#alleventshdr').append(json2.name);
                        $('#backtoclub .ui-btn-text').text('Back');
                    }
                });
            }
            else
            {
                for (var i = 0; i < json.length; i++)
                {
                    $('#eventlist').append('<li><a href="#" class="ui-link-inherit" data-event-id=\"' + json[i].id + '\" rel="external"><h3 class="ui-li-heading">' + json[i].name + '</h3><p class="ui-li-aside ui-li-desc"><strong>'+json[i].date+' '+json[i].time+'</strong></p></a></li>');
                }

                $('#eventlist').listview('refresh');
                $('#ev2').empty();
                $('#ev2').append('<button onclick="triggerAllEventsTrue()" id="settotrue">More Events</button>').trigger('create');
            }
        },
    });

    };

    function triggerAllEventsTrue() {
        var tempBool = true;
        $.mobile.changePage('#moreevents');
        getEvents(tempBool);
    }

    function getAnnouncements(appendURI) {
		var auri = $(appendURI)
        $.ajax({
            url: 'http://clubbedinapp.com/web/php/getannouncements.php',
            crossDomain: true,
            type: 'post',
            data: {
                'clubID': curClub
            },
            success: function (data) {
               var json = jQuery.parseJSON(data);
               auri.listview();
               auri.empty();
               if(appendURI == '#annlist')
               {
                    for (var i =0; i < json.length; i++)
                        auri.append('<li><h3 class="ui-li-heading">' + json[i].title + '</h3><p class="ui-li-desc">'+json[i].info+'</p></li>');
                    auri.listview('refresh');
               }
               else {
                   for (var i=0; i<json.length; i++)
                    auri.append('<li><a><h3 class="ui-li-heading">' + json[i].title + '</h3><p class="ui-li-desc">'+json[i].info+'</p></a><a id=\"' + json[i].num + '\" class="deleteMe2"></a></li>');
                  auri.listview('refresh');
               }
            },
        });

    }

    $('.deploy-toggle-1').click(function(){
        $(this).parent().find('.toggle-content').toggle(100);
        $(this).toggleClass('toggle-1-active');
        return false;
    });

    var options2 = {
    'maxCharacterSize': 140,
    'originalStyle': 'originalDisplayInfo',
    'warningStyle': 'warningDisplayInfo',
    'warningNumber': 40,
    'displayFormat': '#left'
    };
    $('#textareapost').textareaCount(options2);
