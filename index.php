<!DOCTYPE html>
<html lang="en">
<head>
    <title>iDate</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="vendorv/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendorv/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="vendorv/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="vendorv/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="vendorv/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="vendorv/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"/>

    <link href="vendorv/sweetalert/sweetalert.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//geodata.solutions/includes/statecity.js"></script>

    <script>
        //<!-- Ajax post test-->
        function loginTest() {
            var request = {};
            request.user_name = $('#user_name').val();
            request.login_password = $('#login_password').val();
            sendDataTest(request, "Login.php");
        }



        var check = function() {
            if (document.getElementById('password').value ==
                document.getElementById('confirm_password').value) {
                document.getElementById('message').style.color = 'green';
                document.getElementById('message').innerHTML = 'Password is matching';
            } else {
                document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = 'Password is not matching';
            }
        }

        function regTest() {
            var request = {};
            request.username = $('#username').val();
            request.pass = $('#password').val();
            request.email = $('#email').val();
            request.name = $('#name').val();
            sendDataTest(request, "Register.php");
        }

        function sendDataTest(request, urll) {
            console.log(request);
            $.ajax({
                method: "POST",
                url: urll,
                data: request,
                success: function (response) {
                    console.log(response);


                    //TODO: use status code to determine what to do next
                    switch(response.statusCode) {
                        case 2: //login success full
                            window.location.href = '/TestUi.php';
                            break;
                            default:
                                Swal.fire(response.title, response.message, response.type);
                                break;
                    }
                    //https://sweetalert2.github.io/#examples

                },
                failure: function (response) {
                    console.log('failure:' + JSON.stringify(response));
                    },
                error: function (response) {
                    console.log('error:' + JSON.stringify(response));
                }
            });
        }

    </script>
</head>
<body style="background-color: #999999;">

<div class="limiter">
    <div class="container-login100">
        <div class="login100-more" style="background-image: url('images/bg-01.jpg');">
        </div>


        <div class="wrap-login100 p-l-50 p-r-50 p-t-72 p-b-50">


            <span class="login100-form-title p-b-59" id="signUpHeader">Sing In</span>

            <div id="loginForm" class="login100-form validate-form" >

                <div class="wrap-input100 validate-input" data-validate="UserName / Email is required">
                    <span class="label-input100">User Name</span>
                    <input class="input100" type="text" id="user_name" placeholder="User Name / Email">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "Password is required:  Abc123!!">
                    <span class="label-input100">Password</span>
                    <input class="input100" type="text" id="login_password" placeholder="Password">
                    <span class="focus-input100"></span>
                </div>

                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn" onclick="loginTest()">
                            Sign In
                        </button>
                    </div>
                </div>
            </div>

            <div id="registerForm" class="login100-form validate-form" style="display: none;" >

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

                <div id="location" class="wrap-input100 validate-input"  >
                    <span class="label-input100">Select your location<br><br></span>
                    <input type="hidden" name="country" id="countryId" value="IE"/>
                    <select name="state" class="states order-alpha" id="stateId"  >
                        <option value="">Select State</option>
                    </select>
                    <select name="city" class="cities order-alpha" id="cityId" style="margin-left: 20px">
                        <option value="">Select City</option>
                    </select>

<!--                    <span class="focus-input100"></span>-->
                </div>

                <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                    <span class="label-input100">Email</span>
                    <input class="input100" type="email" id="email" placeholder="user@example.com">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Username is required">
                    <span class="label-input100">Username</span>
                    <input class="input100" type="text" id="username" placeholder="Username...">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 " data-validate = "Password is required">
                    <span class="label-input100">Password</span>
                    <input class="input100" name="password" type="password" id="password" required onkeyup="check();" placeholder="*************">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 " data-validate = "Confirm Password">
                    <span class="label-input100">Confirm Password</span>
                    <input class="input100" name="confirm_password" type="password" id="confirm_password" required  onkeyup="check();" placeholder="*************">
                    <span  id="message"></span>
                </div>

                <div class="flex-m w-full p-b-33">
                    <div class="contact100-form-checkbox">
                        <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                        <label class="label-checkbox100" for="ckb1">
								<span class="txt1">
									I agree to the
									<a href="#" class="txt2 hov1">
										Terms of User
									</a>
								</span>
                        </label>
                    </div>


                </div>

                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn" onclick="regTest()">
                            Sign Up
                        </button>
                    </div>
                </div>
            </div>

            <a href="#" id="signUp" class="dis-block txt3 hov1 p-r-30 p-t-10 p-b-10 p-l-30">
                Sign Up
                <i class="fa fa-long-arrow-right m-l-5"></i>
            </a>

            <p style="margin: auto;" align="middle">IDate</p>
        </div>
    </div>
</div>


</div>




<script src="vendorv/jquery/jquery-3.2.1.min.js"></script>
<script src="vendorv/animsition/js/animsition.min.js"></script>
<script src="vendorv/bootstrap/js/popper.js"></script>
<script src="vendorv/bootstrap/js/bootstrap.min.js"></script>
<script src="vendorv/select2/select2.min.js"></script>
<script src="vendorv/daterangepicker/moment.min.js"></script>
<script src="vendorv/daterangepicker/daterangepicker.js"></script>
<script src="vendorv/countdowntime/countdowntime.js"></script>
<script src="js/main.js"></script>

</body>
</html>

