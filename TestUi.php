<?php
session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>iDate</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="vendorv/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/chat.css">
    <link rel="stylesheet" type="text/css" href="css/scroll.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/chatv2.css">
    <link rel="stylesheet" href="css/matches.css">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/profileCard.css">
    <!--    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"/>-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <script>



        /*
        {"messages":[{"username":"Jenny Ruiz","message":"Hello","timestamp":"2020-03-27 14:19:29"}]}
               <li class="sent">
                   <img src="http://emilcarlsson.se/assets/mikeross.png" alt="" />
                   <p>How the hell am I supposed to get a jury to believe you when I am not even sure that I do?!</p>
               </li>
        */
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


        function toggleClass(elem) {

            $('.messages ul').empty();

            if(!elem.classList.contains('active')){
                let act = $('ul#contactsList').find('li.active');
                if(act !== undefined){
                    act.removeClass('active');
                    $(elem).toggleClass('active');
                }
            }

            $('#contact_name').text($('ul#contactsList').find('li.active').attr("data-username"));

            getMessage()

        };

        function getMessage(){

            $('#placeholder').css({"display": 'none'});
            $('.contact-profile').css({"display": 'block'});
            $('.messages').css({"display": 'block'});
            $('.message-input').css({"display": 'block'});


            const request = {};
            request.messages = $('ul#contactsList').find('li.active').attr("data-id");
            request.userId = 'Bartekm1999';
            $.ajax({
                method: "GET",
                url: "Mongo.php",
                data: request,
                success: function (response) {
                    console.log('success ' + response + " length ");
                    let res = JSON.parse(response);



                        let length = 0;
                        if($('.messages ul').attr('data-length') !== undefined){
                            $('.messages ul').attr('data-length', $('.messages ul li').length);
                            length =  $('.messages ul').attr('data-length');
                        }else{
                            length = $('.messages ul li').length;
                        }

                        console.log(length);
                        for (let i = length; i < res["messages"].length; i++) {
                            $(  '<li>' +
                                '<div class="' + (res['messages'][i]['username'] === 'Bartekm1999' ? "outgoing_msg" : "incoming_msg") + '">' +
                                '<div class="' + (res['messages'][i]['username'] === 'Bartekm1999' ? "outgoing_msg_img" : "incoming_msg_img") + '"> <img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /></div>' +
                                '<div class="' + (res['messages'][i]['username'] === 'Bartekm1999' ? "sent_msg" : "received_msg") + '">' +
                                '<p>' + res['messages'][i]["message"] + '</p>' +
                                '<span class="time_date">' + res['messages'][i]["timestamp"] + '</span>' +
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

            showChat();
            $('#contactsList').empty();

            const request = {};
            request.userId = 'Bartekm1999';
            $.ajax({
                method: "GET",
                url: "Mongo.php",
                data: request,
                success: function (response) {

                    let res = JSON.parse(response);
                    console.log('success ' + response + " length " + res["contacts"].length);

                    for (let i = 0; i < res["contacts"].length; i++) {

                        console.log(res['contacts'][i]["username"]);

                        $('<li class="contact" onclick="toggleClass(this)" data-id='+res['contacts'][i]["id"]+' data-username='+res['contacts'][i]["username"]+'>'
                            + '<div class="wrap">'
                            + '<img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="">'
                            + '<div class="meta">'
                            + '<p class="name">' +res['contacts'][i]["username"]+'</p>'
                            + '<p class="preview">'+res['contacts'][i]["message"]+'</p>'
                            + '</div></div></li>').appendTo($('#contactsList'))

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
                    if (Math.ceil(file.size / 1000) > 38) {
                        Swal.showValidationMessage(
                            `Picture cannot be bigger than 38KB`
                        );
                    }
                }
            });


            if (file) {

                const reader = new FileReader();
                const request = {};


                reader.onload = (e) => {
                    Swal.fire({
                        title: 'Your Selected Picture',
                        imageUrl: e.target.result,
                        imageAlt: 'The Selected Picture'
                    });

                    console.log(e.target.result);
                    request.userId = '170';
                    request.photoUrl = e.target.result;

                    $.ajax({
                        method: "POST",
                        url: "Picture.php",
                        data: request,
                        success: function (response) {
                            Swal.fire(response.title, response.message, response.type);
                            console.log('success' + JSON.stringify(response));
                            document.getElementById('profilePicture').src = response.img;
                        },
                        failure: function (response) {
                            console.log('failure:' + JSON.stringify(response));
                        },
                        error: function (response) {
                            console.log('error:' + JSON.stringify(response));
                        }
                    });
                };

                reader.readAsDataURL(file);
            }
        }

        $(".messages").animate({ scrollTop: $(document).height() }, "fast");



        $(".expand-button").click(function() {
            $("#profile").toggleClass("expanded");
            $("#contacts").toggleClass("expanded");
        });



        function newMessage() {
            message = $(".message-input input").val();
            if($.trim(message) == '') {
                return false;
            }

            const request = {};

            request.userOne = 'Bartekm1999';
            request.userTwoId = $('ul#contactsList').find('li.active').attr("data-id");
            request.userTwoName = $('ul#contactsList').find('li.active').attr("data-username");
            request.messages = message;

            $('.messages ul').attr('data-length', ($('.messages ul li').length));

            $.ajax({
                method: "GET",
                url: "Mongo.php",
                data: request,
                success: function (response) {
                    console.log('success' + response);
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
        };


        $(window).on('keydown', function(e) {
            if (e.which == 13) {
                newMessage();
                return false;
            }
        });

    </script>
    <!-- Import the Stitch JS SDK at the top of the file -->
    <script src="https://s3.amazonaws.com/stitch-sdks/js/bundles/4/stitch.js"></script>
    <script>
        // Destructure Stitch JS SDK Components
        const { Stitch, RemoteMongoClient, BSON } = stitch;
        const stitchApp = Stitch.initializeDefaultAppClient("<Your App ID>");
        const mongodb = stitchApp.getServiceClient(RemoteMongoClient.factory, "mongodb-atlas");
        const itemsCollection = mongodb.db("store").collection("items");
        const purchasesCollection = mongodb.db("store").collection("purchases");

        async function watcher() {
            // Create a change stream that watches the collection
            // for when any document's 'status' field is changed
            // to the string 'blocked'.
            const stream = await myCollection.watch({
                "updateDescription.updatedFields": {
                    "status": "blocked",
                }
            });
            // Set up a change event handler function for the stream
            stream.onNext((event) => {
                // Handle the change events for all specified documents here
                console.log(event.fullDocument);
            });

            // Insert a document with status set to 'blocked'
            // to trigger the stream onNext handler
            await myCollection.insertOne({
                "name": "test",
                "status": "blocked",
            });
        }
    </script>


    <style>
        div
    </style>
</head>
<body style="background-color: #999999;">
<div>
  <div class="page-wrapper chiller-theme toggled">
                <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
                    <i class="fas fa-bars"></i>
                </a>
                <nav id="sidebar" class="sidebar-wrapper">
                    <div class="sidebar-content">

                        <div class="sidebar-header">
                            <div class="user-pic">
                               <!-- <img class="img-responsive img-rounded" src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg"
                                     alt="User picture">
                                     -->
                                <div class="img__wrap">
                                    <?php

                                    require __DIR__.'/vendor/autoload.php';
                                    require ("db.php");
                                    $resp = ""; $respAdmin = "";

                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }else{
                                        $id = $conn->real_escape_string('170');
                                        $sql = "SELECT url FROM photo WHERE user_id='{$id}' && name='userProfilePhoto';";
                                        $sqlUserAdmin = "SELECT user_id FROM admin";

                                        $result = $conn->query($sql);
                                        if($result->num_rows > 0) {
                                            $resp = $result->fetch_row()[0];
                                        }

                                        $result->free_result();
                                        $result = $conn->query($sqlUserAdmin);
                                        if($result->num_rows > 0){
                                            $respAdmin = $result->fetch_row()[0];
                                        }
                                        $conn->close();
                                    }

                                    ?>
                                    <img class="img__img" style="width: 130px; height: 130px;" id="profilePicture" src=" <?php if(strlen($resp)){echo $resp;}else{echo 'images/icons/userIcon.png';} ?>" alt="User Profile Picture"/>
                                    <div class="img__description_layer">
                                        <button class="img__description"  onclick="changeProfilePicture()">Change Profile Picture</button>
                                    </div>
                                </div>
                            </div>
                            <div class="user-info mt-lg-4">
                              <span class="user-name">Jhon
                                <strong>Smith</strong>
                              </span>
                              <span class="user-role"><?php if($respAdmin === "Administrator")echo "Administrator"; ?></span>
                              <span class="user-status">
                              <i class="fa fa-circle"></i>
                              <span>Online</span>
                              </span>
                            </div>
                        </div>
                        <!-- sidebar-header  -->
                        <!-- sidebar-search  -->
                        <div class="sidebar-menu">
                            <ul>
                                <li class="header-menu">
                                    <span>General</span>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fas fa-user"></i>
                                        <span>Profile</span>
                                    </a>
                                </li>
                                <li class="sidebar-dropdown">
                                    <a href="#">
                                        <i class="fas fa-users"></i>
                                        <span>Users</span>
                                        <span class="badge badge-pill badge-warning">New</span>
                                    </a>
                                    <div class="sidebar-submenu">
                                        <ul>
                                            <li>
                                                <a href="#" onclick="showSearch()">All users</a>
                                            </li>
                                            <li>
                                                <a href="#">New Users</a>
                                            </li>
                                            <li>
                                                <a href="#">Unverified users</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <a onclick="loadConversations()">
                                        <i class="fas fa-envelope"></i>
                                        <span >Messages</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- sidebar-menu  -->
                    </div>
                    <!-- sidebar-content  -->
                    <div class="sidebar-footer">
                        <a href="#">
                            <i class="fa fa-bell"></i>
                        </a>
                        <a href="#">
                            <i class="fa fa-envelope"></i>
                        </a>
                        <a href="#">
                            <i class="fa fa-power-off"></i>
                        </a>
                    </div>
                </nav>
      <main>
          <div class="matches" id="matcharea">
              <div class="container h-100 mb-5">
                  <div class="d-flex justify-content-center h-100">
                      <div class="searchbar">
                          <input class="search_input" id="searchFilter" type="text" name="" placeholder="Search..." onkeyup="getAllProfiles()">
                      </div>
                  </div>
              </div>
              <div class="grid-container scroll scrollbar" id="searchResults">
                  <!-- Matches will be generated here via JS -->
             </div>
          </div>

          <div id="frame" hidden>
              <div id="sidepanel">
                  <div id="search">
                      <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
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
                      <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
                      <p class="mt-3" id="contact_name"></p>
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
      </main>
  </div>

</div>




        <div id="profileModal" class="modal" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title"><b>Information about this person</b></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeUserProfile()">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <table id="popup_user_info">
                              <tr>
                                  <td><p class='grid-item'><img src='https://placekitten.com/100/100'/></p></td>
                                  <td>
                                      <style type="text/css">
                                          td
                                          {
                                              padding:0 15px 0 15px;
                                          }
                                      </style>
                                      <table >
                                          <tr>
                                              <td></td>
                                              <td>Name:</td>
                                              <td id="person_fullname">Full name</td>
                                          </tr>
                                          <tr>
                                              <td></td>
                                              <td>Age:</td>
                                              <td id="person_age">100</td>
                                          </tr>
                                          <tr>
                                              <td></td>
                                              <td>Gender:</td>
                                              <td id="person_gender">Male</td>
                                          </tr>
                                          <tr>
                                              <td></td>
                                              <td>Location:</td>
                                              <td id="person_location">City</td>
                                          </tr>
                                          <tr>
                                              <td></td>
                                              <td>Smoker:</td>
                                              <td id="person_is_smoker">Yes/No</td>
                                          </tr>
                                          <tr>
                                              <td></td>
                                              <td>Drinker:</td>
                                              <td id="person_is_drinker">Yes/No</td>
                                          </tr>
                                      </table>
                                  </td>
                              </tr>
                          </table>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-outline-info" data-dismiss="modal" onclick="showChat(), closeUserProfile()">Start Chat</button>
                          <button type="button" class="btn btn-outline-success pull-right" data-dismiss="modal" onclick="match()">Match</button>
                          <button type="button" class="btn btn-outline-danger pull-right" data-dismiss="modal" onclick="unlink()">Unlink</button>
                          <span style="width: 100px"></span>
                          <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeUserProfile()">Close</button>
                      </div>
                  </div>
              </div>
          </div>
        <div>





<script src="vendorv/jquery/jquery-3.2.1.min.js"></script>
<script src="vendorv/animsition/js/animsition.min.js"></script>
<script src="vendorv/bootstrap/js/popper.js"></script>
<script src="vendorv/bootstrap/js/bootstrap.js"></script>
<script src="js/main.js"></script>
<script src="js/testui.js"></script>

</body>
</html>

