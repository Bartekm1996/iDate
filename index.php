<!DOCTYPE html>
<html lang="en">
<head>
    <title>iDate</title>
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
        function loginTest() {
            const request = {};
            request.user_name = $('#user_name').val();
            request.login_password = $('#login_password').val();
            sendDataTest(request, "Login.php");
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

        function passWordInfo(){
            let colorOne = parseInt($('#passWordId').attr('data-password-digit')) !== 1 ? 'red' : 'green';
            let colorTwo =  parseInt($('#passWordId').attr('data-password-special-case')) !== 1 ? 'red' : 'green';
            let colorThree =  parseInt($('#passWordId').attr('data-password-upper-case')) !== 1 ? 'red' : 'green';
            let colorFour =  parseInt($('#passWordId').attr('data-password-lower-case')) !== 1 ? 'red' : 'green';

            console.log(colorOne);
            Swal.fire({
                icon: 'info',
                html:
                    '<div class="d-flex"><ul class="my-auto flex-grow-1"><li style="color: '+ colorOne + ';" >Contains 1 digit</li' +
                    '><li style="color: ' + colorTwo + ';" >Contains 1 Special Char</li></ul>' +
                    '<ul class="my-auto flex-grow-1"><li style="color: ' + colorThree + ';">' +
                    'Contains 2 upper case</li><li style="color: ' + colorFour + ';">Contains 2 lower case</li>'+
                    '</ul></div>',
                focusConfirm: false,
                confirmButtonText:'Ok',
            })
        }

        function emailReqs() {
            if($('#email').val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) !== null){
                return true;
            }else{
                if($('#email').val().trim().length > 0) {
                    errorMessage("Email Error", "Email doesn't meet criteria");
                }
                return false;
            }
        }

        function passWordReqs() {
            if(parseInt($('#passWordId').attr('aria-valuenow')) === 100 && $('#password').val() === $('#confirm_password').val()){
                return true;
            }else{

                if($('#password').val() !== $('#confirm_password').val()){
                    errorMessage("PassWord Error", "Passwords don't match");
                }else {
                    errorMessage("PassWord Error", "Password doesn't meet criteria");
                }
                return false;
            }
        }

        function regTest() {
            const request = {};
            request.username = $('#username').val();
            request.pass = $('#password').val();
            request.email = $('#email').val();

            if(request.username !== "" && request.pass !== "" && request.email !== ""){
                if(passWordReqs() && emailReqs()){
                    acceptTermsAndCons(request);
                }
            }else{
                Swal.fire("Fill In All Required Fields");
            }
        }

        function sendDataTest(request, urll) {
            console.log(request);
            $.ajax({
                method: "POST",
                url: urll,
                data: request,
                success: function (response) {

                console.log(response.title);

                    switch(response.statusCode) {
                        case 11:
                            Swal.fire(response.title, response.message, response.type);
                            break
                        case 2: //login success full
                            window.location.href = '/TestUi.php';
                            break;
                            case 3:
                                Swal.fire({
                                    title: 'Invalid password',
                                    text: "Would you like to reset?",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes'
                                }).then((result) => {
                                    //start
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
                                    //end
                                });

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
        <div class="login100-more" style="background-image: url('images/connected-couples.jpg');">
        </div>


        <div class="wrap-login100 p-l-50 p-r-50 p-t-72 p-b-50">


            <span class="login100-form-title p-b-59" id="signUpHeader">Sing In</span>

            <div id="loginForm" class="login100-form validate-form" >


                <div class="wrap-input100 validate-input m-b-23" data-validate="UserName / Email is required">
                    <span class="label-input100">User Name</span>
                    <input class="input100" type="text" id="user_name" placeholder="User Name / Email">
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-23" data-validate = "Password is required:  Abc123!!">
                    <span class="label-input100">Password</span>
                    <input class="input100" type="text" id="login_password" placeholder="Password">
                    <span class="focus-input100" data-symbol="&#xf190;"></span>
                </div>

                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn txt4" onclick="loginTest()">
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
                    <input class="input100" type="text" id="username" onclick="emailReqs()" placeholder="Username...">
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                </div>

                <div class="wrap-input100-password validate-input m-b-25" data-validate = "Password is required">
                    <span class="label-input100">Password</span>
                    <input class="input100" name="password" type="password" id="password" onclick="passWordInfo()" required placeholder="*************">
                    <span  id="message"></span>
                    <span class="focus-input100" data-symbol="&#xf190;"></span>
                    <div class="progress">
                        <div id="passWordId" role="progressbar" style="width: 100%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div class="wrap-input100-password validate-input m-b-25" data-validate = "Confirm Password">
                    <span class="label-input100">Confirm Password</span>
                    <input class="input100" name="confirm_password" type="password" id="confirm_password" onclick="passWordInfo()" required placeholder="*************">
                    <span  id="message"></span>
                    <span class="focus-input100" data-symbol="&#xf190;"></span>
                    <div class="progress">
                        <div id="confirmPassWordBar" role="progressbar"  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>


                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn txt4" onclick="regTest()">
                            Sign Up
                        </button>
                    </div>
                </div>
            </div>


            <div class="d-flex m-t-30">
                <hr class="my-auto flex-grow-1">
                <div class="px-4">Or</div>
                <hr class="my-auto flex-grow-1">
            </div>

            <!--dis-flex txt3 hov1 pos-justify m-t-50-->
            <a href="#" id="signUp" class="login100-form-btn m-t-20 txt3">
                Sign Up
            </a>

            <p class="dis-flex pos-justify m-t-25">IDate</p>
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

