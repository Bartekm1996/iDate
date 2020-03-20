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
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"/>-->
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
    <!--    <script src="//geodata.solutions/includes/statecity.js"></script>-->
    <script src="//geodata.solutions/includes/countrystatecity.js"></script>

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
                    <img src='https://placekitten.com/100/100'/>
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
<!--                            <li><a href="#tab4default" data-toggle="tab">Personal information</a></li>-->
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

                            <!-- TODO: Norbert this needs to go into pop up or new page.
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
                                </div>-->

                            </div>
                            <div class="tab-pane fade" id="tab3default">Default 3</div>
                        </div>
                    </div>
                </div>
            </div>

        <?php require("matchcontent.php"); ?>
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

