<?php session_start(); ?>
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
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"/>-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>

        function toggleClass(elem) {

            if(!elem.classList.contains('active')){
                let act = $('ul#contactsList').find('li.active');
                if(act !== undefined){
                    act.removeClass('active');
                    $(elem).toggleClass('active');
                }
            }
        };

        async function loadConversation(){
            $.ajax({
                method: "GET",
                url: "messaging.php",
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

    </script>


    <style>
        div.scroll {
            margin:4px 4px;
            padding:4px;
            width: 100%;
            height: 65vh;
            overflow-x: hidden;
            overflow-x: auto;
        }
    </style>
</head>
<body style="background-color: #999999;">
<div class="limiter">
    <div style="background-color: #edebeb">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mt-lg-2">
                        <div class="card-horizontal" style="padding: 20px">
                            <div class="card-img">
                                <div class="img__wrap">
                                    <?php

                                    require __DIR__.'/vendor/autoload.php';
                                    require ("db.php");
                                    $resp = "";

                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }else{
                                        $id = $conn->real_escape_string('170');
                                        $sql = "SELECT url FROM photo WHERE user_id='{$id}' & name='userProfilePhoto';";
                                        $result = $conn->query($sql);
                                        if($result->num_rows > 0) {
                                            $resp = $result->fetch_row()[0];
                                        }
                                        $conn->close();
                                    }

                                    ?>
                                    <img class="img__img" style="width: 130px; height: 130px;" id="profilePicture" src=" <?php if(strlen($resp)){echo $resp;}else{echo 'images/icons/userIcon.png';} ?>" alt="User Profile Picture"/>
                                    <div class="img__description_layer">
                                        <button class="img__description"  onclick="changeProfilePicture()">Change Profile Picture</button>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-primary" style="margin-top: 10px; margin-left: 5px;">View Profile</a>
                            </div>
                            <div class="card-body">
                            </div>
                        </div>
                    </div>

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-matches-tab" data-toggle="tab" href="#matches" role="tab" aria-controls="nav-matches" aria-selected="true" onclick="showSearch()">Matches</a>
                            <a class="nav-item nav-link" id="nav-messages-tab" data-toggle="tab" href="#messages" role="tab" aria-controls="nav-messages" aria-selected="false" onclick="showChat()">Messages</a>
                            <a class="nav-item nav-link" id="nav-search-tab" data-toggle="tab" href="#search" role="tab" aria-controls="nav-search" aria-selected="false">Search</a>
                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="matches" role="tabpanel" aria-labelledby="nav-matches-tab">
                            <div class="grid-container scroll scrollbar" id="mymatches">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="nav-messages-tab">
                            <div class="grid-container scroll scrollbar" >
                                <div id="contacts">
                                    <ul id="contactsList">
                                        <li class="contact active" onclick="toggleClass(this)">
                                            <div class="wrap">
                                                <img src="http://emilcarlsson.se/assets/louislitt.png" alt="" />
                                                <div class="meta">
                                                    <h4 class="name">Louis Litt</h4>
                                                    <p class="preview">You just got LITT up, Mike.</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="contact" onclick="toggleClass(this)">
                                            <div class="wrap">
                                                <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
                                                <div class="meta">
                                                    <p class="name">Harvey Specter</p>
                                                    <p class="preview">Wrong. You take the gun, or you pull out a bigger one. Or, you call their bluff. Or, you do any one of a hundred and forty six other things.</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="contact" onclick="toggleClass(this)">
                                            <div class="wrap">
                                                <img src="http://emilcarlsson.se/assets/rachelzane.png" alt="" />
                                                <div class="meta">
                                                    <p class="name">Rachel Zane</p>
                                                    <p class="preview">I was thinking that we could have chicken tonight, sounds good?</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="contact" onclick="toggleClass(this)">
                                            <div class="wrap">
                                                <img src="http://emilcarlsson.se/assets/donnapaulsen.png" alt="" />
                                                <div class="meta">
                                                    <p class="name">Donna Paulsen</p>
                                                    <p class="preview">Mike, I know everything! I'm Donna..</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="contact" onclick="toggleClass(this)">
                                            <div class="wrap">
                                                <img src="http://emilcarlsson.se/assets/jessicapearson.png" alt="" />
                                                <div class="meta">
                                                    <p class="name">Jessica Pearson</p>
                                                    <p class="preview">Have you finished the draft on the Hinsenburg deal?</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="contact" onclick="toggleClass(this)">
                                            <div class="wrap">
                                                <img src="http://emilcarlsson.se/assets/haroldgunderson.png" alt="" />
                                                <div class="meta">
                                                    <p class="name">Harold Gunderson</p>
                                                    <p class="preview">Thanks Mike! :)</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="contact" onclick="toggleClass(this)">
                                            <div class="wrap">
                                                <img src="http://emilcarlsson.se/assets/danielhardman.png" alt="" />
                                                <div class="meta">
                                                    <p class="name">Daniel Hardman</p>
                                                    <p class="preview">We'll meet again, Mike. Tell Jessica I said 'Hi'.</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="contact" onclick="toggleClass(this)">
                                            <div class="wrap">
                                                <img src="http://emilcarlsson.se/assets/katrinabennett.png" alt="" />
                                                <div class="meta">
                                                    <p class="name">Katrina Bennett</p>
                                                    <p class="preview">I've sent you the files for the Garrett trial.</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="contact" onclick="toggleClass(this)">
                                            <div class="wrap">
                                                <img src="http://emilcarlsson.se/assets/charlesforstman.png" alt="" />
                                                <div class="meta">
                                                    <p class="name">Charles Forstman</p>
                                                    <p class="preview">Mike, this isn't over.</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="contact" onclick="toggleClass(this)">
                                            <div class="wrap">
                                                <img src="http://emilcarlsson.se/assets/jonathansidwell.png" alt="" />
                                                <div class="meta">
                                                    <p class="name">Jonathan Sidwell</p>
                                                    <p class="preview"><span>You:</span> That's bullshit. This deal is solid.</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="search" role="tabpanel" aria-labelledby="nav-search-tab" >
                            <input id="searchFilter" type="text" class="form-control" placeholder="Search...." onkeyup="getAllProfiles()"/>
                            <div class="grid-container scroll scrollbar" id="searchResults">
                                <!-- Matches will be generated here via JS -->
                            </div>
                        </div>
                    </div>



                </div>

                <?php require("matchcontent.php"); ?>
                <?php require ("messaging.php");?>

            </div>

        </div>



        <!--
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

        -->

    </div>
</div>

<script src="vendorv/jquery/jquery-3.2.1.min.js"></script>
<script src="vendorv/animsition/js/animsition.min.js"></script>
<script src="vendorv/bootstrap/js/popper.js"></script>
<script src="vendorv/bootstrap/js/bootstrap.js"></script>
<script src="js/main.js"></script>
<script src="js/testui.js"></script>

</body>
</html>

