<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="vendorv/jquery/jquery-3.2.1.min.js"></script>

    <link href="vendorv/sweetalert/sweetalert.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        function updateButton() {
            if($('#updatepass').val().length > 7) {
                $('#resetbtn').prop('disabled', false);
            } else {
               $('#resetbtn').prop('disabled', true);
            }
        }
        function resetPassword() {
            var request = {};
            request.updateemail = $('#updateemail').val();
            request.updatepass = $('#updatepass').val();
            $.ajax({
                method: "POST",
                url: "update.php",
                data: request,
                success: function (response) {
                    console.log(response);
                    //TODO: use status code to determine what to do next
                    Swal.fire(response.title, response.message, response.type);
                    switch(response.statusCode) {
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
    <title>Hello World</title>
</head>
<body>
<div class="container">
<h1 align="center">Verification Page</h1>
<div style="text-align: center;">
    <img src="images/iDtae.png"  width="450" height="150">


<?php
require 'vendorv/autoload.php';
require("db.php");

 function decrypt($data) {
     $ciphering = "AES-128-CTR";
     $iv_length = openssl_cipher_iv_length($ciphering);
     $options = 0;
     $encryption_iv = '1234567891011121';
     $encryption_key = "University_Of_Limerick".date("m.d.y");//code only valid for a day

     return openssl_decrypt($data, $ciphering, $encryption_key, $options, $encryption_iv);
}


if (isset($_GET['verification'])) {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $decryptedUserName = decrypt($_GET['verification']);
        $userName = $conn->real_escape_string($decryptedUserName);
        $sql = "UPDATE user SET registered = 1 WHERE userName='{$userName}'";

        if ($conn->query($sql) === TRUE)
        {
            echo "<br><br><br><br><br>$decryptedUserName has been verified. <br/><br>Please return to <a href=\"http://www.idate.ie\">Login Page</a>";
        } else {
            echo "Key is invalid or has expired please try again.";
        }
    }

}
else if (isset($_GET['reset'])) {

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $decryptedUserName = decrypt($_GET['reset']);
        $userName = $conn->real_escape_string($decryptedUserName);
        $sql = "SELECT registered FROM user where email='{$decryptedUserName}' LIMIT 1;";


        $result = $conn->query($sql);
        if ($result->num_rows > 0)
        {
            //display success message and redirect
            echo "<div class='form-group' style='padding-top:50px'>".
                "<input id='updateemail' type='hidden' value='{$_GET['reset']}'/>".
                "<label class='form-control btn-warning'>Reset Password for</label>".
                "<label class='form-control'>$decryptedUserName</label>".
                "<input id='updatepass' class='form-control' type='text' onkeyup='updateButton()' placeholder='New password' style='padding-bottom:10px'/>".
                "<button id='resetbtn' class='btn btn-success' onclick='resetPassword()' disabled>Reset</button></div>";
        } else {
            echo "Key is invalid or has expired please try again.";
        }
    }

}
?>
</div>
</div>
</body>