<!DOCTYPE html>
<html lang="en">
<head>
    <title>iDate</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="vendorv/bootstrap/css/bootstrap.min.css">
    <script src="vendorv/bootstrap/js/bootstrap.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">

    <link href="vendorv/sweetalert/sweetalert.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        $(document).ready(function() {
            $(".btn-pref .btn").click(function () {
                $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
                // $(".tab").addClass("active"); // instead of this do the below
                $(this).removeClass("btn-default").addClass("btn-primary");
            });
        });
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!--    <script src="//geodata.solutions/includes/statecity.js"></script>-->
    <script src="//geodata.solutions/includes/countrystatecity.js"></script>

    <style>

        .panel.with-nav-tabs .panel-heading{
            padding: 5px 5px 0 5px;
        }
        .panel.with-nav-tabs .nav-tabs{
            border-bottom: none;
        }
        .panel.with-nav-tabs .nav-justified{
            margin-bottom: -1px;
        }
        /********************************************************************/
        /*** PANEL DEFAULT ***/
        .with-nav-tabs.panel-default .nav-tabs > li > a,
        .with-nav-tabs.panel-default .nav-tabs > li > a:hover,
        .with-nav-tabs.panel-default .nav-tabs > li > a:focus {
            color: #777;
        }
        .with-nav-tabs.panel-default .nav-tabs > .open > a,
        .with-nav-tabs.panel-default .nav-tabs > .open > a:hover,
        .with-nav-tabs.panel-default .nav-tabs > .open > a:focus,
        .with-nav-tabs.panel-default .nav-tabs > li > a:hover,
        .with-nav-tabs.panel-default .nav-tabs > li > a:focus {
            color: #777;
            background-color: #ddd;
            border-color: transparent;
        }
        .with-nav-tabs.panel-default .nav-tabs > li.active > a,
        .with-nav-tabs.panel-default .nav-tabs > li.active > a:hover,
        .with-nav-tabs.panel-default .nav-tabs > li.active > a:focus {
            color: #555;
            background-color: #fff;
            border-color: #ddd;
            border-bottom-color: transparent;
        }
        .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu {
            background-color: #f5f5f5;
            border-color: #ddd;
        }
        .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a {
            color: #777;
        }
        .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
        .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
            background-color: #ddd;
        }
        .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a,
        .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
        .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
            color: #fff;
            background-color: #555;
        }

        .matches td {
            padding: 5px 5px 5px 5px;
        }

        .matches h4 {
            text-align: center;
        }

        .matches img {
            border-radius: 5px 5px;
        }

        .matches-msg img {
            border-radius: 20px 20px;
        }

        .matches-msg {
            display: inline-flex;
            width: 100%;

        }

        .matches-msg p {
            padding-left: 5px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto;
            padding: 5px 5px 5px 5px;
        }

        .grid-item {
            padding: 5px;
            font-size: 10px;
            text-align: center;
        }

        .matchbtn {
            position:absolute;
            top:50%;
        }

        .matchbtn i {
            color: #dddddd;
        }

        .matchbtn i:hover{
            color: #ddd098;
        }
        .grid-item img { border-radius: 5px 5px; }
    </style>

    <script>
        var curPos = 0;
        var testImgs = [
        {imgurl:'https://placekitten.com/300/300'},
        {imgurl:'https://i.pravatar.cc/300'},
        {imgurl:'https://placedog.net/300'}
        ];

        function nextImg() {
            curPos++;
            if(curPos >= testImgs.length) curPos = 0;
            $('#imgP').attr("src",testImgs[curPos].imgurl);
        }

        function prevImg() {
            curPos--;
            if(curPos < 0) curPos = testImgs.length -1;
            $('#imgP').attr("src",testImgs[curPos].imgurl);
        }

    </script>
</head>
<body style="background-color: #999999;">

