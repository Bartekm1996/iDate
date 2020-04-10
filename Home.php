<?php session_start()?>
<?php if(!isset($_SESSION['userid'])){ session_unset($_SESSION['userid']); session_destroy(); header("Location: index.php");} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>iDate</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/userManagmentTable.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/chat.css">
    <link rel="stylesheet" type="text/css" href="css/scroll.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/chatv2.css">
    <link rel="stylesheet" href="css/matches.css">
    <link rel="stylesheet" href="css/usermatch.css">
    <link rel="stylesheet" href="css/cardV2.css">
    <link rel="stylesheet" href="css/userProfile.css"/>
    <link rel="stylesheet" type="text/css" href="css/profileCard.css">
    <script src="js/userProfile.js"></script>
    <script src="js/support.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="vendorv/jquery/jquery-3.2.1.min.js"></script>


    <script>

        let interval  =0;

        var userID = '<?php echo $_SESSION['userid']; ?>';

        window.onload = function() {

            console.log("From on load function");

            <?php


               require __DIR__.'/vendor/autoload.php';
               require ("db.php");

                   $username = $_SESSION['username'];
                   $firstname = $_SESSION['firstname'];
                   $userid = $_SESSION['userid'];
                   $resp = ""; $respAdmin = "";

               if ($conn->connect_error) {
                   die("Connection failed: " . $conn->connect_error);
               }else{
                   $id = $conn->real_escape_string($userid);
                  // $sql = "SELECT url FROM photo WHERE user_id='{$id}' && name='userProfilePhoto';";
                   $sqlUserAdmin = "SELECT admin FROM user WHERE id = $id";

                   /*
                   $result = $conn->query($sql);
                   if($result->num_rows > 0) {
                       $resp = $result->fetch_row()[0];
                   }
                   */

                   //$result->free_result();
                   $result = $conn->query($sqlUserAdmin);
                   if($result->num_rows > 0){
                       $respAdmin = $result->fetch_row()[0];
                   }
                   $conn->close();
               }
               ?>


            let admin = parseInt('<?php echo $respAdmin?>');

       
            //console.log("UD " + <?php echo $userid?>);
            $('#username-header').text('<?php echo $firstname?>');
            $('#username-header').attr('user-id', <?php echo $userid ?>);
            $('#username-header').attr('user-name', "<?php echo $username ?>");
            $('#username-header').attr('user_name', "<? $_SESSION['user_name']?>")
            $('#username-header').attr('user_email', "<?php $_SESSION['email'] ?>")

            fillTicketsNumbers();
            fillMembersNumbers();
            loadHistoryTable($('#username-header').attr('user-name'));
            showProfile( $('#username-header').attr('user-name'), null, false);
            loadMyProfile();
            interval = setInterval(function() {
               loadConversations();
            }, 1000);


        };

        //let interval = setInterval(() => getMessage(),2000);

        jQuery(function ($) {

            $(".sidebar-dropdown > a").click(function() {
                $(".sidebar-submenu").slideUp(200);
                if (
                    $(this)
                        .parent()
                        .hasClass("active")
                ) {
                    $(".sidebar-dropdown").removeClass("active");
                    $(this)
                        .parent()
                        .removeClass("active");
                } else {
                    $(".sidebar-dropdown").removeClass("active");
                    $(this)
                        .next(".sidebar-submenu")
                        .slideDown(200);
                    $(this)
                        .parent()
                        .addClass("active");
                }
            });

            $("#close-sidebar").click(function() {
                $(".page-wrapper").removeClass("toggled");
            });
            $("#show-sidebar").click(function() {
                $(".page-wrapper").addClass("toggled");
            });

            $("#search input").on('input', function () {
                let ul = document.getElementById("contactsList");
                let items = ul.getElementsByTagName("li");
                for (let i = 0; i < items.length; ++i) {
                    console.log($('#search input').val());
                    if(!items[i].getAttribute('data-username').toLowerCase().includes($('#search input').val().toLowerCase(), 0)) {
                        items[i].style.display = "none";
                    }else{
                        items[i].style.display = "block";
                    }
                }
            })

        });



        function search() {

        }

        function logout() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "Ready to miss a chance of finding your love ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {

                if (result.value) {
                clearInterval(interval);
                    let request = {};
                    request.logout_api = true;
                    sendDataTest(request, 'api.php');

                    Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        onOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    }).fire({
                        icon: 'success',
                        title: 'Logged out successfully'
                    });

                    //clearInterval(interval);
                window.location.href = "index.php";
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Congratulations',
                        'You Made the right choice :)',
                        'success'
                    )
                }
            })
        }


        function toggleClass(elem) {

            $('.messages ul').empty();

            if (!elem.classList.contains('active')) {
                let act = $('ul#contactsList').find('li.active');
                if (act !== undefined) {
                    act.removeClass('active');
                    $(elem).toggleClass('active');
                }
            }

            $('#contact_name').text($('ul#contactsList').find('li.active').attr("data-username"));

            getMessage()

        };


        function getMessage(){
            clearInterval(interval);
            interval = setInterval(function() {
                getMessage();
                loadConversations();
            }, 2000);

            $('#placeholder').css({"display": 'none'});
            $('.contact-profile').css({"display": 'block'});
            $('.messages').css({"display": 'block'});
            $('.message-input').css({"display": 'block'});

            let id = $('#username-header').attr('user-name');

            console.log("id " + id);
            const request = {};
            request.messages = ($('ul#contactsList').find('li.active').attr("data-id") === undefined ?   0 : $('ul#contactsList').find('li.active').attr("data-id"));
            request.userId = id;


            console.log(request.messages + "  " + request.userId);
            $.ajax({
                method: "GET",
                url: "Mongo.php",
                data: request,
                success: function (response) {
                    console.log('success ' + response + " length ");
                    let res = JSON.parse(response);
                    console.log("Message " + res[0]._conversations[request.messages].messages[0].message);

                        let length = 0;
                        if ($('.messages ul').attr('data-length') !== undefined || $('.messages ul').attr('data-length') > 0) {
                            $('.messages ul').attr('data-length', $('.messages ul li').length);
                            length = $('.messages ul').attr('data-length');
                        } else {
                            length = $('.messages ul li').length;
                        }

                        console.log("Length " + res[0]._conversations[request.messages].messages[0].username + " " + length);

                            for (let i = length; i < res[0]._conversations[request.messages].messages.length; i++) {
                                $('<li>' +
                                    '<div class="' + (res[0]._conversations[request.messages].messages[i].username === id ? "outgoing_msg" : "incoming_msg") + '">' +
                                    '<div class="' + (res[0]._conversations[request.messages].messages[i].username === id ? "outgoing_msg_img" : "incoming_msg_img") + '"> <img src="" alt="" /></div>' +
                                    '<div class="' + (res[0]._conversations[request.messages].messages[i].username === id ? "sent_msg" : "received_msg") + '">' +
                                    '<p>' + res[0]._conversations[request.messages].messages[i].message + '</p>' +
                                    '<span class="time_date">' + res[0]._conversations[request.messages].messages[i].timestamp + '</span>' +
                                    '</div>' +
                                    '</div>' +
                                    '</li>').appendTo($('.messages ul'));
                            }



                },
                failure: function (response) {
                    console.log('failure:' + JSON.stringify(response));
                },
                error: function (response) {
                    console.log('error:' + JSON.stringify(response));
                }
            });
        }



        async function loadConversations(){

            $('#contactsList').empty();

            const request = {};
            request.userId =  $('#username-header').attr('user-name');
            console.log(request.userId);
            $.ajax({
                method: "GET",
                url: "Mongo.php",
                data: request,
                success: function (response) {

                    let res = JSON.parse(response);
                    console.log(res);

                    for (let i = 0; i < res[0]._conversations.length; i++) {


                        $('<li class="contact" onclick="toggleClass(this)" data-id='+i+' data-username='+res[0]._conversations[i].username+'>'
                            + '<div class="wrap">'
                            + '<img src="https://source.unsplash.com/random" alt="">'
                            + '<div class="meta">'
                            + '<p class="name"><strong>' +res[0]._conversations[i].username+'</strong></p>'
                            + '<p class="preview">'+res[0]._conversations[i].messages[res[0]._conversations[i].messages.length-1].message+'</p>'
                            + '</div></div></li>').appendTo($('#contactsList'));

                        console.log("Cse");

                    }
                },
                failure: function (response) {
                    console.log('failure:' + JSON.stringify(response));
                },
                error: function (response) {
                    console.log('error:' + JSON.stringify(response));
                }
            });
        }





        $(".expand-button").click(function() {
            $("#profile").toggleClass("expanded");
            $("#contacts").toggleClass("expanded");
        });

        function loadMatches(){

            const request = {};
            request.get_matches_api = true;
            request.userId = $('#username-header').attr('user-id');

            $.ajax({
                method: "POST",
                url: "api.php",
                data: request,
                success: function (response) {
                    console.log(response);
                    if(response.length > 0) {
                        let res = response.substring(2).slice(0, -1).split(",");
                        nextMatch(res[0]);
                        $('#person_fullname').attr('data-matches', res);
                        $('#person_fullname').attr('data-index', 0);
                        $('#my_matches_place_holder').attr('hidden', true);
                    }else {
                        hideMatching();
                        $('#my_matches_place_holder').text("Sorry No Other Sheep Shagers To Show");
                        $('#my_matches_place_holder').attr('hidden', false);
                    }
                },
                failure: function (response) {
                    console.log('failure:' + JSON.stringify(response));
                },
                error: function (response) {
                    console.log('error:' + JSON.stringify(response));
                }
            });

        }

        function nextMatch(index) {


            const request = {};
            request.get_user_profile_api = true;

            if($('#person_fullname').attr('data-index') !== undefined || index === null){
                let tmp = $('#person_fullname').attr('data-matches').split(',');
                let tmpIndex = parseInt($('#person_fullname').attr('data-index'))+1;
                if(tmpIndex > tmp.length-1){
                    tmpIndex = 0;
                }
                request.userId = tmp[tmpIndex];
                $('#person_fullname').attr('data-index',tmpIndex+1)
            }else{
                request.userId = index;
            }


            $.ajax({
                method: "POST",
                url: "api.php",
                data: request,
                success: function (response) {

                    console.log(response);
                    let res = JSON.parse(response);
                    $('#person_fullname').attr('data-user-name', res.username);
                    $('#person_fullname').attr('data-id',res.id);
                    $('#person_fullname').text(res.name);
                    $('#person_age_outter').text("Age: " + res.age);

                    console.log("Town " + res.town);
                     $('#person_location_outter').text(res.town !== undefined ? res.town : "Location: Hidden");
//
                    $('#user_full_age').html('<strong>Age </strong>' + res.age);
                    $('#user_full_name').html('<strong>Name </strong>' + res.name);
                    $('#user_gender').html('<strong>Gender </strong>' + res.gender);
                    $('#user_card_bio').html('<strong>Bio </strong><br>' + res.desc);
                    $('#user_smoking').html('<strong>Smoking </strong>' + res.smoking);
                    $('#user_drinking').html('<strong>Drinking </strong>' + res.drinking);

                    let defImage = res.photoId;
                    if(defImage == null || defImage.length == 0) {
                        defImage = res.gender == 'Male' ? 'images/male.png' : 'images/female.png';
                    }

                    document.getElementById("person_image").src = defImage;// "https://source.unsplash.com/random";
                    console.log('success' + response);
                },
                failure: function (response) {
                    console.log('failure:' + JSON.stringify(response));
                },
                error: function (response) {
                    console.log('error:' + JSON.stringify(response));
                }
            });
        }

        function showFilter() {
            let filter = $('.filter');
            if(filter.attr('hidden')){
                filter.attr('hidden', false);
            }else filter.attr('hidden', true);
        }

        function showChat() {
            $('#frame').attr('data-opened', false);
            hideMatchArea();
            hideUserManagment();
            hideMatching();
            hideUserProfile();
            hideTickets();
            $('#frame').prop('hidden', false);

        }

        function addActive(elem) {
            if($(elem).hasClass('active')){
                $(elem).removeClass('active');
                $(elem).css({"background":"gray"});
            }else {
                $(elem).addClass('active');
                $(elem).css({"background":"blue"});
            }
        }

        function newMessage() {
            clearInterval(interval);
            let message = $(".message-input input").val();
            if($.trim(message) == '') {
                return false;
            }

            let size = $('.messages ul li').length;

            console.log("Size "+ size);

            const request = {};

            request.userOne = $('#username-header').attr('user-name');
            request.userTwoId = ($('ul#contactsList').find('li.active').attr("data-id") === undefined ?   $('#contact_name').text() : $('ul#contactsList').find('li.active').attr("data-id"));
            request.userTwoName = $('#contact_name').text();
            request.messages = message;
            request.size = size;

            console.log(request.userTwoId);

            $('.messages ul').attr('data-length', ($('.messages ul li').length));

            $.ajax({
                method: "GET",
                url: "Mongo.php",
                data: request,
                success: function (response) {
                    console.log('success' + response);
                    getMessage();
                },
                failure: function (response) {
                    console.log('failure:' + JSON.stringify(response));
                },
                error: function (response) {
                    console.log('error:' + JSON.stringify(response));
                }
            });

            //$('<li class="sent"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));
            $('.message-input input').val(null);
            $(".messages").animate({ scrollTop: $(document).height() }, "fast");


            interval = setInterval(function() {
                loadConversations();
                getMessage();
            }, 2000);
        };


        function changeValue(val){
            $('#current_slider_value').text(val);
        }

        $(window).on('keydown', function(e) {
            if (e.which === 13) {
                newMessage();
                return false;
            }
        });

    </script>


