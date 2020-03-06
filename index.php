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
    <!-- removed JQuery from header test -->

</head>
<body style="background-color: #999999;">

<div class="limiter">
    <div class="container-login100">
        <div class="login100-more" style="background-image: url('images/bg-01.jpg');">
        </div>


        <div class="wrap-login100 p-l-50 p-r-50 p-t-72 p-b-50">
            <span class="login100-form-title p-b-59" id="signUpHeader">Sing In</span>

            <form id="loginForm" class="login100-form validate-form" action="Login.php"  method="POST">

                <div class="wrap-input100 validate-input" data-validate="UserName required">
                    <span class="label-input100">User Name</span>
                    <input class="input100" type="text" name="user_name" placeholder="User Name / Email">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "Password is required:  Abc123!!">
                    <span class="label-input100">Password</span>
                    <input class="input100" type="text" name="password" placeholder="Password">
                    <span class="focus-input100"></span>
                </div>

                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn">
                            Sign In
                        </button>
                    </div>
                </div>


            </form>

            <form id="registerForm" class="login100-form validate-form" style="display: none;" action="Register.php"  method="post">

                <div class="wrap-input100 validate-input" data-validate="Name is required">
                    <span class="label-input100">Full Name</span>
                    <input class="input100" type="text" name="name" placeholder="Name...">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                    <span class="label-input100">Email</span>
                    <input class="input100" type="text" name="email" placeholder="Email addess...">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Username is required">
                    <span class="label-input100">Username</span>
                    <input class="input100" type="text" name="username" placeholder="Username...">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "Password is required">
                    <span class="label-input100">Password</span>
                    <input class="input100" type="text" name="pass" placeholder="*************">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "Repeat Password is required">
                    <span class="label-input100">Repeat Password</span>
                    <input class="input100" type="text" name="repeat-pass" placeholder="*************">
                    <span class="focus-input100"></span>
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
                        <button class="login100-form-btn" onclick="">
                            Sign Up
                        </button>
                    </div>
                </div>
            </form>

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

