<?php
session_start();
require("db.php");
require("SweetalertResponse.php");
require("Email.php");
require("MongoConnect.php");

$resp = null;
if(isset($_POST['reset_uname']) && isset($_POST['reset_email'])) {
    $rname = $_POST['reset_uname'];
    $remail = $_POST['reset_email'];

    header('Content-Type: application/json');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $rname = $conn->real_escape_string($rname);
        $remail = $conn->real_escape_string($remail);
        $sql = "SELECT id,firstname,registered FROM user where username='{$rname}' AND email='{$remail}' LIMIT 1;";

        $result = $conn->query($sql);
        $isValid = false;
        if ($result->num_rows > 0)
        {
            $isValid = true;
                //TODO: send reset email here
            $semail = new Email($remail, $rname);
            $semail->sendRegisterEmail(Email::RESET_PASSWORD);
        }

        $resp = new SweetalertResponse($isValid ? 100 : 101,
            $isValid  ? 'Password Reset' : 'Error',
            $isValid  ? "Please click reset link in email $remail" : "Sorry $rname or $remail is not valid",
            $isValid  ? SweetalertResponse::SUCCESS : SweetalertResponse::ERROR
        );
    }

} else if (isset($_POST['user_name']) && isset($_POST['login_password']) ) {
    $uname = $_POST['user_name'];
    $upass = $_POST['login_password'];

    header('Content-Type: application/json');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $uname = $conn->real_escape_string($uname);
        $upass = $conn->real_escape_string($upass);

        $sql = "";
        if (strpos($uname, "@") !== false) {
            $sql = "select blocked from profile where userID = (select id from user where email = '{$uname}');";
        } else {
            $sql = "select blocked from profile where userID = (select id from user where userName = '{$uname}');";
        }

        $res = $conn->query($sql);
        if($res->num_rows > 0 && $res->fetch_row()[0] === 1){
            $resp = new SweetalertResponse(5,
                'Account Blocked',
                "Please contact our team at customercareteam@iDate.ie to solve this issue",
                SweetalertResponse::WARNING
            );
        }else {

            if (strpos($uname, "@") !== false) {
                $sql = "SELECT registered, id, firstname, lastname, userName FROM user where email='{$uname}' AND password='{$upass}' LIMIT 1;";
            } else {
                $sql = "SELECT registered, id, firstname, lastname, email FROM user where userName='{$uname}' AND password='{$upass}' LIMIT 1;";
            }


            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = mysqli_fetch_row($result);
                //echo $row[0] ? "You logged and registered": "You are logged in but not registered";
                $reg = $row[0] == 0;
                $resp = new SweetalertResponse($reg ? 1 : 2,
                    $reg ? 'Please Verify' : 'Login Success',
                    $reg ? "Please verify $uname" : "$uname logged in successfully",
                    $reg ? SweetalertResponse::WARNING : SweetalertResponse::SUCCESS
                );

                $_SESSION['userid'] = $row[1];
                $_SESSION['firstname'] = $row[2] . " " . $row[3];
                $uname = strpos($uname, "@") !== false ? $row[4] : $uname;
                $email = strpos($uname, "@") !== false ? $uname : $row[4];

                $_SESSION['email'] = $email;
                $_SESSION['username'] = $uname;


                $mongo = new MongoConnect();
                $mongo->historyUpdate($uname, "User Logged In", "Log In");

            } else {
                $resp = new SweetalertResponse(3,
                    'Login Failed',
                    "Failed to login with username $uname",
                    SweetalertResponse::ERROR
                );
            }
        }
    }


    $conn->close();
} else {
    //didn't set username or pass
    $resp = new SweetalertResponse(4,
        'Error',
        "Invalid Parameters set",
        SweetalertResponse::ERROR
    );
}

echo $resp->jsonSerialize();