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
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"/>-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        <?php echo "var userID = '{$_SESSION['userid']}';"; ?>
        var users = <?php require("usersjson.php"); ?>
        var curPos = 0;
        var testImgs = [
        {imgurl:'https://placekitten.com/300/300'},
        {imgurl:'https://i.pravatar.cc/300'},
        {imgurl:'https://placedog.net/300'}
        ];
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
<div id="profileModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeUserProfile()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Display the user profile here</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeUserProfile()">Close</button>
            </div>
        </div>
    </div>
</div>
<div style="background-color: #edebeb">
    <div class="row">
        <div class="col-md-4" >
            <div class="card">
                <div class="card-body" style="display: inline-flex">
                    <img src='https://placekitten.com/100/100'/>
                    <h1>Profile</h1>
                </div>
            </div>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link btn-primary active" href="#matches" onclick="showSearch()">Matches</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-primary" href="#messages" onclick="showChat()">Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-primary" href="#search">Search</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="matches" role="tabpanel" aria-labelledby="home-tab">
                    <div class="grid-container scroll scrollbar" id="mymatches">
                        <!-- Matches will be generated here via JS -->
                    </div>
                </div>
                <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="profile-tab">
                    <ul class="list-group ">
                        <div class="scroll scrollbar" id="style-5"/>
                        <?php

                        for($i = 0; $i < 10;$i++) {
                            echo "\n<li class='list-group-item matches-msg'><img src='https://placekitten.com/100/100'/><p>Your last message goes here</p></li>";
                        }
                        echo "\n";
                        ?>
                        </div>
                    </ul>
                </div>
                <div class="tab-pane" id="search" role="tabpanel" aria-labelledby="messages-tab" style="margin: 3%">
                    <!-- add search bar -->
                    <input id="searchFilter" type="text" class="form-control" placeholder="Search...." onkeyup="getAllProfiles()"/>
                    <div class="grid-container scroll scrollbar" id="searchResults">
                        <!-- Matches will be generated here via JS -->
                    </div>
                </div>
            </div>
        </div>

    <div class="col-8">
        <div id="chatarea"  class="chatarea" hidden>
            <div class="card" >
                <div class="card-body" style="display: inline-flex" >
                    <img src='https://placekitten.com/50/50'/>
                    <h3>You match Name on 01/01/2020</h3>
                </div>
            </div>
        <h1>Messages Example</h1>
        <p>We need to make this a fixed height and have search bar at the bottom</p>
        <!-- Chat content goes here -->

            <div class="bubble">
                Blue text bubble
            </div>

            <div class="bubble bubble--alt">
                Green text bubble
            </div>

            <div class="bubble">
                A bubble containing lots and lots and lots and lots of content on multiple lines
            </div>

            <div class="bubble bubble--alt">
                Bubble with image
                <img src="http://placekitten.com/300/300" alt="" />
            </div>

            <div class="bubble">
                Bubblewitharidiculouslylongwordwhichwrapseffortlesslyontotwolines
            </div>

            <!-- Chat content goes here -->
            <input class="form-control" type="text" placeholder="Type a message...."/>
        </div>

        <?php require("matchcontent.php"); ?>
    </div>

    </div>
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

