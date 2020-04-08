<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>iDate: Where people meet</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="vendorv/bootstrap/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"/>
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
    <link href="vendorv/sweetalert/sweetalert.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!--    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
    <!--    <script src="//geodata.solutions/includes/statecity.js"></script>-->
    <!--    <script src="//geodata.solutions/includes/countrystatecity.js"></script>-->
    <script type="text/javascript">
        //<!-- Ajax post test-->


        onload = function () {
            document.getElementById('vid').play();
        }

        function loginTest() {
            const request = {};


            let button = $('#login_button');
            if(!button.text().match("Signing In")) {

                request.user_name = $('#user_name').val();
                request.login_password = $('#login_password').val();
                if (request.user_name.length === 0 || request.login_password.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        text: "Fill In All Required Fields"
                    });
                } else {
                    $('#login_button').html('<i class="fa fa-spinner fa-spin mr-2"></i> Signing In');
                    sendDataTest(request, "Login.php");
                }
            }
        }
        function resetEmail(username, email, values) {
            const request = {};
            request.reset_uname = username;
            request.reset_email = email;
            sendDataTest(request, "Login.php");
        }
        async function acceptTermsAndCons(request) {
            const {value: accept} = await Swal.fire({
                title: 'Terms and conditions',
                input: 'checkbox',
                inputValue: 1,
                inputPlaceholder:
                    'I agree with the <a href="#">terms and conditions</a>',
                confirmButtonText:
                    'Continue<i class="fa fa-arrow-right"></i>',
                inputValidator: (result) => {
                    return !result && 'You need to agree with T&C to continue'
                }
            })
            if (accept) {
                sendDataTest(request, "Register.php");
            }
        }
        function errorMessage(tittle, message) {
            Swal.fire({
                icon: 'error',
                title: tittle,
                text: message,
            })
        }

        function makeid(length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%&*(){}';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }

        async function generatePassWord() {
            let timerInterval;
            let res =  makeid(16);

            Swal.fire({
                title: 'Generating Password!',
                html: 'Your Password will be generated in <b></b> milliseconds.',
                timer: 1000,
                timerProgressBar: true,
                onBeforeOpen: (i) => {
                    Swal.showLoading()
                    timerInterval = setInterval((i) => {
                        const content = Swal.getContent()
                        if (content) {
                            const b = content.querySelector('b')
                            if (b) {
                                b.textContent = Swal.getTimerLeft()
                            }
                        }
                    }, 100)
                },
                onClose: (i) => {
                    Swal.fire({
                        title: 'Your Password',
                        text: res,
                    })
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                       $('#password').val(res);
                       $('#confirm_password').val(res);
                       document.getElementById("password").dispatchEvent(new Event('input'));
                }
            })
        }



        function errorMessage(tittle, message) {
            Swal.fire({
                icon: 'error',
                title: tittle,
                text: message,
            })
        }

        function passWordReqs() {
                if(parseInt($('#passWordId').attr('aria-valuenow')) === 100 && $('#password').val() === $('#confirm_password').val()){
                    return true;
                }else{
                    if($('#password').val() !== $('#confirm_password').val()){
                        errorMessage("PassWord Error", "Passwords don't match");
                        return false;
                    }else {
                        errorMessage("PassWord Error", "Password doesn't meet criteria");
                        return false;
                    }
                }
        }

        function isNumber(n) { return /^-?[\d.]+(?:e-?\d+)?$/.test(n); }


        function showSupport() {
            $('#contact_form').attr('hidden', false);
        }


        function regTest() {
            const request = {};
            request.username = $('#username').val();
            request.pass = $('#password').val();
            request.email = $('#email').val();

            let pp = passWordReqs();
            console.log(request.email !== "" + " email " + $('#email').val());

            if(request.username !== "" && request.pass !== "" && request.email !== ""){

                if(isNumber(request.username)){
                    errorMessage("UserName Error", "Username cannot contain digits only");
                }else {

                    if ($('#password').val().match($('#username').val()) || $('#password').val().match($('#email').val())) {
                        errorMessage("Password Error", "Password cannot contain your username or email");
                    } else if ($('#username').val().match(" ") || $('#password').val().match(" ")) {
                        errorMessage("Whitespace Error", "Username or Password cannot contain Whitespaces");
                    } else {
                        if (passWordReqs()) {
                            $('#signUp').html('<i class="fa fa-spinner fa-spin mr-2"></i> Registering');
                            acceptTermsAndCons(request);
                        }
                    }
                }

            }else{
                Swal.fire({
                    icon: 'warning',
                    text: "Fill In All Required Fields"
                });
            }
        }

        function viewPassWord(elem){
            console.log();
            let pass = document.getElementById($(elem).attr('data-input-id'));
            if(pass.type === 'password'){
                pass.type = 'text';
            }else if(pass.type === 'text'){
                pass.type = 'password';
            }

        }

        function passWordReset(title, icon) {
            Swal.fire({
                title: title,
                text: "Would you like to reset?",
                icon: icon,
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then((result) => {
                if(result.value) {
                    Swal.mixin({
                        input: 'text',
                        confirmButtonText: 'Next &rarr;',
                        showCancelButton: true,
                        progressSteps: ['1', '2']
                    }).queue([
                        {
                            title: 'Question 1',
                            text: 'What is your username?'
                        },
                        {
                            title: 'Question 2',
                            text: 'What is your email?'
                        }
                    ]).then((result) => {
                        var invalid = false;
                        for (let i = 0; i < result.value.length; i++) {
                            if (result.value[i].trim().length < 6) {
                                invalid = true;
                            }
                        }
                        if (invalid) {
                            Swal.fire("Error", "username or email is not long enough", "error");
                        } else {
                            resetEmail(result.value[0], result.value[1]);
                        }
                    });
                }
                //end
            });
        }
        function sendDataTest(request, urll) {
            console.log(request);
            $.ajax({
                method: "POST",
                url: urll,
                data: request,
                success: function (response) {
                    console.log(response.title);
                    $('#login_button').html('Sign In');
                    switch(response.statusCode) {
                        case 2:{
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
                                title: 'Signed in successfully'
                            });
                            window.location.href = 'Home.php';
                            break;
                        }
                        case 3:
                            passWordReset('Invalid Password', 'warning')
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
<body style="background-color: #e8519e;">
<div class="limiter">
    <?php require ("support.php")?>

    <div class="container-login100" style="height: 100%;" >

        <video class="login100-more" style="object-fit: cover;" height="100vh" id="vid" src="https://firebasestorage.googleapis.com/v0/b/inventory-b7072.appspot.com/o/iDate.mp4?alt=media&token=8c04f07e-a8c4-4278-ae4b-2fbc22513b83" preload="metadata" type="video/mp4" playsinline loop autoplay muted></video>
        <div class="wrap-login100 p-l-50 p-r-50 p-t-72 p-b-50" style="height: 100%; overflow-y: scroll;">
            <span class="login100-form-title p-b-59" id="signUpHeader">Sign In</span>
            <div id="loginForm" class="login100-form validate-form" >
                <div class="wrap-input100 validate-input m-b-23" data-validate="UserName / Email is required">
                    <span class="label-input100">User Name</span>
                    <input class="input100" type="text" id="user_name" placeholder="User Name / Email">
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                </div>
                <div class="wrap-input100 validate-input m-b-23" data-validate = "Password is required">
                    <span class="label-input100">Password</span>
                    <input class="input100" name="password" id="login_password" type="password" required placeholder="*******************">
                    <button class="focus-input100" data-symbol="&#xf190;" data-input-id="login_password" onclick="viewPassWord(this)">
                        <span class="tooltiptext"><i class="fa fa-eye" aria-hidden="true"></i> View password</span>
                    </button>
                </div>
                <div class="container-login100-form-btn m-t-10">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn txt4" id="login_button" onclick="loginTest()">
                            Sign In
                        </button>
                    </div>
                </div>
            </div>
            <div id="registerForm" class="login100-form validate-form" style="display: none;" >
                <div class="wrap-input100 validate-input m-b-25" data-validate = "Valid email is required: ex@abc.xyz">
                    <span class="label-input100">Email</span>
                    <input class="input100" type="email" id="email" placeholder="user@example.com">
                    <span class="focus-input100" data-symbol="&#xf15a;"></span>
                </div>
                <div class="wrap-input100 validate-input m-b-25" data-validate="Username is required">
                    <span class="label-input100">Username</span>
                    <input class="input100" type="text" id="username" minlength="5" placeholder="Username...">
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                </div>
                <div class="wrap-input100-password validate-input m-b-25" data-validate = "Password is required">
                    <span class="label-input100">Password</span>
                    <button class="label-input100 generate-password" onclick="generatePassWord()">Generate Password</button>
                    <input class="input100" name="password" type="password" id="password" required placeholder="Enter Password">
                    <span  id="message"></span>
                    <button class="focus-input100" data-symbol="&#xf190;" data-input-id="password" onclick="viewPassWord(this)">
                        <span class="tooltiptext"><i class="fa fa-eye" aria-hidden="true"></i> View password</span>
                    </button>
                    <div class="progress">
                        <div id="passWordId" role="progressbar" style="width: 100%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div id="passWordInfo" style="padding: 5px; margin-top: 10px; margin-bottom: 10px;" hidden>
                    <div class="d-flex pos-justify ml-3">
                        <ul class="m-r-40" style="text-align: left;">
                            <li id="digit" class="m-b-20" style="color: red;">Contains 1 digit</li>
                            <li id="specialChar" class="m-b-20" style="color: red;">Contains 1 Special Char</li>
                            <li id="passLength" style="color: red;">7 Charchters Long</li></ul>
                        <ul style="text-align: left;">
                            <li id="upperCase" class="m-b-20" style="color: red;">Contains 2 upper case</li>
                            <li id="lowerCase" style="color: red;">Contains 2 lower case</li>
                        </ul>
                    </div>
                </div>
                <div class="wrap-input100-password validate-input m-b-25" data-validate = "Confirm Password">
                    <span class="label-input100">Confirm Password</span>
                    <input class="input100" name="confirm_password" type="password" id="confirm_password" required placeholder="Confirm Password">
                    <span  id="message"></span>
                    <button class="focus-input100" data-symbol="&#xf190;" data-input-id="confirm_password" onclick="viewPassWord(this)">
                        <span class="tooltiptext"><i class="fa fa-eye" aria-hidden="true"></i> View password</span>
                    </button>
                    <div class="progress">
                        <div id="confirmPassWordBar" role="progressbar"  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="container-login100-form-btn m-t-10">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn txt4" onclick="regTest()">
                            Sign Up
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex-w m-t-30">
                <hr class="my-auto flex-grow-1">
                <div class="px-4">Or</div>
                <hr class="my-auto flex-grow-1">
            </div>
            <!--dis-flex txt3 hov1 pos-justify m-t-50-->
            <div class="flex-w  m-t-20 ">
                <a href="#" onclick="passWordReset('Password Rest', 'question')" id="forgotPassWord" style="text-align: center;" class="flex-grow-1 txt3 m-r-50">
                    Forgot<br>Password
                </a>
                <a href="#" id="signUp" style="text-align: center;" class="my-auto flex-grow-1 txt3 m-r-10">
                    Sign Up
                </a>
            </div>
            <p class="dis-flex pos-justify m-t-45">IDate ® <script>document.write(new Date().getFullYear().toString())</script></p>
            <a href="#" class="dis-flex pos-justify m-t-5" id="support" onclick="showSupport()">Contact Support</a>
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