<div style="background-color: #edebeb">
    <div class="row">
        <div class="col-md-4" >
            <div class="card">
                <div class="card-body" style="display: inline-flex">
                    <img src='https://placekitten.com/150/150'/>
                    <h1>Profile</h1>
                </div>
            </div>

            <div>
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1default" data-toggle="tab">Matches</a></li>
                            <li><a href="#tab2default" data-toggle="tab">Messages</a></li>
                            <li><a href="#tab3default" data-toggle="tab">Search</a></li>
                            <li><a href="#tab4default" data-toggle="tab">Personal information</a></li>
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#tab5default" data-toggle="tab">Default 4</a></li>
                                    <li><a href="#tab6default" data-toggle="tab">Default 5</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab1default">
                                <div class="grid-container">
                                    <?php

                                        for($i = 0; $i < 20;$i++) {
                                            echo"<div class='grid-item'><img src='https://placekitten.com/100/100'/><h4>Name</h4></div>\n";
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab2default">
                                <ul class="list-group">
                                <?php

                                for($i = 0; $i < 10;$i++) {
                                    echo "\n<li class='list-group-item matches-msg'><img src='https://placekitten.com/100/100'/><p>Your last message goes here</p></li>";
                                }
                                echo "\n";
                                ?>
                                </ul>
                            </div>

                            //User profile info
                            <div id="tab4default" class="login100-form validate-form" style="display: none;" >

                                <div class="wrap-input100 validate-input" data-validate="First name is required" >
                                    <span class="label-input100">First Name</span>
                                    <input class="input100" type="text" id="firstname" pattern="^(\w\w+)\s(\w+)$"  placeholder="First name">
                                    <span class="focus-input100"></span>
                                </div>

                                <div class="wrap-input100 validate-input" data-validate="Last name is required" >
                                    <span class="label-input100">Last Name</span>
                                    <input class="input100" type="text" id="lastname" pattern="^(\w\w+)\s(\w+)$"  placeholder="Last name">
                                    <span class="focus-input100"></span>
                                </div>
                                <div id="location" class="wrap-input100 validate-input">
                                    <span class="label-input100">Preference<br><br></span>
                                    <div class="form-inline">
                                        <div class="col-6">
                                            <span class="label-input100">I am </span>
                                            <select name="gender" class="form-control" id="gender">
                                                <option value="0">Male</option>
                                                <option value="1">Female</option>
                                            </select>
                                        </div>


                                        <div class="col-6">
                                            <span class="label-input100">Seeking </span>
                                            <select name="seeking" class="form-control" id="seeking">
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>


                                    </div>

                                </div>

                                <div id="location" class="wrap-input100 validate-input">
                                    <span class="label-input100">Select your location<br><br></span>
                                    <span class="label-input100">Country</span>
                                    <select name="country" class="form-control countries order-alpha " id="countryId">
                                        <option value="">Select Country</option>
                                    </select>
                                </div>
                                <div id="location" class="wrap-input100 validate-input">
                                    <span class="label-input100">State</span>
                                    <select name="state" class="form-control states order-alpha" id="stateId">
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                                <div id="location" class="wrap-input100 validate-input">
                                    <span class="label-input100">City</span>
                                    <select name="city" class="form-control cities order-alpha" id="cityId">
                                        <option value="">Select City</option>
                                    </select>
                                </div>


<!--                                <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">-->
<!--                                    <span class="label-input100">Email</span>-->
<!--                                    <input class="input100" type="email" id="email" placeholder="user@example.com">-->
<!--                                    <span class="focus-input100"></span>-->
<!--                                </div>-->

<!--                                <div class="wrap-input100 validate-input" data-validate="Username is required">-->
<!--                                    <span class="label-input100">Username</span>-->
<!--                                    <input class="input100" type="text" id="username" placeholder="Username...">-->
<!--                                    <span class="focus-input100"></span>-->
<!--                                </div>-->

<!--                                <div class="wrap-input100 " data-validate = "Password is required">-->
<!--                                    <span class="label-input100">Password</span>-->
<!--                                    <input class="input100" name="password" type="password" id="password" required onkeyup="check();" placeholder="*************">-->
<!--                                    <span class="focus-input100"></span>-->
<!--                                </div>-->
<!---->
<!--                                <div class="wrap-input100 " data-validate = "Confirm Password">-->
<!--                                    <span class="label-input100">Confirm Password</span>-->
<!--                                    <input class="input100" name="confirm_password" type="password" id="confirm_password" required  onkeyup="check();" placeholder="*************">-->
<!--                                    <span  id="message"></span>-->
<!--                                </div>-->

<!--                                <div class="flex-m w-full p-b-33">-->
<!--                                    <div class="contact100-form-checkbox">-->
<!--                                        <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">-->
<!--                                        <label class="label-checkbox100" for="ckb1">-->
<!--								<span class="txt1">-->
<!--									I agree to the-->
<!--									<a href="#" class="txt2 hov1">-->
<!--										Terms of User-->
<!--									</a>-->
<!--								</span>-->
<!--                                        </label>-->
<!--                                    </div>-->
<!---->
<!---->
<!--                                </div>-->

<!--                                <div class="container-login100-form-btn">-->
<!--                                    <div class="wrap-login100-form-btn">-->
<!--                                        <div class="login100-form-bgbtn"></div>-->
<!--                                        <button class="login100-form-btn" onclick="regTest()">-->
<!--                                            Sign Up-->
<!--                                        </button>-->
<!--                                    </div>-->
<!--                                </div>-->
                            </div>

                            <div class="tab-pane fade" id="tab3default">Default 3</div>
                            <div class="tab-pane fade" id="tab4default">Default 4</div>
                            <div class="tab-pane fade" id="tab5default">Default 5</div>
                        </div>
                    </div>
                </div>
            </div>
            <div>list</div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-lg p-3 mb-5 bg-white rounded" style="width: 25rem;display:block; margin-left: auto;margin-right: auto">
                <div style="position:relative">
                    <img id="imgP" width="300px" height="350px" src="https://placekitten.com/300/300" class="card-img-top">
                    <div class="matchbtn" style="left:2%">
                        <i class="fa fa-3x fa-arrow-circle-left" onclick="prevImg()"></i>
                    </div>
                    <div class="matchbtn" style="right:2%">
                        <i class="fa fa-3x fa-arrow-circle-right" onclick="nextImg()"></i>
                    </div>

                </div>

                <div class="card-body">
                    <div style="position:relative;left: 35%;">
                        <i class="fa fa-4x fa-ban" style="color: rgba(14,0,6,0.87);" onclick="match()"></i>
                        <i class="fa fa-4x fa-heart" style="color: red;" onclick="nomatch()"></i>
                    </div>
                    <h5 class="card-title">Sally <e>23</e></h5>
                    <h6><i class="fa fa-graduation-cap"></i> University Of Limerick</h6>
                    <h6><i class="fa fa-suitcase"></i> Software Developer</h6>
                    <h6><i class="fa fa-map-marker"></i> Co. Limerick</h6>
                    </div>
<!--                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->

                </div>
            </div>
        </div>
    </div>
</div>


</div>




<script src="vendorv/jquery/jquery-3.2.1.min.js"></script>
<script src="vendorv/animsition/js/animsition.min.js"></script>
<script src="vendorv/bootstrap/js/popper.js"></script>
<script src="vendorv/bootstrap/js/bootstrap.js"></script>
<script src="js/main.js"></script>

</body>
</html>