</head>
<body style="background-color: white; width: 100%; height: 100%;" >
        <div class="page-wrapper chiller-theme toggled">
            <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
                <i class="fas fa-bars"></i>
            </a>
            <nav id="sidebar" class="sidebar-wrapper">
                <div class="sidebar-content">

                    <div class="sidebar-header">
                        <div class="user-pic">
                            <div class="img__wrap">
                                <img class="img__img" style="width: 130px; height: 130px;" id="profilePicture" src="images/icons/userIcon.png" alt="User Profile Picture"/>
                                <div class="img__description_layer">
                                    <button class="img__description"  onclick="changeProfilePicture()">Change Profile Picture</button>
                                </div>
                            </div>
                        </div>
                        <div class="user-info mt-lg-4">
                            <span class="user-name" id="username-header"></span>
                            <span class="user-role"><?php echo $respAdmin == 1 ? "Administrator" : "User"?></span>
                            <span class="user-status">
                                  <i class="fa fa-circle"></i>
                                  <span>Online</span>
                            </span>
                        </div>
                    </div>

                    <div class="sidebar-menu">
                        <ul>
                            <li class="header-menu">
                                <span>General</span>
                            </li>
                            <li class="sidebar-dropdown">
                                    <a href="#">
                                        <i class="fas fa-user"></i>
                                        <span>Profile</span>
                                    </a>
                                <div class="sidebar-submenu">
                                    <ul>
                                        <li><a href="#" onclick="showProfile('<?php echo $username?>', null, false)"><i class="fas fa-user"></i><span>Profile</span></a></li>
                                        <li><a href="#" onclick="showUerMatches('<?php echo $id ?>')"><i class="fas fa-heart"></i><span>My Matches</span></a></li>
                                        </ul>
                                    </div>
                            </li>

                            <?php


                            if($respAdmin == 1){
                                echo
                                    '<li class="sidebar-dropdown">'.
                                    '<a href="#">'.
                                    '<i class="fas fa-users"></i>'.
                                    '<span>Users</span>'.
                                    '<span class="badge badge-pill badge-warning">New</span>'.
                                    '</a>'.
                                    '<div class="sidebar-submenu">' .
                                    '<ul>'.
                                    '<li><a href="#" onclick="showUserManagment(null)">All users <span class="label label-success tag-pill" id="all_users"></span></a></li>'.
                                    '<li><a href="#" onclick="showUserManagment(0)">Unverified users <span class="label tag-pill label-success" id="unverified_users"></span></a></li>'.
                                    '<li><a href="#" onclick="showUserManagment(1)">Blocked users <span class="label tag-pill label-success" id="blocked_users"></span></a></li>'.
                                    '</ul>'.
                                    '</div></li>'.
                                    '<li><a onclick="showSearch()"><i class="fas fa-users""></i><span>Find Love</span></a></li>';
                            }else{
                                echo '<li><a onclick="showSearch()"><i class="fas fa-users""></i><span>Find Love</span></a></li>';
                            }
                            ?>
                            <li>
                                <?php

                                    if($respAdmin == 1){
                                        echo
                                            '<li class="sidebar-dropdown">'.
                                            '<a href="#">'.
                                            '<i class="fas fa-envelope"></i>'.
                                            '<span>Tickets</span>'.
                                            '<span class="badge badge-pill badge-warning">New</span>'.
                                            '</a>'.
                                            '<div class="sidebar-submenu">' .
                                            '<ul>'.
                                            '<li><a href="#" onclick="showTickets(\'Opened\')">Opened <span class="label tag-pill" id="opened_tickets"></span></a></li>'.
                                            '<li><a href="#" onclick="showTickets(\'Closed\')">Closed <span class="label tag-pill label-success" id="closed_tickets"></span></a></li>'.
                                            '<li><a href="#" onclick="showTickets(\'Unresolved\')">Unresolved <span class="label tag-pill label-success" id="unresolved_tickets"></span></a></li>'.
                                            '<li><a href="#" onclick="showTickets(\'Archived\')">Archived <span class="label tag-pill label-success" id="archived_tickets"></span></a></li>'.
                                            '</ul>'.
                                            '</div></li>'.
                                            '<li><a onclick="showChat()"><i class="fas fa-envelope"></i><span>Messages</span></a></li>';
                                    }else{
                                        echo '<li><a onclick="showChat()"><i class="fas fa-envelope"></i><span>Messages</span></a></li>';
                                    }
                                ?>        
                            </li>
                        </ul>
                    </div>
                    <!-- sidebar-menu  -->
                </div>
                <!-- sidebar-content  -->
                <div class="sidebar-footer">
                    <?php

                    if($respAdmin == 1) {

                        echo
                         '<a href="#" onclick="showTickets(\'Opened\')">'.
                         '<i class="fa fa-bell"></i>'.
                         '</a>';
                    }

                    ?>

                    <a href="#" onclick="showChat()">
                        <i class="fa fa-envelope"></i>
                    </a>
                    <a href="#" onclick="logout()">
                        <i class="fa fa-power-off"></i>
                    </a>
                </div>
            </nav>
        </div>
        <main style="width: 80%; height: 100%;">
            <?php include ("userProfile.php") ?>
            <?php include ("userManagment.php") ?>
            <?php include ("userTickets.php")?>


            <div class="matches" id="matcharea" hidden>
                <a href="#" class="fab" onclick="showFilter()">
                    <i class="fas fa-filter fab-float"></i>
                </a>
                <div class="container h-100 mb-5">
                    <div class="d-flex justify-content-center h-100">
                        <div class="searchbar">
                            <input class="search_input" id="searchFilter" type="text" name="" placeholder="Search..." data-matches="false" onkeyup="getAllProfiles(null,null,null)">
                        </div>
                    </div>
                </div>
                <h3 id="my_matches_place_holder" style="position: absolute; left: 40%; top: 50%;" hidden>No Matches Yet ?</h3>
                <div class="grid-container" id="searchResults" >
                </div>
            </div>

            <div id="matching" hidden>
                <section class="matching">
                <div class="row active-with-click">
                    <div class="col-xs-12">
                        <article class="material-card Red">
                            <div>
                                <h2><span id="person_fullname"></span><strong><i class="fas fa-birthday-cake"><i id="person_age_outter" class="ml-3"></i></i><i class="fas fa-map-pin ml-3"><i id="person_location_outter" class="ml-3"></i></i></strong></h2>
                            </div>
                            <div class="mc-content">
                                <div class="img-container">
                                    <img  id="person_image" style="width: 100%; height= 100%;" src="https://source.unsplash.com/random">
                                </div>
                                <div class="mc-description">
                                    <div class="modal-body">
                                        <table id="popup_user_info">
                                            <tr><td></td><td id="user_full_name"><b></b></td><td id="person_fullname"></td>
                                            <tr><td><td id="user_full_age"><b> </b> </td><td></td></td></tr>
                                            <tr><td><td id="user_gender"><b> </b> </td></td></tr>
                                            <tr><td><td id="user_card_bio"> </td></td></tr>
                                            <tr><td><td id="user_smoking"> </td></td></tr>
                                            <tr><td><td id="user_drinking"> </td></td></tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <a class="mc-btn-action" id="expandable" onclick="epxand(this)"><i class="fa fa-bars"></i></a>
                            <a class="mc-btn-next" onclick="nextMatch(null)"><i class="fas fa-angle-double-right"></i></a>
                            <a class="mc-btn-previous" onclick="nextMatch(null)"><i class="fas fa-angle-double-left"></i></a>
                            <div class="mc-footer">
                                <button class="btn btn-danger mt-2"><i class="fas fa-user-plus"  onclick="connect($('#person_fullname').attr('data-id'),$('#username-header').attr('user-id'))" ></i></button>
                                <button class="ml-3 btn btn-success mt-2" onclick="showProfile($('#person_fullname').attr('data-user-name'),$('#username-header').attr('user-name'),false)"><i class="fas fa-user-alt"></i></button>
                            </div>
                        </article>
                    </div>
                </div>
                </section>
            </div>


            <section class="filter" hidden>
                <div class="mb-3 mt-3" style="width: 100%;margin-top: 40px;">
                    <label class="text-white">Smoker </label>
                    <select id="smoker_select_picker" class="form-control" >
                        <optgroup label="Select A Smoker">
                            <option value="" disabled selected>Select your option</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                            <option value="ocasionally">Ocasionally</option>
                            <option value="party drinker">Party Smoker</option>
                        </optgroup>
                    </select>
                </div>
                <div style="width: 100%;">
                    <label class="text-white">Drinker </label>
                    <select id="drinker_select_picker" class="form-control">
                        <optgroup label="Select A Drinking">
                            <option value="" disabled selected>Select your option</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                            <option value="ocasionally">Ocasionally</option>
                            <option value="party drinker">Party Drinker</option>
                        </optgroup>
                    </select>
                </div>
                <div style="width: 100%;">
                    <div class="form-group focused">
                        <label class="text-white">City </label>
                        <select id="city_select_picker" class="form-control">
                            <option value="" disabled selected>Select your option</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex mt-4">
                    <span class="text-white font-weight-bold">Select Age : <span class="text-white font-weight-bold blue-text mr-2 mt-1 ml-3">18</span></span>
                    <form class="range-field" style="width: 50%;"><input type="range" class="bg-secondary shadow-sm form-control-range border-0" id="ageSlider" min="18" max="65" onchange="changeValue($(this).val())" /></form>
                    <span class="text-white font-weight-bold blue-text ml-2 mt-1mr-3">65+</span>
                    <span class="text-white font-weight-bold blue-text ml-2 mt-1mr-3" id="current_slider_value">Age</span>
                </div>
                <div style="margin-top: 20px;">
                    <label class="text-left text-white d-none d-lg-flex ml-2 mt-2 mb-2" for="interest_box">Interests</label>
                    <div id="interest_box" class="ml-2 mr-2">
                        <div class="mb-3" style="display: grid;grid-template-columns: auto auto auto auto;grid-gap: 10px;"><span class="badge badge-primary" onclick="addActive(this)">Programming</span><span class="badge badge-primary" onclick="addActive(this)">Football</span><span class="badge badge-primary" onclick="addActive(this)">Travelling</span><span class="badge badge-primary ml-2" onclick="addActive(this)">Horse Riding</span></div>
                        <div class="mb-3" style="display: grid;grid-template-columns: auto auto auto;grid-gap: 10px;"><span class="badge badge-primary" onclick="addActive(this)">Fashion</span><span class="badge badge-primary" onclick="addActive(this)">Jogging</span><span class="badge badge-primary" onclick="addActive(this)">Crossfit</span></div>
                        <div style="display: grid;grid-template-columns: auto auto auto auto;grid-gap: 20px;"><span class="badge badge-primary" onclick="addActive(this)">Swimming</span><span class="badge badge-primary" onclick="addActive(this)">Cinema</span><span class="badge badge-primary ml-2" onclick="addActive(this)">Diving</span></div>
                    </div>
                </div>
                <button class="btn btn-success" style="width: 100%; margin-top: 15px;" onclick="profileFilterButton()">Filter</button>
            </section>

            <div id="frame" hidden >
                <div id="sidepanel">
                    <div id="search">
                        <label ><i class="fa fa-search" aria-hidden="true"></i></label>
                        <input type="text" placeholder="Search contacts..." />
                    </div>
                    <div id="contacts">
                        <ul id="contactsList">
                        </ul>
                        </div>
                    </div>

                    <div class="content">
                        <div id="placeholder">
                            <h3 style="position: absolute; top: 50%; left: 35%;">Select User To Start Chat</h3>
                        </div>
                        <div class="contact-profile" id="contact-profile" style="display: none;">
                            <img src="images/icons/userIcon.png" alt="" />
                            <strong><p class="mt-3" id="contact_name"></p></strong>
                        </div>
                        <div class="messages" id="messages" style="display: none;">
                            <ul id="messages">
                            </ul>
                        </div>
                        <div class="message-input" id="message-input" style="display: none;">
                            <div class="wrap">
                                <input type="text" placeholder="Write your message..." />
                                <button class="submit" onclick="newMessage()"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

            <section id="report_pane" style="width: 550px;padding: 20px;height: 500px;background: lightgray;border-radius: 20px; border: 2px solid rgb(85,31,31);  position: absolute; left: 20%; right: 20%; bottom: 20%; z-index: 100;" hidden>
                <button class="btn btn-primary" onclick="openReportPane()" style="width: 25px;height: 25px;border-radius: 12px;background: red;position: absolute;top: 5px;left: 5px;border: 2px; text-align: center;"></button>
                <div class="col mt-4">
                    <div class="row">
                            <strong class="ml-2 mb-2" style="color: rgb(255,255,255);">User Name Being Reported</strong><input id="user_report_username" type="text" class="ml-2" placeholder="UserName" readonly/>
                            <strong class="ml-2 mt-2 mb-2" style="color: rgb(255,255,255);">Name</strong><input id="user_report_name" type="text" class="ml-2" placeholder="Name" readonly/>
                            <strong class="mt-2 ml-2 mb-2" style="color: rgb(255,255,255);">Email</strong><input id="user_report_email" type="email" class="ml-2" placeholder="Email"/>
                            <strong class="mt-2 ml-2 mb-2" style="color: rgb(255,255,255);">Reason For Report</strong>
                    </div>
                    <div class="row mb-2">
                        <select class="form-control" id="report_select_reason"><optgroup  style="width: 100%;" label="Select A Reason For Report"><option value="Abusive Messages" selected>Abusive Messages</option><option value="Continous Stalking">Continous Stalking</option><option value="Inapropiate Behaviour">Inapropiate Behaviour</option></optgroup></select>
                    </div>
                </div>
                <div><textarea id="reason_text" placeholder="Please Enter Some Additional Details" style="width: 100%;height: 150px;resize: none;"></textarea></div><button class="btn btn-primary pull-right mt-2" type="button" onclick="sendReportMessage(true)">Report</button>
            </section>

        </main>

        <script src="https://www.gstatic.com/firebasejs/7.13.2/firebase-app.js"></script>

        <!-- TODO: Add SDKs for Firebase products that you want to use
             https://firebase.google.com/docs/web/setup#available-libraries -->
        <script src="https://www.gstatic.com/firebasejs/7.13.2/firebase-storage.js"></script>
        <script>
            // Your web app's Firebase configuration
            var firebaseConfig = {
                apiKey: "AIzaSyDYlh0TCY0b6KaHCzkf8HHTaGLwI38-LHc",
                authDomain: "idev-10931.firebaseapp.com",
                databaseURL: "https://idev-10931.firebaseio.com",
                projectId: "idev-10931",
                storageBucket: "idev-10931.appspot.com",
                messagingSenderId: "392385283208",
                appId: "1:392385283208:web:02610f3f1bb6dac8534b3d",
                measurementId: "G-XR4NDN7MYF"
            };
            // Initialize Firebase
            firebase.initializeApp(firebaseConfig);

            const storage = firebase.storage();
            const storageRef = storage.ref();




            async function changeProfilePicture() {
                const {value: file} = await Swal.fire({
                    title: 'Select Profile image',
                    input: 'file',
                    inputAttributes: {
                        'accept': 'image/jpeg',
                        'aria-label': 'Upload your profile picture'
                    },
                    showCancelButton: true,
                    showLoaderOnConfirm: true,
                    preConfirm: (file) => {
                        if (Math.ceil(file.size / 1000) > 256) {
                            Swal.showValidationMessage(
                                `Picture cannot be bigger than 38KB`
                            );
                        }
                    }
                });


                if (file) {

                    const reader = new FileReader();
                    const request = {};

                    console.log(file);

                    reader.onload = (e) => {
                        Swal.fire({
                            title: 'Your Selected Picture',
                            imageUrl: e.target.result,
                            imageAlt: 'The Selected Picture'
                        });

                        var uploadTask = storageRef.child('images/' + file.name).put(file);
                        uploadTask.on('state_changed', function(snapshot){
                        }, function(error) {
                            Swal.fire({
                                title: 'Upload Failed',
                                text: 'Image Upload Failed',
                                icon: 'error'
                            })
                        }, function() {
                            uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
                                request.userId =  $('#username-header').attr('user-id');
                                request.photoUrl = downloadURL;
                                $.ajax({
                                    method: "POST",
                                    url: "Picture.php",
                                    data: request,
                                    success: function (response) {
                                        Swal.fire(response.title, response.message, response.type);
                                        document.getElementById('profilePicture').src = downloadURL;
                                    },
                                    failure: function (response) {
                                        console.log('failure:' + JSON.stringify(response));
                                    },
                                    error: function (response) {
                                        console.log('error:' + JSON.stringify(response));
                                    }
                                });
                            });
                        });
                    };

                    reader.readAsDataURL(file);
                }
            }


        </script>

        <script src="https://kit.fontawesome.com/2530adff57.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script src="vendorv/animsition/js/animsition.min.js"></script>
        <script src="vendorv/bootstrap/js/popper.js"></script>
        <script src="vendorv/bootstrap/js/bootstrap.js"></script>
        <script src="js/userTickets.js"></script>
        <script src="js/userManagment.js"></script>
        <script src="js/main.js"></script>
        <script src="js/testui.js"></script>
</body>
</html>